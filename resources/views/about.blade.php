@extends('layouts.public')

@section('title', 'Tentang Kami')

@php($activeNav = 'about')

@section('content')
    <style>
        @keyframes fadeUp { 0% { opacity: 0; transform: translateY(30px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.6); }
    </style>

    <div class="bg-[#f8fafc] overflow-hidden relative">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#d0e1fb] rounded-full mix-blend-multiply blur-3xl opacity-40"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#c3c6d7] rounded-full mix-blend-multiply blur-3xl opacity-30"></div>

        {{-- Hero --}}
        <section class="relative px-6 py-28 z-10">
            <div class="mx-auto flex max-w-4xl flex-col items-center gap-8 text-center opacity-0 animate-fade-up">
                <div class="p-4 bg-white rounded-3xl shadow-sm border border-[#e1e2ed] mb-2 transform hover:scale-110 transition-transform">
                    <svg width="40" height="40" fill="none" stroke="#004ac6" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h1 class="text-4xl font-extrabold leading-[1.2] text-[#191B23] sm:text-5xl">
                    Memberdayakan Suara Mahasiswa dengan Kejelasan & Kepercayaan
                </h1>
                <p class="text-lg leading-relaxed text-[#505f76]">
                    Sistem Manajemen Pengaduan Mahasiswa (SCMS) tidak sekadar meneruskan pesan. Kami membangun infrastruktur komunikasi institusional yang menjamin transparansi absolut, pelacakan ketat, dan perlindungan privasi di setiap titik kontak.
                </p>
            </div>
        </section>

        {{-- Core Values (Kotak Interaktif) --}}
        <section class="px-6 pb-28 relative z-10">
            <div class="mx-auto max-w-[1280px]">
                <div class="mb-14 text-center opacity-0 animate-fade-up" style="animation-delay: 100ms;">
                    <h2 class="text-3xl font-extrabold text-[#191B23]">Tiga Pilar Integritas Sistem</h2>
                </div>
                
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3 opacity-0 animate-fade-up" style="animation-delay: 200ms;">
                    
                    <article class="glass-panel rounded-[2rem] p-10 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                        <div class="w-16 h-16 bg-[#004ac6] rounded-2xl flex items-center justify-center text-white mb-6 group-hover:rotate-12 transition-transform duration-300 shadow-md">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#191B23] mb-4">Struktur Pasti</h3>
                        <p class="text-base text-[#505f76] leading-relaxed">
                            Tidak ada lagi laporan yang hilang di tumpukan email. Setiap masalah dienkapsulasi menjadi tiket khusus dan diurutkan menggunakan sistem triase otomatis berdasarkan urgensi.
                        </p>
                    </article>

                    <article class="glass-panel rounded-[2rem] p-10 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                        <div class="w-16 h-16 bg-[#191b23] rounded-2xl flex items-center justify-center text-white mb-6 group-hover:rotate-12 transition-transform duration-300 shadow-md">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#191B23] mb-4">Pantauan Waktu Nyata</h3>
                        <p class="text-base text-[#505f76] leading-relaxed">
                            Dasbor interaktif kami menghapus kebutaan informasi. Anda, beserta pihak administrasi, dapat melihat perkembangan resolusi detik demi detik dari layar mana pun.
                        </p>
                    </article>

                    <article class="glass-panel rounded-[2rem] p-10 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                        <div class="w-16 h-16 bg-white border-2 border-[#e1e2ed] rounded-2xl flex items-center justify-center text-[#004ac6] mb-6 group-hover:-rotate-12 transition-transform duration-300 shadow-sm">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#191B23] mb-4">Proteksi Total</h3>
                        <p class="text-base text-[#505f76] leading-relaxed">
                            Bicara tanpa rasa takut. Sistem pelaporan kami menyertakan opsi 'Anonim' berlapis enkripsi yang melindungi identitas pelapor dari mata staf lapangan.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </div>
@endsection