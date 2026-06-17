@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-white px-6 pb-32 pt-24 max-sm:px-4 max-sm:pb-24 max-sm:pt-16">
        <div class="pointer-events-none absolute right-0 top-0 h-[620px] w-[640px] rounded-bl-full bg-[linear-gradient(223deg,rgba(219,225,255,1)_0%,rgba(219,225,255,0)_100%)] opacity-30" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-[1232px] grid-cols-1 items-start gap-6 lg:grid-cols-2">
            <div class="flex flex-col gap-6 pt-0.5">
                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#D0E1FB] px-3 py-1 text-[13px] font-semibold leading-[18px] tracking-[0.05em] text-[#54647A]">
                    <img src="{{ asset('assets/icons/shield-badge.svg') }}" alt="" width="15" height="14" class="block">
                    <span>Platform Resmi</span>
                </div>

                <h1 class="text-4xl font-bold leading-[44px] tracking-[-0.02em] text-[#191B23] sm:text-[48px] sm:leading-[56px]">
                    Keandalan Institusi.<br>
                    <span class="text-[#004AC6]">Resolusi Transparan.</span>
                </h1>

                <p class="max-w-[512px] text-base leading-6 text-[#434655]">
                    Student Complaint Management System (SCMS) menyediakan lingkungan yang terstruktur, aman, dan transparan untuk menyampaikan keluhan. Kami memprioritaskan de-eskalasi dan kejelasan, memastikan setiap suara didengar dan dilacak secara efisien.
                </p>

                <div class="flex flex-wrap gap-4 pt-2 max-sm:w-full max-sm:flex-col">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#004AC6] px-8 py-3 text-lg font-semibold leading-7 text-white shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-opacity hover:opacity-90 max-sm:w-full">
                        Ajukan Pengaduan
                        <img src="{{ asset('assets/icons/arrow-right.svg') }}" alt="" width="16" height="16" class="block">
                    </a>
                    <a href="{{ url('/how-it-works') }}" class="inline-flex items-center justify-center rounded-lg border border-[#C3C6D7] bg-white px-8 py-3 text-lg font-semibold leading-7 text-[#191B23] transition-opacity hover:opacity-90 max-sm:w-full">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="relative mx-auto min-h-0 w-full max-w-[600px] lg:mx-0 lg:min-h-[396px] lg:max-w-none" aria-label="Keunggulan platform">
                <article class="relative mb-4 flex min-h-[140px] flex-col justify-between rounded-xl bg-[#F3F3FE] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:absolute lg:left-0 lg:top-0 lg:mb-0 lg:aspect-[2.196/1] lg:w-[calc(50%-8px)]">
                    <img src="{{ asset('assets/icons/icon-secure.svg') }}" alt="" class="block h-[33px] w-auto">
                    <div>
                        <h3 class="mt-3 text-lg font-semibold leading-7 text-[#191B23]">Aman</h3>
                        <p class="text-sm leading-5 text-[#434655]">Pengiriman terenkripsi.</p>
                    </div>
                </article>

                <article class="relative mb-4 flex min-h-[140px] flex-col justify-between rounded-xl bg-[#DBE1FF] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:absolute lg:right-0 lg:top-0 lg:mb-0 lg:aspect-[2.196/1] lg:w-[calc(50%-8px)]">
                    <img src="{{ asset('assets/icons/icon-trackable.svg') }}" alt="" class="block h-[33px] w-auto">
                    <div>
                        <h3 class="mt-3 text-lg font-semibold leading-7 text-[#00174B]">Dapat Dilacak</h3>
                        <p class="text-sm leading-5 text-[#003EA8]">Pembaruan status waktu nyata.</p>
                    </div>
                </article>

                <article class="relative flex h-auto flex-row items-center gap-4 rounded-xl bg-[#EDEDF9] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:absolute lg:left-0 lg:right-0 lg:top-[300px] lg:h-24">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#D3E4FE]">
                        <img src="{{ asset('assets/icons/icon-support.svg') }}" alt="" width="20" height="18" class="block">
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold leading-7 text-[#191B23]">Dukungan Khusus</h3>
                        <p class="text-sm leading-5 text-[#434655]">Jalur langsung ke administrasi.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="bg-[#FAF8FF] py-24">
        <div class="mx-auto flex max-w-[1280px] flex-col items-center gap-16 px-6">
            <header class="flex max-w-[672px] flex-col gap-4 text-center">
                <h2 class="text-[32px] font-bold leading-10 tracking-[-0.02em] text-[#191B23]">Pendekatan Modern untuk Resolusi</h2>
                <p class="text-base leading-6 text-[#434655]">Kami merancang SCMS untuk menghilangkan hambatan dalam proses pelaporan.</p>
            </header>
            <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-[21px]">
                <article class="flex flex-col gap-3 rounded-xl border border-[#EDEDF9] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]"><h3 class="pt-3 text-lg font-semibold">Platform Resmi</h3></article>
                <article class="flex flex-col gap-3 rounded-xl border border-[#EDEDF9] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]"><h3 class="pt-3 text-lg font-semibold">Pelacakan Jelas</h3></article>
                <article class="flex flex-col gap-3 rounded-xl border border-[#EDEDF9] bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)]"><h3 class="pt-3 text-lg font-semibold">Transparansi Total</h3></article>
            </div>
        </div>
    </section>
@endsection