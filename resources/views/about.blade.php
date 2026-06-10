@extends('layouts.public')

@section('title', 'Tentang Kami')

@php($activeNav = 'about')

@section('content')
    {{-- Hero --}}
    <section class="bg-white px-6 py-24">
        <div class="mx-auto flex max-w-[1280px] flex-col items-center gap-6 text-center">
            <h1 class="max-w-4xl text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">
                Memberdayakan Suara Mahasiswa dengan Kejelasan dan<br>Kepercayaan
            </h1>
            <p class="max-w-3xl text-base leading-6 text-[#434655]">
                Sistem Manajemen Pengaduan Mahasiswa (SCMS) berdedikasi untuk menciptakan
                lingkungan institusi yang transparan, akuntabel, dan responsif. Kami memastikan setiap
                keluhan didengar, dilacak, dan diselesaikan dengan privasi dan efisiensi maksimal.
            </p>
        </div>
    </section>

    {{-- How SCMS Works --}}
    <section class="bg-[#FAF8FF] px-6 py-24">
        <div class="mx-auto max-w-[1280px]">
            <div class="mb-12 text-center">
                <h2 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">Bagaimana SCMS Bekerja</h2>
                <p class="mt-4 text-base leading-6 text-[#434655]">Proses yang efisien mulai dari pengajuan hingga resolusi.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <article class="flex flex-col items-center rounded-xl bg-white p-8 pb-[52px] text-center shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-[#D0E1FB]">
                        <img src="{{ asset('assets/icons/about-step-1.svg') }}" alt="" class="block h-6 w-6">
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">1. Pengajuan</h3>
                    <p class="mt-3 whitespace-pre-line text-sm leading-5 text-[#434655]">
                        Mahasiswa mengajukan keluhan secara aman
                        melalui portal yang mudah diakses,
                        dikategorikan untuk perutean yang tepat.
                    </p>
                </article>

                <article class="flex flex-col items-center rounded-xl bg-white p-8 pb-[52px] text-center shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-[#D0E1FB]">
                        <img src="{{ asset('assets/icons/about-step-2.svg') }}" alt="" class="block h-6 w-6">
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">2. Triase & Perutean</h3>
                    <p class="mt-3 whitespace-pre-line text-sm leading-5 text-[#434655]">
                        Sistem otomatis kami meneruskan pengaduan
                        ke kepala departemen terkait secara aman,
                        memastikan tinjauan awal yang cepat.
                    </p>
                </article>

                <article class="flex flex-col items-center rounded-xl bg-white p-8 pb-[52px] text-center shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-[#D0E1FB]">
                        <img src="{{ asset('assets/icons/about-step-3.svg') }}" alt="" class="block h-6 w-6">
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">3. Resolusi</h3>
                    <p class="mt-3 whitespace-pre-line text-sm leading-5 text-[#434655]">
                        Administrator berkolaborasi untuk
                        menyelesaikan masalah, memberikan
                        pembaruan waktu nyata dan menjaga
                        transparansi penuh.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- Benefits --}}
    <section class="bg-white px-6 py-24">
        <div class="mx-auto max-w-[1280px]">
            <h2 class="mb-12 text-center text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">Mengapa SCMS?</h2>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <article class="rounded-xl border border-[rgba(195,198,215,0.3)] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <img src="{{ asset('assets/icons/icon-transparency.svg') }}" alt="" width="22" height="15" class="mb-6 block">
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Transparansi Penuh</h3>
                    <p class="mt-3 text-sm leading-5 text-[#434655]">
                        Dapatkan wawasan jelas tentang proses institusi. Setiap langkah
                        perjalanan pengaduan Anda dicatat dan dapat dilihat, memastikan
                        tidak ada keluhan yang terabaikan dalam sistem.
                    </p>
                </article>

                <article class="rounded-xl border border-[rgba(195,198,215,0.3)] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <img src="{{ asset('assets/icons/icon-tracking.svg') }}" alt="" width="22" height="12" class="mb-6 block">
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Pelacakan Real-Time</h3>
                    <p class="mt-3 text-sm leading-5 text-[#434655]">
                        Tetap terinformasi dengan pembaruan instan. Dasbor kami
                        menyediakan tampilan langsung perubahan status, personel yang
                        ditugaskan, dan estimasi waktu penyelesaian.
                    </p>
                </article>

                <article class="rounded-xl border border-[rgba(195,198,215,0.3)] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <img src="{{ asset('assets/icons/icon-privacy.svg') }}" alt="" class="mb-6 block h-5 w-5">
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Privasi Tanpa Kompromi</h3>
                    <p class="mt-3 text-sm leading-5 text-[#434655]">
                        Kepercayaan Anda adalah prioritas kami. SCMS menggunakan langkah-langkah keamanan yang kuat
                        untuk memastikan semua pengajuan dan data pribadi tetap rahasia, hanya dapat diakses oleh personel
                        yang berwenang.
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection
