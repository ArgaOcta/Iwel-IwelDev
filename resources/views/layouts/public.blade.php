<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SCMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#191b23] antialiased min-h-screen flex flex-col justify-between">

    <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-white/40 shadow-[0_2px_20px_rgba(0,0,0,0.02)] transition-all duration-300">
        <div class="mx-auto max-w-[1232px] px-4 sm:px-6 flex h-20 items-center justify-between">
            
            <a href="{{ url('/') }}" class="flex items-center gap-3 group transition-transform duration-300 hover:scale-105">
                <div class="w-10 h-10 bg-white rounded-xl border border-[#e1e2ed] flex items-center justify-center shadow-sm group-hover:-rotate-6 transition-transform duration-300">
                    <img src="{{ asset('assets/icons/logo.svg') }}" alt="SCMS Logo" width="26" height="21" class="block">
                </div>
                <div class="flex flex-col">
                    <span class="text-[#191b23] font-extrabold text-lg tracking-tight leading-none">SCMS</span>
                    <span class="text-[#505f76] text-[11px] font-semibold tracking-wider mt-0.5 uppercase">Aspirasi Kampus</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-1 bg-gray-100/50 p-1.5 rounded-full border border-gray-200/40">
                <a href="{{ url('/') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->is('/') ? 'bg-[#004ac6] text-white shadow-sm' : 'text-[#505f76] hover:text-[#004ac6] hover:bg-white/50' }}">Beranda</a>
                <a href="{{ route('how-it-works') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->routeIs('how-it-works') ? 'bg-[#004ac6] text-white shadow-sm' : 'text-[#505f76] hover:text-[#004ac6] hover:bg-white/50' }}">Cara Kerja</a>
                <a href="{{ route('about') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->routeIs('about') ? 'bg-[#004ac6] text-white shadow-sm' : 'text-[#505f76] hover:text-[#004ac6] hover:bg-white/50' }}">Tentang</a>
                <a href="{{ route('faq') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->routeIs('faq') ? 'bg-[#004ac6] text-white shadow-sm' : 'text-[#505f76] hover:text-[#004ac6] hover:bg-white/50' }}">FAQ</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-bold text-[#505f76] hover:text-[#004ac6] px-4 py-2 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[#004ac6] text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md shadow-[#004ac6]/10 hover:bg-blue-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">Daftar</a>
            </div>

            <div x-data="{ mobileOpen: false }" class="md:hidden">
                <button @click="mobileOpen = !mobileOpen" class="p-2 text-[#191b23] hover:bg-gray-100 rounded-xl transition-colors">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </button>
                
                <div x-show="mobileOpen" @click.away="mobileOpen = false" style="display: none;" class="absolute left-4 right-4 top-24 bg-white/95 backdrop-blur-2xl rounded-2xl border border-gray-100 p-5 shadow-xl flex flex-col gap-3" x-transition>
                    <a href="{{ url('/') }}" class="p-3 text-base font-bold rounded-xl {{ request()->is('/') ? 'bg-blue-50 text-[#004ac6]' : 'text-[#505f76]' }}">Beranda</a>
                    <a href="{{ route('how-it-works') }}" class="p-3 text-base font-bold rounded-xl {{ request()->routeIs('how-it-works') ? 'bg-blue-50 text-[#004ac6]' : 'text-[#505f76]' }}">Cara Kerja</a>
                    <a href="{{ route('about') }}" class="p-3 text-base font-bold rounded-xl {{ request()->routeIs('about') ? 'bg-blue-50 text-[#004ac6]' : 'text-[#505f76]' }}">Tentang</a>
                    <a href="{{ route('faq') }}" class="p-3 text-base font-bold rounded-xl {{ request()->routeIs('faq') ? 'bg-blue-50 text-[#004ac6]' : 'text-[#505f76]' }}">FAQ</a>
                    <div class="h-px bg-gray-100 my-1"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" class="w-full py-3 text-center text-sm font-bold text-[#505f76] bg-gray-50 rounded-xl">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full py-3 text-center text-sm font-bold text-white bg-[#004ac6] rounded-xl shadow-sm">Daftar</a>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 py-8 text-center text-sm text-[#737686] font-medium">
        <div class="mx-auto max-w-[1232px] px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} SCMS. Hak Cipta Dilindungi.</p>
            <div class="flex gap-6 text-[#505f76]">
                <a href="{{ route('about') }}" class="hover:text-[#004ac6] transition-colors">Tentang Sistem</a>
                <a href="{{ route('faq') }}" class="hover:text-[#004ac6] transition-colors">Pusat Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>