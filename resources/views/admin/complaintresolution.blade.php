@extends('layouts.admin')
@section('title', 'Complaint Details - SCMS')

@section('content')

@php
    // Logika Warna Urgensi
    $urgencyBg = match($complaint->priority) {
        'Tinggi' => 'bg-[#ffdad6] border-[rgba(186,26,26,0.20)] text-[#93000a]',
        'Sedang' => 'bg-[rgba(37,99,235,0.20)] border-[rgba(0,74,198,0.20)] text-[#004ac6]',
        'Rendah' => 'bg-[#e7e7f3] border-[rgba(195,198,215,0.30)] text-[#505f76]',
        default => 'bg-gray-100 border-gray-200 text-gray-700'
    };
    
    // Logika Warna Status
    $statusBg = match($complaint->status) {
        'Pending' => 'bg-[#e7e7f3] border-[rgba(195,198,215,0.30)] text-[#191b23]',
        'Reviewing' => 'bg-[#fff5d6] border-[#ffe082] text-[#8a6a00]',
        'In Progress' => 'bg-[#d0e1fb] border-[rgba(0,74,198,0.20)] text-[#54647a]',
        'Resolved', 'Closed' => 'bg-[#d1fae5] border-[#16a34a] text-[#065f46]',
        default => 'bg-gray-100 border-gray-200 text-gray-700'
    };
@endphp

