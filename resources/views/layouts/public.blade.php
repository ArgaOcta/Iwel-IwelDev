<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SCMS') — Sistem Manajemen Pengaduan Mahasiswa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-gradient-to-b from-[#FAF8FF] to-white font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased scroll-smooth">
    @php
        $active = $activeNav ?? '';
        $navClass = fn (string $item) => $active === $item
            ? 'text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6]'
            : 'text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#191B23] transition-colors hover:text-[#004AC6]';
    @endphp

    <header class="sticky top-0 z-50 bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
        <div class="mx-auto flex h-16 max-w-[1280px] items-center justify-between gap-6 px-6">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/icons/logo.svg') }}" alt="" width="26" height="21" class="block">
                <span class="text-2xl font-bold leading-8 text-[#004AC6]">SCMS</span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="Utama">
                <a href="{{ Route::has('how-it-works') ? route('how-it-works') : url('/how-it-works') }}" class="{{ $navClass('how-it-works') }}">Cara Kerja</a>
                <a href="{{ Route::has('about') ? route('about') : url('/about') }}" class="{{ $navClass('about') }}">Tentang Kami</a>
                <a href="{{ Route::has('faq') ? route('faq') : url('/faq') }}" class="{{ $navClass('faq') }}">FAQ</a>
            </nav>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6] transition-opacity hover:opacity-90">Masuk</a>
                @else
                    <a href="#" class="text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#004AC6]">Masuk</a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-[#004AC6] px-4 py-2 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white shadow-[0_4px_20px_rgba(0,0,0,0.04)] transition-opacity hover:opacity-90">Daftar</a>
                @else
                    <a href="#" class="inline-flex items-center justify-center rounded-lg bg-[#004AC6] px-4 py-2 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-white shadow-[0_4px_20px_rgba(0,0,0,0.04)] transition-opacity hover:opacity-90">Daftar</a>
                @endif
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-[rgba(195,198,215,0.3)] bg-[#FAF8FF] py-12">
        <div class="mx-auto flex max-w-[1280px] flex-wrap items-center justify-between gap-6 px-6 max-sm:flex-col max-sm:items-start">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/icons/footer-logo.svg') }}" alt="" width="22" height="18" class="block">
                <span class="text-[13px] font-bold leading-[18px] tracking-[0.05em] text-[#191B23]">Sistem Manajemen Pengaduan Mahasiswa</span>
            </div>
            <p class="text-sm leading-5 text-[#434655]">
                © {{ date('Y') }} SCMS. Hak cipta dilindungi undang-undang. Platform Institusi.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
