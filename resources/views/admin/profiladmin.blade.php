@extends('layouts.admin')
@section('title', 'Admin Profile - SCMS')

@section('content')
<div class="flex flex-col gap-8 w-full max-w-[1400px] mx-auto pb-10">
    
    <div class="flex flex-col relative w-full mb-6">
        <div class="rounded-t-2xl w-full h-40 relative overflow-hidden shadow-sm" style="background: linear-gradient(90deg, rgba(0,74,198,1) 0%, rgba(37,99,235,1) 100%);">
            <div class="absolute inset-0" style="background: radial-gradient(closest-side, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);"></div>
        </div>
        
        <div class="bg-white rounded-b-2xl border-x border-b border-[#c3c6d7] px-8 pt-4 pb-6 flex flex-col md:flex-row gap-6 items-start md:items-center justify-start w-full shadow-sm relative">
            <div class="shrink-0 -mt-20 relative z-10">
                <img class="rounded-2xl border-4 border-white w-[130px] h-[130px] object-cover shadow-md bg-gray-50" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=fff&background=004ac6&size=128" />
            </div>
            
            <div class="flex flex-col gap-1 w-full">
                <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[28px] font-bold tracking-tight">{{ $user->name }}</h1>
                <div class="flex flex-wrap gap-3 items-center mt-1.5">
                    <div class="bg-[#f3f3fe] border border-[#d0e1fb] rounded-md px-3 py-1 flex items-center gap-2 shadow-sm">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#004ac6]"></div>
                        <span class="text-[#004ac6] font-semibold text-[13px] tracking-wide uppercase">{{ $user->role == 'superadmin' ? 'Super Administrator' : 'Senior Administrator' }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-md px-3 py-1 flex items-center gap-1.5 border border-gray-200">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 10.6667V6H3.33333V10.6667H2ZM6 10.6667V6H7.33333V10.6667H6ZM0 13.3333V12H13.3333V13.3333H0ZM10 10.6667V6H11.3333V10.6667H10ZM0 4.66667V3.33333L6.66667 0L13.3333 3.33333V4.66667H0ZM2.96667 3.33333H6.66667H10.3667H2.96667ZM2.96667 3.33333H10.3667L6.66667 1.5L2.96667 3.33333Z" fill="#434655"/></svg>
                        <span class="text-[#434655] font-medium text-[13px]">Complaint Handler</span>
                    </div>
                </div>
            </div>
            
            <button class="md:ml-auto bg-white border border-[#c3c6d7] rounded-lg px-4 py-2 flex items-center gap-2 hover:bg-gray-50 transition shadow-sm shrink-0">
                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"><path d="M11.25 15C10.625 15 10.0938 14.7812 9.65625 14.3438C9.21875 13.9062 9 13.375 9 12.75C9 12.675 9.01875 12.5 9.05625 12.225L3.7875 9.15C3.5875 9.3375 3.35625 9.48438 3.09375 9.59062C2.83125 9.69687 2.55 9.75 2.25 9.75C1.625 9.75 1.09375 9.53125 0.65625 9.09375C0.21875 8.65625 0 8.125 0 7.5C0 6.875 0.21875 6.34375 0.65625 5.90625C1.09375 5.46875 1.625 5.25 2.25 5.25C2.55 5.25 2.83125 5.30313 3.09375 5.40938C3.35625 5.51562 3.5875 5.6625 3.7875 5.85L9.05625 2.775C9.03125 2.6875 9.01562 2.60312 9.00937 2.52187C9.00312 2.44062 9 2.35 9 2.25C9 1.625 9.21875 1.09375 9.65625 0.65625C10.0938 0.21875 10.625 0 11.25 0C11.875 0 12.4062 0.21875 12.8438 0.65625C13.2812 1.09375 13.5 1.625 13.5 2.25C13.5 2.875 13.2812 3.40625 12.8438 3.84375C12.4062 4.28125 11.875 4.5 11.25 4.5C10.95 4.5 10.6687 4.44687 10.4062 4.34062C10.1438 4.23438 9.9125 4.0875 9.7125 3.9L4.44375 6.975C4.46875 7.0625 4.48438 7.14687 4.49062 7.22813C4.49687 7.30938 4.5 7.4 4.5 7.5C4.5 7.6 4.49687 7.69062 4.49062 7.77187C4.48438 7.85313 4.46875 7.9375 4.44375 8.025L9.7125 11.1C9.9125 10.9125 10.1438 10.7656 10.4062 10.6594C10.6687 10.5531 10.95 10.5 11.25 10.5C11.875 10.5 12.4062 10.7188 12.8438 11.1562C13.2812 11.5938 13.5 12.125 13.5 12.75C13.5 13.375 13.2812 13.9062 12.8438 14.3438C12.4062 14.7812 11.875 15 11.25 15Z" fill="#191B23"/></svg>
                <span class="text-[#191b23] font-semibold text-[13px]">Share Profile</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <div class="bg-white rounded-2xl border border-[#c3c6d7] p-6 shadow-sm flex flex-col gap-6">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 8C6.9 8 5.95833 7.60833 5.175 6.825C4.39167 6.04167 4 5.1 4 4C4 2.9 4.39167 1.95833 5.175 1.175C5.95833 0.391667 6.9 0 8 0C9.1 0 10.0417 0.391667 10.825 1.175C11.6083 1.95833 12 2.9 12 4C12 5.1 11.6083 6.04167 10.825 6.825C10.0417 7.60833 9.1 8 8 8ZM0 16V13.2C0 12.6333 0.145833 12.1125 0.4375 11.6375C0.729167 11.1625 1.11667 10.8 1.6 10.55C2.63333 10.0333 3.68333 9.64583 4.75 9.3875C5.81667 9.12917 6.9 9 8 9C9.1 9 10.1833 9.12917 11.25 9.3875C12.3167 9.64583 13.3667 10.0333 14.4 10.55C14.8833 10.8 15.2708 11.1625 15.5625 11.6375C15.8542 12.1125 16 12.6333 16 13.2V16H0Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Personal Information</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[#434655] font-semibold text-[13px]">Full Name</span>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 pl-4">
                            <span class="text-[#191b23] text-base">{{ $user->name }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[#434655] font-semibold text-[13px]">Email Address</span>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 pl-4">
                            <span class="text-[#191b23] text-base">{{ $user->email }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[#434655] font-semibold text-[13px]">Phone Number</span>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 pl-4">
                            <span class="text-[#191b23] text-base">{{ $user->phone ?? '+62 8XX XXXX XXXX' }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[#434655] font-semibold text-[13px]">Employee ID</span>
                        <div class="bg-[#ededf9] rounded-xl border border-[#c3c6d7] p-3 pl-4">
                            <span class="text-[#434655] text-base">{{ $user->nip ?? 'ADM-2026-' . str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-[#c3c6d7] shadow-sm flex flex-col overflow-hidden">
                <div class="border-b border-[#c3c6d7] p-6 flex items-center gap-2 bg-[#fcfcfc]">
                    <svg width="16" height="21" viewBox="0 0 16 21" fill="none"><path d="M2 21C1.45 21 0.979167 20.8042 0.5875 20.4125C0.195833 20.0208 0 19.55 0 19V9C0 8.45 0.195833 7.97917 0.5875 7.5875C0.979167 7.19583 1.45 7 2 7H3V5C3 3.61667 3.4875 2.4375 4.4625 1.4625C5.4375 0.4875 6.61667 0 8 0C9.38333 0 10.5625 0.4875 11.5375 1.4625C12.5125 2.4375 13 3.61667 13 5V7H14C14.55 7 15.0208 7.19583 15.4125 7.5875C15.8042 7.97917 16 8.45 16 9V19C16 19.55 15.8042 20.0208 15.4125 20.4125C15.0208 20.8042 14.55 21 14 21H2ZM2 19H14V9H2V19ZM8 16C8.55 16 9.02083 15.8042 9.4125 15.4125C9.80417 15.0208 10 14.55 10 14C10 13.45 9.80417 12.9792 9.4125 12.5875C9.02083 12.1958 8.55 12 8 12C7.45 12 6.97917 12.1958 6.5875 12.5875C6.19583 12.9792 6 13.45 6 14C6 14.55 6.19583 15.0208 6.5875 15.4125C6.97917 15.8042 7.45 16 8 16ZM5 7H11V5C11 4.16667 10.7083 3.45833 10.125 2.875C9.54167 2.29167 8.83333 2 8 2C7.16667 2 6.45833 2.29167 5.875 2.875C5.29167 3.45833 5 4.16667 5 5V7ZM2 19V9V19Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Security Settings</h2>
                </div>

                @if (session('status') === 'password-updated')
                    <div class="bg-[#d1fae5] border-b border-[#16a34a] text-[#065f46] px-6 py-3 font-medium text-sm">
                        Password successfully updated!
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}" class="p-6 flex flex-col gap-6">
                    @csrf
                    @method('put')

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[#434655] font-semibold text-[13px]">Current Password</label>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 px-4 focus-within:border-[#004ac6] transition shadow-sm">
                            <input type="password" name="current_password" placeholder="••••••••••••" class="w-full bg-transparent border-none outline-none text-[#191b23]" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-sm text-red-600" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[#434655] font-semibold text-[13px]">New Password</label>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 px-4 focus-within:border-[#004ac6] transition shadow-sm">
                            <input type="password" name="password" placeholder="Min. 8 characters" class="w-full bg-transparent border-none outline-none text-[#191b23]" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="text-sm text-red-600" />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[#434655] font-semibold text-[13px]">Confirm New Password</label>
                        <div class="bg-[#f3f3fe] rounded-xl border border-[#c3c6d7] p-3 px-4 focus-within:border-[#004ac6] transition shadow-sm">
                            <input type="password" name="password_confirmation" placeholder="Confirm your new password" class="w-full bg-transparent border-none outline-none text-[#191b23]" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-sm text-red-600" />
                    </div>

                    <div class="border-t border-[#c3c6d7] pt-5 mt-2 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex flex-col">
                            <span class="text-[#191b23] font-semibold text-[13px]">2FA Authentication</span>
                            <span class="text-[#434655] text-[11px]">Extra security layer</span>
                        </div>
                        <div class="bg-[#004ac6] rounded-full w-11 h-6 relative cursor-pointer opacity-80 shadow-sm">
                            <div class="bg-white rounded-full w-5 h-5 absolute right-[2px] top-[2px]"></div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-2">
                        <button type="submit" class="bg-[#004ac6] text-white rounded-lg py-3 px-8 text-[13px] font-semibold hover:bg-blue-800 transition shadow-sm w-full sm:w-auto">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <div class="bg-[#004ac6] rounded-2xl p-6 shadow-md flex flex-col relative overflow-hidden text-white">
                <div class="bg-white/10 rounded-full w-24 h-24 absolute -right-4 -top-4 blur-xl"></div>
                <h3 class="font-semibold text-[13px] tracking-wide z-10 opacity-90">Department Performance</h3>
                <div class="font-bold text-[32px] mt-1 z-10">{{ $performanceRate }}%</div>
                <p class="text-sm opacity-90 mt-2 z-10 leading-relaxed">Resolution rate for your department<br/>this month.</p>
                
                <div class="bg-white/20 rounded-full h-2 w-full mt-4 overflow-hidden z-10">
                    <div class="bg-white h-full rounded-full shadow-inner" style="width: {{ $performanceRate }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-[#c3c6d7] flex flex-col shadow-sm">
                <div class="border-b border-[#c3c6d7] p-6 flex items-center gap-2 bg-[#fcfcfc] rounded-t-2xl">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 18C6.7 18 4.69583 17.2375 2.9875 15.7125C1.27917 14.1875 0.3 12.2833 0.05 10H2.1C2.33333 11.7333 3.10417 13.1667 4.4125 14.3C5.72083 15.4333 7.25 16 9 16C10.95 16 12.6042 15.3208 13.9625 13.9625C15.3208 12.6042 16 10.95 16 9C16 7.05 15.3208 5.39583 13.9625 4.0375C12.6042 2.67917 10.95 2 9 2C7.85 2 6.775 2.26667 5.775 2.8C4.775 3.33333 3.93333 4.06667 3.25 5H6V7H0V1H2V3.35C2.85 2.28333 3.8875 1.45833 5.1125 0.875C6.3375 0.291667 7.63333 0 9 0C10.25 0 11.4208 0.2375 12.5125 0.7125C13.6042 1.1875 14.5542 1.82917 15.3625 2.6375C16.1708 3.44583 16.8125 4.39583 17.2875 5.4875C17.7625 6.57917 18 7.75 18 9C18 10.25 17.7625 11.4208 17.2875 12.5125C16.8125 13.6042 16.1708 14.5542 15.3625 15.3625C14.5542 16.1708 13.6042 16.8125 12.5125 17.2875C11.4208 17.7625 10.25 18 9 18ZM11.8 13.2L8 9.4V4H10V8.6L13.2 11.8L11.8 13.2Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] text-lg font-semibold">Recent Activity</h2>
                </div>
                
                <div class="flex flex-col">
                    @forelse($recentActivities as $activity)
                    <div class="border-b border-[#e1e2ed] p-4 flex flex-row gap-3 hover:bg-gray-50 transition cursor-default">
                        <div class="bg-[#dbeafe] rounded-full p-2 h-10 w-10 flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                        </div>
                        <div class="flex flex-col w-full">
                            <div class="flex justify-between items-start w-full">
                                <span class="text-[#191b23] font-semibold text-[13px]">{{ $activity->action ?? 'Ticket Updated' }}</span>
                                <span class="text-[#434655] text-[11px] font-medium">{{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Baru saja' }}</span>
                            </div>
                            <span class="text-[#434655] text-xs mt-1">Ticket #{{ $activity->complaint->ticket_no ?? 'ID' }} changed to <b class="text-[#191b23]">{{ $activity->new_status }}</b></span>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center flex flex-col items-center gap-2 text-gray-500 text-sm">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22v-7l-8-4 8-4 8 4-8 4v7Z"></path></svg>
                        Belum ada riwayat aktivitas.
                    </div>
                    @endforelse
                </div>

                <div class="bg-[#f3f3fe] p-4 rounded-b-2xl text-center border-t border-[#e1e2ed]">
                    <a href="{{ route('admin.complaints.index') }}" class="text-[#004ac6] text-[13px] font-semibold hover:underline">View all activities</a>
                </div>
            </div>

            <div class="bg-[#d0e1fb] rounded-2xl border border-[#c3c6d7] p-5 flex gap-4 shadow-sm items-center">
                <svg class="text-[#004ac6] shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <div class="flex flex-col">
                    <span class="text-[#54647a] text-[13px] font-semibold">Admin Pro-Tip</span>
                    <span class="text-[rgba(84,100,122,0.90)] text-xs mt-1 leading-relaxed">Ensure you always leave an internal note before resolving a complex ticket.</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection