@extends('layouts.admin')
@section('title', 'Notifikasi Admin - SCMS')

@section('content')
<div class="flex flex-col gap-6 w-full max-w-[1000px] mx-auto pb-10">
    
    @if(session('success'))
        <div class="bg-[#d1fae5] border border-[#16a34a] text-[#065f46] px-4 py-3 rounded-lg relative shadow-sm mb-2">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-row items-center justify-between mb-2">
        <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] font-bold tracking-[-0.64px]">
            System Notifications
        </h1>
        
        <form action="{{ route('admin.notifications.markRead') }}" method="POST">
            @csrf
            <button type="submit" class="bg-[#d0e1fb] hover:bg-[#b4c5ff] transition rounded-lg py-2 px-4 flex items-center justify-center shadow-sm">
                <span class="text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">
                    Mark all as read
                </span>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col">
        @forelse($notifications as $notif)
        <a href="{{ route('admin.complaints.show', $notif->id) }}" class="border-b border-[#e1e2ed] p-6 flex flex-row gap-4 items-start relative hover:bg-blue-50 transition cursor-pointer group">
            <div class="bg-[rgba(37,99,235,0.10)] group-hover:bg-[#004ac6] transition-colors rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="text-[#004ac6] group-hover:text-white transition-colors" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <div class="flex flex-col flex-1 gap-1">
                <div class="flex justify-between items-start">
                    <span class="text-[#191b23] font-semibold text-base group-hover:text-[#004ac6] transition-colors">Tiket Baru: {{ $notif->title }}</span>
                    <span class="text-[#737686] text-[12px] font-medium">{{ $notif->created_at ? $notif->created_at->diffForHumans() : 'Baru saja' }}</span>
                </div>
                <p class="text-[#434655] text-sm line-clamp-2">Kategori: {{ $notif->category->name ?? 'Umum' }} - Tiket #{{ $notif->ticket_no }} memerlukan peninjauan.</p>
            </div>
            <div class="bg-[#004ac6] w-2.5 h-2.5 rounded-full absolute right-6 top-1/2 transform -translate-y-1/2 shadow-sm"></div>
        </a>
        @empty
        <div class="p-12 flex flex-col items-center justify-center text-center gap-3">
            <div class="bg-gray-100 rounded-full p-4 mb-2">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#737686" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            </div>
            <h3 class="text-[#191b23] font-semibold text-lg">Tidak ada notifikasi baru</h3>
            <p class="text-[#737686] text-sm">Semua tiket telah ditinjau dengan baik.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection