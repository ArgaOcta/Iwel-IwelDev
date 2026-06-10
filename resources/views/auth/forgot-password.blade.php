<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi — SCMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-[#FAF8FF] to-white font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-16 sm:py-[277.5px]">
        {{-- Subtle radial pattern --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.03]"
            style="background: radial-gradient(circle at 50% 50%, #004AC6 3%, transparent 3%); background-size: 32px 32px;"
            aria-hidden="true"
        ></div>

        <div class="relative flex w-full max-w-[420px] flex-col gap-6">
            {{-- Brand header --}}
            <div class="flex flex-col items-center gap-1">
                <h1 class="text-[32px] font-bold leading-10 tracking-[-0.025em] text-[#004AC6]">SCMS</h1>
                <p class="text-[13px] font-semibold uppercase leading-[18px] tracking-[0.1em] text-[#434655]">Portal Manajemen</p>
            </div>

            <div class="relative rounded-xl border border-[#E1E2ED] bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                @if (session('status'))
                    {{-- State 2: Success message --}}
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#EDEDF9]">
                            <img src="{{ asset('assets/icons/icon-success-check.svg') }}" alt="" width="27" height="27" class="block">
                        </div>

                        <h2 class="pb-2 text-2xl font-semibold leading-8 text-[#191B23]">Cek kotak masuk Anda</h2>

                        <p class="max-w-sm pb-6 text-base leading-6 text-[#434655]">
                            Kami telah mengirimkan tautan atur ulang kata sandi ke
                            @if (session('reset_email') || old('email'))
                                <span class="font-semibold text-[#191B23]">{{ session('reset_email', old('email')) }}</span>
                            @else
                                email Anda
                            @endif
                        </p>

                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="flex w-full items-center justify-center rounded-lg border border-[#C3C6D7] bg-[#FAF8FF] px-4 py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23] transition-opacity hover:opacity-90"
                            >
                                Kembali ke Halaman Masuk
                            </a>
                        @else
                            <a
                                href="#"
                                class="flex w-full items-center justify-center rounded-lg border border-[#C3C6D7] bg-[#FAF8FF] px-4 py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23] transition-opacity hover:opacity-90"
                            >
                                Kembali ke Halaman Masuk
                            </a>
                        @endif

                        <p class="pt-4 text-sm leading-5 text-[#737686]">
                            Tidak menerima email?
                            <button
                                type="button"
                                onclick="document.getElementById('resend-form').classList.remove('hidden'); this.closest('.flex').classList.add('hidden');"
                                class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6] hover:opacity-90"
                            >
                                Klik untuk mengirim ulang
                            </button>
                        </p>

                        <form id="resend-form" method="POST" action="{{ route('password.email') }}" class="hidden mt-4 w-full">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('reset_email', old('email')) }}">
                            <button
                                type="submit"
                                class="w-full rounded-lg bg-[#004AC6] px-4 py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white transition-opacity hover:opacity-90"
                            >
                                Kirim Ulang Tautan
                            </button>
                        </form>
                    </div>
                @else
                    {{-- State 1: Request form --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-2xl font-semibold leading-8 text-[#191B23]">Atur Ulang Kata Sandi</h2>
                            <p class="text-base leading-6 text-[#434655]">
                                Masukkan alamat email yang terdaftar pada akun Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
                            @csrf

                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23]">
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <img src="{{ asset('assets/icons/icon-mail-forgot.svg') }}" alt="" width="17" height="14" class="block">
                                    </div>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        autocomplete="email"
                                        placeholder="nama@institusi.edu"
                                        class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-3 text-base text-[#191B23] placeholder:text-[#737686] focus:border-[#004AC6] focus:outline-none focus:ring-2 focus:ring-[#004AC6]/20 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                    >
                                </div>
                                @error('email')
                                    <p class="text-sm leading-5 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-1">
                                <button
                                    type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#004AC6] px-4 py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#004AC6]/30"
                                >
                                    Kirim Tautan Atur Ulang
                                    <img src="{{ asset('assets/icons/icon-send-arrow.svg') }}" alt="" width="12" height="12" class="block">
                                </button>
                            </div>
                        </form>

                        <div class="border-t border-[#E1E2ED] pt-4">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#505F76] transition-opacity hover:opacity-90">
                                    <img src="{{ asset('assets/icons/icon-back-arrow.svg') }}" alt="" width="11" height="11" class="block">
                                    Kembali ke Halaman Masuk
                                </a>
                            @else
                                <a href="#" class="flex items-center justify-center gap-2 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#505F76] transition-opacity hover:opacity-90">
                                    <img src="{{ asset('assets/icons/icon-back-arrow.svg') }}" alt="" width="11" height="11" class="block">
                                    Kembali ke Halaman Masuk
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
