@extends('layouts.public')

@section('title', 'FAQ')

@php($activeNav = 'faq')

@section('content')
    <style>
        @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        .glass-panel { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.8); }
    </style>

    <section class="px-6 py-28 relative bg-[#f8fafc] overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#004ac6] rounded-full blur-[100px] opacity-10 pointer-events-none"></div>

        <div class="mx-auto max-w-[1000px] relative z-10">
            {{-- Header & Search Besar --}}
            <div class="mb-14 flex flex-col items-center gap-6 text-center opacity-0 animate-fade-up">
                <div class="inline-flex items-center gap-2 rounded-full bg-white border border-[#e1e2ed] px-4 py-1.5 text-sm font-bold text-[#191b23] shadow-sm">
                    Pusat Bantuan SCMS
                </div>
                <h1 class="text-4xl font-extrabold leading-tight text-[#191B23] sm:text-5xl">Ada Pertanyaan?</h1>
                
                <div class="relative w-full max-w-2xl mt-4 group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none transition-transform group-focus-within:scale-110">
                        <svg width="22" height="22" fill="none" stroke="#737686" stroke-width="2" viewBox="0 0 24 24" class="group-focus-within:stroke-[#004ac6] transition-colors"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                    <input type="search" id="faq-search" placeholder="Ketik kata kunci (misal: sandi, anonim...)" class="w-full rounded-2xl border-2 border-white bg-white/60 backdrop-blur-md py-5 pl-14 pr-6 text-lg text-[#191B23] shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 placeholder:text-[#737686] focus:border-[#004AC6] focus:bg-white focus:outline-none">
                </div>
            </div>

            <div class="mx-auto flex flex-col gap-8 opacity-0 animate-fade-up" style="animation-delay: 150ms;">
                
                {{-- Kategori (Pill Buttons) --}}
                <div class="flex flex-wrap justify-center gap-3">
                    <button data-category="general" class="faq-category rounded-full bg-[#004AC6] px-6 py-3 text-sm font-bold text-white shadow-md transition-transform hover:scale-105 active:scale-95">Umum</button>
                    <button data-category="process" class="faq-category rounded-full bg-white border border-[#e1e2ed] px-6 py-3 text-sm font-bold text-[#434655] shadow-sm transition-transform hover:scale-105 hover:border-[#004ac6] hover:text-[#004ac6] active:scale-95">Proses Laporan</button>
                    <button data-category="account" class="faq-category rounded-full bg-white border border-[#e1e2ed] px-6 py-3 text-sm font-bold text-[#434655] shadow-sm transition-transform hover:scale-105 hover:border-[#004ac6] hover:text-[#004ac6] active:scale-95">Akun Saya</button>
                </div>

                {{-- Accordion Area --}}
                <div class="flex flex-col gap-4 max-w-3xl mx-auto w-full">
                    
                    {{-- Grup Umum --}}
                    <div class="faq-group flex flex-col gap-4" data-category="general">
                        <details class="group glass-panel rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg" open>
                            <summary class="flex cursor-pointer items-center justify-between p-6 focus:outline-none select-none">
                                <span class="text-lg font-bold text-[#191B23] group-hover:text-[#004AC6] transition-colors">Siapa yang dapat menggunakan sistem SCMS?</span>
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f3f3fe] text-[#004AC6] transition-transform duration-300 group-open:rotate-180 group-open:bg-[#004ac6] group-open:text-white">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </summary>
                            <div class="border-t border-[#e1e2ed]/50 px-6 pb-6 pt-4 text-base text-[#505f76] leading-relaxed">
                                Sistem ini eksklusif bagi mahasiswa aktif dan staf institusi. Mahasiswa berperan sebagai pelapor masalah, sedangkan staf berwenang menggunakan portal ini untuk menginvestigasi dan menyelesaikan laporan.
                            </div>
                        </details>

                        <details class="group glass-panel rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                            <summary class="flex cursor-pointer items-center justify-between p-6 focus:outline-none select-none">
                                <span class="text-lg font-bold text-[#191B23] group-hover:text-[#004AC6] transition-colors">Apakah pengaduan saya bisa disamarkan (Anonim)?</span>
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f3f3fe] text-[#004AC6] transition-transform duration-300 group-open:rotate-180 group-open:bg-[#004ac6] group-open:text-white">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </summary>
                            <div class="border-t border-[#e1e2ed]/50 px-6 pb-6 pt-4 text-base text-[#505f76] leading-relaxed">
                                Ya. Kami menyediakan centang "Kirim sebagai Anonim" di formulir. Identitas Anda tidak akan bisa dilihat oleh staf atau departemen yang menyelesaikan masalah Anda.
                            </div>
                        </details>
                    </div>

                    {{-- Grup Proses --}}
                    <div class="faq-group flex hidden flex-col gap-4" data-category="process">
                        <details class="group glass-panel rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                            <summary class="flex cursor-pointer items-center justify-between p-6 focus:outline-none select-none">
                                <span class="text-lg font-bold text-[#191B23] group-hover:text-[#004AC6] transition-colors">Berapa lama estimasi keluhan ditangani?</span>
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f3f3fe] text-[#004AC6] transition-transform duration-300 group-open:rotate-180 group-open:bg-[#004ac6] group-open:text-white">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </summary>
                            <div class="border-t border-[#e1e2ed]/50 px-6 pb-6 pt-4 text-base text-[#505f76] leading-relaxed">
                                Target *SLA (Service Level Agreement)* institusi kami adalah merespons laporan Anda di bawah 24 jam. Namun untuk tahap penyelesaian fisik, rata-rata memakan waktu 3-7 hari kerja tergantung dari tingkat urgensi "Tinggi", "Sedang", atau "Rendah".
                            </div>
                        </details>
                    </div>

                    {{-- Grup Akun --}}
                    <div class="faq-group flex hidden flex-col gap-4" data-category="account">
                        <details class="group glass-panel rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                            <summary class="flex cursor-pointer items-center justify-between p-6 focus:outline-none select-none">
                                <span class="text-lg font-bold text-[#191B23] group-hover:text-[#004AC6] transition-colors">Saya lupa kata sandi, apa yang harus dilakukan?</span>
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f3f3fe] text-[#004AC6] transition-transform duration-300 group-open:rotate-180 group-open:bg-[#004ac6] group-open:text-white">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </summary>
                            <div class="border-t border-[#e1e2ed]/50 px-6 pb-6 pt-4 text-base text-[#505f76] leading-relaxed">
                                Navigasikan ke halaman Login, lalu klik tombol "Lupa Kata Sandi?". Sistem akan otomatis mengirimkan surel (email) reset kata sandi ke kotak masuk Anda.
                            </div>
                        </details>
                    </div>

                </div>
            </div>

            {{-- Kartu Kontak Dukungan Akhir --}}
            <div class="mt-16 mx-auto max-w-3xl glass-panel rounded-[2rem] p-10 text-center opacity-0 animate-fade-up border-t-[4px] border-t-[#004ac6]" style="animation-delay: 200ms;">
                <h3 class="text-2xl font-bold text-[#191B23] mb-2">Masih buntu?</h3>
                <p class="text-base text-[#505f76] mb-8">Admin kami siap membantu kesulitan teknis Anda melalui email bantuan institusi.</p>
                <a href="mailto:support@scms.edu" class="inline-flex items-center justify-center rounded-xl bg-[#191b23] px-8 py-3.5 text-base font-bold text-white transition-all hover:scale-105 hover:bg-black hover:shadow-xl">
                    Tulis Email Bantuan
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const categories = document.querySelectorAll('.faq-category');
    const groups = document.querySelectorAll('.faq-group');

    categories.forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.category;
            categories.forEach((b) => {
                b.classList.remove('bg-[#004AC6]', 'text-white', 'shadow-md');
                b.classList.add('bg-white', 'text-[#434655]', 'shadow-sm');
            });
            btn.classList.add('bg-[#004AC6]', 'text-white', 'shadow-md');
            btn.classList.remove('bg-white', 'text-[#434655]', 'shadow-sm');

            groups.forEach((g) => { g.classList.toggle('hidden', g.dataset.category !== target); });
        });
    });

    document.getElementById('faq-search')?.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('details').forEach((item) => {
            const question = item.querySelector('summary span').innerText.toLowerCase();
            const answer = item.querySelector('div').innerText.toLowerCase();
            item.style.display = (question.includes(query) || answer.includes(query)) ? 'block' : 'none';
            if (query.length > 2 && item.style.display === 'block') item.setAttribute('open', true);
        });
    });
</script>
@endpush