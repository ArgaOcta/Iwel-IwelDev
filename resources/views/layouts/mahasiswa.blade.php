<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCMS Academic Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <style>
        /* Animasi Premium */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-right { animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        /* Smooth Scroll & Transitions */
        html { scroll-behavior: smooth; }
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d0e1fb; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #004ac6; }
    </style>
</head>
<body class="font-['Manrope',_sans-serif] antialiased bg-[#faf8ff] overflow-x-hidden text-[#191b23]">

@php
    $hasUnreadUpdates = \App\Models\AuditLog::whereHas('complaint', function($q) {
        $q->where('user_id', Auth::id());
    })->where('user_id', '!=', Auth::id())->where('created_at', '>=', \Carbon\Carbon::now()->subDays(3))->count();
@endphp

<div x-data="{ mobileMenuOpen: false, showLogoutModal: false }" class="flex flex-row items-start min-h-screen w-full relative">
  
  <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 md:hidden" x-transition.opacity style="display: none;"></div>

  {{-- Sidebar Navigasi --}}
  <div :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" class="bg-white border-r border-[#c3c6d7] flex flex-col justify-between shrink-0 w-[260px] h-screen fixed left-0 top-0 z-50 shadow-[0_1px_2px_rgba(0,0,0,0.05)] transition-transform duration-300 md:translate-x-0">
    <div>
      <div class="p-6 flex flex-row items-center justify-between relative border-b border-[#e1e2ed]">
        <div class="flex items-center gap-3 hover:scale-105 transition-transform cursor-default">
            <div class="w-10 h-10 bg-white border border-[#e1e2ed] rounded-xl flex items-center justify-center shadow-sm shrink-0">
                <img src="{{ asset('assets/icons/logo.svg') }}" alt="SCMS Logo" width="22" height="18" class="block">
            </div>
            <div class="flex flex-col justify-center">
                <div class="text-[#004ac6] font-['Manrope-Bold',_sans-serif] text-[22px] font-bold tracking-[0.5px] leading-tight">SCMS</div>
                <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[10px] font-bold tracking-wider uppercase">Academic Portal</div>
            </div>
        </div>
        <button @click="mobileMenuOpen = false" class="md:hidden p-2 -mr-2 text-gray-400 hover:text-[#ba1a1a] hover:bg-red-50 rounded-lg transition-colors">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
      <div class="px-3 pt-4 flex flex-col gap-1 relative overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-all-300 group hover:pl-5">
          <svg class="group-hover:scale-110 transition-transform" width="15" height="15" viewBox="0 0 15 15" fill="currentColor"><path d="M8.33333 5V0H15V5H8.33333ZM0 8.33333V0H6.66667V8.33333H0ZM8.33333 15V6.66667H15V15H8.33333ZM0 15V10H6.66667V15H0ZM1.66667 6.66667H5V1.66667H1.66667V6.66667ZM10 13.3333H13.3333V8.33333H10V13.3333ZM10 3.33333H13.3333V1.66667H10V3.33333ZM1.66667 13.3333H5V11.6667H1.66667V13.3333Z"/></svg>
          <span class="font-semibold text-[13px] tracking-[0.65px]">Dashboard</span>
        </a>
        <a href="{{ route('complaint.history') }}" class="{{ request()->routeIs('complaint.history', 'complaint.show') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-all-300 mt-1 group hover:pl-5">
          <svg class="group-hover:scale-110 transition-transform" width="15" height="17" viewBox="0 0 15 17" fill="currentColor"><path d="M1.66667 16.6667C1.20833 16.6667 0.815972 16.5035 0.489583 16.1771C0.163194 15.8507 0 15.4583 0 15V3.33333C0 2.875 0.163194 2.48264 0.489583 2.15625C0.815972 1.82986 1.20833 1.66667 1.66667 1.66667H5.16667C5.34722 1.16667 5.64931 0.763889 6.07292 0.458333C6.49653 0.152778 6.97222 0 7.5 0C8.02778 0 8.50347 0.152778 8.92708 0.458333C9.35069 0.763889 9.65278 1.16667 9.83333 1.66667H13.3333C13.7917 1.66667 14.184 1.82986 14.5104 2.15625C14.8368 2.48264 15 2.875 15 3.33333V15C15 15.4583 14.8368 15.8507 14.5104 16.1771C14.184 16.5035 13.7917 16.6667 13.3333 16.6667H1.66667ZM1.66667 15H13.3333V3.33333H1.66667V15ZM3.33333 13.3333H9.16667V11.6667H3.33333V13.3333ZM3.33333 10H11.6667V8.33333H3.33333V10ZM3.33333 6.66667H11.6667V5H3.33333V6.66667ZM7.5 2.70833C7.68056 2.70833 7.82986 2.64931 7.94792 2.53125C8.06597 2.41319 8.125 2.26389 8.125 2.08333C8.125 1.90278 8.06597 1.75347 7.94792 1.63542C7.82986 1.51736 7.68056 1.45833 7.5 1.45833C7.31944 1.45833 7.17014 1.51736 7.05208 1.63542C6.93403 1.75347 6.875 1.90278 6.875 2.08333C6.875 2.26389 6.93403 2.41319 7.05208 2.53125C7.17014 2.64931 7.31944 2.70833 7.5 2.70833ZM1.66667 15V3.33333V15Z" fill="currentColor"/></svg>
          <span class="font-semibold text-[13px] tracking-[0.65px]">My Complaints</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-all-300 mt-1 group hover:pl-5">
          <svg class="group-hover:rotate-90 transition-transform duration-500" width="17" height="17" viewBox="0 0 17 17" fill="currentColor"><path d="M6.08333 16.6667L5.75 14C5.56944 13.9306 5.39931 13.8472 5.23958 13.75C5.07986 13.6528 4.92361 13.5486 4.77083 13.4375L2.29167 14.4792L0 10.5208L2.14583 8.89583C2.13194 8.79861 2.125 8.70486 2.125 8.61458C2.125 8.52431 2.125 8.43056 2.125 8.33333C2.125 8.23611 2.125 8.14236 2.125 8.05208C2.125 7.96181 2.13194 7.86806 2.14583 7.77083L0 6.14583L2.29167 2.1875L4.77083 3.22917C4.92361 3.11806 5.08333 3.01389 5.25 2.91667C5.41667 2.81944 5.58333 2.73611 5.75 2.66667L6.08333 0H10.6667L11 2.66667C11.1806 2.73611 11.3507 2.81944 11.5104 2.91667C11.6701 3.01389 11.8264 3.11806 11.9792 3.22917L14.4583 2.1875L16.75 6.14583L14.6042 7.77083C14.6181 7.86806 14.625 7.96181 14.625 8.05208C14.625 8.14236 14.625 8.23611 14.625 8.33333C14.625 8.43056 14.625 8.52431 14.625 8.61458C14.625 8.70486 14.6111 8.79861 14.5833 8.89583L16.7292 10.5208L14.4375 14.4792L11.9792 13.4375C11.8264 13.5486 11.6667 13.6528 11.5 13.75C11.3333 13.8472 11.1667 13.9306 11 14L10.6667 16.6667H6.08333ZM7.54167 15H9.1875L9.47917 12.7917C9.90972 12.6806 10.309 12.5174 10.6771 12.3021C11.0451 12.0868 11.3819 11.8264 11.6875 11.5208L13.75 12.375L14.5625 10.9583L12.7708 9.60417C12.8403 9.40972 12.8889 9.20486 12.9167 8.98958C12.9444 8.77431 12.9583 8.55556 12.9583 8.33333C12.9583 8.11111 12.9444 7.89236 12.9167 7.67708C12.8889 7.46181 12.8403 7.25694 12.7708 7.0625L14.5625 5.70833L13.75 4.29167L11.6875 5.16667C11.3819 4.84722 11.0451 4.57986 10.6771 4.36458C10.309 4.14931 9.90972 3.98611 9.47917 3.875L9.20833 1.66667H7.5625L7.27083 3.875C6.84028 3.98611 6.44097 4.14931 6.07292 4.36458C5.70486 4.57986 5.36806 4.84028 5.0625 5.14583L3 4.29167L2.1875 5.70833L3.97917 7.04167C3.90972 7.25 3.86111 7.45833 3.83333 7.66667C3.80556 7.875 3.79167 8.09722 3.79167 8.33333C3.79167 8.55556 3.80556 8.77083 3.83333 8.97917C3.86111 9.1875 3.90972 9.39583 3.97917 9.60417L2.1875 10.9583L3 12.375L5.0625 11.5C5.36806 11.8194 5.70486 12.0868 6.07292 12.3021C6.44097 12.5174 6.84028 12.6806 7.27083 12.7917L7.54167 15ZM8.41667 11.25C9.22222 11.25 9.90972 10.9653 10.4792 10.3958C11.0486 9.82639 11.3333 9.13889 11.3333 8.33333C11.3333 7.52778 11.0486 6.84028 10.4792 6.27083C9.90972 5.70139 9.22222 5.41667 8.41667 5.41667C7.59722 5.41667 6.90625 5.70139 6.34375 6.27083C5.78125 6.84028 5.5 7.52778 5.5 8.33333C5.5 9.13889 5.78125 9.82639 6.34375 10.3958C6.90625 10.9653 7.59722 11.25 8.41667 11.25Z" fill="currentColor"/></svg>
          <span class="font-semibold text-[13px] tracking-[0.65px]">Profile</span>
        </a>
      </div>
    </div>
    <div class="w-full">
      <div class="border-t border-[#e1e2ed] p-4">
        <button @click="showLogoutModal = true" type="button" class="w-full rounded-lg p-2.5 px-3 flex flex-row gap-3 items-center hover:bg-red-50 text-[#ba1a1a] transition-all-300 group hover:shadow-inner">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" class="group-hover:translate-x-1 transition-transform"><path d="M1.66667 15C1.20833 15 0.815972 14.8368 0.489583 14.5104C0.163194 14.184 0 13.7917 0 13.3333V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H7.5V1.66667H1.66667V13.3333H7.5V15H1.66667ZM10.8333 11.6667L9.6875 10.4583L11.8125 8.33333H5V6.66667H11.8125L9.6875 4.54167L10.8333 3.33333L15 7.5L10.8333 11.6667Z" fill="currentColor"/></svg>
            <span class="font-medium text-sm">Logout</span>
        </button>
      </div>
    </div>
  </div>

  <div class="flex flex-col flex-1 relative w-full min-h-screen md:ml-[260px] transition-all duration-300">
    
    <div class="bg-white/90 backdrop-blur-md px-4 sm:px-8 py-4 flex flex-row items-center justify-between z-30 sticky top-0 border-b border-[rgba(195,198,215,0.40)]">
      <div class="flex items-center gap-2 sm:gap-3 animate-fade-up w-full">
        <button @click="mobileMenuOpen = true" class="md:hidden p-2 -ml-2 text-[#191b23] hover:bg-gray-100 rounded-lg transition-colors">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <div class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-base sm:text-lg font-semibold truncate max-w-[140px] sm:max-w-md">
          Welcome, {{ Auth::user()->name }}
        </div>
      </div>
      
      <div class="flex flex-row gap-3 sm:gap-4 items-center animate-slide-right shrink-0">
        <a href="{{ route('complaint.create') }}" class="hidden md:flex bg-[#004ac6] text-white rounded-lg py-2 px-4 items-center gap-2 hover:bg-blue-800 transition-all shadow-sm hover:shadow-md active:scale-95">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M7 1v12M1 7h12"/></svg>
            <span class="font-semibold text-[13px] tracking-wide">New Ticket</span>
        </a>

        <a href="{{ route('notifications.index') }}" class="rounded-full p-2.5 bg-gray-50 border border-[#c3c6d7] hover:bg-gray-100 transition-all-300 cursor-pointer relative shadow-sm group active:scale-90">
          <svg class="group-hover:rotate-12 transition-transform text-[#434655]" width="16" height="18" viewBox="0 0 16 20" fill="currentColor"><path d="M0 17V15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V2.2C10.8333 2.53333 11.9167 3.2375 12.75 4.3125C13.5833 5.3875 14 6.61667 14 8V15H16V17H0ZM8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20Z"/></svg>
          @if($hasUnreadUpdates > 0)
              <div class="bg-[#ba1a1a] rounded-full w-2.5 h-2.5 absolute right-1.5 top-1.5 border-2 border-white shadow-sm animate-ping"></div>
              <div class="bg-[#ba1a1a] rounded-full w-2.5 h-2.5 absolute right-1.5 top-1.5 border-2 border-white shadow-sm"></div>
          @endif
        </a>

        <a href="{{ route('profile.edit') }}" class="flex w-10 h-10 border-2 border-transparent hover:border-[#004ac6] transition-all duration-300 rounded-full overflow-hidden shadow-sm hover:scale-105 active:scale-95">
            <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=fff&background=004ac6" alt="Avatar"/>
        </a>
      </div>
    </div>
    
    <main class="page-transition w-full flex-1 relative z-10 bg-transparent overflow-x-hidden">
        @yield('content')
    </main>
  </div>

  <div x-show="showLogoutModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
    <div @click.away="showLogoutModal = false" 
         class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden flex flex-col transform transition-all" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" 
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
         x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95">
        
        <div class="p-8 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 bg-[rgba(186,26,26,0.1)] rounded-full flex items-center justify-center text-[#ba1a1a] mb-2 animate-bounce" style="animation-duration: 2s;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </div>
            <h3 class="text-xl font-bold text-[#191b23]">Konfirmasi Keluar</h3>
            <p class="text-[#434655] text-sm leading-relaxed">Apakah Anda yakin ingin keluar dari sesi ini? Anda harus login kembali untuk masuk.</p>
        </div>
        <div class="bg-[#faf8ff] px-8 py-5 flex gap-3 justify-center w-full border-t border-[rgba(195,198,215,0.3)]">
            <button @click="showLogoutModal = false" type="button" class="px-5 py-2.5 bg-white border border-[#c3c6d7] rounded-lg text-sm font-semibold text-[#434655] hover:bg-gray-50 hover:shadow-sm transition-all w-1/2 active:scale-95">Batal</button>
            <form method="POST" action="{{ route('logout') }}" class="w-1/2">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-[#ba1a1a] text-white rounded-lg text-sm font-semibold hover:bg-[#93000a] transition-all shadow-sm hover:shadow-md w-full active:scale-95">Ya, Keluar</button>
            </form>
        </div>
    </div>
  </div>

</div>
</body>
</html>