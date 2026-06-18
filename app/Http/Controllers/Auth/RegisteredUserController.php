<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. PERBAIKAN: Tambahkan validasi untuk 'nim'
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nim' => ['required', 'string', 'max:50', 'unique:'.User::class], // Mencegah NIM ganda
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. PERBAIKAN: Masukkan NIM dan Set Role Default ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim, // Menyimpan NIM
            'role' => 'mahasiswa',  // Pastikan yang daftar selalu menjadi mahasiswa
            'status' => 'active',   // Status akun langsung aktif
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}