<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // PERBAIKAN: Ubah validasi 'email' agar tidak wajib berekstensi @email.com, 
            // karena user bisa memasukkan kombinasi angka NIM.
            'email' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // LOGIKA BARU: Cek apakah inputnya Email atau NIM
        $loginInput = $this->input('email'); // Field input di HTML bernama 'email'
        
        // Jika input mengandung format email (@), gunakan kolom 'email'. Jika tidak, gunakan kolom 'nim'.
        $loginField = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Susun data kredensial
        $credentials = [
            $loginField => $loginInput,
            'password' => $this->input('password')
        ];

        // Lakukan Autentikasi
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // PERBAIKAN KEAMANAN: Tolak akses jika akun sedang berstatus 'suspended'
        if (Auth::user()->status === 'suspended') {
            Auth::logout(); // Keluarkan kembali secara paksa
            throw ValidationException::withMessages([
                'email' => 'Akses Ditolak: Akun Anda telah ditangguhkan oleh Administrator. Silakan hubungi dukungan.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}