@extends('layouts.mahasiswa')
@section('title', 'Riwayat Pengaduan - SCMS')

@section('content')
<div class="w-full max-w-5xl mx-auto pt-8 pb-14 px-4 sm:px-6 lg:px-8 relative">
  
    <form method="GET" action="{{ route('complaint.history') }}" class="bg-white/80 backdrop-blur-md rounded-xl border border-[rgba(195,198,215,0.30)] p-6 mb-6 flex flex-col sm:flex-row gap-4 items-end justify-between shadow-[0_4px_20px_rgba(0,0,0,0.04)] relative z-20">
    
        <div class="flex-1 w-full">
          <label class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mb-2 block">Search Complaints</label>
          <div class="relative focus-within:text-[#004ac6] text-[#737686]">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-[18px] h-[18px] transition-colors" viewBox="0 0 18 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nomor tiket atau subjek lalu tekan Enter..." class="w-full bg-[#faf8ff] rounded-lg border border-[#c3c6d7] py-3 pl-10 pr-4 text-[#191b23] text-base focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6]/20 transition-all">
          </div>
        </div>
        
        <div class="flex gap-4 w-full sm:w-auto">
          <div class="w-40">
            <label class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mb-2 block">Status</label>
            <select name="status" onchange="this.form.submit()" class="w-full bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 text-[#191b23] text-base focus:outline-none focus:border-[#004ac6] cursor-pointer transition-all">
              <option value="All Statuses" {{ request('status') == 'All Statuses' ? 'selected' : '' }}>All Statuses</option>
              <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
              <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
              <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
          </div>
    
          <div class="w-40">
            <label class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mb-2 block">Date Sort</label>
            <select name="sort" onchange="this.form.submit()" class="w-full bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 text-[#191b23] text-base focus:outline-none focus:border-[#004ac6] cursor-pointer transition-all">
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
              <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
            </select>
          </div>
        </div>
      </form>

  <div class="bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden relative z-10">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse whitespace-nowrap">
        <thead class="bg-[#f3f3fe] border-b border-[rgba(195,198,215,0.30)]">
          <tr>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Ticket ID</th>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Date<br/>Submitted</th>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Subject</th>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Category</th>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Status</th>
            <th class="py-5 px-6 text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($complaints as $complaint)
            @php
                $badgeStyles = match($complaint->status) {
                    'Pending' => 'bg-[rgba(188,72,0,0.10)] border-[rgba(188,72,0,0.20)] text-[#bc4800]',
                    'In Progress' => 'bg-[rgba(0,74,198,0.10)] border-[rgba(0,74,198,0.20)] text-[#004ac6]',
                    'Resolved', 'Closed' => 'bg-[rgba(80,95,118,0.10)] border-[rgba(80,95,118,0.20)] text-[#505f76]',
                    default => 'bg-gray-100 border-gray-200 text-gray-700'
                };
            @endphp
            <tr class="border-t border-[rgba(195,198,215,0.50)] hover:bg-[#faf8ff] transition-colors group">
              <td class="py-5 px-6">
                <div class="text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-sm font-semibold">
                  #{{ explode('-', $complaint->ticket_no)[0] }}-{{ explode('-', $complaint->ticket_no)[1] }}-<br/>{{ explode('-', $complaint->ticket_no)[2] ?? '' }}
                </div>
              </td>
              <td class="py-5 px-6">
                <div class="text-[#434655] font-['Manrope-Medium',_sans-serif] text-sm font-medium">{{ $complaint->created_at->format('M d, Y') }}</div>
              </td>
              <td class="py-5 px-6 max-w-[200px] truncate">
                <div class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium">{{ $complaint->title }}</div>
              </td>
              <td class="py-5 px-6">
                <div class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium whitespace-pre-line">{{ str_replace(' ', "\n", $complaint->category->name ?? '-') }}</div>
              </td>
              <td class="py-5 px-6">
                <div class="{{ $badgeStyles }} rounded-full border px-3 py-1 inline-flex text-xs font-medium">
                  {{ $complaint->status }}
                </div>
              </td>
              <td class="py-5 px-6 text-right">
                <a href="{{ route('complaint.show', $complaint->id) }}" class="inline-flex items-center gap-2 text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold hover:text-blue-800 transition-colors">
                  <span class="text-right">View<br/>Details</span>
                  <svg class="group-hover:translate-x-1 transition-transform" width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.45 4.5L0 1.05L1.05 0L5.55 4.5L1.05 9L0 7.95L3.45 4.5Z" fill="currentColor"/>
                  </svg>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-8 text-center text-[#737686]">Tidak ada riwayat pengaduan yang ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    
    @if ($complaints->hasPages())
    <div class="border-t border-[#c3c6d7] py-4 px-6 bg-gray-50 flex items-center justify-between">
      <div class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm font-normal">
        Showing {{ $complaints->firstItem() }} to {{ $complaints->lastItem() }} of {{ $complaints->total() }} results
      </div>
      <div>
        {{ $complaints->links() }}
      </div>
    </div>
    @endif

  </div>
</div>
@endsection