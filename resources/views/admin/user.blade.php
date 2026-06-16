@extends('layouts.admin')
@section('title', 'Kelola User & Admin - SCMS')

@section('content')
<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto">
    
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between w-full relative gap-4">
        <div class="flex flex-col gap-1 w-full md:w-auto shrink-0">
            <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px] whitespace-nowrap">
                Kelola User & Admin
            </h1>
            <p class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-base leading-6 font-normal">
                Manage system access, roles, and account statuses.
            </p>
        </div>
        
        <div class="flex flex-row flex-wrap gap-3 items-center justify-start lg:justify-end shrink-0 w-full lg:w-auto">
            <button onclick="alert('Fitur Form Add User sedang dalam pengembangan.')" class="bg-[#004ac6] border border-[#004ac6] text-white rounded-lg py-2 px-4 flex items-center gap-2 hover:bg-blue-800 transition shadow-sm">
                <svg width="17" height="12" viewBox="0 0 17 12" fill="none"><path d="M12.75 7.5V5.25H10.5V3.75H12.75V1.5H14.25V3.75H16.5V5.25H14.25V7.5H12.75ZM6 6C5.175 6 4.46875 5.70625 3.88125 5.11875C3.29375 4.53125 3 3.825 3 3C3 2.175 3.29375 1.46875 3.88125 0.88125C4.46875 0.29375 5.175 0 6 0C6.825 0 7.53125 0.29375 8.11875 0.88125C8.70625 1.46875 9 2.175 9 3C9 3.825 8.70625 4.53125 8.11875 5.11875C7.53125 5.70625 6.825 6 6 6ZM0 12V9.9C0 9.475 0.109375 9.08437 0.328125 8.72812C0.546875 8.37187 0.8375 8.1 1.2 7.9125C1.975 7.525 2.7625 7.23438 3.5625 7.04063C4.3625 6.84688 5.175 6.75 6 6.75C6.825 6.75 7.6375 6.84688 8.4375 7.04063C9.2375 7.23438 10.025 7.525 10.8 7.9125C11.1625 8.1 11.4531 8.37187 11.6719 8.72812C11.8906 9.08437 12 9.475 12 9.9V12H0ZM1.5 10.5H10.5V9.9C10.5 9.7625 10.4656 9.6375 10.3969 9.525C10.3281 9.4125 10.2375 9.325 10.125 9.2625C9.45 8.925 8.76875 8.67188 8.08125 8.50313C7.39375 8.33438 6.7 8.25 6 8.25C5.3 8.25 4.60625 8.33438 3.91875 8.50313C3.23125 8.67188 2.55 8.925 1.875 9.2625C1.7625 9.325 1.67188 9.4125 1.60312 9.525C1.53437 9.6375 1.5 9.7625 1.5 9.9V10.5ZM6 4.5C6.4125 4.5 6.76562 4.35312 7.05937 4.05937C7.35312 3.76562 7.5 3.4125 7.5 3C7.5 2.5875 7.35312 2.23438 7.05937 1.94062C6.76562 1.64687 6.4125 1.5 6 1.5C5.5875 1.5 5.23438 1.64687 4.94063 1.94062C4.64688 2.23438 4.5 2.5875 4.5 3C4.5 3.4125 4.64688 3.76562 4.94063 4.05937C5.23438 4.35312 5.5875 4.5 6 4.5Z" fill="white"/></svg>
                <span class="font-semibold text-[13px]">Add New User</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-[#d1fae5] border border-[#16a34a] text-[#065f46] px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4 w-full justify-between items-center bg-transparent mt-2">
        <div class="relative bg-white rounded-lg border border-[#c3c6d7] p-2 pl-10 w-full lg:flex-1 shadow-sm focus-within:border-[#004ac6] transition-colors">
            <svg class="absolute left-3 top-2.5 text-[#6b7280]" width="18" height="24" viewBox="0 0 18 24" fill="none"><path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID..." class="bg-transparent border-none outline-none w-full text-sm text-[#191b23]">
        </div>
        
        <div class="flex flex-row gap-4 w-full lg:w-auto">
            <div class="relative bg-white rounded-lg border border-[#c3c6d7] p-2 pl-3 pr-8 shadow-sm cursor-pointer focus-within:border-[#004ac6] transition-colors w-full lg:w-48">
                <select name="role" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none text-[#191b23] text-sm cursor-pointer">
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                <svg class="absolute right-3 top-3.5 pointer-events-none" width="12" height="12" viewBox="0 0 21 21" fill="none"><path d="M6.3 8.4L10.5 12.6L14.7 8.4" stroke="#6B7280" stroke-width="1.575" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            
            <div class="relative bg-white rounded-lg border border-[#c3c6d7] p-2 pl-3 pr-8 shadow-sm cursor-pointer focus-within:border-[#004ac6] transition-colors w-full lg:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full appearance-none bg-transparent outline-none text-[#191b23] text-sm cursor-pointer">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                <svg class="absolute right-3 top-3.5 pointer-events-none" width="12" height="12" viewBox="0 0 21 21" fill="none"><path d="M6.3 8.4L10.5 12.6L14.7 8.4" stroke="#6B7280" stroke-width="1.575" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            
            <button type="submit" class="hidden">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.50)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] w-full overflow-hidden flex flex-col">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead class="bg-[#f3f3fe] border-b border-[#e1e2ed] text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
                    <tr>
                        <th class="py-4 px-6 w-10 text-center">
                            <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 rounded border-[#c3c6d7] text-[#004ac6] focus:ring-[#004ac6] cursor-pointer">
                        </th>
                        <th class="py-4 px-4">User Name</th>
                        <th class="py-4 px-4">Institution ID</th>
                        <th class="py-4 px-4">Role</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#191b23] text-sm">
                    @forelse($users as $user)
                    <tr class="border-b border-[#e1e2ed] hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6 text-center">
                            <input type="checkbox" class="user-checkbox w-4 h-4 rounded border-[#c3c6d7] text-[#004ac6] focus:ring-[#004ac6] cursor-pointer" value="{{ $user->id }}">
                        </td>
                        
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $avatarBg = match($user->role) {
                                        'superadmin' => 'bg-[#ffdbcd] text-[#7d2d00]',
                                        'admin' => 'bg-[#dbe1ff] text-[#00174b]',
                                        default => 'bg-[#d3e4fe] text-[#0b1c30]'
                                    };
                                    $initials = strtoupper(substr($user->name, 0, 2));
                                @endphp
                                <div class="{{ $avatarBg }} w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                                    <span class="font-bold text-xs">{{ $initials }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-[#191b23] {{ $user->status == 'suspended' ? 'line-through text-gray-500' : '' }}">{{ $user->name }}</span>
                                    <span class="text-[#434655] text-xs">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-4">
                            <span class="text-[#434655] font-medium">{{ $user->nim ?? $user->nip ?? '-' }}</span>                        </td>
                        <td class="py-4 px-4">
                            @if($user->role == 'superadmin')
                                <div class="bg-[#ffdbcd] border border-[rgba(255,181,150,0.50)] rounded-full inline-flex px-2.5 py-1 items-center gap-1.5">
                                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none"><path d="M3.033 7.933L4.666 6.708L6.27 7.933L5.658 5.95L7.291 4.666H5.308L4.666 2.683L4.025 4.666H2.041L3.645 5.95L3.033 7.933ZM4.666 11.666C3.315 11.326 2.199 10.551 1.319 9.34C0.439 8.13 0 6.786 0 5.308V1.75L4.666 0L9.333 1.75V5.308C9.333 6.786 8.893 8.13 8.013 9.34C7.133 10.551 6.018 11.326 4.666 11.666Z" fill="#7D2D00"/></svg>
                                    <span class="text-[#7d2d00] font-semibold text-xs">Super Admin</span>
                                </div>
                            @elseif($user->role == 'admin')
                                <div class="bg-[#dbe1ff] border border-[rgba(180,197,255,0.50)] rounded-full inline-flex px-2.5 py-1 items-center">
                                    <span class="text-[#003ea8] font-semibold text-xs">Admin</span>
                                </div>
                            @else
                                <div class="bg-[#d3e4fe] border border-[rgba(183,200,225,0.30)] rounded-full inline-flex px-2.5 py-1 items-center">
                                    <span class="text-[#0b1c30] font-semibold text-xs">Student</span>
                                </div>
                            @endif
                        </td>

                        <td class="py-4 px-4">
                            @if($user->status == 'active' || !$user->status)
                                <div class="bg-[#dcfce7] border border-[#bbf7d0] rounded-full inline-flex px-2.5 py-1 items-center">
                                    <span class="text-[#166534] font-semibold text-xs">Active</span>
                                </div>
                            @else
                                <div class="bg-[#ffdad6] border border-[rgba(186,26,26,0.20)] rounded-full inline-flex px-2.5 py-1 items-center">
                                    <span class="text-[#93000a] font-semibold text-xs">Suspended</span>
                                </div>
                            @endif
                        </td>

                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pengguna ini?');">
                                    @csrf
                                    <button type="submit" class="bg-gray-50 hover:bg-gray-200 border border-[#c3c6d7] rounded px-3 py-1 text-xs font-semibold text-[#434655] transition shadow-sm" title="{{ $user->status == 'suspended' ? 'Reactivate User' : 'Suspend User' }}">
                                        {{ $user->status == 'suspended' ? 'Reactivate' : 'Suspend' }}
                                    </button>
                                </form>

                                <button onclick="alert('Fitur edit data user sedang dalam pengembangan.')" class="rounded-md p-1.5 hover:bg-gray-100 transition text-gray-500" title="Edit User">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">Tidak ada data pengguna yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-[#f3f3fe] border-t border-[#e1e2ed] p-4 flex flex-col sm:flex-row items-center justify-between">
            <div class="text-[#434655] text-sm mb-4 sm:mb-0">
                Showing <span class="font-bold text-[#191b23]">{{ $users->firstItem() ?? 0 }}</span> 
                to <span class="font-bold text-[#191b23]">{{ $users->lastItem() ?? 0 }}</span> 
                of <span class="font-bold text-[#191b23]">{{ $users->total() }}</span> users
            </div>
            
            <div class="flex items-center gap-1">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');

        // Jika Master Checkbox diklik
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        }
        
        // Memeriksa status checkbox individu untuk mengubah status Master Checkbox
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(userCheckboxes).every(c => c.checked);
                const someChecked = Array.from(userCheckboxes).some(c => c.checked);
                
                selectAllCheckbox.checked = allChecked;
                // Indeterminate (strip kotak di tengah) jika tercentang sebagian
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            });
        });
    });
</script>
@endsection