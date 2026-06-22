@extends('layouts.admin')
@section('title', 'Manage Complaints - SCMS')

@section('content')
<div class="flex flex-col gap-4 sm:gap-6 w-full max-w-[1400px] mx-auto pb-10 animate-fade-up" x-data="{ showDeleteModal: false, deleteUrl: '', deleteTicket: '' }">
    
    @if(session('success'))
        <div class="bg-[#d1fae5] border border-[#16a34a] text-[#065f46] px-4 py-3 rounded-lg relative shadow-sm mb-[-1rem] animate-fade-up">
            <span class="block sm:inline font-medium text-sm sm:text-base">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col gap-1 text-[#191b23]">
        <h1 class="font-['Manrope-Bold',_sans-serif] text-2xl sm:text-[32px] leading-tight sm:leading-10 font-bold tracking-[-0.64px]">Complaint Triage</h1>
        <p class="text-[#505f76] text-sm sm:text-base">Manage, triage, and resolve incoming student reports efficiently.</p>
    </div>

    <form method="GET" action="{{ route('admin.complaints.index') }}" class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-4 sm:p-6 flex flex-col xl:flex-row gap-4 items-start xl:items-center justify-between">
        
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full xl:w-auto">
            <div class="flex flex-col gap-1 w-full md:w-72">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-xs sm:text-[13px] font-semibold">Search Reports</span>
                <div class="relative focus-within:text-[#004ac6] text-[#737686] transition-colors">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-[16px] h-[16px]" viewBox="0 0 18 24" fill="none"><path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ticket ID, User, or Subject" class="w-full bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] py-2.5 sm:py-2 pl-10 pr-4 text-[#191b23] text-sm focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6] transition shadow-sm placeholder-[#737686]">
                </div>
            </div>
            
            <div class="flex flex-col gap-1 w-full md:w-48">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-xs sm:text-[13px] font-semibold">Category</span>
                <div class="relative bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6] transition shadow-sm">
                    <select name="category" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none py-2.5 sm:py-2 pl-4 pr-10 text-[#191b23] text-sm cursor-pointer font-medium">
                        <option value="all">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-3 sm:top-3 pointer-events-none text-[#737686]" width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M3.5 5.25L7 8.75L10.5 5.25"></path></svg>
                </div>
            </div>

            <div class="flex flex-col gap-1 w-full md:w-48">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-xs sm:text-[13px] font-semibold">Status</span>
                <div class="relative bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6] transition shadow-sm">
                    <select name="status" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none py-2.5 sm:py-2 pl-4 pr-10 text-[#191b23] text-sm cursor-pointer font-medium">
                        <option value="all">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Reviewing" {{ request('status') == 'Reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    <svg class="absolute right-3 top-3 pointer-events-none text-[#737686]" width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M3.5 5.25L7 8.75L10.5 5.25"></path></svg>
                </div>
            </div>
        </div>

        <div class="w-full xl:w-auto flex justify-start xl:justify-end mt-2 xl:mt-0 items-end">
            <a href="{{ route('admin.complaints.index') }}" class="w-full sm:w-auto justify-center text-[#004ac6] text-[13px] font-semibold hover:underline flex items-center gap-1 bg-[#d0e1fb] px-4 py-2 sm:px-3 sm:py-1.5 rounded-lg transition-colors hover:bg-[#b4c5ff]">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                Reset Filters
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden">
        
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead class="bg-[#f3f3fe] border-b border-[rgba(195,198,215,0.20)] text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">
                    <tr>
                        <th class="py-4 px-4 text-center w-12"><input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)" class="w-4 h-4 text-[#004ac6] bg-white border-[#c3c6d7] rounded focus:ring-[#004ac6] cursor-pointer"></th>
                        <th class="py-4 px-4">Ticket ID</th>
                        <th class="py-4 px-4">User</th>
                        <th class="py-4 px-4">Subject</th>
                        <th class="py-4 px-4">Date & Time</th>
                        <th class="py-4 px-4">Priority / Status</th>
                        <th class="py-4 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-[#191b23] text-sm">
                    @forelse($complaints as $complaint)
                        @php
                            $statusBg = match($complaint->status) {
                                'Pending' => 'bg-[#e7e7f3] border-[rgba(195,198,215,0.30)] text-[#191b23]',
                                'Reviewing' => 'bg-[#fff5d6] border-[#ffe082] text-[#8a6a00]',
                                'In Progress' => 'bg-[#d0e1fb] border-[rgba(0,74,198,0.20)] text-[#004ac6]',
                                'Resolved', 'Closed' => 'bg-[#d1fae5] border-[#16a34a] text-[#065f46]',
                                default => 'bg-gray-100 border-gray-200 text-gray-700'
                            };
                            $priorityBg = match($complaint->priority) {
                                'Tinggi' => 'text-[#ba1a1a]',
                                'Sedang' => 'text-[#d97706]',
                                'Rendah' => 'text-[#16a34a]',
                                default => 'text-gray-500'
                            };
                        @endphp
                        <tr class="border-b border-[rgba(195,198,215,0.20)] hover:bg-gray-50 transition-colors group">
                            <td class="py-4 px-4 text-center">
                                <input type="checkbox" onchange="checkIndeterminate()" class="complaint-checkbox w-4 h-4 text-[#004ac6] bg-white border-[#c3c6d7] rounded focus:ring-[#004ac6] cursor-pointer">
                            </td>
                            <td class="py-4 px-4 font-semibold text-[#191b23] transition-transform group-hover:translate-x-1">#{{ $complaint->ticket_no }}</td>
                            <td class="py-4 px-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[13px]">{{ $complaint->is_anonymous ? 'Anonymous' : $complaint->user->name }}</span>
                                    <span class="text-gray-500 text-xs">{{ $complaint->is_anonymous ? 'HIDDEN' : $complaint->user->nim }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-medium max-w-[200px] sm:max-w-[250px] truncate" title="{{ $complaint->title }}">{{ $complaint->title }}</span>
                                    <span class="text-xs text-[#004ac6]">{{ $complaint->category->name ?? 'Umum' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-[#505f76]">
                                <div class="flex flex-col">
                                    <span>{{ $complaint->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs">{{ $complaint->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex flex-col gap-1.5 items-start">
                                    <span class="text-xs font-bold uppercase tracking-wider {{ $priorityBg }} flex items-center gap-1">
                                        @if($complaint->priority == 'Tinggi') <div class="w-1.5 h-1.5 rounded-full bg-[#ba1a1a] animate-pulse"></div> @endif
                                        {{ $complaint->priority }}
                                    </span>
                                    <span class="{{ $statusBg }} rounded-full px-2 py-0.5 text-[11px] font-bold uppercase tracking-wider border shadow-sm">{{ $complaint->status }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="bg-white border border-[#c3c6d7] text-[#191b23] rounded-lg px-3 py-1.5 text-xs font-semibold hover:bg-gray-50 transition shadow-sm inline-flex items-center gap-1 group/btn">
                                        View
                                        <svg class="group-hover/btn:translate-x-0.5 transition-transform" width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 9l3-3-3-3"></path></svg>
                                    </a>
                                    
                                    <button @click="deleteUrl = '{{ route('admin.complaints.destroy', $complaint->id) }}'; deleteTicket = '{{ $complaint->ticket_no }}'; showDeleteModal = true" type="button" class="bg-white border border-red-200 text-red-600 rounded-lg p-1.5 hover:bg-red-50 hover:border-red-300 transition shadow-sm group/del" title="Hapus Pengaduan">
                                        <svg class="group-hover/del:scale-110 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-[#737686]">Tidak ada pengaduan yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-[#faf8ff] border-t border-[rgba(195,198,215,0.20)] p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[#434655] text-sm text-center sm:text-left">
                Showing <span class="font-bold text-[#191b23]">{{ $complaints->firstItem() ?? 0 }}</span> 
                to <span class="font-bold text-[#191b23]">{{ $complaints->lastItem() ?? 0 }}</span> 
                of <span class="font-bold text-[#191b23]">{{ $complaints->total() }}</span> results
            </div>
            <div class="flex items-center justify-center gap-1 w-full sm:w-auto">
                {{ $complaints->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showDeleteModal = false" 
             class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden flex flex-col transform transition-all" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95">
            
            <div class="p-8 flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-600 mb-2">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </div>
                <h3 class="text-xl font-bold text-[#191b23]">Hapus Pengaduan?</h3>
                <p class="text-[#434655] text-sm leading-relaxed">Anda yakin ingin menghapus tiket <b class="text-[#ba1a1a]" x-text="'#' + deleteTicket"></b>? Semua lampiran dan obrolan terkait akan terhapus permanen.</p>
            </div>
            <div class="bg-[#faf8ff] px-8 py-5 flex gap-3 justify-center w-full border-t border-[rgba(195,198,215,0.3)]">
                <button @click="showDeleteModal = false" type="button" class="px-5 py-2.5 bg-white border border-[#c3c6d7] rounded-lg text-sm font-semibold text-[#434655] hover:bg-gray-50 hover:shadow-sm transition-all w-1/2 active:scale-95">Batal</button>
                
                <form method="POST" :action="deleteUrl" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 bg-[#ba1a1a] text-white rounded-lg text-sm font-semibold hover:bg-[#93000a] transition-all shadow-sm hover:shadow-md w-full active:scale-95">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.complaint-checkbox');
        checkboxes.forEach(cb => { cb.checked = masterCheckbox.checked; });
    }
    function checkIndeterminate() {
        const masterCheckbox = document.getElementById('selectAllCheckbox');
        const checkboxes = document.querySelectorAll('.complaint-checkbox');
        if (checkboxes.length === 0) return;
        const allChecked = Array.from(checkboxes).every(c => c.checked);
        const someChecked = Array.from(checkboxes).some(c => c.checked);
        masterCheckbox.checked = allChecked;
        masterCheckbox.indeterminate = someChecked && !allChecked;
    }
</script>
@endsection