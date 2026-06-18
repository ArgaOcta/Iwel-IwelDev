@extends('layouts.admin')
@section('title', 'Category Management - SCMS')

@section('content')
<div class="flex flex-col gap-8 w-full max-w-[1400px] mx-auto pb-10" x-data="{ openAddModal: false }">
    
    @if(session('success'))
        <div class="bg-[#d1fae5] border border-[#16a34a] text-[#065f46] px-4 py-3 rounded-lg relative shadow-sm mb-[-1rem]">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-[#ffdad6] border border-[#ba1a1a] text-[#93000a] px-4 py-3 rounded-lg relative shadow-sm mb-[-1rem]">
            <span class="block sm:inline font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row items-start md:items-center justify-between w-full gap-4">
        <div class="flex flex-col gap-1 w-full md:w-auto shrink-0">
            <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">
                Category Management
            </h1>
            <p class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-base leading-6 font-normal">
                Manage system complaint categories and their active status.
            </p>
        </div>
        
        <button @click="openAddModal = true" class="bg-[#2563eb] rounded-lg py-2.5 px-6 flex items-center gap-2 hover:bg-blue-700 transition shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M4.5 6H0V4.5H4.5V0H6V4.5H10.5V6H6V10.5H4.5V6Z" fill="white"/></svg>
            <span class="text-white font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Add New Category</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 flex flex-col gap-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Total Categories</span>
                <div class="bg-[rgba(208,225,251,0.50)] rounded-full w-10 h-10 flex items-center justify-center">
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none"><path d="M3.5 9L9 0L14.5 9H3.5ZM14.5 20C13.25 20 12.1875 19.5625 11.3125 18.6875C10.4375 17.8125 10 16.75 10 15.5C10 14.25 10.4375 13.1875 11.3125 12.3125C12.1875 11.4375 13.25 11 14.5 11C15.75 11 16.8125 11.4375 17.6875 12.3125C18.5625 13.1875 19 14.25 19 15.5C19 16.75 18.5625 17.8125 17.6875 18.6875C16.8125 19.5625 15.75 20 14.5 20ZM0 19.5V11.5H8V19.5H0ZM14.5 18C15.2 18 15.7917 17.7583 16.275 17.275C16.7583 16.7917 17 16.2 17 15.5C17 14.8 16.7583 14.2083 16.275 13.725C15.7917 13.2417 15.2 13 14.5 13C13.8 13 13.2083 13.2417 12.725 13.725C12.2417 14.2083 12 14.8 12 15.5C12 16.2 12.2417 16.7917 12.725 17.275C13.2083 17.7583 13.8 18 14.5 18ZM2 17.5H6V13.5H2V17.5ZM7.05 7H10.95L9 3.85L7.05 7Z" fill="#54647A"/></svg>
                </div>
            </div>
            <div class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">{{ $totalCategories }}</div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 flex flex-col gap-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Active Categories</span>
                <div class="bg-[rgba(16,185,129,0.10)] rounded-full w-10 h-10 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M8.6 14.6L15.65 7.55L14.25 6.15L8.6 11.8L5.75 8.95L4.35 10.35L8.6 14.6ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="#10B981"/></svg>
                </div>
            </div>
            <div class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">{{ $activeCategories }}</div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 flex flex-col gap-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Inactive Categories</span>
                <div class="bg-[rgba(255,218,214,0.50)] rounded-full w-10 h-10 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M6.4 15L10 11.4L13.6 15L15 13.6L11.4 10L15 6.4L13.6 5L10 8.6L6.4 5L5 6.4L8.6 10L5 13.6L6.4 15ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="#93000A"/></svg>
                </div>
            </div>
            <div class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">{{ $inactiveCategories }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col w-full">
        
        <div class="bg-[#faf8ff] border-b border-[rgba(195,198,215,0.30)] p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="bg-white rounded-lg border border-[#c3c6d7] p-2 pl-10 relative w-full lg:w-96 focus-within:border-[#004ac6] transition">
                <svg class="absolute left-3 top-2.5 text-[#737686]" width="18" height="20" viewBox="0 0 18 24" fill="none"><path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/></svg>
                <input type="text" id="searchCategory" onkeyup="filterCategories()" placeholder="Search by name or department..." class="bg-transparent border-none outline-none w-full text-sm text-[#191b23]">
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]" id="categoryTable">
                <thead class="bg-[#f1f5f9] border-b border-[rgba(195,198,215,0.30)] text-[#434655] text-[13px] font-semibold tracking-[0.65px] uppercase">
                    <tr>
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">Category Name</th>
                        <th class="py-4 px-6">Department Handle</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($categories as $cat)
                    <tr class="border-b border-[#e1e2ed] hover:bg-blue-50 transition-colors category-row">
                        <td class="py-4 px-6 font-medium text-[#434655]">CAT-{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 font-semibold text-[#191b23] cat-name">{{ $cat->name }}</td>
                        <td class="py-4 px-6 font-medium text-[#434655] cat-dept">{{ $cat->department }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="bg-[rgba(16,185,129,0.10)] rounded-full px-2.5 py-1 inline-flex items-center gap-2">
                                <div class="bg-[#10b981] rounded-full w-1.5 h-1.5"></div>
                                <span class="text-[#10b981] font-medium text-xs">Active</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            
                            <div x-data="{ openEditModal: false }" class="flex items-center justify-end gap-2">
                                <button @click="openEditModal = true" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-[#004ac6] transition" title="Edit Kategori">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>

                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Peringatan: Menghapus kategori ini dapat berdampak pada laporan yang sudah masuk. Apakah Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md p-1.5 text-gray-500 hover:text-[#ba1a1a] hover:bg-red-50 transition" title="Hapus Kategori">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>

                                <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-[99] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm whitespace-normal text-left">
                                    <div @click.away="openEditModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col">
                                        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-[#faf8ff]">
                                            <h2 class="text-lg font-bold text-[#191b23]">Edit Category</h2>
                                            <button @click="openEditModal = false" class="text-gray-400 hover:text-red-500 transition">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST" class="flex flex-col">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-6 flex flex-col gap-5">
                                                <div class="flex flex-col gap-1.5">
                                                    <label class="text-[#434655] font-semibold text-[13px]">Category Name</label>
                                                    <input type="text" name="name" value="{{ $cat->name }}" required class="bg-white border border-[#c3c6d7] rounded-lg px-3 py-2.5 text-sm focus:border-[#004ac6] outline-none transition">
                                                </div>
                                                <div class="flex flex-col gap-1.5">
                                                    <label class="text-[#434655] font-semibold text-[13px]">Assigned Department</label>
                                                    <select name="department" required class="bg-white border border-[#c3c6d7] rounded-lg px-3 py-2.5 text-sm focus:border-[#004ac6] outline-none transition cursor-pointer">
                                                        <option value="Academic Affairs" {{ $cat->department == 'Academic Affairs' ? 'selected' : '' }}>Academic Affairs</option>
                                                        <option value="Facilities Management" {{ $cat->department == 'Facilities Management' ? 'selected' : '' }}>Facilities Management</option>
                                                        <option value="Finance" {{ $cat->department == 'Finance' ? 'selected' : '' }}>Finance</option>
                                                        <option value="IT Services" {{ $cat->department == 'IT Services' ? 'selected' : '' }}>IT Services</option>
                                                        <option value="Student Services" {{ $cat->department == 'Student Services' ? 'selected' : '' }}>Student Services</option>
                                                        <option value="General Administration" {{ $cat->department == 'General Administration' ? 'selected' : '' }}>General Administration</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="p-5 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                                                <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-white border border-[#c3c6d7] rounded-lg text-sm font-semibold text-[#434655] hover:bg-gray-50">Cancel</button>
                                                <button type="submit" class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 shadow-sm">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-[#faf8ff] border-t border-[rgba(195,198,215,0.30)] p-4 flex justify-between items-center">
            <span class="text-[#434655] text-sm font-medium">Showing 1 to {{ $totalCategories }} of {{ $totalCategories }} entries</span>
        </div>
    </div>

    <div x-show="openAddModal" style="display: none;" class="fixed inset-0 z-[99] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div @click.away="openAddModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-[#faf8ff]">
                <h2 class="text-lg font-bold text-[#191b23]">Add New Category</h2>
                <button @click="openAddModal = false" class="text-gray-400 hover:text-red-500 transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col">
                @csrf
                <div class="p-6 flex flex-col gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[#434655] font-semibold text-[13px]">Category Name</label>
                        <input type="text" name="name" required placeholder="e.g. Broken AC, KRS Issue..." class="bg-white border border-[#c3c6d7] rounded-lg px-3 py-2.5 text-sm focus:border-[#004ac6] outline-none transition">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[#434655] font-semibold text-[13px]">Assign to Department</label>
                        <select name="department" required class="bg-white border border-[#c3c6d7] rounded-lg px-3 py-2.5 text-sm focus:border-[#004ac6] outline-none transition cursor-pointer">
                            <option value="" disabled selected>Select department...</option>
                            <option value="Academic Affairs">Academic Affairs</option>
                            <option value="Facilities Management">Facilities Management</option>
                            <option value="Finance">Finance</option>
                            <option value="IT Services">IT Services</option>
                            <option value="Student Services">Student Services</option>
                            <option value="General Administration">General Administration</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-white border border-[#c3c6d7] rounded-lg text-sm font-semibold text-[#434655] hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 shadow-sm">Create Category</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function filterCategories() {
        let input = document.getElementById("searchCategory").value.toUpperCase();
        let table = document.getElementById("categoryTable");
        let tr = table.getElementsByClassName("category-row");
        
        for (let i = 0; i < tr.length; i++) {
            let tdName = tr[i].getElementsByClassName("cat-name")[0];
            let tdDept = tr[i].getElementsByClassName("cat-dept")[0];
            
            if (tdName || tdDept) {
                let textName = tdName.textContent || tdName.innerText;
                let textDept = tdDept.textContent || tdDept.innerText;
                
                if (textName.toUpperCase().indexOf(input) > -1 || textDept.toUpperCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection