<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — SCMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 8s infinite ease-in-out; }
        .animation-delay-2000 { animation-delay: 2s; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 15px 35px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen bg-[#f8fafc] font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased flex items-center justify-center p-4 relative overflow-hidden">

    <div class="fixed inset-0 w-full h-full z-[-1] pointer-events-none">
        <div class="absolute top-10 left-10 w-96 h-96 bg-[#d0e1fb]/60 rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#e7e7f3]/70 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <a href="{{ url('/') }}" class="absolute top-6 left-6 sm:top-8 sm:left-8 flex items-center gap-2 text-[#505f76] hover:text-[#004ac6] transition-colors group z-40">
        <div class="w-10 h-10 bg-white border border-[#c3c6d7] rounded-full flex items-center justify-center shadow-sm group-hover:-translate-x-1 transition-transform">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </div>
        <span class="font-bold text-sm hidden sm:block">Kembali ke Beranda</span>
    </a>

    @if (session('status') || $errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.opacity.duration.500ms class="fixed top-6 right-6 max-sm:left-4 max-sm:right-4 z-50 flex flex-col gap-3">
            @if(session('status'))
                <div class="bg-white border-l-4 border-l-green-500 p-4 rounded-xl shadow-xl flex items-start gap-3 w-full sm:w-80">
                    <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Berhasil!</h4>
                        <p class="text-xs text-gray-600 mt-0.5">{{ session('status') }}</p>
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-white border-l-4 border-l-red-500 p-4 rounded-xl shadow-xl flex items-start gap-3 w-full sm:w-80">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Gagal Masuk!</h4>
                        <p class="text-xs text-red-600 mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="glass-panel w-full max-w-[420px] rounded-3xl p-8 sm:p-10 relative z-10">
        
        <div class="flex flex-col items-center gap-3 mb-8 text-center">
            <div class="w-14 h-14 bg-white border border-[#e1e2ed] rounded-2xl flex items-center justify-center shadow-sm">
                <img src="{{ asset('assets/icons/logo.svg') }}" alt="SCMS Logo" width="30" height="25" class="block">
            </div>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-[#191B23]">Selamat Datang</h1>
                <p class="text-sm text-[#505f76] mt-1">Masuk untuk mengelola laporan Anda.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
            @csrf
            
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-sm font-bold text-[#191b23]">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg width="18" height="18" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@kampus.edu" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-3 pl-11 pr-4 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                </div>
            </div>

            <div x-data="{ showPassword: false }" class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-bold text-[#191b23]">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#004AC6] hover:underline">Lupa Sandi?</a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg width="18" height="18" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-3 pl-11 pr-12 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                    
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#737686] hover:text-[#004ac6] z-10">
                        <svg x-show="!showPassword" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <svg x-show="showPassword" style="display:none;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a2 2 0 1 1-2.83-2.83l18-18a2 2 0 0 1 2.83 2.83z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#004AC6] bg-white border-gray-300 rounded focus:ring-[#004AC6] cursor-pointer">
                <label for="remember_me" class="ml-2 text-sm text-[#434655] font-medium cursor-pointer">Ingat Saya</label>
            </div>

            <button type="submit" class="mt-2 w-full bg-[#004AC6] hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#004ac6]/30 transition-all hover:-translate-y-0.5 hover:shadow-xl active:scale-95 flex items-center justify-center gap-2">
                Masuk
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-200 pt-6">
            <p class="text-sm text-[#505f76] font-medium">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-[#004AC6] hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</body>
</html>