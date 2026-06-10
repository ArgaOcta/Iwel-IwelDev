@extends('layouts.public')

@section('title', 'FAQ')

@php($activeNav = 'faq')

@section('content')
    <section class="px-6 py-24">
        <div class="mx-auto max-w-[1280px]">
            {{-- Header & Search --}}
            <div class="mb-12 flex flex-col items-center gap-6 text-center">
                <h1 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">Apa yang bisa kami bantu?</h1>
                <p class="max-w-2xl text-base leading-6 text-[#434655]">
                    Temukan jawaban untuk pertanyaan umum tentang Sistem Manajemen Pengaduan
                    Mahasiswa, akun Anda, dan proses resolusi pengaduan.
                </p>
                <div class="relative w-full max-w-xl">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <img src="{{ asset('assets/icons/icon-search.svg') }}" alt="" width="18" height="18" class="block opacity-70">
                    </div>
                    <input
                        type="search"
                        id="faq-search"
                        placeholder="Cari jawaban..."
                        class="w-full rounded-lg border border-[#C3C6D7] bg-white py-3.5 pl-11 pr-4 text-base text-[#191B23] shadow-[0_4px_20px_rgba(0,0,0,0.04)] placeholder:text-[#737686] focus:border-[#004AC6] focus:outline-none focus:ring-2 focus:ring-[#004AC6]/20"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[280px_1fr]">
                {{-- Categories --}}
                <aside class="h-fit rounded-xl border border-[rgba(195,198,215,0.3)] bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <h2 class="mb-4 text-lg font-semibold leading-7 text-[#191B23]">Kategori</h2>
                    <nav class="flex flex-col gap-1" id="faq-categories">
                        @foreach ([
                            'general' => 'Informasi Umum',
                            'account' => 'Akun Mahasiswa',
                            'process' => 'Proses Pengaduan',
                            'privacy' => 'Privasi & Keamanan',
                        ] as $id => $label)
                            <button
                                type="button"
                                data-category="{{ $id }}"
                                class="faq-category flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-left text-[13px] font-semibold leading-[18px] tracking-[0.05em] transition-colors {{ $id === 'general' ? 'bg-[#D0E1FB] text-[#004AC6]' : 'text-[#434655] hover:bg-[#FAF8FF]' }}"
                            >
                                {{ $label }}
                                @if ($id === 'general')
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" width="8" height="12" class="block rotate-[-90deg]">
                                @endif
                            </button>
                        @endforeach
                    </nav>
                </aside>

                {{-- FAQ Accordion --}}
                <div class="flex flex-col gap-10" id="faq-content">
                    <div class="faq-group" data-category="general">
                        <div class="mb-4 flex items-center gap-3 border-b border-[#C3C6D7] pb-4">
                            <img src="{{ asset('assets/icons/icon-faq-general.svg') }}" alt="" width="20" height="20" class="block">
                            <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Informasi Umum</h3>
                        </div>
                        <div class="flex flex-col gap-3">
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)] open:shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Apa itu Sistem Manajemen Pengaduan Mahasiswa?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    SCMS adalah platform resmi institusi untuk mengajukan, melacak, dan menyelesaikan pengaduan mahasiswa secara terstruktur, aman, dan transparan.
                                </div>
                            </details>
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Siapa saja yang dapat menggunakan sistem ini?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    Seluruh mahasiswa terdaftar di institusi dapat mengakses SCMS menggunakan kredensial akun institusi mereka.
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-group hidden" data-category="account">
                        <div class="mb-4 flex items-center gap-3 border-b border-[#C3C6D7] pb-4">
                            <img src="{{ asset('assets/icons/icon-user.svg') }}" alt="" width="14" height="14" class="block">
                            <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Akun Mahasiswa</h3>
                        </div>
                        <div class="flex flex-col gap-3">
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Bagaimana cara membuat akun?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    Klik tombol Daftar di halaman utama, isi formulir pendaftaran dengan NIM dan email institusi Anda, lalu verifikasi akun melalui email.
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-group hidden" data-category="process">
                        <div class="mb-4 flex items-center gap-3 border-b border-[#C3C6D7] pb-4">
                            <img src="{{ asset('assets/icons/icon-faq-process.svg') }}" alt="" width="20" height="20" class="block">
                            <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Proses Pengaduan</h3>
                        </div>
                        <div class="flex flex-col gap-3">
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Berapa lama biasanya waktu yang dibutuhkan untuk menyelesaikan pengaduan?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    Waktu penyelesaian bervariasi tergantung kompleksitas kasus. Anda akan menerima pembaruan status secara berkala melalui dasbor pribadi.
                                </div>
                            </details>
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Dapatkah saya tetap anonim?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    Ya, SCMS menyediakan opsi pengajuan anonim untuk masalah sensitif. Identitas Anda tetap dilindungi dan hanya dapat diakses personel berwenang.
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-group hidden" data-category="privacy">
                        <div class="mb-4 flex items-center gap-3 border-b border-[#C3C6D7] pb-4">
                            <img src="{{ asset('assets/icons/icon-privacy.svg') }}" alt="" class="block h-5 w-5">
                            <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Privasi & Keamanan</h3>
                        </div>
                        <div class="flex flex-col gap-3">
                            <details class="group rounded-lg border border-[rgba(195,198,215,0.2)] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-base font-semibold leading-6 text-[#191B23] [&::-webkit-details-marker]:hidden">
                                    Bagaimana data saya dilindungi?
                                    <img src="{{ asset('assets/icons/icon-chevron-accordion.svg') }}" alt="" class="block shrink-0 transition-transform group-open:rotate-180">
                                </summary>
                                <div class="border-t border-[rgba(195,198,215,0.2)] px-5 py-4 text-sm leading-5 text-[#434655]">
                                    Semua data dienkripsi dan disimpan sesuai standar keamanan institusi. Hanya personel yang berwenang yang dapat mengakses informasi pengaduan.
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-16 flex flex-col items-center rounded-xl border border-[rgba(195,198,215,0.3)] bg-[#FAF8FF] p-10 text-center shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#2563EB]">
                    <img src="{{ asset('assets/icons/about-step-2.svg') }}" alt="" class="block h-6 w-6 brightness-0 invert">
                </div>
                <h2 class="text-lg font-semibold leading-7 text-[#191B23]">Masih butuh bantuan?</h2>
                <p class="mt-2 max-w-md text-sm leading-5 text-[#434655]">
                    Jika Anda tidak dapat menemukan jawaban yang Anda cari, tim
                    dukungan kami siap membantu Anda.
                </p>
                <a href="#" class="mt-6 inline-flex items-center justify-center rounded-lg bg-[#004AC6] px-6 py-3 text-base font-semibold leading-6 text-white shadow-[0_1px_2px_rgba(0,0,0,0.05)] transition-opacity hover:opacity-90">
                    Hubungi Dukungan
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
                b.classList.remove('bg-[#D0E1FB]', 'text-[#004AC6]');
                b.classList.add('text-[#434655]');
            });
            btn.classList.add('bg-[#D0E1FB]', 'text-[#004AC6]');
            btn.classList.remove('text-[#434655]');

            groups.forEach((g) => {
                g.classList.toggle('hidden', g.dataset.category !== target);
            });
        });
    });

    document.getElementById('faq-search')?.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('details').forEach((item) => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? '' : 'none';
        });
        groups.forEach((g) => g.classList.remove('hidden'));
    });
</script>
@endpush
