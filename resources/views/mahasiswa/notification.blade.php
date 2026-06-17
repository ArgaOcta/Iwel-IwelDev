@extends('layouts.mahasiswa')
@section('title', 'Notifikasi - SCMS')

@section('content')
<div class="w-full max-w-4xl mx-auto pt-8 pb-14 px-4 sm:px-6 lg:px-8 relative">
    
    <div class="flex flex-row items-center justify-between mb-6">
        <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-2xl font-bold tracking-[-0.48px]">
            Your Updates
        </h1>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col">
        
        @forelse($notifications as $notif)
            <a href="{{ route('complaint.show', $notif->complaint_id) }}" class="bg-[#faf8ff] border-b border-[rgba(195,198,215,0.30)] p-6 flex flex-row gap-4 items-start relative hover:bg-[#f0f0fb] transition cursor-pointer group">
                <div class="bg-[rgba(37,99,235,0.10)] group-hover:bg-[#004ac6] transition-colors rounded-full w-12 h-12 flex items-center justify-center shrink-0">
                    <svg class="text-[#004ac6] group-hover:text-white transition-colors" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div class="flex flex-col flex-1 gap-1">
                    <div class="flex justify-between items-start">
                        <span class="text-[#191b23] font-semibold text-base group-hover:text-[#004ac6] transition-colors">
                            Pembaruan Tiket #{{ $notif->complaint->ticket_no ?? 'ID' }}
                        </span>
                        <span class="text-[#737686] text-[12px] font-medium">{{ $notif->created_at?->diffForHumans() ?? 'Baru saja' }}</span>
                    </div>
                    <p class="text-[#434655] text-sm leading-relaxed">
                        Admin <b>{{ $notif->user->name ?? 'Staf' }}</b> memperbarui status tiket Anda dari <span class="italic">{{ $notif->old_status }}</span> menjadi <span class="font-bold text-[#191b23]">{{ $notif->new_status }}</span>.
                    </p>
                </div>
            </a>
        @empty
            <div class="p-12 flex flex-col items-center justify-center text-center gap-3">
                <div class="bg-gray-100 rounded-full p-4 mb-2">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#737686" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </div>
                <h3 class="text-[#191b23] font-semibold text-lg">Belum Ada Pembaruan</h3>
                <p class="text-[#737686] text-sm">Anda akan menerima notifikasi jika admin memproses atau mengubah status tiket Anda.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection