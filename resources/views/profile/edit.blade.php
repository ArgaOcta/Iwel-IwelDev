@extends(Auth::user()->role === 'mahasiswa' ? 'layouts.mahasiswa' : 'layouts.admin')
@section('title', 'Profil - SCMS')

@section('content')
<div class="w-full max-w-7xl mx-auto pt-8 pb-14 px-4 sm:px-6 lg:px-8 relative">
    
    <div class="flex flex-col gap-1 mb-8">
        <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">Profile Settings</h1>
        <p class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-base">Manage your personal information and account security.</p>
    </div>

    @if (session('status') === 'password-updated')
        <div class="w-full bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm flex items-center gap-3">
            <div class="bg-green-100 rounded-full p-1">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <span class="font-medium text-sm">Kata sandi berhasil diperbarui!</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <div class="bg-[rgba(255,255,255,0.90)] backdrop-blur-sm rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col relative pb-6">
                
                <div class="h-32 w-full relative" style="background: linear-gradient(135deg, rgba(219, 225, 255, 1) 0%, rgba(237, 237, 249, 1) 100%);">
                    <div class="absolute inset-0 opacity-20" style="background: radial-gradient(closest-side, rgba(0, 74, 198, 1) 2%, rgba(0, 74, 198, 0) 2%);"></div>
                </div>

                <div class="absolute w-full top-[64px] flex justify-center">
                    <div class="bg-white rounded-full p-1 shadow-sm">
                        <div class="bg-[#004ac6] rounded-full w-28 h-28 flex items-center justify-center relative">
                            <span class="text-white text-3xl font-bold font-['Manrope-Bold',_sans-serif]">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </span>
                            <div class="bg-[#10b981] rounded-full border-2 border-white w-5 h-5 absolute right-1 bottom-1 shadow-[0_1px_2px_rgba(0,0,0,0.05)]"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-[84px] flex flex-col items-center gap-1.5 px-6">
                    <h2 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold text-center truncate w-full">{{ Auth::user()->name }}</h2>
                    <div class="bg-[#ededf9] rounded-full px-3 py-1">
                        <span class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm leading-5">
                            {{ Auth::user()->role == 'mahasiswa' ? 'Student' : (Auth::user()->role == 'superadmin' ? 'Super Admin' : 'Administrator') }}
                        </span>
                    </div>
                </div>

                <div class="mx-6 mt-6 pt-4 border-t border-[rgba(195,198,215,0.40)] flex flex-col gap-3">
                    <div class="flex justify-between items-center w-full">
                        <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Account Status</span>
                        <div class="flex items-center gap-1.5">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.73333 9.73333L10.4333 5.03333L9.5 4.1L5.73333 7.86667L3.83333 5.96667L2.9 6.9L5.73333 9.73333ZM6.66667 13.3333C5.74444 13.3333 4.87778 13.1583 4.06667 12.8083C3.25556 12.4583 2.55 11.9833 1.95 11.3833C1.35 10.7833 0.875 10.0778 0.525 9.26667C0.175 8.45555 0 7.58889 0 6.66667C0 5.74444 0.175 4.87778 0.525 4.06667C0.875 3.25556 1.35 2.55 1.95 1.95C2.55 1.35 3.25556 0.875 4.06667 0.525C4.87778 0.175 5.74444 0 6.66667 0C7.58889 0 8.45555 0.175 9.26667 0.525C10.0778 0.875 10.7833 1.35 11.3833 1.95C11.9833 2.55 12.4583 3.25556 12.8083 4.06667C13.1583 4.87778 13.3333 5.74444 13.3333 6.66667C13.3333 7.58889 13.1583 8.45555 12.8083 9.26667C12.4583 10.0778 11.9833 10.7833 11.3833 11.3833C10.7833 11.9833 10.0778 12.4583 9.26667 12.8083C8.45555 13.1583 7.58889 13.3333 6.66667 13.3333ZM6.66667 12C8.15556 12 9.41667 11.4833 10.45 10.45C11.4833 9.41667 12 8.15556 12 6.66667C12 5.17778 11.4833 3.91667 10.45 2.88333C9.41667 1.85 8.15556 1.33333 6.66667 1.33333C5.17778 1.33333 3.91667 1.85 2.88333 2.88333C1.85 3.91667 1.33333 5.17778 1.33333 6.66667C1.33333 8.15556 1.85 9.41667 2.88333 10.45C3.91667 11.4833 5.17778 12 6.66667 12Z" fill="#10B981"/></svg>
                            <span class="text-[#10b981] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Active</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Member Since</span>
                        <span class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium">{{ Auth::user()->created_at?->format('M Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] flex flex-col gap-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M6.95 13.55L12.6 7.9L11.175 6.475L6.95 10.7L4.85 8.6L3.425 10.025L6.95 13.55ZM8 20C5.68333 19.4167 3.77083 18.0875 2.2625 16.0125C0.754167 13.9375 0 11.6333 0 9.1V3L8 0L16 3V9.1C16 11.6333 15.2458 13.9375 13.7375 16.0125C12.2292 18.0875 10.3167 19.4167 8 20ZM8 17.9C9.73333 17.35 11.1667 16.25 12.3 14.6C13.4333 12.95 14 11.1167 14 9.1V4.375L8 2.125L2 4.375V9.1C2 11.1167 2.56667 12.95 3.7 14.6C4.83333 16.25 6.26667 17.35 8 17.9Z" fill="#004AC6"/></svg>
                    <h2 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Quick Actions</h2>
                </div>
                
                @if(Auth::user()->role === 'mahasiswa')
                    <a href="{{ route('complaint.history') }}" class="rounded-lg p-3 flex gap-3 items-center hover:bg-gray-50 transition group border border-transparent hover:border-gray-200">
                        <div class="bg-[rgba(0,74,198,0.10)] group-hover:bg-[#004ac6] transition-colors rounded w-8 h-8 flex items-center justify-center shrink-0">
                            <svg class="group-hover:fill-white transition-colors" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.75 13.5C5.025 13.5 3.52187 12.9281 2.24062 11.7844C0.959375 10.6406 0.225 9.2125 0.0375 7.5H1.575C1.75 8.8 2.32812 9.875 3.30938 10.725C4.29063 11.575 5.4375 12 6.75 12C8.2125 12 9.45312 11.4906 10.4719 10.4719C11.4906 9.45312 12 8.2125 12 6.75C12 5.2875 11.4906 4.04688 10.4719 3.02813C9.45312 2.00938 8.2125 1.5 6.75 1.5C5.8875 1.5 5.08125 1.7 4.33125 2.1C3.58125 2.5 2.95 3.05 2.4375 3.75H4.5V5.25H0V0.75H1.5V2.5125C2.1375 1.7125 2.91562 1.09375 3.83437 0.65625C4.75312 0.21875 5.725 0 6.75 0C7.6875 0 8.56562 0.178125 9.38437 0.534375C10.2031 0.890625 10.9156 1.37188 11.5219 1.97812C12.1281 2.58437 12.6094 3.29688 12.9656 4.11562C13.3219 4.93437 13.5 5.8125 13.5 6.75C13.5 7.6875 13.3219 8.56562 12.9656 9.38437C12.6094 10.2031 12.1281 10.9156 11.5219 11.5219C10.9156 12.1281 10.2031 12.6094 9.38437 12.9656C8.56562 13.3219 7.6875 13.5 6.75 13.5ZM8.85 9.9L6 7.05V3H7.5V6.45L9.9 8.85L8.85 9.9Z" fill="#004AC6"/></svg>
                        </div>
                        <div class="flex flex-col flex-1">
                            <span class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium">View Complaint History</span>
                            <span class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">See all past submissions</span>
                        </div>
                    </a>
                @else
                    <a href="{{ route('admin.complaints.index') }}" class="rounded-lg p-3 flex gap-3 items-center hover:bg-gray-50 transition group border border-transparent hover:border-gray-200">
                        <div class="bg-[rgba(0,74,198,0.10)] group-hover:bg-[#004ac6] transition-colors rounded w-8 h-8 flex items-center justify-center shrink-0">
                            <svg class="group-hover:fill-white transition-colors" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.75 13.5C5.025 13.5 3.52187 12.9281 2.24062 11.7844C0.959375 10.6406 0.225 9.2125 0.0375 7.5H1.575C1.75 8.8 2.32812 9.875 3.30938 10.725C4.29063 11.575 5.4375 12 6.75 12C8.2125 12 9.45312 11.4906 10.4719 10.4719C11.4906 9.45312 12 8.2125 12 6.75C12 5.2875 11.4906 4.04688 10.4719 3.02813C9.45312 2.00938 8.2125 1.5 6.75 1.5C5.8875 1.5 5.08125 1.7 4.33125 2.1C3.58125 2.5 2.95 3.05 2.4375 3.75H4.5V5.25H0V0.75H1.5V2.5125C2.1375 1.7125 2.91562 1.09375 3.83437 0.65625C4.75312 0.21875 5.725 0 6.75 0C7.6875 0 8.56562 0.178125 9.38437 0.534375C10.2031 0.890625 10.9156 1.37188 11.5219 1.97812C12.1281 2.58437 12.6094 3.29688 12.9656 4.11562C13.3219 4.93437 13.5 5.8125 13.5 6.75C13.5 7.6875 13.3219 8.56562 12.9656 9.38437C12.6094 10.2031 12.1281 10.9156 11.5219 11.5219C10.9156 12.1281 10.2031 12.6094 9.38437 12.9656C8.56562 13.3219 7.6875 13.5 6.75 13.5ZM8.85 9.9L6 7.05V3H7.5V6.45L9.9 8.85L8.85 9.9Z" fill="#004AC6"/></svg>
                        </div>
                        <div class="flex flex-col flex-1">
                            <span class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium">Manage Complaints</span>
                            <span class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">Review incoming tickets</span>
                        </div>
                    </a>
                @endif

                <a href="{{ route('faq') }}" class="rounded-lg p-3 flex gap-3 items-center hover:bg-gray-50 transition group border border-transparent hover:border-gray-200">
                    <div class="bg-[rgba(0,74,198,0.10)] group-hover:bg-[#004ac6] transition-colors rounded w-8 h-8 flex items-center justify-center shrink-0">
                        <svg class="group-hover:fill-white transition-colors" width="13" height="15" viewBox="0 0 13 15" fill="none"><path d="M6.75 15L6.5625 12.75H6.375C4.6 12.75 3.09375 12.1313 1.85625 10.8938C0.61875 9.65625 0 8.15 0 6.375C0 4.6 0.61875 3.09375 1.85625 1.85625C3.09375 0.61875 4.6 0 6.375 0C7.2625 0 8.09062 0.165625 8.85938 0.496875C9.62813 0.828125 10.3031 1.28437 10.8844 1.86563C11.4656 2.44688 11.9219 3.12188 12.2531 3.89062C12.5844 4.65938 12.75 5.4875 12.75 6.375C12.75 7.3125 12.5969 8.2125 12.2906 9.075C11.9844 9.9375 11.5656 10.7375 11.0344 11.475C10.5031 12.2125 9.87187 12.8812 9.14062 13.4812C8.40938 14.0813 7.6125 14.5875 6.75 15ZM8.25 12.2625C9.1375 11.5125 9.85938 10.6344 10.4156 9.62813C10.9719 8.62187 11.25 7.5375 11.25 6.375C11.25 5.0125 10.7781 3.85938 9.83438 2.91563C8.89062 1.97188 7.7375 1.5 6.375 1.5C5.0125 1.5 3.85938 1.97188 2.91563 2.91563C1.97188 3.85938 1.5 5.0125 1.5 6.375C1.5 7.7375 1.97188 8.89062 2.91563 9.83438C3.85938 10.7781 5.0125 11.25 6.375 11.25H8.25V12.2625ZM6.35625 10.4812C6.56875 10.4812 6.75 10.4062 6.9 10.2563C7.05 10.1063 7.125 9.925 7.125 9.7125C7.125 9.5 7.05 9.31875 6.9 9.16875C6.75 9.01875 6.56875 8.94375 6.35625 8.94375C6.14375 8.94375 5.9625 9.01875 5.8125 9.16875C5.6625 9.31875 5.5875 9.5 5.5875 9.7125C5.5875 9.925 5.6625 10.1063 5.8125 10.2563C5.9625 10.4062 6.14375 10.4812 6.35625 10.4812ZM5.8125 8.1H6.9375C6.9375 7.725 6.975 7.4625 7.05 7.3125C7.125 7.1625 7.3625 6.8875 7.7625 6.4875C7.9875 6.2625 8.175 6.01875 8.325 5.75625C8.475 5.49375 8.55 5.2125 8.55 4.9125C8.55 4.275 8.33437 3.79688 7.90312 3.47813C7.47187 3.15938 6.9625 3 6.375 3C5.825 3 5.3625 3.15312 4.9875 3.45937C4.6125 3.76562 4.35 4.1375 4.2 4.575L5.25 4.9875C5.3125 4.775 5.43125 4.56563 5.60625 4.35938C5.78125 4.15312 6.0375 4.05 6.375 4.05C6.7125 4.05 6.96563 4.14375 7.13438 4.33125C7.30312 4.51875 7.3875 4.725 7.3875 4.95C7.3875 5.1625 7.325 5.35313 7.2 5.52187C7.075 5.69062 6.925 5.8625 6.75 6.0375C6.3125 6.4125 6.04688 6.70937 5.95312 6.92812C5.85938 7.14687 5.8125 7.5375 5.8125 8.1Z" fill="#004AC6"/></svg>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[#191b23] font-['Manrope-Medium',_sans-serif] text-sm font-medium">Bantuan & FAQ</span>
                        <span class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">Pelajari cara penggunaan sistem</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                <div class="border-b border-[rgba(195,198,215,0.30)] bg-[rgba(243,243,254,0.50)] rounded-t-xl p-4 px-6 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V7C0 6.45 0.195833 5.97917 0.5875 5.5875C0.979167 5.19583 1.45 5 2 5H7V2C7 1.45 7.19583 0.979167 7.5875 0.5875C7.97917 0.195833 8.45 0 9 0H11C11.55 0 12.0208 0.195833 12.4125 0.5875C12.8042 0.979167 13 1.45 13 2V5H18C18.55 5 19.0208 5.19583 19.4125 5.5875C19.8042 5.97917 20 6.45 20 7V18C20 18.55 19.8042 19.0208 19.4125 19.4125C19.0208 19.8042 18.55 20 18 20H2ZM2 18H18V7H13C13 7.55 12.8042 8.02083 12.4125 8.4125C12.0208 8.80417 11.55 9 11 9H9C8.45 9 7.97917 8.80417 7.5875 8.4125C7.19583 8.02083 7 7.55 7 7H2V18ZM4 16H10V15.55C10 15.2667 9.92083 15.0042 9.7625 14.7625C9.60417 14.5208 9.38333 14.3333 9.1 14.2C8.76667 14.05 8.42917 13.9375 8.0875 13.8625C7.74583 13.7875 7.38333 13.75 7 13.75C6.61667 13.75 6.25417 13.7875 5.9125 13.8625C5.57083 13.9375 5.23333 14.05 4.9 14.2C4.61667 14.3333 4.39583 14.5208 4.2375 14.7625C4.07917 15.0042 4 15.2667 4 15.55V16ZM12 14.5H16V13H12V14.5ZM7 13C7.41667 13 7.77083 12.8542 8.0625 12.5625C8.35417 12.2708 8.5 11.9167 8.5 11.5C8.5 11.0833 8.35417 10.7292 8.0625 10.4375C7.77083 10.1458 7.41667 10 7 10C6.58333 10 6.22917 10.1458 5.9375 10.4375C5.64583 10.7292 5.5 11.0833 5.5 11.5C5.5 11.9167 5.64583 12.2708 5.9375 12.5625C6.22917 12.8542 6.58333 13 7 13ZM12 11.5H16V10H12V11.5ZM9 7H11V2H9V7Z" fill="#004AC6"/></svg>
                        <h2 class="text-[#191b23] text-lg font-semibold">Personal Information</h2>
                    </div>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Full Name</label>
                        <div class="bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 pl-10 relative">
                            <svg class="absolute left-3.5 top-3.5 text-[#737686]" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.66667 6.66667C5.75 6.66667 4.96528 6.34028 4.3125 5.6875C3.65972 5.03472 3.33333 4.25 3.33333 3.33333C3.33333 2.41667 3.65972 1.63194 4.3125 0.979167C4.96528 0.326389 5.75 0 6.66667 0C7.58333 0 8.36806 0.326389 9.02083 0.979167C9.67361 1.63194 10 2.41667 10 3.33333C10 4.25 9.67361 5.03472 9.02083 5.6875C8.36806 6.34028 7.58333 6.66667 6.66667 6.66667ZM0 13.3333V11C0 10.5278 0.121528 10.0938 0.364583 9.69792C0.607639 9.30208 0.930556 9 1.33333 8.79167C2.19444 8.36111 3.06944 8.03819 3.95833 7.82292C4.84722 7.60764 5.75 7.5 6.66667 7.5C7.58333 7.5 8.48611 7.60764 9.375 7.82292C10.2639 8.03819 11.1389 8.36111 12 8.79167C12.4028 9 12.7257 9.30208 12.9688 9.69792C13.2118 10.0938 13.3333 10.5278 13.3333 11V13.3333H0Z" fill="currentColor"/></svg>
                            <div class="text-[#191b23] text-base">{{ Auth::user()->name }}</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
                            {{ Auth::user()->role === 'mahasiswa' ? 'Student ID (NIM)' : 'Institution ID (NIP)' }}
                        </label>
                        <div class="bg-[#e7e7f3] opacity-80 rounded-lg border border-[rgba(195,198,215,0.50)] p-3 pl-10 relative">
                            <svg class="absolute left-3 top-3.5 text-[#737686]" width="17" height="14" viewBox="0 0 17 14" fill="none"><path d="M10 7.5H14.1667V5.83333H10V7.5ZM10 5H14.1667V3.33333H10V5ZM2.5 10H9.16667V9.54167C9.16667 8.91667 8.86111 8.42014 8.25 8.05208C7.63889 7.68403 6.83333 7.5 5.83333 7.5C4.83333 7.5 4.02778 7.68403 3.41667 8.05208C2.80556 8.42014 2.5 8.91667 2.5 9.54167V10ZM1.66667 13.3333C1.20833 13.3333 0.815972 13.1701 0.489583 12.8438C0.163194 12.5174 0 12.125 0 11.6667V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H15C15.4583 0 15.8507 0.163194 16.1771 0.489583C16.5035 0.815972 16.6667 1.20833 16.6667 1.66667V11.6667C16.6667 12.125 16.5035 12.5174 16.1771 12.8438C15.8507 13.1701 15.4583 13.3333 15 13.3333H1.66667Z" fill="currentColor"/></svg>
                            <div class="text-[#434655] text-base">{{ Auth::user()->nim ?? Auth::user()->nip ?? 'Not Registered' }}</div>
                        </div>
                        <p class="text-[#737686] text-[12px] mt-1 italic">{{ Auth::user()->role === 'mahasiswa' ? 'NIM' : 'NIP' }} cannot be changed directly.</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Account Role</label>
                        <div class="bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 pl-10 relative">
                            <svg class="absolute left-3 top-3.5 text-[#737686]" width="19" height="15" viewBox="0 0 19 15" fill="none"><path d="M9.16667 15L3.33333 11.8333V6.83333L0 5L9.16667 0L18.3333 5V11.6667H16.6667V5.91667L15 6.83333V11.8333L9.16667 15ZM9.16667 8.08333L14.875 5L9.16667 1.91667L3.45833 5L9.16667 8.08333ZM9.16667 13.1042L13.3333 10.8542V7.70833L9.16667 10L5 7.70833V10.8542L9.16667 13.1042Z" fill="currentColor"/></svg>
                            <div class="text-[#191b23] text-base capitalize">{{ Auth::user()->role }}</div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Registered Email</label>
                        <div class="bg-[#faf8ff] rounded-lg border border-[#c3c6d7] p-3 pl-10 relative">
                            <svg class="absolute left-3 top-3.5 text-[#737686]" width="17" height="14" viewBox="0 0 17 14" fill="none"><path d="M1.66667 13.3333C1.20833 13.3333 0.815972 13.1701 0.489583 12.8438C0.163194 12.5174 0 12.125 0 11.6667V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H15C15.4583 0 15.8507 0.163194 16.1771 0.489583C16.5035 0.815972 16.6667 1.20833 16.6667 1.66667V11.6667C16.6667 12.125 16.5035 12.5174 16.1771 12.8438C15.8507 13.1701 15.4583 13.3333 15 13.3333H1.66667ZM8.33333 7.5L1.66667 3.33333V11.6667H15V3.33333L8.33333 7.5ZM8.33333 5.83333L15 1.66667H1.66667L8.33333 5.83333ZM1.66667 3.33333V1.66667V3.33333V11.6667V3.33333Z" fill="currentColor"/></svg>
                            <div class="text-[#191b23] text-base">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] flex flex-col h-auto shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                <div class="bg-[#faf8ff] rounded-t-xl border-b border-[rgba(195,198,215,0.30)] p-4 px-6 flex items-center gap-2">
                    <svg width="16" height="21" viewBox="0 0 16 21" fill="none"><path d="M2 21C1.45 21 0.979167 20.8042 0.5875 20.4125C0.195833 20.0208 0 19.55 0 19V9C0 8.45 0.195833 7.97917 0.5875 7.5875C0.979167 7.19583 1.45 7 2 7H3V5C3 3.61667 3.4875 2.4375 4.4625 1.4625C5.4375 0.4875 6.61667 0 8 0C9.38333 0 10.5625 0.4875 11.5375 1.4625C12.5125 2.4375 13 3.61667 13 5V7H14C14.55 7 15.0208 7.19583 15.4125 7.5875C15.8042 7.97917 16 8.45 16 9V19C16 19.55 15.8042 20.0208 15.4125 20.4125C15.0208 20.8042 14.55 21 14 21H2ZM8 16C8.55 16 9.02083 15.8042 9.4125 15.4125C9.80417 15.0208 10 14.55 10 14C10 13.45 9.80417 12.9792 9.4125 12.5875C9.02083 12.1958 8.55 12 8 12C7.45 12 6.97917 12.1958 6.5875 12.5875C6.19583 12.9792 6 13.45 6 14C6 14.55 6.19583 15.0208 6.5875 15.4125C6.97917 15.8042 7.45 16 8 16ZM5 7H11V5C11 4.16667 10.7083 3.45833 10.125 2.875C9.54167 2.29167 8.83333 2 8 2C7.16667 2 6.45833 2.29167 5.875 2.875C5.29167 3.45833 5 4.16667 5 5V7Z" fill="#004AC6"/></svg>
                    <div class="flex flex-col">
                        <h2 class="text-[#191b23] text-lg font-semibold">Account Security</h2>
                        <p class="text-[#434655] text-sm">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="p-6 flex flex-col gap-5">
                    @csrf
                    @method('put')

                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Current Password</label>
                        <div class="bg-white rounded-lg border border-[#c3c6d7] p-3 pl-10 relative focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6]/20 transition">
                            <svg class="absolute left-3 top-3.5 text-[#737686]" width="20" height="10" viewBox="0 0 20 10" fill="none"><path d="M5 10C3.61111 10 2.43056 9.51389 1.45833 8.54167C0.486111 7.56944 0 6.38889 0 5C0 3.61111 0.486111 2.43056 1.45833 1.45833C2.43056 0.486111 3.61111 0 5 0C5.93056 0 6.77431 0.229167 7.53125 0.6875C8.28819 1.14583 8.88889 1.75 9.33333 2.5H16.6667L19.1667 5L15.4167 8.75L13.75 7.5L12.0833 8.75L10.3125 7.5H9.33333C8.88889 8.25 8.28819 8.85417 7.53125 9.3125C6.77431 9.77083 5.93056 10 5 10ZM5 8.33333C5.77778 8.33333 6.46181 8.09722 7.05208 7.625C7.64236 7.15278 8.03472 6.55556 8.22917 5.83333H10.8333L12.0417 6.6875L13.75 5.41667L15.2292 6.5625L16.7917 5L15.9583 4.16667H8.22917C8.03472 3.44444 7.64236 2.84722 7.05208 2.375C6.46181 1.90278 5.77778 1.66667 5 1.66667C4.08333 1.66667 3.29861 1.99306 2.64583 2.64583C1.99306 3.29861 1.66667 4.08333 1.66667 5C1.66667 5.91667 1.99306 6.70139 2.64583 7.35417C3.29861 8.00694 4.08333 8.33333 5 8.33333Z" fill="currentColor"/></svg>
                            <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-transparent border-none outline-none text-[#191b23] text-base" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">New Password</label>
                        <div class="bg-white rounded-lg border border-[#c3c6d7] p-3 pl-10 relative focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6]/20 transition">
                            <svg class="absolute left-3.5 top-3 text-[#737686]" width="17" height="17" viewBox="0 0 17 17" fill="none"><path d="M8.33333 16.6667C7.18056 16.6667 6.09722 16.4479 5.08333 16.0104C4.06944 15.5729 3.1875 14.9792 2.4375 14.2292C1.6875 13.4792 1.09375 12.5972 0.65625 11.5833C0.21875 10.5694 0 9.48611 0 8.33333H1.66667C1.66667 9.25 1.84028 10.1146 2.1875 10.9271C2.53472 11.7396 3.01042 12.4479 3.61458 13.0521C4.21875 13.6562 4.92708 14.1354 5.73958 14.4896C6.55208 14.8438 7.41667 15.0208 8.33333 15.0208C10.1944 15.0208 11.7708 14.375 13.0625 13.0833C14.3542 11.7917 15 10.2153 15 8.35417C15 6.49306 14.3542 4.91667 13.0625 3.625C11.7708 2.33333 10.1944 1.6875 8.33333 1.6875C7.09722 1.6875 5.97569 1.98958 4.96875 2.59375C3.96181 3.19792 3.16667 4 2.58333 5H5V6.66667H0V1.66667H1.66667V3.33333C2.43056 2.31944 3.38889 1.51042 4.54167 0.90625C5.69444 0.302083 6.95833 0 8.33333 0C9.48611 0 10.5694 0.21875 11.5833 0.65625C12.5972 1.09375 13.4792 1.6875 14.2292 2.4375C14.9792 3.1875 15.5729 4.06944 16.0104 5.08333C16.4479 6.09722 16.6667 7.18056 16.6667 8.33333C16.6667 9.48611 16.4479 10.5694 16.0104 11.5833C15.5729 12.5972 14.9792 13.4792 14.2292 14.2292C13.4792 14.9792 12.5972 15.5729 11.5833 16.0104C10.5694 16.4479 9.48611 16.6667 8.33333 16.6667ZM6.66667 11.6667C6.43056 11.6667 6.23264 11.5868 6.07292 11.4271C5.91319 11.2674 5.83333 11.0694 5.83333 10.8333V8.33333C5.83333 8.09722 5.91319 7.89931 6.07292 7.73958C6.23264 7.57986 6.43056 7.5 6.66667 7.5V6.66667C6.66667 6.20833 6.82986 5.81597 7.15625 5.48958C7.48264 5.16319 7.875 5 8.33333 5C8.79167 5 9.18403 5.16319 9.51042 5.48958C9.83681 5.81597 10 6.20833 10 6.66667V7.5C10.2361 7.5 10.434 7.57986 10.5938 7.73958C10.7535 7.89931 10.8333 8.09722 10.8333 8.33333V10.8333C10.8333 11.0694 10.7535 11.2674 10.5938 11.4271C10.434 11.5868 10.2361 11.6667 10 11.6667H6.66667ZM7.5 7.5H9.16667V6.66667C9.16667 6.43056 9.08681 6.23264 8.92708 6.07292C8.76736 5.91319 8.56944 5.83333 8.33333 5.83333C8.09722 5.83333 7.89931 5.91319 7.73958 6.07292C7.57986 6.23264 7.5 6.43056 7.5 6.66667V7.5Z" fill="currentColor"/></svg>
                            <input type="password" name="password" placeholder="Enter new password" class="w-full bg-transparent border-none outline-none text-[#191b23] text-base" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="text-sm text-red-600" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Confirm New Password</label>
                        <div class="bg-white rounded-lg border border-[#c3c6d7] p-3 pl-10 relative focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6]/20 transition">
                            <svg class="absolute left-3.5 top-3.5 text-[#737686]" width="19" height="10" viewBox="0 0 19 10" fill="none"><path d="M0.833333 10V8.33333H17.5V10H0.833333ZM1.79167 4.95833L0.708333 4.33333L1.41667 3.08333H0V1.83333H1.41667L0.708333 0.625L1.79167 0L2.5 1.20833L3.20833 0L4.29167 0.625L3.58333 1.83333H5V3.08333H3.58333L4.29167 4.33333L3.20833 4.95833L2.5 3.70833L1.79167 4.95833ZM8.45833 4.95833L7.375 4.33333L8.08333 3.08333H6.66667V1.83333H8.08333L7.375 0.625L8.45833 0L9.16667 1.20833L9.875 0L10.9583 0.625L10.25 1.83333H11.6667V3.08333H10.25L10.9583 4.33333L9.875 4.95833L9.16667 3.70833L8.45833 4.95833ZM15.125 4.95833L14.0417 4.33333L14.75 3.08333H13.3333V1.83333H14.75L14.0417 0.625L15.125 0L15.8333 1.20833L16.5417 0L17.625 0.625L16.9167 1.83333H18.3333V3.08333H16.9167L17.625 4.33333L16.5417 4.95833L15.8333 3.70833L15.125 4.95833Z" fill="currentColor"/></svg>
                            <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full bg-transparent border-none outline-none text-[#191b23] text-base" required>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-sm text-red-600" />
                    </div>

                    <div class="flex justify-end gap-3 w-full mt-2 pt-4 border-t border-[rgba(195,198,215,0.30)]">
                        <button type="reset" class="bg-white rounded-lg border border-[#c3c6d7] py-2.5 px-6 hover:bg-gray-50 transition">
                            <span class="text-[#191b23] text-[13px] font-semibold tracking-[0.65px]">Cancel</span>
                        </button>
                        <button type="submit" class="bg-[#004ac6] rounded-lg py-2.5 px-6 flex items-center gap-2 hover:bg-blue-800 transition-all hover:shadow-md transform hover:-translate-y-0.5">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13.5 3V12C13.5 12.4125 13.3531 12.7656 13.0594 13.0594C12.7656 13.3531 12.4125 13.5 12 13.5H1.5C1.0875 13.5 0.734375 13.3531 0.440625 13.0594C0.146875 12.7656 0 12.4125 0 12V1.5C0 1.0875 0.146875 0.734375 0.440625 0.440625C0.734375 0.146875 1.0875 0 1.5 0H10.5L13.5 3ZM12 3.6375L9.8625 1.5H1.5V12H12V3.6375ZM6.75 11.25C7.375 11.25 7.90625 11.0312 8.34375 10.5938C8.78125 10.1562 9 9.625 9 9C9 8.375 8.78125 7.84375 8.34375 7.40625C7.90625 6.96875 7.375 6.75 6.75 6.75C6.125 6.75 5.59375 6.96875 5.15625 7.40625C4.71875 7.84375 4.5 8.375 4.5 9C4.5 9.625 4.71875 10.1562 5.15625 10.5938C5.59375 11.0312 6.125 11.25 6.75 11.25ZM2.25 5.25H9V2.25H2.25V5.25ZM1.5 3.6375V12V1.5V3.6375Z" fill="white"/></svg>
                            <span class="text-white text-[13px] font-semibold tracking-[0.65px]">Save Changes</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection