@extends('layouts.public')

@section('title', 'Cara Kerja')

@php($activeNav = 'how-it-works')

@section('content')
    <style>
        @keyframes fadeUp { 0% { opacity: 0; transform: translateY(30px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .glass-panel { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.8); }
        .timeline-line::before { content: ''; position: absolute; left: 23px; top: 40px; bottom: -40px; width: 2px; background: linear-gradient(to bottom, #004ac6, transparent); z-index: 0; }
        li:last-child .timeline-line::before { display: none; }
    </style>

    {{-- Hero --}}
    <section class="relative overflow-hidden pt-28 pb-16 bg-[#f8fafc]">
        <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(#c3c6d7 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative mx-auto flex max-w-[1280px] flex-col items-center gap-6 px-6 text-center opacity-0 animate-fade-up">
            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-blue-100 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#004ac6]">
                Alur Proses
            </div>
            <h1 class="text-4xl font-extrabold leading-tight text-[#191B23] sm:text-5xl">Jalur Transparan<br/>Menuju Resolusi</h1>
            <p class="max-w-2xl text-lg text-[#505f76]">
                Kami mendesain alur kerja yang logis, aman, dan tanpa hambatan. Dari laporan pertama hingga penyelesaian, Anda tidak akan pernah kehilangan jejak.
            </p>
        </div>
    </section>

    {{-- 4-Step Process --}}
    <section class="px-6 py-20 relative bg-[#f8fafc]">
        <div class="mx-auto grid max-w-[1280px] grid-cols-1 gap-16 lg:grid-cols-2 lg:items-center">
            
            <div class="flex flex-col gap-6 opacity-0 animate-fade-up" style="animation-delay: 100ms;">
                <ul class="relative space-y-8">
                    
                    <li class="relative pl-16 group timeline-line">
                        <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-2xl bg-white border-2 border-[#e1e2ed] shadow-sm transition-all duration-300 group-hover:bg-[#004ac6] group-hover:border-[#004ac6] group-hover:scale-110 group-hover:shadow-lg group-hover:-rotate-3 z-10 text-[#004ac6] group-hover:text-white">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl transition-transform hover:-translate-y-1">
                            <h3 class="text-xl font-bold text-[#191B23] mb-2">1. Pengajuan Laporan</h3>
                            <p class="text-base text-[#505f76]">Mahasiswa mengisi formulir cerdas kami, melampirkan bukti foto/dokumen, dan menentukan tingkat urgensi.</p>
                        </div>
                    </li>

                    <li class="relative pl-16 group timeline-line">
                        <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-2xl bg-white border-2 border-[#e1e2ed] shadow-sm transition-all duration-300 group-hover:bg-[#004ac6] group-hover:border-[#004ac6] group-hover:scale-110 group-hover:shadow-lg group-hover:-rotate-3 z-10 text-[#004ac6] group-hover:text-white">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="21" y1="8" x2="21" y2="21"></line><line x1="9" y1="8" x2="9" y2="21"></line><line x1="5" y1="3" x2="19" y2="3"></line></svg>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl transition-transform hover:-translate-y-1">
                            <h3 class="text-xl font-bold text-[#191B23] mb-2">2. Triase Otomatis</h3>
                            <p class="text-base text-[#505f76]">Sistem memilah dan mengarahkan tiket langsung ke dasbor departemen terkait (Fasilitas, Academic, dll) secara instan.</p>
                        </div>
                    </li>

                    <li class="relative pl-16 group timeline-line">
                        <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-2xl bg-white border-2 border-[#e1e2ed] shadow-sm transition-all duration-300 group-hover:bg-[#004ac6] group-hover:border-[#004ac6] group-hover:scale-110 group-hover:shadow-lg group-hover:-rotate-3 z-10 text-[#004ac6] group-hover:text-white">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl transition-transform hover:-translate-y-1">
                            <h3 class="text-xl font-bold text-[#191B23] mb-2">3. Investigasi & Resolusi</h3>
                            <p class="text-base text-[#505f76]">Admin meninjau masalah dan berkomunikasi dua arah dengan pelapor melalui fitur obrolan *real-time* di dalam tiket.</p>
                        </div>
                    </li>

                    <li class="relative pl-16 group timeline-line">
                        <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-2xl bg-white border-2 border-[#e1e2ed] shadow-sm transition-all duration-300 group-hover:bg-[#004ac6] group-hover:border-[#004ac6] group-hover:scale-110 group-hover:shadow-lg group-hover:-rotate-3 z-10 text-[#004ac6] group-hover:text-white">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl transition-transform hover:-translate-y-1">
                            <h3 class="text-xl font-bold text-[#191B23] mb-2">4. Ulasan Penutup</h3>
                            <p class="text-base text-[#505f76]">Setelah masalah selesai, mahasiswa memberikan skor kepuasan (Rating) untuk membantu institusi menjaga kualitas layanan.</p>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="relative opacity-0 animate-fade-up perspective-1000" style="animation-delay: 200ms;">
                <div class="absolute -inset-4 bg-gradient-to-r from-[#004ac6] to-transparent rounded-full blur-2xl opacity-20"></div>
                <div class="relative transform transition-transform duration-700 hover:rotate-2 hover:scale-[1.03]">
                    <img src="{{ asset('assets/icons/phone.png') }}" alt="Dasbor Institusi" class="block w-full">
                </div>
            </div>
        </div>
    </section>
@endsection