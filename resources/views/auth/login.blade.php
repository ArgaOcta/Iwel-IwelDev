<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — SCMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[linear-gradient(141deg,#F0F0FB_0%,#FAF8FF_100%)] font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased">
    <div class="flex min-h-screen items-center justify-center px-4 py-16 sm:py-[189.5px]">
        <div class="flex w-full max-w-[448px] flex-col gap-6 pb-6">
            {{-- Logo area --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex w-16 items-center justify-center rounded-full bg-[#DBE1FF] py-3">
                    <img src="{{ asset('assets/icons/login-logo.svg') }}" alt="" width="33" height="35" class="block">
                </div>
                <div class="flex w-full flex-col items-center pt-1">
                    <h1 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">SCMS</h1>
                </div>
                <p class="text-center text-base leading-6 text-[#434655]">
                    Sistem Manajemen Keluhan Mahasiswa
                </p>
            </div>

            {{-- Login card --}}
            <div class="flex flex-col gap-4 rounded-xl bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                <h2 class="text-center text-2xl font-semibold leading-8 text-[#191B23]">
                    Selamat Datang Kembali
                </h2>

                @if (session('status'))
                    <div class="rounded-lg border border-[#D0E1FB] bg-[#FAF8FF] px-4 py-3 text-sm leading-5 text-[#434655]">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4 pb-2">
                    @csrf

                    {{-- Email / NIM --}}
                    <div class="flex flex-col gap-1">
                        <label for="email" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23]">
                            Email atau NIM
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-email.svg') }}" alt="" width="16" height="16" class="block">
                            </div>
                            <input
                                id="email"
                                type="text"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email atau nomor induk mahasiswa"
                                class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-3 text-base text-[#191B23] placeholder:text-[#C3C6D7] focus:border-[#004AC6] focus:outline-none focus:ring-2 focus:ring-[#004AC6]/20 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            >
                        </div>
                        @error('email')
                            <p class="text-sm leading-5 text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password DENGAN IKON MATA --}}
                    <div class="flex flex-col gap-1">
                        <label for="password" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23]">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-password.svg') }}" alt="" width="16" height="21" class="block">
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi Anda"
                                class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-10 text-base text-[#191B23] placeholder:text-[#C3C6D7] focus:border-[#004AC6] focus:outline-none focus:ring-2 focus:ring-[#004AC6]/20 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#C3C6D7] hover:text-[#004AC6] transition-colors focus:outline-none">
                                <svg id="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm leading-5 text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember me & forgot password --}}
                    <div class="flex items-center justify-between">
                        <label class="flex cursor-pointer items-center">
                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                                {{ old('remember') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border border-[#C3C6D7] text-[#004AC6] focus:ring-[#004AC6]/20"
                            >
                            <span class="pl-2 text-sm leading-5 text-[#434655]">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6] transition-opacity hover:opacity-90">
                                Lupa kata sandi?
                            </a>
                        @else
                            <a href="#" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6] transition-opacity hover:opacity-90">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#004AC6] px-4 py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white shadow-[0_1px_2px_rgba(0,0,0,0.05)] transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#004AC6]/30"
                    >
                        Masuk
                    </button>
                </form>

                {{-- Support link --}}
                <div class="border-t border-[#E1E2ED] pt-4 text-center text-sm leading-5 text-[#434655]">
                    Butuh bantuan masuk?
                    <a href="#" class="font-normal text-[#004AC6] transition-opacity hover:opacity-90">Hubungi Dukungan</a>
                </div>
            </div>

            {{-- Copyright --}}
            <p class="text-center text-sm leading-5 text-[#737686]">
                © {{ date('Y') }} SCMS Institution Portal. Hak cipta dilindungi undang-undang.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ganti ke icon mata dicoret (invisible)
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                // Ganti ke icon mata terbuka (visible)
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>