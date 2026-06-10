@extends('layouts.public')

@section('title', 'Cara Kerja')

@php($activeNav = 'how-it-works')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-white py-24">
        <div
            class="pointer-events-none absolute inset-0 opacity-5"
            style="background: radial-gradient(circle at 50% 50%, #004AC6 2%, transparent 2%); background-size: 32px 32px;"
            aria-hidden="true"
        ></div>
        <div class="relative mx-auto flex max-w-[1280px] flex-col items-center gap-6 px-6 text-center">
            <h1 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">Jalur Transparan Menuju Resolusi</h1>
            <p class="max-w-[672px] text-base leading-[26px] text-[#434655] opacity-80">
                Sistem Manajemen Pengaduan Mahasiswa dirancang untuk akuntabilitas. Alur kerja
                terstruktur kami memastikan setiap kekhawatiran didengar, dilacak, dan ditangani dengan
                presisi institusional.
            </p>
        </div>
    </section>

    {{-- 4-Step Process --}}
    <section class="bg-gradient-to-b from-white to-slate-50 px-6 py-24">
        <div class="mx-auto grid max-w-[1280px] grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['icon' => 'step-submit.svg', 'stage' => 'TAHAP 01', 'title' => 'Pengajuan', 'text' => "Mahasiswa mengirimkan keluhan\nterperinci secara aman melalui\nportal. Tersedia opsi pengajuan\nanonim untuk masalah yang bersifat\nsensitif."],
                ['icon' => 'step-triage.svg', 'stage' => 'TAHAP 02', 'title' => 'Triase & Perutean', 'text' => "Sistem secara otomatis\nmengkategorikan dan meneruskan\npengaduan ke kepala departemen\nterkait, memastikan pemrosesan\nyang efisien."],
                ['icon' => 'step-resolution.svg', 'stage' => 'TAHAP 03', 'title' => 'Resolusi', 'text' => "Admin berkolaborasi mencari solusi\nsambil memberikan pembaruan\nstatus waktu nyata yang dapat\ndiakses melalui dasbor pribadi\nmahasiswa."],
                ['icon' => 'step-feedback.svg', 'stage' => 'TAHAP 04', 'title' => 'Umpan Balik & Penutupan', 'text' => "Setelah diselesaikan, mahasiswa\nmemberikan umpan balik untuk\nmenjamin kualitas layanan institusi\ndan memfinalisasi dokumentasi\nkasus."],
            ] as $step)
                <article class="flex flex-col gap-4 rounded-xl border border-[#C3C6D7] bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#D0E1FB]">
                        <img src="{{ asset('assets/icons/' . $step['icon']) }}" alt="" class="block h-[22px] w-[22px]">
                    </div>
                    <p class="text-[13px] font-semibold uppercase leading-[18px] tracking-[0.1em] text-[#004AC6]">{{ $step['stage'] }}</p>
                    <h3 class="text-lg font-semibold leading-7 text-[#191B23]">{{ $step['title'] }}</h3>
                    <p class="whitespace-pre-line text-sm leading-5 text-[#434655]">{{ $step['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Visualization --}}
    <section class="bg-white px-6 py-24">
        <div class="mx-auto grid max-w-[1280px] grid-cols-1 items-center gap-12 lg:grid-cols-2">
            <div class="flex flex-col gap-6">
                <h2 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">
                    Memberdayakan Mahasiswa<br>Melalui Data
                </h2>
                <p class="text-base leading-6 text-[#434655]">
                    SCMS bukan sekadar kotak surat—ini adalah alat tata kelola yang
                    komprehensif. Dengan memusatkan komunikasi, kami
                    menghilangkan hambatan dan memastikan tidak ada keluhan
                    mahasiswa yang terabaikan oleh administrasi.
                </p>
                <div class="flex flex-col gap-4 pt-2">
                    <div class="flex gap-4 rounded-lg bg-[#EDEDF9] p-4">
                        <img src="{{ asset('assets/icons/icon-verified.svg') }}" alt="" width="22" height="21" class="mt-0.5 block shrink-0">
                        <div>
                            <h4 class="text-lg font-semibold leading-7 text-[#191B23]">Identitas Terverifikasi</h4>
                            <p class="text-sm leading-5 text-[#434655]">Integrasi SSO institusi untuk autentikasi yang aman.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 rounded-lg bg-[#EDEDF9] p-4">
                        <img src="{{ asset('assets/icons/icon-encryption.svg') }}" alt="" width="16" height="20" class="mt-0.5 block shrink-0">
                        <div>
                            <h4 class="text-lg font-semibold leading-7 text-[#191B23]">Enkripsi End-to-End</h4>
                            <p class="text-sm leading-5 text-[#434655]">Data Anda dilindungi oleh standar keamanan tertinggi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl shadow-[0_8px_10px_-6px_rgba(0,0,0,0.1),0_20px_25px_-5px_rgba(0,0,0,0.1)]">
                <img
                    src="{{ asset('assets/icons/dashboard-preview-44d8a8.png') }}"
                    alt="Dasbor Institusi"
                    class="block aspect-video w-full object-cover"
                >
                <div class="absolute inset-0 bg-[rgba(0,74,198,0.1)]" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-[#004AC6] px-6 py-24">
        <div class="mx-auto flex max-w-[1280px] flex-col items-center gap-4 px-6 text-center">
            <h2 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-white">Siap untuk Memulai?</h2>
            <p class="max-w-[576px] text-base leading-6 text-white opacity-90">
                Ambil langkah pertama untuk menyelesaikan masalah institusional Anda hari
                ini. Tim kami siap membantu Anda.
            </p>
            <div class="flex flex-wrap justify-center gap-4 pt-6">
                <a href="#" class="rounded-xl bg-white px-10 py-[18px] text-lg font-bold leading-7 text-[#004AC6] transition-opacity hover:opacity-90">Ajukan Pengaduan</a>
                <a href="{{ url('/faq') }}" class="rounded-xl border-2 border-white px-10 py-4 text-lg font-bold leading-7 text-white transition-opacity hover:opacity-90">Lihat FAQ</a>
            </div>
        </div>
    </section>
@endsection
