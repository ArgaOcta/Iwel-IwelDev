@extends('layouts.admin')
@section('title', 'Manage Complaints - SCMS')

@section('content')
<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto">
    
    <div class="flex flex-col gap-1 text-[#191b23]">
        <h1 class="font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">Complaint Triage</h1>
        <p class="text-[#505f76] text-base">Manage, triage, and resolve incoming student reports efficiently.</p>
    </div>

    <form method="GET" action="{{ route('admin.complaints.index') }}" class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-4 lg:p-6 flex flex-col xl:flex-row gap-4 items-center justify-between">
        
        <div class="flex flex-col md:flex-row items-center gap-4 w-full xl:w-auto">
            <div class="flex flex-col gap-1 w-full md:w-72">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">Search Reports</span>
                <div class="bg-white rounded-lg border border-[#c3c6d7] p-2 pl-9 relative focus-within:border-[#004ac6] transition-colors shadow-sm">
                    <svg class="absolute left-3 top-2.5 text-[#6b7280]" width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M13.8333 15L8.58333 9.75C8.16667 10.0833 7.6875 10.3472 7.14583 10.5417C6.60417 10.7361 6.02778 10.8333 5.41667 10.8333C3.90278 10.8333 2.62153 10.309 1.57292 9.26042C0.524305 8.21181 0 6.93056 0 5.41667C0 3.90278 0.524305 2.62153 1.57292 1.57292C2.62153 0.524305 3.90278 0 5.41667 0C6.93056 0 8.21181 0.524305 9.26042 1.57292C10.309 2.62153 10.8333 3.90278 10.8333 5.41667C10.8333 6.02778 10.7361 6.60417 10.5417 7.14583C10.3472 7.6875 10.0833 8.16667 9.75 8.58333L15 13.8333L13.8333 15ZM5.41667 9.16667C6.45833 9.16667 7.34375 8.80208 8.07292 8.07292C8.80208 7.34375 9.16667 6.45833 9.16667 5.41667C9.16667 4.375 8.80208 3.48958 8.07292 2.76042C7.34375 2.03125 6.45833 1.66667 5.41667 1.66667C4.375 1.66667 3.48958 2.03125 2.76042 2.76042C2.03125 3.48958 1.66667 4.375 1.66667 5.41667C1.66667 6.45833 2.03125 7.34375 2.76042 8.07292C3.48958 8.80208 4.375 9.16667 5.41667 9.16667Z" fill="currentColor"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, Name, or Keyword" class="bg-transparent border-none outline-none w-full text-sm text-[#191b23] placeholder-[#6b7280]">
                </div>
            </div>

            <div class="flex flex-col gap-1 w-full md:w-48">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">Category</span>
                <div class="relative bg-white rounded-lg border border-[#c3c6d7] cursor-pointer focus-within:border-[#004ac6] transition-colors shadow-sm">
                    <select name="category" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none p-2 px-3 text-[#191b23] text-sm cursor-pointer">
                        <option value="all">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-3.5 pointer-events-none" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75L10.5 5.25" stroke="#737686" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="flex flex-col gap-1 w-full md:w-48">
                <span class="text-[#505f76] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">Status</span>
                <div class="relative bg-white rounded-lg border border-[#c3c6d7] cursor-pointer focus-within:border-[#004ac6] transition-colors shadow-sm">
                    <select name="status" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none p-2 px-3 text-[#191b23] text-sm cursor-pointer">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Reviewing" {{ request('status') == 'Reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    <svg class="absolute right-3 top-3.5 pointer-events-none" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75L10.5 5.25" stroke="#737686" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            
            <button type="submit" class="hidden">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] w-full flex flex-col overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-[#f3f3fe] border-b border-[rgba(195,198,215,0.50)] text-[#505f76] text-[13px] font-semibold tracking-[0.65px]">
                    <tr>
                        <th class="py-3 px-4 w-10 text-center">
                            <input type="checkbox" id="selectAllCheckbox" onclick="toggleAll(this)" class="w-4 h-4 rounded border-[#c3c6d7] text-[#004ac6] focus:ring-[#004ac6] cursor-pointer transition-colors">
                        </th>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Student Name</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Urgency</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date Submitted</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#191b23] text-sm">
                    @forelse($complaints as $complaint)
                    
                    @php
                        $statusBg = match($complaint->status) {
                            'Pending' => 'bg-[#e7e7f3] border-[#c3c6d7] text-[#191b23]',
                            'Reviewing' => 'bg-[#fff5d6] border-[#ffe082] text-[#8a6a00]',
                            'In Progress' => 'bg-[#d0e1fb] border-[rgba(0,74,198,0.20)] text-[#004ac6]',
                            'Resolved', 'Closed' => 'bg-[#e1e2ed] border-[rgba(195,198,215,0.30)] text-[#505f76]',
                            default => 'bg-gray-100 border-gray-200 text-gray-700'
                        };
                        
                        $urgencyBg = match($complaint->priority) {
                            'Tinggi' => 'bg-[#ffdad6] border-[rgba(186,26,26,0.20)] text-[#93000a]',
                            'Sedang' => 'bg-[rgba(37,99,235,0.20)] border-[rgba(0,74,198,0.20)] text-[#004ac6]',
                            'Rendah' => 'bg-[#e7e7f3] border-[rgba(195,198,215,0.30)] text-[#505f76]',
                            default => 'bg-gray-100 border-gray-200 text-gray-700'
                        };
                    @endphp
                    
                    <tr class="border-b border-[#e1e2ed] hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" class="complaint-checkbox w-4 h-4 rounded border-[#c3c6d7] text-[#004ac6] focus:ring-[#004ac6] cursor-pointer transition-colors" value="{{ $complaint->id }}" onclick="checkIndeterminate()">
                        </td>
                        <td class="py-4 px-4 font-medium">#{{ $complaint->ticket_no }}</td>
                        <td class="py-4 px-4 flex items-center gap-3">
                            @if($complaint->is_anonymous)
                                <div class="bg-gray-200 text-gray-500 font-bold text-xs w-8 h-8 flex items-center justify-center rounded-full">AN</div>
                                <div class="flex flex-col">
                                    <span class="font-medium">Anonymous User</span>
                                    <span class="text-[#505f76] text-xs">Hidden</span>
                                </div>
                            @else
                                <div class="bg-[#d0e1fb] text-[#54647a] font-bold text-xs w-8 h-8 flex items-center justify-center rounded-full">
                                    {{ strtoupper(substr($complaint->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $complaint->user->name ?? 'Unknown User' }}</span>
                                    <span class="text-[#505f76] text-xs">{{ $complaint->user->nim ?? 'NIM' }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-[#434655]">{{ $complaint->category->name ?? '-' }}</td>
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center gap-1.5 {{ $urgencyBg }} border px-2.5 py-1 rounded-full">
                                @if($complaint->priority === 'Tinggi')
                                    <div class="w-1.5 h-1.5 bg-[#ba1a1a] rounded-full"></div>
                                @elseif($complaint->priority === 'Sedang')
                                    <div class="w-1.5 h-1.5 bg-[#004ac6] rounded-full"></div>
                                @else
                                    <div class="w-1.5 h-1.5 bg-[#505f76] rounded-full"></div>
                                @endif
                                <span class="text-xs font-medium">{{ $complaint->priority }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center {{ $statusBg }} border px-2.5 py-1 rounded-full">
                                <span class="text-xs font-medium">{{ $complaint->status }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-[#505f76] text-sm">{{ $complaint->created_at ? $complaint->created_at->format('M d, Y') : '-' }}</td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-[#004ac6] hover:text-blue-800 font-semibold text-[13px] tracking-[0.65px] flex items-center justify-end gap-1 transition-colors">
                                Review
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-[#505f76] bg-gray-50">
                            Tidak ada data pengaduan yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-[#faf8ff] border-t border-[rgba(195,198,215,0.20)] p-4 flex flex-col sm:flex-row items-center justify-between">
            <div class="text-[#434655] text-sm mb-4 sm:mb-0">
                Showing <span class="font-bold text-[#191b23]">{{ $complaints->firstItem() ?? 0 }}</span> 
                to <span class="font-bold text-[#191b23]">{{ $complaints->lastItem() ?? 0 }}</span> 
                of <span class="font-bold text-[#191b23]">{{ $complaints->total() }}</span> results
            </div>
            <div class="flex items-center gap-1">
                {{ $complaints->links('pagination::tailwind') }}
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