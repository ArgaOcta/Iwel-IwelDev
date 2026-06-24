@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(25px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(25px, -40px) scale(1.05); }
            66% { transform: translate(-15px, 20px) scale(0.95); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-fade-up { animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-blob { animation: blob 8s infinite ease-in-out; }
        .animation-delay-2000 { animation-delay: 2s; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 10px 30px 0 rgba(31, 38, 135, 0.04);
        }
    </style>

    <div class="fixed inset-0 w-full h-full z-[-1] bg-[#f8fafc] overflow-hidden pointer-events-none">
        <div class="absolute top-10 -left-10 w-96 h-96 bg-[#d0e1fb]/60 rounded-full filter blur-3xl opacity-40 animate-blob"></div>
        <div class="absolute top-20 -right-10 w-96 h-96 bg-[#e7e7f3]/60 rounded-full filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
    </div>

    {{-- Hero Section --}}
    <section class="relative px-4 sm:px-6 pb-20 pt-20 lg:pt-24">
        <div class="mx-auto max-w-[1232px] grid grid-cols-1 items-center gap-12 lg:grid-cols-2 opacity-0 animate-fade-up">
            
            <div class="flex flex-col gap-6">
                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-white border border-gray-200 px-4 py-1.5 text-xs font-bold tracking-wide text-[#004ac6] shadow-sm">
                    <span class="flex h-2 w-2 relative">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Portal Layanan Mahasiswa Resmi
                </div>

                <h1 class="text-4xl font-black leading-[1.15] tracking-tight text-[#191B23] sm:text-5xl lg:text-[54px]">
                    Mengenal <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#004ac6] to-[#2563eb]">SCMS</span>,<br>
                    Suara Anda untuk Perubahan Kampus
                </h1>

                <p class="max-w-[500px] text-base sm:text-lg leading-relaxed text-[#434655] font-medium">
                    <b class="text-[#004ac6]">SCMS (Student Complaint Management System)</b> adalah wadah digital resmi untuk menyampaikan keluhan, saran, atau masalah fasilitas di kampus. Di sini, laporan Anda dijamin aman, diproses cepat, dan bisa dipantau langsung sampai tuntas.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-[#004ac6] px-8 py-3.5 text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:shadow-[0_8px_25px_rgba(0,74,198,0.35)] hover:bg-blue-800">
                        Buat Laporan Baru
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="transition-transform group-hover:translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('how-it-works') }}" class="inline-flex items-center justify-center rounded-xl bg-white/80 border border-gray-200 px-8 py-3.5 text-sm font-bold text-[#191b23] transition-all duration-300 hover:scale-105 hover:bg-white hover:shadow-sm">
                        Lihat Alur Kerja
                    </a>
                </div>
            </div>

            <div class="relative mt-4 lg:mt-0 group opacity-0 animate-fade-up" style="animation-delay: 150ms;">
                <div class="absolute -inset-2 bg-gradient-to-r from-[#004ac6]/20 to-transparent rounded-[2rem] blur-xl opacity-50"></div>
                <div class="relative transform transition-transform duration-500 hover:-translate-y-1">
                    <img src="{{ asset('assets/icons/mac.webp') }}" alt="Pratinjau SCMS" class="block w-full object-cover">
                </div>
                
                <div class="absolute -bottom-6 -left-4 sm:-left-8 bg-white/90 backdrop-blur-md border border-gray-100 rounded-2xl p-4 shadow-lg transform transition-transform duration-300 hover:scale-105">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#004ac6]">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-xs sm:text-sm font-extrabold text-[#191b23]">Enkripsi Data 256-bit</p>
                            <p class="text-[11px] text-[#505f76] font-semibold">Identitas & Laporan Anda Aman</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Banner Angka Statis (Trust Section) --}}
    <section class="border-y border-gray-200/50 bg-white/50 backdrop-blur-md py-8">
        <div class="mx-auto max-w-[1280px] px-4 sm:px-6">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 text-center">
                <div class="flex flex-col">
                    <span class="text-2xl sm:text-3xl font-black text-[#004ac6]">100%</span>
                    <span class="text-xs sm:text-sm font-bold text-[#505f76] mt-0.5">Sistem Transparan</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl sm:text-3xl font-black text-[#004ac6]">&lt; 24 Jam</span>
                    <span class="text-xs sm:text-sm font-bold text-[#505f76] mt-0.5">Tanggapan Awal Staf</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl sm:text-3xl font-black text-[#004ac6]">Pilihan Anonim</span>
                    <span class="text-xs sm:text-sm font-bold text-[#505f76] mt-0.5">Bebas Laporkan Apa Saja</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl sm:text-3xl font-black text-[#004ac6]">Mudah Diakses</span>
                    <span class="text-xs sm:text-sm font-bold text-[#505f76] mt-0.5">Bisa Lewat HP / Laptop</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Kenapa Harus Menggunakan SCMS? --}}
    <section class="py-20 relative">
        <div class="mx-auto flex max-w-[1280px] flex-col items-center gap-12 px-4 sm:px-6">
            <header class="flex max-w-xl flex-col gap-3 text-center opacity-0 animate-fade-up">
                <h2 class="text-3xl font-black text-[#191B23]">Kenapa Harus Pakai SCMS?</h2>
                <p class="text-base text-[#505f76]">Kami memotong jalur birokrasi yang rumit agar semua keluhan Anda didengar langsung oleh bagian yang bertanggung jawab.</p>
            </header>

            <div class="grid w-full grid-cols-1 gap-6 md:grid-cols-3 opacity-0 animate-fade-up" style="animation-delay: 100ms;">
                <article class="glass-panel flex flex-col gap-3 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-[#004ac6]/20 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#004ac6] group-hover:scale-110 transition-transform">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#191B23]">Pasti Sampai ke Tujuan</h3>
                    <p class="text-sm text-[#505f76] leading-relaxed">Setiap laporan dikelompokkan otomatis berdasarkan kategorinya, jadi tidak akan salah alamat atau mengendap tanpa kejelasan.</p>
                </article>

                <article class="glass-panel flex flex-col gap-3 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-[#004ac6]/20 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#004ac6] group-hover:scale-110 transition-transform">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#191B23]">Bisa Dipantau Terus</h3>
                    <p class="text-sm text-[#505f76] leading-relaxed">Anda bisa melihat riwayat pengerjaan dari admin. Mulai dari status dibaca, ditinjau, sedang dikerjakan, sampai selesai.</p>
                </article>

                <article class="glass-panel flex flex-col gap-3 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-[#004ac6]/20 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#004ac6] group-hover:scale-110 transition-transform">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12 3 7.582 7.03 4 12 4s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#191B23]">Fitur Diskusi Interaktif</h3>
                    <p class="text-sm text-[#505f76] leading-relaxed">Jika ada detail laporan yang kurang lengkap, staf berwenang bisa langsung bertanya pada Anda melalui kolom komentar tiket.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- Call to Action Besar --}}
    <section class="py-20 relative z-10 mx-4 sm:mx-6 max-w-[1280px] lg:mx-auto mb-10">
        <div class="rounded-[2.5rem] bg-[#004ac6] px-6 py-16 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#b4c5ff] opacity-20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
            
            <div class="relative z-10 flex flex-col items-center gap-6 opacity-0 animate-fade-up">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Jangan Diam Saja. Laporkan!</h2>
                <p class="text-lg text-white/80 max-w-xl">Bergabunglah dalam menciptakan lingkungan kampus yang lebih baik. Satu laporan Anda bisa membawa perubahan besar.</p>
                <a href="{{ route('register') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-white px-8 py-4 text-base font-bold text-[#004ac6] transition-transform hover:scale-105 hover:shadow-lg">
                    Daftar Sekarang Secara Gratis
                </a>
            </div>
        </div>
    </section>
@endsection