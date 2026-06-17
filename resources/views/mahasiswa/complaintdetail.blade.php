@extends('layouts.mahasiswa')
@section('title', 'Detail Pengaduan - SCMS')

@section('content')

@php
    $statusBg = match($complaint->status) {
        'Pending', 'Reviewing' => 'bg-[#ffdbcd]',
        'In Progress' => 'bg-[#d0e1fb]',
        'Resolved', 'Closed' => 'bg-[rgba(80,95,118,0.10)]',
        default => 'bg-gray-100'
    };
    $statusText = match($complaint->status) {
        'Pending', 'Reviewing' => 'text-[#bc4800]',
        'In Progress' => 'text-[#54647a]',
        'Resolved', 'Closed' => 'text-[#505f76]',
        default => 'text-gray-700'
    };
    
    $urgencyBg = match($complaint->priority) {
        'Tinggi' => 'bg-[#ffdad6]',
        'Sedang' => 'bg-[#ffdbcd]',
        'Rendah' => 'bg-[#d0e1fb]',
        default => 'bg-gray-100'
    };
    $urgencyText = match($complaint->priority) {
        'Tinggi' => 'text-[#93000a]',
        'Sedang' => 'text-[#bc4800]',
        'Rendah' => 'text-[#004ac6]',
        default => 'text-gray-700'
    };
@endphp

