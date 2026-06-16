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
        'Resolved', 'Closed' => 'bg-[#e1e2ed] border-[rgba(195,198,215,0.30)] text-[#505f76]',
        default => 'bg-gray-100 border-gray-200 text-gray-700'
    };
@endphp

<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1 text-[#191b23]">
            <div class="flex items-center gap-3">
                <span class="bg-[#e7e7f3] px-2 py-1 rounded text-[#434655] font-semibold text-[13px]">#{{ $complaint->ticket_no }}</span>
                <span class="{{ $urgencyBg }} px-2.5 py-1 rounded-full flex items-center gap-1.5 font-semibold text-[13px]">
                    @if($complaint->priority === 'Tinggi') <div class="w-1.5 h-1.5 bg-[#ba1a1a] rounded-full"></div> @endif
                    {{ $complaint->priority == 'Tinggi' ? 'Urgent' : $complaint->priority }}
                </span>
            </div>
            <h1 class="font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">{{ $complaint->title }}</h1>
            <p class="text-[#434655] text-sm">Submitted on {{ $complaint->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button class="bg-[#faf8ff] rounded-lg border border-[#c3c6d7] py-2 px-4 text-[#191b23] font-semibold text-[13px] hover:bg-gray-50 transition">
                More Actions
            </button>
            <button class="bg-[#ffdad6] text-[#93000a] border border-transparent rounded-lg py-2 px-4 flex items-center gap-2 font-semibold text-[13px] hover:bg-red-200 transition">
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M1.05 10.5L0 9.45L4.2 5.25L0 1.05L1.05 0L5.25 4.2L9.45 0L10.5 1.05L6.3 5.25L10.5 9.45L9.45 10.5L5.25 6.3L1.05 10.5Z" fill="#93000A"/></svg>
                Close Ticket
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
        
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col">
                <div class="p-6 border-b border-[rgba(195,198,215,0.20)] flex items-center gap-2">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M4 16H12V14H4V16ZM4 12H12V10H4V12ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H10L16 6V18C16 18.55 15.8042 19.0208 15.4125 19.4125C15.0208 19.8042 14.55 20 14 20H2ZM9 7V2H2V18H14V7H9ZM2 2V7V2V7V18V2Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Complaint Description</h2>
                </div>
                <div class="p-6">
                    <p class="text-[#434655] text-base leading-[26px] whitespace-pre-wrap">{{ $complaint->description }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col">
                <div class="p-6 border-b border-[rgba(195,198,215,0.20)] flex items-center gap-2">
                    <svg width="20" height="13" viewBox="0 0 20 13" fill="none"><path d="M6.25 12.5C4.51667 12.5 3.04167 11.8917 1.825 10.675C0.608333 9.45833 0 7.98333 0 6.25C0 4.51667 0.608333 3.04167 1.825 1.825C3.04167 0.608333 4.51667 0 6.25 0H15.5C16.75 0 17.8125 0.4375 18.6875 1.3125C19.5625 2.1875 20 3.25 20 4.5C20 5.75 19.5625 6.8125 18.6875 7.6875C17.8125 8.5625 16.75 9 15.5 9H6.75C5.98333 9 5.33333 8.73333 4.8 8.2C4.26667 7.66667 4 7.01667 4 6.25C4 5.48333 4.26667 4.83333 4.8 4.3C5.33333 3.76667 5.98333 3.5 6.75 3.5H16V5.5H6.75C6.53333 5.5 6.35417 5.57083 6.2125 5.7125C6.07083 5.85417 6 6.03333 6 6.25C6 6.46667 6.07083 6.64583 6.2125 6.7875C6.35417 6.92917 6.53333 7 6.75 7H15.5C16.2 6.98333 16.7917 6.7375 17.275 6.2625C17.7583 5.7875 18 5.2 18 4.5C18 3.8 17.7583 3.20833 17.275 2.725C16.7917 2.24167 16.2 2 15.5 2H6.25C5.06667 1.98333 4.0625 2.39167 3.2375 3.225C2.4125 4.05833 2 5.06667 2 6.25C2 7.41667 2.4125 8.40833 3.2375 9.225C4.0625 10.0417 5.06667 10.4667 6.25 10.5H16V12.5H6.25Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Uploaded Evidence</h2>
                </div>
                <div class="p-6">
                    @if($complaint->attachments->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($complaint->attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="bg-[#ededf9] rounded-lg border border-[rgba(195,198,215,0.30)] flex items-center justify-center aspect-[4/3] overflow-hidden hover:opacity-80 transition cursor-pointer">
                                    @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $attachment->file_path) }}" alt="Evidence">
                                    @else
                                        <div class="flex flex-col items-center gap-2 text-[#004ac6]">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6C4.9 2 4.01 2.9 4.01 4L4 20C4 21.1 4.89 22 5.99 22H18C19.1 22 20 21.1 20 20V8L14 2ZM13 9V3.5L18.5 9H13Z"/></svg>
                                            <span class="text-xs font-semibold uppercase">{{ $attachment->file_type }}</span>
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#737686] italic text-sm">Tidak ada file bukti yang dilampirkan.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col">
                <div class="p-6 border-b border-[rgba(195,198,215,0.20)] flex items-center gap-2">
                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M16 14V10C16 9.16667 15.7083 8.45833 15.125 7.875C14.5417 7.29167 13.8333 7 13 7H3.825L7.425 10.6L6 12L0 6L6 0L7.425 1.4L3.825 5H13C14.3833 5 15.5625 5.4875 16.5375 6.4625C17.5125 7.4375 18 8.61667 18 10V14H16Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Admin Response</h2>
                </div>
                <div class="p-6 flex flex-row gap-4 items-start">
                    <div class="bg-[#e7e7f3] rounded-full border border-[rgba(195,198,215,0.30)] w-10 h-10 shrink-0 overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=fff&background=004ac6" />
                    </div>
                    
                    <form method="POST" action="{{ route('admin.complaints.response', $complaint->id) }}" class="flex flex-col gap-3 flex-1 w-full">
                        @csrf
                        <div class="bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 focus-within:border-[#004ac6] transition-colors">
                            <textarea name="response" rows="3" placeholder="Type your response to the student or internal note here..." class="w-full bg-transparent border-none outline-none text-[#191b23] text-sm resize-none"></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_internal" class="w-4 h-4 rounded border-[#c3c6d7] text-[#004ac6] focus:ring-[#004ac6]">
                                <span class="text-[#434655] text-sm">Internal Note Only</span>
                            </label>
                            
                            <button type="submit" class="bg-[#004ac6] rounded-lg py-2 px-5 flex items-center gap-2 hover:bg-blue-800 transition shadow-sm w-full sm:w-auto justify-center">
                                <svg width="15" height="12" viewBox="0 0 15 12" fill="none"><path d="M0 12V0L14.25 6L0 12ZM1.5 9.75L10.3875 6L1.5 2.25V4.875L6 6L1.5 7.125V9.75ZM1.5 9.75V6V2.25V4.875V7.125V9.75Z" fill="white"/></svg>
                                <span class="text-white text-sm font-medium">Post Reply</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col">
                <div class="p-6 border-b border-[rgba(195,198,215,0.20)]">
                    <h2 class="text-[#191b23] text-lg font-semibold">Reporter Info</h2>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    <div class="flex items-center gap-4">
                        @if($complaint->is_anonymous)
                            <div class="w-14 h-14 rounded-full bg-gray-200 border-2 border-white shadow-sm flex items-center justify-center text-gray-500 font-bold text-xl">AN</div>
                            <div class="flex flex-col">
                                <span class="text-[#191b23] font-semibold text-xl">Anonymous User</span>
                                <span class="text-[#434655] text-sm">ID: Hidden</span>
                            </div>
                        @else
                            <img class="w-14 h-14 rounded-full border-2 border-white shadow-sm object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($complaint->user->name ?? 'User') }}&color=54647a&background=d0e1fb" />
                            <div class="flex flex-col">
                                <span class="text-[#191b23] font-semibold text-xl">{{ $complaint->user->name ?? 'Unknown' }}</span>
                                <span class="text-[#434655] text-sm">ID: {{ $complaint->user->nim ?? '-' }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col gap-4 border-t border-[#ededf9] pt-4">
                        <div class="flex justify-between items-center border-b border-[#ededf9] pb-3">
                            <span class="text-[#434655] text-sm">Faculty</span>
                            <span class="text-[#191b23] text-sm font-medium">Informatics</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-[#ededf9] pb-3">
                            <span class="text-[#434655] text-sm">Email</span>
                            <span class="text-[#191b23] text-sm font-medium">{{ $complaint->is_anonymous ? 'Hidden' : ($complaint->user->email ?? '-') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-1">
                            <span class="text-[#434655] text-sm">Phone</span>
                            <span class="text-[#191b23] text-sm font-medium">{{ $complaint->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <button class="w-full rounded-lg border border-[#c3c6d7] py-2 flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.75 13.5C5.025 13.5 3.52187 12.9281 2.24062 11.7844C0.959375 10.6406 0.225 9.2125 0.0375 7.5H1.575C1.75 8.8 2.32812 9.875 3.30938 10.725C4.29063 11.575 5.4375 12 6.75 12C8.2125 12 9.45312 11.4906 10.4719 10.4719C11.4906 9.45312 12 8.2125 12 6.75C12 5.2875 11.4906 4.04688 10.4719 3.02813C9.45312 2.00938 8.2125 1.5 6.75 1.5C5.8875 1.5 5.08125 1.7 4.33125 2.1C3.58125 2.5 2.95 3.05 2.4375 3.75H4.5V5.25H0V0.75H1.5V2.5125C2.1375 1.7125 2.91562 1.09375 3.83437 0.65625C4.75312 0.21875 5.725 0 6.75 0C7.6875 0 8.56562 0.178125 9.38437 0.534375C10.2031 0.890625 10.9156 1.37188 11.5219 1.97812C12.1281 2.58437 12.6094 3.29688 12.9656 4.11562C13.3219 4.93437 13.5 5.8125 13.5 6.75C13.5 7.6875 13.3219 8.56562 12.9656 9.38437C12.6094 10.2031 12.1281 10.9156 11.5219 11.5219C10.9156 12.1281 10.2031 12.6094 9.38437 12.9656C8.56562 13.3219 7.6875 13.5 6.75 13.5ZM8.85 9.9L6 7.05V3H7.5V6.45L9.9 8.85L8.85 9.9Z" fill="#505F76"/></svg>
                        <span class="text-[#505f76] text-sm font-medium">View Past Tickets</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col">
                <div class="p-6 border-b border-[rgba(195,198,215,0.20)]">
                    <h2 class="text-[#191b23] text-lg font-semibold">Ticket Details</h2>
                </div>
                <div class="p-6 flex flex-col gap-5">
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px]">Category</span>
                        <div class="bg-[#f3f3fe] border border-[#c3c6d7] rounded-lg p-2.5 flex items-center gap-2">
                            <span class="text-[#191b23] text-sm">{{ $complaint->category->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px]">Assign To</span>
                        <div class="bg-[#faf8ff] border border-[#c3c6d7] rounded-lg p-2.5 flex justify-between items-center cursor-pointer hover:border-[#004ac6] transition">
                            <span class="text-[#191b23] text-sm">{{ $complaint->category->department ?? 'General' }}</span>
                            <svg width="10" height="5" viewBox="0 0 10 5" fill="none"><path d="M5 5L0 0H10L5 5Z" fill="#434655"/></svg>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px]">Location</span>
                        <span class="text-[#191b23] text-base">{{ $complaint->location ?? 'Belum ditentukan' }}</span>
                    </div>

                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.20)] shadow-sm flex flex-col pb-6">
                <div class="p-6">
                    <h2 class="text-[#191b23] text-lg font-semibold">Timeline</h2>
                </div>
                
                <div class="px-6 relative">
                    <div class="absolute top-2 bottom-2 left-[31px] w-0.5 bg-[#ededf9]"></div>

                    <div class="flex flex-col gap-6">
                        
                        @foreach($complaint->responses->sortByDesc('created_at') as $reply)
                            <div class="flex gap-4 relative z-10">
                                <div class="{{ $reply->is_internal ? 'bg-[#f59e0b]' : 'bg-[#004ac6]' }} border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0 shadow-sm"></div>
                                <div class="flex flex-col bg-gray-50 border border-gray-100 p-3 rounded-lg w-full">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[#191b23] text-sm font-bold">
                                            {{ $reply->user->name }} 
                                            @if($reply->is_internal) <span class="text-xs text-[#f59e0b] ml-1">(Internal Note)</span> @endif
                                        </span>
                                        <span class="text-gray-500 text-[12px] font-semibold">{{ $reply->created_at->format('M d, H:i') }}</span>
                                    </div>
                                    <span class="text-[#434655] text-sm whitespace-pre-wrap">{{ $reply->message }}</span>
                                </div>
                            </div>
                        @endforeach

                        @if($complaint->updated_at != $complaint->created_at)
                        <div class="flex gap-4 relative z-10">
                            <div class="bg-[#0053db] border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0"></div>
                            <div class="flex flex-col">
                                <span class="text-[#191b23] text-sm font-medium">Ticket Status Updated</span>
                                <span class="text-[#434655] text-sm">Changed to '{{ $complaint->status }}'</span>
                                <span class="text-gray-500 text-[12px] font-semibold mt-1">{{ $complaint->updated_at->format('M d, H:i A') }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="flex gap-4 relative z-10">
                            <div class="bg-[#10b981] border-2 border-white w-4 h-4 rounded-full mt-1 shrink-0"></div>
                            <div class="flex flex-col">
                                <span class="text-[#191b23] text-sm font-medium">Ticket Created</span>
                                <span class="text-[#434655] text-sm">Submitted via Student Portal</span>
                                <span class="text-gray-500 text-[12px] font-semibold mt-1">{{ $complaint->created_at->format('M d, H:i A') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection