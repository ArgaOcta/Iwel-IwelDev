<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — SCMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-[#FAF8FF] to-white font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-16 sm:py-[142px]">
        {{-- Ambient background blurs --}}
        <div class="pointer-events-none absolute -left-32 -top-52 h-[512px] w-[640px] rounded-full bg-[rgba(0,74,198,0.05)] blur-[120px]" aria-hidden="true"></div>
        <div class="pointer-events-none absolute bottom-0 right-0 h-[614px] w-[768px] rounded-full bg-[rgba(208,225,251,0.2)] blur-[150px]" aria-hidden="true"></div>

        <div class="relative w-full max-w-[520px] rounded-xl border border-[rgba(195,198,215,0.3)] bg-white shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
            {{-- Header --}}
            <div class="flex flex-col gap-1 border-b border-[rgba(195,198,215,0.2)] px-6 pb-4 pt-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#2563EB] shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                        <img src="{{ asset('assets/icons/register-logo.svg') }}" alt="" width="22" height="18" class="block">
                    </div>
                    <span class="text-2xl font-bold leading-8 tracking-[-0.025em] text-[#004AC6]">SCMS</span>
                </div>
                <h1 class="pt-3 text-lg font-semibold leading-7 text-[#191B23]">Buat Akun Mahasiswa</h1>
                <p class="text-sm leading-5 text-[#434655]">Daftar untuk mengajukan dan melacak pengaduan Anda.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mx-auto flex w-full max-w-[470px] flex-col gap-4 px-6 pb-4 pt-6">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">Nama Lengkap</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <img src="{{ asset('assets/icons/icon-user.svg') }}" alt="" width="14" height="14" class="block">
                        </div>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-3 text-base text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] placeholder:text-[#737686] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 @error('name') border-red-500 @enderror"
                        >
                    </div>
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIM & Program Studi --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="nim" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">NIM</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-nim.svg') }}" alt="" width="17" height="17" class="block">
                            </div>
                            <input
                                id="nim"
                                type="text"
                                name="nim"
                                value="{{ old('nim') }}"
                                required
                                placeholder="Nomor Induk Mahasiswa"
                                class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-3 text-base text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] placeholder:text-[#737686] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 @error('nim') border-red-500 @enderror"
                            >
                        </div>
                        @error('nim')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="program_studi" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">Program Studi</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-graduation.svg') }}" alt="" width="18" height="14" class="block">
                            </div>
                            <select
                                id="program_studi"
                                name="program_studi"
                                required
                                class="w-full appearance-none rounded-lg border border-[#C3C6D7] bg-white py-3 pl-10 pr-10 text-base leading-6 text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 @error('program_studi') border-red-500 @enderror"
                            >
                                <option value="" disabled {{ old('program_studi') ? '' : 'selected' }}>Pilih Program Studi</option>
                                <option value="ti" {{ old('program_studi') === 'ti' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="si" {{ old('program_studi') === 'si' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="manajemen" {{ old('program_studi') === 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                                <option value="akuntansi" {{ old('program_studi') === 'akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <img src="{{ asset('assets/icons/icon-chevron-down.svg') }}" alt="" width="10" height="6" class="block">
                            </div>
                        </div>
                        @error('program_studi')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">Email</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <img src="{{ asset('assets/icons/icon-mail.svg') }}" alt="" width="17" height="14" class="block">
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="mahasiswa@university.edu"
                            class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-3 text-base text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] placeholder:text-[#737686] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 @error('email') border-red-500 @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Passwords --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">Kata Sandi</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-lock.svg') }}" alt="" width="14" height="18" class="block">
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-10 text-base text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] placeholder:text-[#737686] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 @error('password') border-red-500 @enderror"
                            >
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 flex items-center pr-3" data-target="password" aria-label="Tampilkan kata sandi">
                                <img src="{{ asset('assets/icons/icon-eye.svg') }}" alt="" width="18" height="17" class="block">
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#434655]">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('assets/icons/icon-lock.svg') }}" alt="" width="17" height="17" class="block">
                            </div>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-[#C3C6D7] bg-white py-[13px] pl-10 pr-10 text-base text-[#191B23] shadow-[0_1px_2px_rgba(0,0,0,0.05)] placeholder:text-[#737686] focus:border-[#2563EB] focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20"
                            >
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 flex items-center pr-3" data-target="password_confirmation" aria-label="Tampilkan kata sandi">
                                <img src="{{ asset('assets/icons/icon-eye.svg') }}" alt="" width="18" height="17" class="block">
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-3 px-0 pb-4 pt-2">
                    <input
                        id="terms"
                        type="checkbox"
                        name="terms"
                        required
                        class="mt-0.5 h-4 w-4 shrink-0 rounded border border-[#C3C6D7] text-[#2563EB] focus:ring-[#2563EB]/20"
                    >
                    <label for="terms" class="text-sm leading-5 text-[#434655]">
                        Saya setuju dengan
                        <a href="#" class="text-[#004AC6] hover:opacity-90">Ketentuan Layanan</a>
                        dan
                        <a href="#" class="text-[#004AC6] hover:opacity-90">Kebijakan Privasi</a>.
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#2563EB] py-3 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white shadow-[0_4px_20px_rgba(37,99,235,0.2)] transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#2563EB]/30"
                >
                    Daftar Sekarang
                    <img src="{{ asset('assets/icons/icon-arrow-right-sm.svg') }}" alt="" width="13" height="13" class="block">
                </button>
            </form>

            {{-- Footer --}}
            <div class="rounded-b-xl border-t border-[rgba(195,198,215,0.2)] bg-[rgba(237,237,249,0.5)] px-6 py-4 text-center text-sm leading-5 text-[#434655]">
                Sudah punya akun?
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="font-semibold text-[#004AC6] hover:opacity-90">Masuk</a>
                @else
                    <a href="#" class="font-semibold text-[#004AC6] hover:opacity-90">Masuk</a>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.password-toggle').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
</body>
</html>
