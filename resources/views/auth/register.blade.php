<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — SCMS</title>
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
<body class="min-h-screen bg-[#f8fafc] font-['Manrope',system-ui,sans-serif] text-[#191B23] antialiased flex items-center justify-center p-4 py-12 relative overflow-hidden">

    <div class="fixed inset-0 w-full h-full z-[-1] pointer-events-none">
        <div class="absolute top-10 left-10 w-96 h-96 bg-[#d0e1fb]/60 rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#e7e7f3]/70 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <a href="{{ url('/') }}" class="absolute top-6 left-6 sm:top-8 sm:left-8 flex items-center gap-2 text-[#505f76] hover:text-[#004ac6] transition-colors group z-40">
        <div class="w-10 h-10 bg-white border border-[#c3c6d7] rounded-full flex items-center justify-center shadow-sm group-hover:-translate-x-1 transition-transform">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </div>
        <span class="font-bold text-sm hidden sm:block">Kembali</span>
    </a>

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity.duration.500ms class="fixed top-6 right-6 max-sm:left-4 max-sm:right-4 z-50 flex flex-col gap-3">
            <div class="bg-white border-l-4 border-l-red-500 p-4 rounded-xl shadow-xl flex items-start gap-3 w-full sm:w-[340px]">
                <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Pendaftaran Gagal!</h4>
                    <ul class="text-xs text-red-600 mt-1 list-disc pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="glass-panel w-full max-w-[480px] rounded-3xl p-8 sm:p-10 relative z-10">
        
        <div class="flex flex-col items-center gap-3 mb-8 text-center">
            <div class="w-12 h-12 bg-[#004ac6] rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-[#191B23]">Buat Akun Baru</h1>
                <p class="text-sm text-[#505f76] mt-1">Lengkapi data diri sesuai identitas kampus.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf
            
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-sm font-bold text-[#191b23]">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg width="18" height="18" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Bahlil Manis" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-2.5 pl-11 pr-4 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="nim" class="text-sm font-bold text-[#191b23]">Nomor Induk Mahasiswa (NIM)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg width="18" height="18" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 01102240..." class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-2.5 pl-11 pr-4 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-sm font-bold text-[#191b23]">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg width="18" height="18" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@kampus.edu" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-2.5 pl-11 pr-4 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div x-data="{ showPass: false }" class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-bold text-[#191b23]">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" :type="showPass ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-2.5 pl-4 pr-10 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#737686] hover:text-[#004ac6] z-10">
                            <svg x-show="!showPass" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg x-show="showPass" style="display:none;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a2 2 0 1 1-2.83-2.83l18-18a2 2 0 0 1 2.83 2.83z"></path></svg>
                        </button>
                    </div>
                </div>

                <div x-data="{ showConf: false }" class="flex flex-col gap-1.5">
                    <label for="password_confirmation" class="text-sm font-bold text-[#191b23]">Konfirmasi Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showConf ? 'text' : 'password'" name="password_confirmation" required placeholder="••••••••" class="w-full bg-white/70 rounded-xl border border-[#c3c6d7] py-2.5 pl-4 pr-10 text-sm text-[#191b23] focus:outline-none focus:border-[#004AC6] focus:ring-1 focus:ring-[#004AC6] focus:bg-white transition-colors placeholder:text-[#a0a3b1]">
                        <button type="button" @click="showConf = !showConf" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#737686] hover:text-[#004ac6] z-10">
                            <svg x-show="!showConf" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg x-show="showConf" style="display:none;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a2 2 0 1 1-2.83-2.83l18-18a2 2 0 0 1 2.83 2.83z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-4 w-full bg-[#004AC6] hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#004ac6]/30 transition-all hover:-translate-y-0.5 hover:shadow-xl active:scale-95 flex items-center justify-center gap-2">
                Daftar Sekarang
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>

        <div class="mt-6 text-center border-t border-gray-200 pt-6">
            <p class="text-sm text-[#505f76] font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#004AC6] hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>