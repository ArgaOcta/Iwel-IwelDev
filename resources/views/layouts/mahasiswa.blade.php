<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCMS Academic Portal')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @keyframes subtleSlideUp {
            from { opacity: 0; transform: translateY(15px); filter: blur(2px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        .page-transition {
            animation: subtleSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d0e1fb; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #004ac6; }
    </style>
</head>
<body class="font-['Manrope',_sans-serif] antialiased bg-[#faf8ff] overflow-x-hidden text-[#191b23]">

<div class="pl-[260px] flex flex-row items-start justify-center relative min-h-screen w-full">
  
  <div class="bg-white border-r border-[#c3c6d7] flex flex-col justify-between shrink-0 w-[260px] h-screen fixed left-0 top-0 z-50 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
    <div>
        <div class="p-6 flex flex-col gap-1 items-start justify-start relative">
          <div class="text-[#004ac6] font-['Manrope-Bold',_sans-serif] text-2xl leading-8 font-bold">SCMS</div>
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] leading-[18px] font-semibold tracking-[0.65px]">Academic Portal</div>
        </div>
        
        <div class="px-2 pt-4 flex flex-col gap-1 items-start justify-start relative">
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#d0e1fb] text-[#434655]' : 'hover:bg-gray-100 text-[#434655]' }} rounded-[10px] p-3 flex flex-row gap-3 items-center self-stretch transition-colors">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M10 6V0H18V6H10ZM0 10V0H8V10H0ZM10 18V8H18V18H10ZM0 18V12H8V18H0ZM2 8H6V2H2V8ZM12 16H16V10H12V16ZM12 4H16V2H12V4ZM2 16H6V14H2V16Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Dashboard</span>
          </a>
          
          <a href="{{ route('complaint.history') }}" class="{{ request()->routeIs('complaint.history', 'complaint.show') ? 'bg-[#d0e1fb] text-[#434655]' : 'hover:bg-gray-100 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center self-stretch transition-colors mt-1">
            <svg width="18" height="20" viewBox="0 0 18 20" fill="none"><path d="M9 16C9.28333 16 9.52083 15.9042 9.7125 15.7125C9.90417 15.5208 10 15.2833 10 15C10 14.7167 9.90417 14.4792 9.7125 14.2875C9.52083 14.0958 9.28333 14 9 14C8.71667 14 8.47917 14.0958 8.2875 14.2875C8.09583 14.4792 8 14.7167 8 15C8 15.2833 8.09583 15.5208 8.2875 15.7125C8.47917 15.9042 8.71667 16 9 16ZM8 12H10V6H8V12ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4C0 3.45 0.195833 2.97917 0.5875 2.5875C0.979167 2.19583 1.45 2 2 2H6.2C6.41667 1.4 6.77917 0.916667 7.2875 0.55C7.79583 0.183333 8.36667 0 9 0C9.63333 0 10.2042 0.183333 10.7125 0.55C11.2208 0.916667 11.5833 1.4 11.8 2H16C16.55 2 17.0208 2.19583 17.4125 2.5875C17.8042 2.97917 18 3.45 18 4V18C18 18.55 17.8042 19.0208 17.4125 19.4125C17.0208 19.8042 16.55 20 16 20H2ZM2 18H16V4H2V18ZM9 3.25C9.21667 3.25 9.39583 3.17917 9.5375 3.0375C9.67917 2.89583 9.75 2.71667 9.75 2.5C9.75 2.28333 9.67917 2.10417 9.5375 1.9625C9.39583 1.82083 9.21667 1.75 9 1.75C8.78333 1.75 8.60417 1.82083 8.4625 1.9625C8.32083 2.10417 8.25 2.28333 8.25 2.5C8.25 2.71667 8.32083 2.89583 8.4625 3.0375C8.60417 3.17917 8.78333 3.25 9 3.25ZM2 18V4V18Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Complaints</span>
          </a>

          <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.index') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center self-stretch transition-all duration-200 mt-1 group">
            <svg width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M0 17V15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V2.2C10.8333 2.53333 11.9167 3.2375 12.75 4.3125C13.5833 5.3875 14 6.61667 14 8V15H16V17H0ZM8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20ZM4 15H12V8C12 6.9 11.6083 5.95833 10.825 5.175C10.0417 4.39167 9.1 4 8 4C6.9 4 5.95833 4.39167 5.175 5.175C4.39167 5.95833 4 6.9 4 8V15Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Notifications</span>
          </a>
          
          <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-100 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center self-stretch transition-colors mt-1">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 8C6.9 8 5.95833 7.60833 5.175 6.825C4.39167 6.04167 4 5.1 4 4C4 2.9 4.39167 1.95833 5.175 1.175C5.95833 0.391667 6.9 0 8 0C9.1 0 10.0417 0.391667 10.825 1.175C11.6083 1.95833 12 2.9 12 4C12 5.1 11.6083 6.04167 10.825 6.825C10.0417 7.60833 9.1 8 8 8ZM0 16V13.2C0 12.6333 0.145833 12.1125 0.4375 11.6375C0.729167 11.1625 1.11667 10.8 1.6 10.55C2.63333 10.0333 3.68333 9.64583 4.75 9.3875C5.81667 9.12917 6.9 9 8 9C9.1 9 10.1833 9.12917 11.25 9.3875C12.3167 9.64583 13.3667 10.0333 14.4 10.55C14.8833 10.8 15.2708 11.1625 15.5625 11.6375C15.8542 12.1125 16 12.6333 16 13.2V16H0ZM2 14H14V13.2C14 13.0167 13.9542 12.85 13.8625 12.7C13.7708 12.55 13.65 12.4333 13.5 12.35C12.6 11.9 11.6917 11.5625 10.775 11.3375C9.85833 11.1125 8.93333 11 8 11C7.06667 11 6.14167 11.1125 5.225 11.3375C4.30833 11.5625 3.4 11.9 2.5 12.35C2.35 12.4333 2.22917 12.55 2.1375 12.7C2.04583 12.85 2 13.0167 2 13.2V14ZM8 6C8.55 6 9.02083 5.80417 9.4125 5.4125C9.80417 5.02083 10 4.55 10 4C10 3.45 9.80417 2.97917 9.4125 2.5875C9.02083 2.19583 8.55 2 8 2C7.45 2 6.97917 2.19583 6.5875 2.5875C6.19583 2.97917 6 3.45 6 4C6 4.55 6.19583 5.02083 6.5875 5.4125C6.97917 5.80417 7.45 6 8 6Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Profile</span>
          </a>
        </div>
    </div>

    <div class="w-full">
      <div class="border-t border-[#c3c6d7] p-4 relative">
        <a href="{{ route('complaint.create') }}" class="w-full bg-[#2563eb] rounded-lg p-3 flex flex-row gap-2 items-center justify-center hover:bg-blue-700 transition-colors shadow-sm">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6 8H0V6H6V0H8V6H14V8H8V14H6V8Z" fill="white"/></svg>
          <span class="text-white font-semibold text-[13px] tracking-[0.65px]">New Complaint</span>
        </a>
      </div>
      
      <div class="px-4 pb-4">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
          @csrf
          <button type="submit" class="w-full rounded-lg p-3 flex gap-3 items-center hover:bg-red-50 text-[#434655] hover:text-red-600 transition-colors">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M1.66667 15C1.20833 15 0.815972 14.8368 0.489583 14.5104C0.163194 14.184 0 13.7917 0 13.3333V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H7.5V1.66667H1.66667V13.3333H7.5V15H1.66667ZM10.8333 11.6667L9.6875 10.4583L11.8125 8.33333H5V6.66667H11.8125L9.6875 4.54167L10.8333 3.33333L15 7.5L10.8333 11.6667Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Logout</span>
          </button>
        </form>
      </div>
    </div>
  </div>

    <div class="flex flex-col flex-1 relative w-full overflow-hidden min-h-screen">
    
        <div class="bg-white/90 backdrop-blur-sm px-6 flex flex-row items-center justify-between h-[62.5px] shrink-0 sticky top-0 z-40 border-b border-[rgba(195,198,215,0.40)]">
      <div class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">
        Welcome back, {{ Auth::user()->name }}
      </div>
      
      <div class="flex flex-row gap-4 items-center">
                <a href="{{ route('complaint.history') }}" class="rounded-full p-2 hover:bg-gray-100 transition cursor-pointer group">
          <svg class="group-hover:scale-110 transition-transform text-[#434655]" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/></svg>
        </a>
        
                <a href="{{ route('notifications.index') }}" class="rounded-full p-2 hover:bg-gray-100 transition cursor-pointer relative group">
          <svg class="group-hover:scale-110 transition-transform text-[#434655]" width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 17V15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V2.2C10.8333 2.53333 11.9167 3.2375 12.75 4.3125C13.5833 5.3875 14 6.61667 14 8V15H16V17H0ZM8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20ZM4 15H12V8C12 6.9 11.6083 5.95833 10.825 5.175C10.0417 4.39167 9.1 4 8 4C6.9 4 5.95833 4.39167 5.175 5.175C4.39167 5.95833 4 6.9 4 8V15Z" fill="currentColor"/></svg>
          <div class="bg-[#ba1a1a] rounded-full w-2 h-2 absolute right-1.5 top-1.5 ring-2 ring-white"></div>
        </a>

                <a href="{{ route('profile.edit') }}" class="rounded-full p-2 hover:bg-gray-100 transition cursor-pointer group">
            <svg class="group-hover:rotate-45 transition-transform duration-300 text-[#434655]" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.3 20L6.9 16.8C6.68333 16.7167 6.47917 16.6167 6.2875 16.5C6.09583 16.3833 5.90833 16.2583 5.725 16.125L2.75 17.375L0 12.625L2.575 10.675C2.55833 10.5583 2.55 10.4458 2.55 10.3375C2.55 10.2292 2.55 10.1167 2.55 10C2.55 9.88333 2.55 9.77083 2.55 9.6625C2.55 9.55417 2.55833 9.44167 2.575 9.325L0 7.375L2.75 2.625L5.725 3.875C5.90833 3.74167 6.1 3.61667 6.3 3.5C6.5 3.38333 6.7 3.28333 6.9 3.2L7.3 0H12.8L13.2 3.2C13.4167 3.28333 13.6208 3.38333 13.8125 3.5C14.0042 3.61667 14.1917 3.74167 14.375 3.875L17.35 2.625L20.1 7.375L17.525 9.325C17.5417 9.44167 17.55 9.55417 17.55 9.6625C17.55 9.77083 17.55 9.88333 17.55 10C17.55 10.1167 17.55 10.2292 17.55 10.3375C17.55 10.4458 17.5333 10.5583 17.5 10.675L20.075 12.625L17.325 17.375L14.375 16.125C14.1917 16.2583 14 16.3833 13.8 16.5C13.6 16.6167 13.4 16.7167 13.2 16.8L12.8 20H7.3ZM9.05 18H11.025L11.375 15.35C11.8917 15.2167 12.3708 15.0208 12.8125 14.7625C13.2542 14.5042 13.6583 14.1917 14.025 13.825L16.5 14.85L17.475 13.15L15.325 11.525C15.4083 11.2917 15.4667 11.0458 15.5 10.7875C15.5333 10.5292 15.55 10.2667 15.55 10C15.55 9.73333 15.5333 9.47083 15.5 9.2125C15.4667 8.95417 15.4083 8.70833 15.325 8.475L17.475 6.85L16.5 5.15L14.025 6.2C13.6583 5.81667 13.2542 5.49583 12.8125 5.2375C12.3708 4.97917 11.8917 4.78333 11.375 4.65L11.05 2H9.075L8.725 4.65C8.20833 4.78333 7.72917 4.97917 7.2875 5.2375C6.84583 5.49583 6.44167 5.80833 6.075 6.175L3.6 5.15L2.625 6.85L4.775 8.45C4.69167 8.7 4.63333 8.95 4.6 9.2C4.56667 9.45 4.55 9.71667 4.55 10C4.55 10.2667 4.56667 10.525 4.6 10.775C4.63333 11.025 4.69167 11.275 4.775 11.525L2.625 13.15L3.6 14.85L6.075 13.8C6.44167 14.1833 6.84583 14.5042 7.2875 14.7625C7.72917 15.0208 8.20833 15.2167 8.725 15.35L9.05 18ZM10.1 13.5C11.0667 13.5 11.8917 13.1583 12.575 12.475C13.2583 11.7917 13.6 10.9667 13.6 10C13.6 9.03333 13.2583 8.20833 12.575 7.525C11.8917 6.84167 11.0667 6.5 10.1 6.5C9.11667 6.5 8.2875 6.84167 7.6125 7.525C6.9375 8.20833 6.6 9.03333 6.6 10C6.6 10.9667 6.9375 11.7917 7.6125 12.475C8.2875 13.1583 9.11667 13.5 10.1 13.5Z" fill="currentColor"/></svg>
        </a>
        
                <a href="{{ route('profile.edit') }}" class="pl-2 flex w-10 h-8 group">
          <div class="bg-[#004ac6] rounded-full flex items-center justify-center w-8 h-8 cursor-pointer group-hover:shadow-md transition-shadow">
            <div class="text-[#ffffff] font-['Manrope-Bold',_sans-serif] text-[14px] font-bold">
              {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
          </div>
        </a>
      </div>
    </div>
    
    <main class="page-transition w-full flex-1">
        @yield('content')
    </main>

  </div>
</div>
</body>
</html>