<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto pb-10">
    
    @if(session('success'))
        <div class="bg-[#d1fae5] border border-[#16a34a] text-[#065f46] px-4 py-3 rounded-lg relative shadow-sm mb-[-1rem]">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between w-full gap-4">
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.complaints.index') }}" class="rounded-full p-2 bg-white border border-[#c3c6d7] hover:bg-gray-100 transition shadow-sm">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15.8333 10H4.16667M4.16667 10L10 15.8333M4.16667 10L10 4.16667" stroke="#434655" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <div class="flex flex-col gap-0.5">
                <div class="flex items-center gap-2">
                    <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-2xl font-bold tracking-[-0.64px]">Ticket #{{ $complaint->ticket_no }}</h1>
                    <span class="{{ $statusBg }} rounded-full px-2.5 py-0.5 text-xs font-bold uppercase tracking-wider border shadow-sm">
                        {{ $complaint->status }}
                    </span>
                </div>
                <p class="text-[#505f76] text-sm">Submitted on {{ $complaint->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-white rounded-lg border border-[#c3c6d7] px-4 py-2 text-[#191b23] font-semibold text-[13px] shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print
            </button>
            <div x-data="{ openOptions: false }" class="relative">
                <button @click="openOptions = !openOptions" class="bg-[#004ac6] text-white rounded-lg px-4 py-2 font-semibold text-[13px] shadow-sm hover:bg-blue-800 transition flex items-center gap-2">
                    Update Status
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="openOptions" @click.away="openOptions = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-[#e1e2ed] py-2 z-50">
                    <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="status" value="Pending" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">Mark as Pending</button>
                        <button type="submit" name="status" value="Reviewing" class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50 hover:text-yellow-700">Mark as Reviewing</button>
                        <button type="submit" name="status" value="In Progress" class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 hover:text-blue-700">Mark as In Progress</button>
                        <button type="submit" name="status" value="Resolved" class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 hover:text-green-700 font-bold border-t border-gray-100 mt-1 pt-2">Resolve Ticket</button>
                        <button type="submit" name="status" value="Closed" class="w-full text-left px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800">Close Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        
        <div class="lg:col-span-8 flex flex-col w-full h-full">
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 lg:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)] relative">
                
                @if($complaint->is_anonymous)
                    <div class="absolute top-0 right-8 bg-[#191b23] text-white text-[10px] font-bold px-3 py-1 rounded-b-lg tracking-wider uppercase">Anonymous Report</div>
                @endif

                <h2 class="text-[#191b23] font-bold text-2xl mb-6">{{ $complaint->title }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col gap-1">
                        <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider">Reporter Name</span>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                                @if($complaint->is_anonymous)
                                    <img src="https://ui-avatars.com/api/?name=Anon&color=fff&background=191b23" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($complaint->user->name) }}&color=fff&background=004ac6" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <span class="text-[#191b23] font-semibold text-sm">
                                {{ $complaint->is_anonymous ? 'Anonymous User' : $complaint->user->name }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider">Reporter ID (NIM)</span>
                        <span class="text-[#191b23] font-medium text-sm">{{ $complaint->is_anonymous ? 'HIDDEN' : $complaint->user->nim }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider">Category</span>
                        <span class="text-[#004ac6] font-semibold text-sm">{{ $complaint->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider">Incident Location</span>
                        <span class="text-[#191b23] font-medium text-sm">{{ $complaint->location ?: 'Not specified' }}</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2 mb-8">
                    <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider">Full Description</span>
                    <div class="bg-[#faf8ff] border border-[#e1e2ed] p-4 rounded-lg text-[#191b23] text-sm leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</div>
                </div>

                @if($complaint->attachments->count() > 0)
                    <div class="flex flex-col gap-2 border-t border-gray-100 pt-6">
                        <span class="text-[#737686] text-xs font-semibold uppercase tracking-wider mb-2">Attached Evidences ({{ $complaint->attachments->count() }})</span>
                        <div class="flex flex-wrap gap-4">
                            @foreach($complaint->attachments as $attachment)
                                @if(in_array(strtolower($attachment->file_type), ['jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="w-32 h-32 rounded-lg border border-[#c3c6d7] overflow-hidden hover:opacity-80 transition hover:shadow-md cursor-pointer block">
                                        <img src="{{ asset('storage/' . $attachment->file_path) }}" class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="w-32 h-32 bg-[#e1e2ed] rounded-lg border border-[#c3c6d7] flex flex-col items-center justify-center gap-2 hover:bg-gray-300 transition text-[#004ac6] font-bold text-sm">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                        {{ strtoupper($attachment->file_type) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] flex flex-col h-[500px] shadow-sm mt-6">
                <div class="bg-[#faf8ff] rounded-t-xl border-b border-[rgba(195,198,215,0.30)] p-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M20 20L16 16H6C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V13H15C15.55 13 16.0208 12.8042 16.4125 12.4125C16.8042 12.0208 17 11.55 17 11V4H18C18.55 4 19.0208 4.19583 19.4125 4.5875C19.8042 4.97917 20 5.45 20 6V20ZM2 10.175L3.175 9H13V2H2V10.175ZM0 15V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H13C13.55 0 14.0208 0.195833 14.4125 0.5875C14.8042 0.979167 15 1.45 15 2V9C15 9.55 14.8042 10.0208 14.4125 10.4125C14.0208 10.8042 13.55 11 13 11H4L0 15ZM2 9V2V9Z" fill="#004AC6"/></svg>
                        <h2 class="text-[#191b23] font-semibold text-lg">Resolution Thread</h2>
                    </div>
                </div>

                <div class="bg-[#faf8ff] flex-1 p-4 overflow-y-auto flex flex-col gap-4 chat-container-scroll">
                    
                    <div class="text-center mb-4 mt-2">
                        <span class="bg-[#ededf9] text-[#434655] text-[11px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            LAPORAN DIBUAT - {{ $complaint->created_at?->format('d M, H:i') ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex flex-row gap-3 items-end justify-start self-start max-w-[85%] mt-2">
                        <div class="w-8 h-8 rounded-full bg-[#505f76] flex items-center justify-center shadow-sm overflow-hidden shrink-0">
                            @if($complaint->is_anonymous)
                                <img src="https://ui-avatars.com/api/?name=Anon&color=fff&background=191b23" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($complaint->user->name) }}&color=fff&background=505f76" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="bg-white rounded-tl-2xl rounded-tr-2xl rounded-br-2xl rounded-bl-sm border border-[rgba(195,198,215,0.30)] p-3 shadow-sm">
                            <div class="text-[#004ac6] font-bold text-[12px] uppercase tracking-wider mb-1">
                                {{ $complaint->is_anonymous ? 'Anonymous User' : $complaint->user->name }} 
                                <span class="text-gray-500 font-normal normal-case text-xs">(Mahasiswa)</span>
                            </div>
                            <div class="text-[#191b23] text-sm whitespace-pre-wrap">{{ $complaint->description }}</div>
                            <div class="text-[#434655] text-[10px] mt-1">{{ $complaint->created_at?->format('H:i') ?? '' }}</div>
                        </div>
                    </div>

                    @foreach($complaint->responses->sortBy('created_at') as $reply)
                        @if($reply->is_internal)
                            <div class="flex flex-col self-center max-w-[90%] w-full my-2">
                                <div class="bg-[#fff8e6] border border-[#ffe082] rounded-lg p-3 shadow-sm flex flex-col gap-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        <span class="text-[#d97706] font-bold text-[11px] uppercase tracking-wider">Internal Note (Admin Only) - {{ $reply->user->name }}</span>
                                    </div>
                                    <div class="text-[#8a6a00] text-sm whitespace-pre-wrap">{{ $reply->message }}</div>
                                    <div class="text-[#b38f00] text-[10px] text-right">{{ $reply->created_at?->format('d M, H:i') ?? '' }}</div>
                                </div>
                            </div>
                        @else
                            @if($reply->user_id == auth()->id())
                                <div class="flex flex-row gap-3 items-end justify-end self-end max-w-[85%] mt-2">
                                    <div class="bg-[#2563eb] rounded-tl-2xl rounded-tr-2xl rounded-br-sm rounded-bl-2xl p-3 shadow-sm text-white text-sm hover:brightness-110 transition-colors">
                                        <div class="whitespace-pre-wrap">{{ $reply->message }}</div>
                                        <div class="text-[rgba(255,255,255,0.70)] text-[10px] text-right mt-1">{{ $reply->created_at?->format('d M, H:i') ?? '' }}</div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-[#004ac6] flex items-center justify-center shadow-sm overflow-hidden border-2 border-white shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&color=fff&background=004ac6" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-row gap-3 items-end justify-start self-start max-w-[85%] mt-2">
                                    <div class="w-8 h-8 rounded-full bg-[#505f76] flex items-center justify-center shadow-sm overflow-hidden shrink-0">
                                        @if($complaint->is_anonymous && $reply->user_id == $complaint->user_id)
                                            <img src="https://ui-avatars.com/api/?name=Anon&color=fff&background=191b23" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&color=fff&background=505f76" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="bg-white rounded-tl-2xl rounded-tr-2xl rounded-br-2xl rounded-bl-sm border border-[rgba(195,198,215,0.30)] p-3 shadow-sm hover:border-[#c3c6d7] transition-colors">
                                        <div class="text-[#004ac6] font-bold text-[12px] uppercase tracking-wider mb-1">
                                            {{ ($complaint->is_anonymous && $reply->user_id == $complaint->user_id) ? 'Anonymous User' : $reply->user->name }} 
                                            <span class="text-gray-500 font-normal normal-case text-xs">(Mahasiswa)</span>
                                        </div>
                                        <div class="text-[#191b23] text-sm whitespace-pre-wrap">{{ $reply->message }}</div>
                                        <div class="text-[#434655] text-[10px] mt-1">{{ $reply->created_at?->format('d M, H:i') ?? '' }}</div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>

                @if(in_array($complaint->status, ['Resolved', 'Closed']))
                    <div class="bg-gray-50 rounded-b-xl border-t border-[rgba(195,198,215,0.30)] p-4 text-center shrink-0">
                        <span class="text-sm text-[#505f76] font-medium">Ticket is closed. Conversation locked.</span>
                    </div>
                @else
                    <form action="{{ route('admin.complaints.response', $complaint->id) }}" method="POST" class="bg-[#ffffff] rounded-b-xl border-t border-[rgba(195,198,215,0.30)] p-4 flex items-center gap-3 shrink-0" x-data="{ isInternal: false }">
                        @csrf
                        
                        <button type="button" @click="isInternal = !isInternal" :class="isInternal ? 'bg-[#fff8e6] border-[#ffe082] text-[#d97706]' : 'bg-gray-100 border-[#c3c6d7] text-[#737686]'" class="w-10 h-10 rounded-lg flex items-center justify-center border transition-colors shrink-0 tooltip" title="Toggle Internal Note">
                            <svg x-show="!isInternal" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <svg x-show="isInternal" style="display:none;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </button>
                        <input type="hidden" name="is_internal" :value="isInternal ? '1' : ''">

                        <input type="text" name="response" required :placeholder="isInternal ? 'Type an internal note (staff only)...' : 'Type reply to student...'" :class="isInternal ? 'bg-[#fff8e6] focus:border-[#d97706] focus:ring-[#d97706]' : 'bg-[#f3f3fe] focus:border-[#004ac6] focus:ring-[#004ac6]'" class="flex-1 rounded-xl border border-[#c3c6d7] px-4 py-2.5 text-[#191b23] text-sm focus:outline-none focus:ring-1 transition-colors">
                        
                        <button type="submit" :class="isInternal ? 'bg-[#d97706] hover:bg-yellow-700' : 'bg-[#004ac6] hover:bg-blue-800'" class="w-10 h-10 rounded-xl flex items-center justify-center transition shadow-sm shrink-0">
                            <svg width="14" height="12" viewBox="0 0 16 14" fill="none"><path d="M0 13.3333V0L15.8333 6.66667L0 13.3333ZM1.66667 10.8333L11.5417 6.66667L1.66667 2.5V5.41667L6.66667 6.66667L1.66667 7.91667V10.8333Z" fill="white"/></svg>
                        </button>
                    </form>
                @endif
            </div>

        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <h3 class="text-[#191b23] font-semibold text-lg border-b border-[rgba(195,198,215,0.30)] pb-3 mb-4">Ticket Classification</h3>
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[#434655] font-semibold text-[13px]">Priority Level</span>
                        <span class="{{ $urgencyBg }} rounded-md border px-2 py-0.5 text-xs font-bold uppercase">{{ $complaint->priority }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#434655] font-semibold text-[13px]">Assignee Dept</span>
                        <span class="text-[#191b23] font-semibold text-[13px] bg-gray-100 rounded-md px-2 py-1">{{ $complaint->category->department ?? 'General' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#191b23" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <h2 class="text-[#191b23] font-semibold text-lg">Audit Timeline</h2>
                </div>

                <div class="relative pl-3 flex flex-col gap-6">
                    <div class="absolute left-[19px] top-[10px] bottom-0 w-[2px] bg-[rgba(195,198,215,0.40)] z-0"></div>
                    
                    <div class="flex flex-col gap-6 max-h-[350px] overflow-y-auto pr-2">
                        @if(in_array($complaint->status, ['Resolved', 'Closed']))
                            <div class="flex gap-4 relative z-10">
                                <div class="bg-[#16a34a] border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0 shadow-sm"></div>
                                <div class="flex flex-col">
                                    <span class="text-[#16a34a] text-sm font-bold">Ticket Closed</span>
                                    <span class="text-[#434655] text-sm">Issue has been resolved.</span>
                                    <span class="text-gray-500 text-[12px] font-semibold mt-1">{{ $complaint->updated_at?->format('M d, Y - H:i A') }}</span>
                                </div>
                            </div>
                        @endif

                        @forelse($complaint->auditLogs->sortByDesc('created_at') as $log)
                            <div class="flex gap-4 relative z-10">
                                <div class="bg-gray-300 border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0"></div>
                                <div class="flex flex-col">
                                    <span class="text-[#191b23] text-sm font-medium">{{ $log->action }}</span>
                                    <span class="text-[#434655] text-xs">Status changed: <span class="line-through">{{ $log->old_status }}</span> &rarr; <b>{{ $log->new_status }}</b></span>
                                    <span class="text-gray-500 text-[11px] font-semibold mt-1">{{ $log->created_at?->format('M d, Y - H:i A') }} by {{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </div>
                        @empty
                        @endforelse

                        @if(!in_array($complaint->status, ['Resolved', 'Closed']))
                            <div class="flex gap-4 relative z-10">
                                <div class="bg-[#0053db] border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0"></div>
                                <div class="flex flex-col">
                                    <span class="text-[#191b23] text-sm font-medium">Ticket Status Updated</span>
                                    <span class="text-[#434655] text-sm">Currently marked as '{{ $complaint->status }}'</span>
                                    <span class="text-gray-500 text-[12px] font-semibold mt-1">{{ $complaint->updated_at?->format('M d, Y - H:i A') ?? 'Baru saja' }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-4 relative z-10">
                            <div class="bg-[#10b981] border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0 shadow-sm"></div>
                            <div class="flex flex-col">
                                <span class="text-[#191b23] text-sm font-medium">Ticket Created</span>
                                <span class="text-[#434655] text-sm">Submitted via Student Portal</span>
                                <span class="text-gray-500 text-[12px] font-semibold mt-1">{{ $complaint->created_at?->format('M d, Y - H:i A') ?? 'Unknown Date' }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatContainer = document.querySelector('.chat-container-scroll');
        const chatForm = document.querySelector('form[action*="response"]');
        
        // Fungsi untuk scroll otomatis ke pesan terbawah
        const scrollToBottom = () => {
            if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        };
        
        scrollToBottom(); // Panggil saat halaman pertama kali dimuat

        if(chatContainer) {
            let currentChatContent = chatContainer.innerHTML.trim();

            // 1. FITUR AUTO-RECEIVE (Background Polling setiap 4 detik)
            const fetchLatestChat = async () => {
                try {
                    // Tarik data halaman ini secara diam-diam
                    const response = await fetch(window.location.href, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    
                    if(response.ok) {
                        const html = await response.text();
                        // Ambil hanya kotak chat dari seluruh halaman HTML yang ditarik
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const newChatContainer = doc.querySelector('.chat-container-scroll');
                        
                        if(newChatContainer) {
                            const newContent = newChatContainer.innerHTML.trim();
                            // Jika ada perubahan HTML (ada pesan baru masuk)
                            if(newContent !== currentChatContent) {
                                chatContainer.innerHTML = newContent;
                                currentChatContent = newContent;
                                scrollToBottom(); // Scroll ke bawah untuk melihat pesan
                            }
                        }
                    }
                } catch(e) { console.error('Polling error:', e); }
            };

            // Jalankan pengecekan setiap 4000 milidetik (4 detik)
            setInterval(fetchLatestChat, 4000);

            // 2. FITUR AUTO-SEND (Kirim Pesan Tanpa Refresh)
            if(chatForm) {
                chatForm.addEventListener('submit', async function(e) {
                    e.preventDefault(); // Hentikan fungsi loading/refresh bawaan browser
                    
                    const submitBtn = chatForm.querySelector('button[type="submit"]');
                    const inputField = chatForm.querySelector('input[name="response"]');
                    
                    // Efek tombol sedang memproses
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-wait');
                    
                    try {
                        const res = await fetch(chatForm.action, {
                            method: 'POST',
                            body: new FormData(chatForm),
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        
                        if(res.ok) {
                            inputField.value = ''; // Kosongkan input setelah terkirim
                            await fetchLatestChat(); // Langsung tarik pesan baru ke layar!
                        }
                    } catch(err) {
                        console.error('Gagal mengirim pesan');
                    } finally {
                        // Kembalikan tombol ke semula
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-wait');
                        inputField.focus();
                    }
                });
            }
        }
    });
</script>
@endsection