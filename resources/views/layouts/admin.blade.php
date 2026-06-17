<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - SCMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @keyframes subtleSlideUp {
            from { opacity: 0; transform: translateY(15px); filter: blur(2px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        .page-transition { animation: subtleSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d0e1fb; border-radius: 10px; }
    </style>
</head>
<body class="font-['Manrope',_sans-serif] antialiased bg-[#faf8ff] text-[#191b23] overflow-x-hidden">

@php
    // PERBAIKAN LOGIKA NOTIFIKASI
    // 1. Angka untuk Sidebar (Total antrean tiket yang belum di-Progress)
    $pendingCount = \App\Models\Complaint::whereIn('status', ['Pending', 'Reviewing'])->count();
    
    // 2. Titik Merah Lonceng (HANYA tiket yang benar-benar BARU / Belum disentuh)
    $unreadCount = \App\Models\Complaint::where('status', 'Pending')->count();
@endphp

<div class="flex flex-row items-start min-h-screen w-full relative">
  
  <div class="bg-white border-r border-[#c3c6d7] flex flex-col justify-between shrink-0 w-[260px] h-screen fixed left-0 top-0 z-50 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
    <div>
        <div class="p-6 flex flex-col gap-1 items-start justify-start relative border-b border-[#e1e2ed]">
          <div class="flex items-center gap-2">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.2112L21 5.7373V17.183C21 17.3896 20.8728 17.575 20.68 17.6494L12 20.9998V9.2112Z" fill="#2563EB"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 4.09398L16.7062 5.78689L12 7.60344L7.29385 5.78689L12 4.09398ZM4.5 7.92424L10.5 10.2401V18.813L4.5 16.4971V7.92424ZM13.5 18.813V10.2401L19.5 7.92424V16.4971L13.5 18.813ZM12.677 1.14931C12.2394 0.991896 11.7606 0.991896 11.323 1.14931L2.49227 4.32593C1.89695 4.54008 1.5 5.10474 1.5 5.73739V17.183C1.5 18.0097 2.00859 18.7512 2.77981 19.0489L11.4599 22.3992C11.8075 22.5334 12.1925 22.5334 12.5401 22.3992L21.2202 19.0489C21.9914 18.7512 22.5 18.0097 22.5 17.183V5.73739C22.5 5.10474 22.1031 4.54008 21.5077 4.32593L12.677 1.14931Z" fill="#2563EB"/></svg>
              <div class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-lg font-bold tracking-[0.65px]">Admin Panel</div>
          </div>
        </div>
        
        <div class="px-3 pt-4 flex flex-col gap-1 relative overflow-y-auto">
          
          <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-colors group">
            <svg class="group-hover:scale-110 transition-transform" width="15" height="15" viewBox="0 0 15 15" fill="currentColor"><path d="M8.33333 5V0H15V5H8.33333ZM0 8.33333V0H6.66667V8.33333H0ZM8.33333 15V6.66667H15V15H8.33333ZM0 15V10H6.66667V15H0ZM1.66667 6.66667H5V1.66667H1.66667V6.66667ZM10 13.3333H13.3333V8.33333H10V13.3333ZM10 3.33333H13.3333V1.66667H10V3.33333ZM1.66667 13.3333H5V11.6667H1.66667V13.3333Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Dashboard</span>
          </a>
          
          <a href="{{ route('admin.complaints.index') }}" class="{{ request()->routeIs('admin.complaints.*') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-colors mt-1 group">            
            <svg class="group-hover:scale-110 transition-transform" width="15" height="17" viewBox="0 0 15 17" fill="currentColor"><path d="M1.66667 16.6667C1.20833 16.6667 0.815972 16.5035 0.489583 16.1771C0.163194 15.8507 0 15.4583 0 15V3.33333C0 2.875 0.163194 2.48264 0.489583 2.15625C0.815972 1.82986 1.20833 1.66667 1.66667 1.66667H5.16667C5.34722 1.16667 5.64931 0.763889 6.07292 0.458333C6.49653 0.152778 6.97222 0 7.5 0C8.02778 0 8.50347 0.152778 8.92708 0.458333C9.35069 0.763889 9.65278 1.16667 9.83333 1.66667H13.3333C13.7917 1.66667 14.184 1.82986 14.5104 2.15625C14.8368 2.48264 15 2.875 15 3.33333V15C15 15.4583 14.8368 15.8507 14.5104 16.1771C14.184 16.5035 13.7917 16.6667 13.3333 16.6667H1.66667ZM1.66667 15H13.3333V3.33333H1.66667V15ZM3.33333 13.3333H9.16667V11.6667H3.33333V13.3333ZM3.33333 10H11.6667V8.33333H3.33333V10ZM3.33333 6.66667H11.6667V5H3.33333V6.66667ZM7.5 2.70833C7.68056 2.70833 7.82986 2.64931 7.94792 2.53125C8.06597 2.41319 8.125 2.26389 8.125 2.08333C8.125 1.90278 8.06597 1.75347 7.94792 1.63542C7.82986 1.51736 7.68056 1.45833 7.5 1.45833C7.31944 1.45833 7.17014 1.51736 7.05208 1.63542C6.93403 1.75347 6.875 1.90278 6.875 2.08333C6.875 2.26389 6.93403 2.41319 7.05208 2.53125C7.17014 2.64931 7.31944 2.70833 7.5 2.70833ZM1.66667 15V3.33333V15Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Manage Complaints</span>
            
            @if($pendingCount > 0)
                <div class="ml-auto bg-[#ba1a1a] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </div>
            @endif
          </a>

          <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports', 'admin.performance') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-colors mt-1 group">
            <svg class="group-hover:scale-110 transition-transform" width="15" height="15" viewBox="0 0 15 15" fill="currentColor"><path d="M4.16667 11.6667C4.40278 11.6667 4.60069 11.5868 4.76042 11.4271C4.92014 11.2674 5 11.0694 5 10.8333C5 10.5972 4.92014 10.3993 4.76042 10.2396C4.60069 10.0799 4.40278 10 4.16667 10C3.93056 10 3.73264 10.0799 3.57292 10.2396C3.41319 10.3993 3.33333 10.5972 3.33333 10.8333C3.33333 11.0694 3.41319 11.2674 3.57292 11.4271C3.73264 11.5868 3.93056 11.6667 4.16667 11.6667ZM4.16667 8.33333C4.40278 8.33333 4.60069 8.25347 4.76042 8.09375C4.92014 7.93403 5 7.73611 5 7.5C5 7.26389 4.92014 7.06597 4.76042 6.90625C4.60069 6.74653 4.40278 6.66667 4.16667 6.66667C3.93056 6.66667 3.73264 6.74653 3.57292 6.90625C3.41319 7.06597 3.33333 7.26389 3.33333 7.5C3.33333 7.73611 3.41319 7.93403 3.57292 8.09375C3.73264 8.25347 3.93056 8.33333 4.16667 8.33333ZM4.16667 5C4.40278 5 4.60069 4.92014 4.76042 4.76042C4.92014 4.60069 5 4.40278 5 4.16667C5 3.93056 4.92014 3.73264 4.76042 3.57292C4.60069 3.41319 4.40278 3.33333 4.16667 3.33333C3.93056 3.33333 3.73264 3.41319 3.57292 3.57292C3.41319 3.73264 3.33333 3.93056 3.33333 4.16667C3.33333 4.40278 3.41319 4.60069 3.57292 4.76042C3.73264 4.92014 3.93056 5 4.16667 5ZM6.66667 11.6667H11.6667V10H6.66667V11.6667ZM6.66667 8.33333H11.6667V6.66667H6.66667V8.33333ZM6.66667 5H11.6667V3.33333H6.66667V5ZM1.66667 15C1.20833 15 0.815972 14.8368 0.489583 14.5104C0.163194 14.184 0 13.7917 0 13.3333V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H13.3333C13.7917 0 14.184 0.163194 14.5104 0.489583C14.8368 0.815972 15 1.20833 15 1.66667V13.3333C15 13.7917 14.8368 14.184 14.5104 14.5104C14.184 14.8368 13.7917 15 13.3333 15H1.66667ZM1.66667 13.3333H13.3333V1.66667H1.66667V13.3333ZM1.66667 1.66667V13.3333V1.66667Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Reports & Analytics</span>
          </a>

          @if(Auth::user()->role === 'superadmin')
          <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-colors mt-1 group">
            <svg class="group-hover:scale-110 transition-transform" width="19" height="14" viewBox="0 0 19 14" fill="currentColor"><path d="M0 13.3333V11C0 10.5278 0.121528 10.0938 0.364583 9.69792C0.607639 9.30208 0.930556 9 1.33333 8.79167C2.19444 8.36111 3.06944 8.03819 3.95833 7.82292C4.84722 7.60764 5.75 7.5 6.66667 7.5C7.58333 7.5 8.48611 7.60764 9.375 7.82292C10.2639 8.03819 11.1389 8.36111 12 8.79167C12.4028 9 12.7257 9.30208 12.9688 9.69792C13.2118 10.0938 13.3333 10.5278 13.3333 11V13.3333H0ZM15 13.3333V10.8333C15 10.2222 14.8299 9.63542 14.4896 9.07292C14.1493 8.51042 13.6667 8.02778 13.0417 7.625C13.75 7.70833 14.4167 7.85069 15.0417 8.05208C15.6667 8.25347 16.25 8.5 16.7917 8.79167C17.2917 9.06944 17.6736 9.37847 17.9375 9.71875C18.2014 10.059 18.3333 10.4306 18.3333 10.8333V13.3333H15ZM6.66667 6.66667C5.75 6.66667 4.96528 6.34028 4.3125 5.6875C3.65972 5.03472 3.33333 4.25 3.33333 3.33333C3.33333 2.41667 3.65972 1.63194 4.3125 0.979167C4.96528 0.326389 5.75 0 6.66667 0C7.58333 0 8.36806 0.326389 9.02083 0.979167C9.67361 1.63194 10 2.41667 10 3.33333C10 4.25 9.67361 5.03472 9.02083 5.6875C8.36806 6.34028 7.58333 6.66667 6.66667 6.66667ZM15 3.33333C15 4.25 14.6736 5.03472 14.0208 5.6875C13.3681 6.34028 12.5833 6.66667 11.6667 6.66667C11.5139 6.66667 11.3194 6.64931 11.0833 6.61458C10.8472 6.57986 10.6528 6.54167 10.5 6.5C10.875 6.05556 11.1632 5.5625 11.3646 5.02083C11.566 4.47917 11.6667 3.91667 11.6667 3.33333C11.6667 2.75 11.566 2.1875 11.3646 1.64583C11.1632 1.10417 10.875 0.611111 10.5 0.166667C10.6944 0.0972222 10.8889 0.0520833 11.0833 0.03125C11.2778 0.0104167 11.4722 0 11.6667 0C12.5833 0 13.3681 0.326389 14.0208 0.979167C14.6736 1.63194 15 2.41667 15 3.33333ZM1.66667 11.6667H11.6667V11C11.6667 10.8472 11.6285 10.7083 11.5521 10.5833C11.4757 10.4583 11.375 10.3611 11.25 10.2917C10.5 9.91667 9.74306 9.63542 8.97917 9.44792C8.21528 9.26042 7.44444 9.16667 6.66667 9.16667C5.88889 9.16667 5.11806 9.26042 4.35417 9.44792C3.59028 9.63542 2.83333 9.91667 2.08333 10.2917C1.95833 10.3611 1.85764 10.4583 1.78125 10.5833C1.70486 10.7083 1.66667 10.8472 1.66667 11V11.6667ZM6.66667 5C7.125 5 7.51736 4.83681 7.84375 4.51042C8.17014 4.18403 8.33333 3.79167 8.33333 3.33333C8.33333 2.875 8.17014 2.48264 7.84375 2.15625C7.51736 1.82986 7.125 1.66667 6.66667 1.66667C6.20833 1.66667 5.81597 1.82986 5.48958 2.15625C5.16319 2.48264 5 2.875 5 3.33333C5 3.79167 5.16319 4.18403 5.48958 4.51042C5.81597 4.83681 6.20833 5 6.66667 5Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Users</span>
          </a>
          @endif

          <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'bg-[#d0e1fb] text-[#004ac6]' : 'hover:bg-gray-50 text-[#434655]' }} rounded-lg p-3 flex flex-row gap-3 items-center transition-colors mt-1 group">
            <svg class="group-hover:rotate-45 transition-transform duration-300" width="17" height="17" viewBox="0 0 17 17" fill="currentColor"><path d="M6.08333 16.6667L5.75 14C5.56944 13.9306 5.39931 13.8472 5.23958 13.75C5.07986 13.6528 4.92361 13.5486 4.77083 13.4375L2.29167 14.4792L0 10.5208L2.14583 8.89583C2.13194 8.79861 2.125 8.70486 2.125 8.61458C2.125 8.52431 2.125 8.43056 2.125 8.33333C2.125 8.23611 2.125 8.14236 2.125 8.05208C2.125 7.96181 2.13194 7.86806 2.14583 7.77083L0 6.14583L2.29167 2.1875L4.77083 3.22917C4.92361 3.11806 5.08333 3.01389 5.25 2.91667C5.41667 2.81944 5.58333 2.73611 5.75 2.66667L6.08333 0H10.6667L11 2.66667C11.1806 2.73611 11.3507 2.81944 11.5104 2.91667C11.6701 3.01389 11.8264 3.11806 11.9792 3.22917L14.4583 2.1875L16.75 6.14583L14.6042 7.77083C14.6181 7.86806 14.625 7.96181 14.625 8.05208C14.625 8.14236 14.625 8.23611 14.625 8.33333C14.625 8.43056 14.625 8.52431 14.625 8.61458C14.625 8.70486 14.6111 8.79861 14.5833 8.89583L16.7292 10.5208L14.4375 14.4792L11.9792 13.4375C11.8264 13.5486 11.6667 13.6528 11.5 13.75C11.3333 13.8472 11.1667 13.9306 11 14L10.6667 16.6667H6.08333ZM7.54167 15H9.1875L9.47917 12.7917C9.90972 12.6806 10.309 12.5174 10.6771 12.3021C11.0451 12.0868 11.3819 11.8264 11.6875 11.5208L13.75 12.375L14.5625 10.9583L12.7708 9.60417C12.8403 9.40972 12.8889 9.20486 12.9167 8.98958C12.9444 8.77431 12.9583 8.55556 12.9583 8.33333C12.9583 8.11111 12.9444 7.89236 12.9167 7.67708C12.8889 7.46181 12.8403 7.25694 12.7708 7.0625L14.5625 5.70833L13.75 4.29167L11.6875 5.16667C11.3819 4.84722 11.0451 4.57986 10.6771 4.36458C10.309 4.14931 9.90972 3.98611 9.47917 3.875L9.20833 1.66667H7.5625L7.27083 3.875C6.84028 3.98611 6.44097 4.14931 6.07292 4.36458C5.70486 4.57986 5.36806 4.84028 5.0625 5.14583L3 4.29167L2.1875 5.70833L3.97917 7.04167C3.90972 7.25 3.86111 7.45833 3.83333 7.66667C3.80556 7.875 3.79167 8.09722 3.79167 8.33333C3.79167 8.55556 3.80556 8.77083 3.83333 8.97917C3.86111 9.1875 3.90972 9.39583 3.97917 9.60417L2.1875 10.9583L3 12.375L5.0625 11.5C5.36806 11.8194 5.70486 12.0868 6.07292 12.3021C6.44097 12.5174 6.84028 12.6806 7.27083 12.7917L7.54167 15ZM8.41667 11.25C9.22222 11.25 9.90972 10.9653 10.4792 10.3958C11.0486 9.82639 11.3333 9.13889 11.3333 8.33333C11.3333 7.52778 11.0486 6.84028 10.4792 6.27083C9.90972 5.70139 9.22222 5.41667 8.41667 5.41667C7.59722 5.41667 6.90625 5.70139 6.34375 6.27083C5.78125 6.84028 5.5 7.52778 5.5 8.33333C5.5 9.13889 5.78125 9.82639 6.34375 10.3958C6.90625 10.9653 7.59722 11.25 8.41667 11.25Z" fill="currentColor"/></svg>
            <span class="font-semibold text-[13px] tracking-[0.65px]">Category Settings</span>
          </a>
        </div>
    </div>

    <div class="w-full">
      <div class="border-t border-[#e1e2ed] p-4">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
          @csrf
          <button type="submit" class="w-full rounded-lg p-2.5 px-3 flex flex-row gap-3 items-center hover:bg-red-50 text-[#ba1a1a] transition-colors group">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" class="group-hover:scale-110 transition-transform"><path d="M1.66667 15C1.20833 15 0.815972 14.8368 0.489583 14.5104C0.163194 14.184 0 13.7917 0 13.3333V1.66667C0 1.20833 0.163194 0.815972 0.489583 0.489583C0.815972 0.163194 1.20833 0 1.66667 0H7.5V1.66667H1.66667V13.3333H7.5V15H1.66667ZM10.8333 11.6667L9.6875 10.4583L11.8125 8.33333H5V6.66667H11.8125L9.6875 4.54167L10.8333 3.33333L15 7.5L10.8333 11.6667Z" fill="currentColor"/></svg>
            <span class="font-medium text-sm">Logout</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="ml-[260px] flex flex-col flex-1 relative w-full overflow-hidden min-h-screen">
    
    <div class="bg-white/80 backdrop-blur-md px-8 py-4 flex flex-row items-center justify-between z-40 sticky top-0 border-b border-[#e1e2ed] shadow-sm">
      <div class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold truncate max-w-[200px] md:max-w-md">
        Welcome back, {{ Auth::user()->name }}
      </div>
      
      <div class="flex flex-row gap-4 items-center">
        <div class="hidden md:flex bg-white rounded-lg border border-[#c3c6d7] py-2 px-4 items-center gap-2 w-64 shadow-sm focus-within:border-[#004ac6] transition-colors">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M13.8333 15L8.58333 9.75C8.16667 10.0833 7.6875 10.3472 7.14583 10.5417C6.60417 10.7361 6.02778 10.8333 5.41667 10.8333C3.90278 10.8333 2.62153 10.309 1.57292 9.26042C0.524305 8.21181 0 6.93056 0 5.41667C0 3.90278 0.524305 2.62153 1.57292 1.57292C2.62153 0.524305 3.90278 0 5.41667 0C6.93056 0 8.21181 0.524305 9.26042 1.57292C10.309 2.62153 10.8333 3.90278 10.8333 5.41667C10.8333 6.02778 10.7361 6.60417 10.5417 7.14583C10.3472 7.6875 10.0833 8.16667 9.75 8.58333L15 13.8333L13.8333 15ZM5.41667 9.16667C6.45833 9.16667 7.34375 8.80208 8.07292 8.07292C8.80208 7.34375 9.16667 6.45833 9.16667 5.41667C9.16667 4.375 8.80208 3.48958 8.07292 2.76042C7.34375 2.03125 6.45833 1.66667 5.41667 1.66667C4.375 1.66667 3.48958 2.03125 2.76042 2.76042C2.03125 3.48958 1.66667 4.375 1.66667 5.41667C1.66667 6.45833 2.03125 7.34375 2.76042 8.07292C3.48958 8.80208 4.375 9.16667 5.41667 9.16667Z" fill="#737686"/></svg>
            <input type="text" placeholder="Search..." class="bg-transparent border-none outline-none w-full text-sm text-[#191b23] placeholder-[#737686]">
        </div>

        <a href="{{ route('admin.notifications') }}" class="rounded-full p-2 hover:bg-gray-100 transition cursor-pointer relative group">
          <svg class="group-hover:scale-110 transition-transform text-[#434655]" width="16" height="20" viewBox="0 0 16 20" fill="currentColor"><path d="M0 17V15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V2.2C10.8333 2.53333 11.9167 3.2375 12.75 4.3125C13.5833 5.3875 14 6.61667 14 8V15H16V17H0ZM8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20ZM4 15H12V8C12 6.9 11.6083 5.95833 10.825 5.175C10.0417 4.39167 9.1 4 8 4C6.9 4 5.95833 4.39167 5.175 5.175C4.39167 5.95833 4 6.9 4 8V15Z" fill="currentColor"/></svg>
          @if($unreadCount > 0)
              <div class="bg-[#ba1a1a] rounded-full w-2.5 h-2.5 absolute right-1.5 top-1.5 border-2 border-white shadow-sm"></div>
          @endif
        </a>

        <a href="{{ route('admin.profile') }}" class="flex w-10 h-10 border-2 border-transparent hover:border-[#004ac6] transition-colors rounded-full overflow-hidden shadow-sm">
            <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=fff&background=004ac6" alt="Avatar"/>
        </a>
      </div>
    </div>
    
    <main class="page-transition w-full flex-1 relative z-10 bg-transparent p-8">
        @yield('content')
    </main>

  </div>
</div>
</body>
</html>