<div class="w-full max-w-7xl mx-auto pt-6 pb-14 px-4 sm:px-6 lg:px-8 relative">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-start sm:items-center gap-3">
            <a href="{{ route('complaint.history') }}" class="rounded-full p-2 hover:bg-gray-200 transition-colors shrink-0 mt-1 sm:mt-0">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3.825 9L9.425 14.6L8 16L0 8L8 0L9.425 1.4L3.825 7H16V9H3.825Z" fill="#434655"/></svg>
            </a>
            
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold uppercase tracking-[0.65px]">
                        COMPLAINT ID: {{ $complaint->ticket_no }}
                    </span>
                    <span class="{{ $statusBg }} {{ $statusText }} rounded-full px-2 py-0.5 text-[11px] font-bold uppercase tracking-[0.55px]">
                        {{ $complaint->status }}
                    </span>
                </div>
                <h1 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">
                    {{ $complaint->title }}
                </h1>
            </div>
        </div>

        <button onclick="window.print()" class="bg-white rounded-lg border border-[#c3c6d7] px-4 py-2 text-[#191b23] font-semibold text-[13px] shadow-sm hover:bg-gray-50 transition shrink-0">
            Print Report
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <div class="border-b border-[rgba(195,198,215,0.30)] pb-3 mb-4 flex items-center gap-2">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M4 16H12V14H4V16ZM4 12H12V10H4V12ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H10L16 6V18C16 18.55 15.8042 19.0208 15.4125 19.4125C15.0208 19.8042 14.55 20 14 20H2ZM9 7V2H2V18H14V7H9ZM2 2V7V2V7V18V2Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] font-semibold text-lg">Informasi Laporan</h2>
                </div>
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-[#434655] font-semibold text-[13px]">Kategori</label>
                        <p class="text-[#191b23] text-base">{{ $complaint->category->name ?? 'Kategori Umum' }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[#434655] font-semibold text-[13px]">Deskripsi Lengkap</label>
                        <div class="text-[#191b23] text-base leading-relaxed mt-2 whitespace-pre-wrap">{{ $complaint->description }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"><path d="M12.5 13.75C12.5 15.4833 11.8917 16.9583 10.675 18.175C9.45833 19.3917 7.98333 20 6.25 20C4.51667 20 3.04167 19.3917 1.825 18.175C0.608333 16.9583 0 15.4833 0 13.75V4.5C0 3.25 0.4375 2.1875 1.3125 1.3125C2.1875 0.4375 3.25 0 4.5 0C5.75 0 6.8125 0.4375 7.6875 1.3125C8.5625 2.1875 9 3.25 9 4.5V13.25C9 14.0167 8.73333 14.6667 8.2 15.2C7.66667 15.7333 7.01667 16 6.25 16C5.48333 16 4.83333 15.7333 4.3 15.2C3.76667 14.6667 3.5 14.0167 3.5 13.25V4H5.5V13.25C5.5 13.4667 5.57083 13.6458 5.7125 13.7875C5.85417 13.9292 6.03333 14 6.25 14C6.46667 14 6.64583 13.9292 6.7875 13.7875C6.92917 13.6458 7 13.4667 7 13.25V4.5C6.98333 3.8 6.7375 3.20833 6.2625 2.725C5.7875 2.24167 5.2 2 4.5 2C3.8 2 3.20833 2.24167 2.725 2.725C2.24167 3.20833 2 3.8 2 4.5V13.75C1.98333 14.9333 2.39167 15.9375 3.225 16.7625C4.05833 17.5875 5.06667 18 6.25 18C7.41667 18 8.40833 17.5875 9.225 16.7625C10.0417 15.9375 10.4667 14.9333 10.5 13.75V4H12.5V13.75Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] font-semibold text-lg">Bukti Lampiran</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($complaint->attachments as $attachment)
                        @if(in_array(strtolower($attachment->file_type), ['jpg', 'jpeg', 'png']))
                            <div class="bg-[#ededf9] rounded-lg border border-[rgba(195,198,215,0.30)] overflow-hidden relative aspect-video cursor-pointer hover:opacity-90 transition">
                                <img src="{{ asset('storage/' . $attachment->file_path) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="bg-[#ededf9] rounded-lg border border-[rgba(195,198,215,0.30)] flex items-center justify-center relative aspect-video p-4 text-center">
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-[#004ac6] text-sm font-semibold hover:underline flex flex-col items-center gap-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2ZM13 9V3.5L18.5 9H13Z" fill="currentColor"/></svg>
                                    Lihat {{ strtoupper($attachment->file_type) }}
                                </a>
                            </div>
                        @endif
                    @empty
                        <p class="text-[#737686] text-sm italic col-span-3">Tidak ada lampiran disertakan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] flex flex-col h-[500px] shadow-sm">
                <div class="bg-[#faf8ff] rounded-t-xl border-b border-[rgba(195,198,215,0.30)] p-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M20 20L16 16H6C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V13H15C15.55 13 16.0208 12.8042 16.4125 12.4125C16.8042 12.0208 17 11.55 17 11V4H18C18.55 4 19.0208 4.19583 19.4125 4.5875C19.8042 4.97917 20 5.45 20 6V20ZM2 10.175L3.175 9H13V2H2V10.175ZM0 15V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H13C13.55 0 14.0208 0.195833 14.4125 0.5875C14.8042 0.979167 15 1.45 15 2V9C15 9.55 14.8042 10.0208 14.4125 10.4125C14.0208 10.8042 13.5 11 13 11H4L0 15ZM2 9V2V9Z" fill="#004AC6"/></svg>
                        <h2 class="text-[#191b23] font-semibold text-lg">Diskusi & Tanggapan</h2>
                    </div>
                </div>

                <div class="bg-[#faf8ff] flex-1 p-4 overflow-y-auto flex flex-col gap-4 relative">
                    
                    <div class="text-center mb-4">
                        <span class="bg-[#ededf9] text-[#434655] text-[11px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            LAPORAN DIBUAT - {{ $complaint->created_at?->format('d M, H:i') ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex flex-row gap-2 items-end justify-end self-end max-w-[85%]">
                        <div class="bg-[#2563eb] rounded-tl-2xl rounded-tr-2xl rounded-br-sm rounded-bl-2xl p-3 flex flex-col gap-1 shadow-sm text-white text-sm">
                            <div>Laporan awal berhasil dikirim ke sistem.</div>
                            <div class="text-[rgba(255,255,255,0.70)] text-[11px] text-right">{{ $complaint->created_at?->format('H:i') ?? '' }}</div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-[#004ac6] flex items-center justify-center text-white font-bold text-xs shrink-0">ME</div>
                    </div>
                    
                    @foreach($complaint->responses->sortBy('created_at') as $reply)
                        
                        @if(!$reply->is_internal)
                            
                            @if($reply->user_id == auth()->id())
                                <div class="flex flex-row gap-2 items-end justify-end self-end max-w-[85%] mt-2">
                                    <div class="bg-[#2563eb] rounded-tl-2xl rounded-tr-2xl rounded-br-sm rounded-bl-2xl p-3 flex flex-col gap-1 shadow-sm text-white text-sm">
                                        <div class="whitespace-pre-wrap">{{ $reply->message }}</div>
                                        <div class="text-[rgba(255,255,255,0.70)] text-[11px] text-right">{{ $reply->created_at?->format('d M, H:i') ?? '' }}</div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-[#004ac6] flex items-center justify-center text-white font-bold text-xs shrink-0">ME</div>
                                </div>
                            @else
                                <div class="flex flex-row gap-2 items-end justify-start self-start max-w-[85%] mt-2">
                                    <div class="w-8 h-8 rounded-full bg-[#505f76] flex items-center justify-center text-white font-bold text-xs shrink-0 shadow-sm overflow-hidden border border-gray-300">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&color=fff&background=505f76" class="w-full h-full object-cover">
                                    </div>
                                    <div class="bg-[#e1e2ed] rounded-tl-2xl rounded-tr-2xl rounded-br-2xl rounded-bl-sm border border-[rgba(195,198,215,0.30)] p-3 flex flex-col gap-1 shadow-sm">
                                        <div class="text-[#004ac6] font-semibold text-[13px] tracking-wide">{{ $reply->user->name }} <span class="text-gray-500 font-normal text-xs">(Admin)</span></div>
                                        <div class="text-[#191b23] text-sm whitespace-pre-wrap">{{ $reply->message }}</div>
                                        <div class="text-[#434655] text-[11px] mt-1">{{ $reply->created_at?->format('d M, H:i') ?? '' }}</div>
                                    </div>
                                </div>
                            @endif

                        @endif
                    @endforeach

                </div>

                @if(in_array($complaint->status, ['Resolved', 'Closed']))
                    <div class="bg-gray-50 rounded-b-xl border-t border-[rgba(195,198,215,0.30)] p-4 text-center shrink-0">
                        <span class="text-sm text-gray-500 font-medium">Tiket ini sudah ditutup. Anda tidak dapat membalas pesan.</span>
                    </div>
                @else
                    <form action="{{ route('complaint.response', $complaint->id) }}" method="POST" class="bg-[#ffffff] rounded-b-xl border-t border-[rgba(195,198,215,0.30)] p-4 flex items-center gap-3 shrink-0">
                        @csrf
                        <input type="text" name="response" required placeholder="Tulis balasan Anda ke admin..." class="flex-1 bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] px-4 py-3 text-[#191b23] focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6]">
                        <button type="submit" class="bg-[#004ac6] w-12 h-12 rounded-xl flex items-center justify-center hover:bg-blue-800 transition shadow-sm shrink-0">
                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none"><path d="M0 13.3333V0L15.8333 6.66667L0 13.3333ZM1.66667 10.8333L11.5417 6.66667L1.66667 2.5V5.41667L6.66667 6.66667L1.66667 7.91667V10.8333Z" fill="white"/></svg>
                        </button>
                    </form>
                @endif
            </div>

        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <h3 class="text-[#191b23] font-semibold text-lg border-b border-[rgba(195,198,215,0.30)] pb-3 mb-4">Ringkasan</h3>
                
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[#434655] font-semibold text-[13px]">Tanggal Dibuat</span>
                        <span class="text-[#191b23] text-sm font-medium">{{ $complaint->created_at?->format('d M Y, H:i') ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#434655] font-semibold text-[13px]">Tingkat Urgensi</span>
                        <span class="{{ $urgencyBg }} {{ $urgencyText }} rounded-full px-3 py-1 text-xs font-semibold flex items-center gap-1">
                            @if($complaint->priority == 'Tinggi')
                                <svg width="8" height="12" viewBox="0 0 3 11" fill="none"><path d="M1.16667 10.5C0.845833 10.5 0.571181 10.3858 0.342708 10.1573C0.114236 9.92882 0 9.65417 0 9.33333C0 9.0125 0.114236 8.73785 0.342708 8.50937C0.571181 8.2809 0.845833 8.16667 1.16667 8.16667C1.4875 8.16667 1.76215 8.2809 1.99063 8.50937C2.2191 8.73785 2.33333 9.0125 2.33333 9.33333C2.33333 9.65417 2.2191 9.92882 1.99063 10.1573C1.76215 10.3858 1.4875 10.5 1.16667 10.5ZM0 7V0H2.33333V7H0Z" fill="currentColor"/></svg>
                            @endif
                            {{ $complaint->priority }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center border-t border-[rgba(195,198,215,0.20)] pt-3 mt-1">
                        <span class="text-[#434655] font-semibold text-[13px]">Terakhir Diperbarui</span>
                        <span class="text-[#191b23] text-sm font-medium">{{ $complaint->updated_at?->diffForHumans() ?? 'Baru saja' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6">
                    <svg width="22" height="12" viewBox="0 0 22 12" fill="none"><path d="M2 12C1.45 12 0.979167 11.8042 0.5875 11.4125C0.195833 11.0208 0 10.55 0 10C0 9.45 0.195833 8.97917 0.5875 8.5875C0.979167 8.19583 1.45 8 2 8C2.1 8 2.1875 8 2.2625 8C2.3375 8 2.41667 8.01667 2.5 8.05L7.05 3.5C7.01667 3.41667 7 3.3375 7 3.2625C7 3.1875 7 3.1 7 3C7 2.45 7.19583 1.97917 7.5875 1.5875C7.97917 1.19583 8.45 1 9 1C9.55 1 10.0208 1.19583 10.4125 1.5875C10.8042 1.97917 11 2.45 11 3C11 3.0333 10.9833 3.2 10.95 3.5L13.5 6.05C13.5833 6.01667 13.6625 6 13.7375 6C13.8125 6 13.9 6 14 6C14.1 6 14.1875 6 14.2625 6C14.3375 6 14.4167 6.01667 14.5 6.05L18.05 2.5C18.0167 2.41667 18 2.3375 18 2.2625C18 2.1875 18 2.1 18 2C18 1.45 18.1958 0.979167 18.5875 0.5875C18.9792 0.195833 19.45 0 20 0C20.55 0 21.0208 0.195833 21.4125 0.5875C21.8042 0.979167 22 1.45 22 2C22 2.55 21.8042 3.02083 21.4125 3.4125C21.0208 3.80417 20.55 4 20 4C19.9 4 19.8125 4 19.7375 4C19.6625 4 19.5833 3.98333 19.5 3.95L15.95 7.5C15.9833 7.58333 16 7.6625 16 7.7375C16 7.8125 16 7.9 16 8C16 8.55 15.8042 9.02083 15.4125 9.4125C15.0208 9.80417 14.55 10 14 10C13.45 10 12.9792 9.80417 12.5875 9.4125C12.1958 9.02083 12 8.55 12 8C12 7.9 12 7.8125 12 7.7375C12 7.6625 12.0167 7.58333 12.05 7.5L9.5 4.95C9.41667 4.98333 9.3375 5 9.2625 5C9.1875 5 9.1 5 9 5C8.96667 5 8.8 4.98333 8.5 4.95L3.95 9.5C3.98333 9.58333 4 9.6625 4 9.7375C4 9.8125 4 9.9 4 10C4 10.55 3.80417 11.0208 3.4125 11.4125C3.02083 11.8042 2.55 12 2 12Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] font-semibold text-lg">Status Pelacakan</h2>
                </div>

                <div class="relative pl-3 flex flex-col gap-8">
                    <div class="absolute left-[27px] top-[24px] bottom-0 w-0.5 bg-[rgba(195,198,215,0.50)] z-0"></div>
                    
                    <div class="flex gap-4 relative z-10">
                        <div class="bg-[#004ac6] w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-[0_0_0_4px_white]">
                            <svg width="13" height="10" viewBox="0 0 13 10" fill="none"><path d="M4.275 9.01875L0 4.74375L1.06875 3.675L4.275 6.88125L11.1562 0L12.225 1.06875L4.275 9.01875Z" fill="white"/></svg>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h4 class="text-[#191b23] font-semibold text-lg">Laporan Diterima</h4>
                            <p class="text-[#434655] text-sm">Sistem mencatat laporan Anda.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 relative z-10 {{ $complaint->status == 'Pending' ? 'opacity-40' : '' }}">
                        <div class="{{ $complaint->status != 'Pending' ? 'bg-[#004ac6]' : 'bg-[#e1e2ed] border-2 border-[#c3c6d7]' }} w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-[0_0_0_4px_white]">
                            @if($complaint->status != 'Pending')
                                <svg width="13" height="10" viewBox="0 0 13 10" fill="none"><path d="M4.275 9.01875L0 4.74375L1.06875 3.675L4.275 6.88125L11.1562 0L12.225 1.06875L4.275 9.01875Z" fill="white"/></svg>
                            @endif
                        </div>
                        <div class="flex flex-col gap-1">
                            <h4 class="{{ $complaint->status != 'Pending' ? 'text-[#004ac6]' : 'text-[#434655]' }} font-bold text-lg">Sedang Diproses</h4>
                            <p class="text-[#191b23] text-sm">Status saat ini: {{ $complaint->status }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4 relative z-10 {{ in_array($complaint->status, ['Resolved', 'Closed']) ? '' : 'opacity-40' }}">
                        <div class="{{ in_array($complaint->status, ['Resolved', 'Closed']) ? 'bg-[#004ac6]' : 'bg-[#e1e2ed] border-2 border-[#c3c6d7]' }} w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-[0_0_0_4px_white]">
                            @if(in_array($complaint->status, ['Resolved', 'Closed']))
                                <svg width="13" height="10" viewBox="0 0 13 10" fill="none"><path d="M4.275 9.01875L0 4.74375L1.06875 3.675L4.275 6.88125L11.1562 0L12.225 1.06875L4.275 9.01875Z" fill="white"/></svg>
                            @endif
                        </div>
                        <div class="flex flex-col gap-1">
                            <h4 class="text-[#434655] font-semibold text-lg">Selesai</h4>
                            <p class="text-[#434655] text-sm">
                                {{ in_array($complaint->status, ['Resolved', 'Closed']) ? 'Laporan telah diselesaikan oleh Admin.' : 'Menunggu penyelesaian.' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatContainer = document.querySelector('.overflow-y-auto');
        if(chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });
</script>
@endsection