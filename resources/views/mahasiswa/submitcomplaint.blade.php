@extends('layouts.mahasiswa')
@section('title', 'Buat Pengaduan Baru - SCMS')

@section('content')
<div class="w-full max-w-3xl mx-auto pt-10 pb-14 px-4 sm:px-0 relative">
        
    <div class="flex flex-col gap-2 items-start justify-start self-stretch mb-8">
      <h1 class="text-[#191b23] text-[32px] leading-10 font-bold tracking-[-0.64px]">Buat Pengaduan</h1>
      <p class="text-[#434655] text-base leading-6">Lengkapi formulir di bawah ini dengan detail yang jelas untuk mempercepat proses penanganan.</p>
    </div>

    @if ($errors->any())
        <div class="w-full bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <ul class="list-disc pl-5 mt-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-8 flex flex-col gap-6 w-full border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-shadow duration-300">
      @csrf
        
        <div class="flex flex-col gap-2 w-full">
          <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
            Judul Pengaduan <span class="text-[#ba1a1a]">*</span>
          </label>
          <div class="bg-white rounded-lg border border-[#c3c6d7] p-[13px] focus-within:border-[#004ac6] focus-within:ring-2 focus-within:ring-[#004ac6]/20 transition-all duration-200 hover:border-gray-400">
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Singkat dan jelas (misal: AC Kelas G-201 Rusak)" class="w-full bg-transparent border-none outline-none text-[#191b23] text-base placeholder-[#737686]" required>
          </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full relative z-30">
          
          <div x-data="{ 
                  open: false, 
                  selectedId: '{{ old('category_id') }}', 
                  selectedName: 'Pilih Kategori...' 
               }" 
               x-init="@if(old('category_id')) selectedName = '{{ $categories->firstWhere('id', old('category_id'))->name ?? 'Pilih Kategori...' }}'; @endif"
               class="flex flex-col gap-2 relative">
            
            <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
              Kategori <span class="text-[#ba1a1a]">*</span>
            </label>
            <input type="hidden" name="category_id" :value="selectedId" required>
            
            <button @click="open = !open" @click.outside="open = false" type="button" class="w-full bg-white rounded-lg border border-[#c3c6d7] p-[13px] flex justify-between items-center transition-all duration-200 hover:border-gray-400 focus:border-[#004ac6] focus:ring-2 focus:ring-[#004ac6]/20 shadow-sm">
              <span x-text="selectedName" :class="selectedId ? 'text-[#191b23]' : 'text-[#737686]'" class="text-base font-normal"></span>
              <svg :class="open ? 'rotate-180' : ''" class="transition-transform duration-200" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M6 7.4L0 1.4L1.4 0L6 4.6L10.6 0L12 1.4L6 7.4Z" fill="#434655"/></svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-[-10px] scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave="transition ease-in duration-100" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute top-full mt-2 left-0 w-full bg-white border border-[#c3c6d7] rounded-lg shadow-[0_10px_40px_rgba(0,0,0,0.1)] overflow-hidden z-40 max-h-48 overflow-y-auto" style="display: none;">
              @foreach($categories as $category)
                  <div @click="selectedId = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false" 
                       class="px-4 py-3 cursor-pointer hover:bg-[#f0f4ff] hover:text-[#004ac6] font-medium transition-colors text-[#191b23] text-[15px] border-b border-gray-100 last:border-0">
                      {{ $category->name }}
                  </div>
              @endforeach
            </div>
          </div>

          <div x-data="{ open: false, selectedId: '{{ old('priority') }}', selectedName: 'Pilih Tingkat Urgensi...' }" 
               x-init="@if(old('priority')) selectedName = '{{ old('priority') }}'; @endif"
               class="flex flex-col gap-2 relative">
            <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
              Tingkat Urgensi <span class="text-[#ba1a1a]">*</span>
            </label>
            <input type="hidden" name="priority" :value="selectedId" required>
            
            <button @click="open = !open" @click.outside="open = false" type="button" class="w-full bg-white rounded-lg border border-[#c3c6d7] p-[13px] flex justify-between items-center transition-all duration-200 hover:border-gray-400 focus:border-[#004ac6] focus:ring-2 focus:ring-[#004ac6]/20 shadow-sm">
              <span x-text="selectedName" :class="selectedId ? 'text-[#191b23]' : 'text-[#737686]'" class="text-base font-normal"></span>
              <svg :class="open ? 'rotate-180' : ''" class="transition-transform duration-200" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M6 7.4L0 1.4L1.4 0L6 4.6L10.6 0L12 1.4L6 7.4Z" fill="#434655"/></svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-[-10px] scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave="transition ease-in duration-100" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute top-full mt-2 left-0 w-full bg-white border border-[#c3c6d7] rounded-lg shadow-[0_10px_40px_rgba(0,0,0,0.1)] overflow-hidden z-40" style="display: none;">
                <div @click="selectedId = 'Rendah'; selectedName = 'Rendah'; open = false" class="px-4 py-3 cursor-pointer hover:bg-green-50 hover:text-green-700 font-medium transition-colors text-[#191b23] text-[15px] border-b border-gray-100">Rendah</div>
                <div @click="selectedId = 'Sedang'; selectedName = 'Sedang'; open = false" class="px-4 py-3 cursor-pointer hover:bg-orange-50 hover:text-orange-600 font-medium transition-colors text-[#191b23] text-[15px] border-b border-gray-100">Sedang</div>
                <div @click="selectedId = 'Tinggi'; selectedName = 'Tinggi'; open = false" class="px-4 py-3 cursor-pointer hover:bg-red-50 hover:text-red-600 font-medium transition-colors text-[#191b23] text-[15px]">Tinggi</div>
            </div>
          </div>
        </div>
        
        <div class="flex flex-col gap-2 w-full relative z-20">
          <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
            Deskripsi Detail <span class="text-[#ba1a1a]">*</span>
          </label>
          <p class="text-[#737686] text-sm mt-[-4px]">Jelaskan kronologi, lokasi spesifik, dan pihak yang terlibat jika ada.</p>
          <div class="bg-white rounded-lg border border-[#c3c6d7] p-4 hover:border-gray-400 focus-within:border-[#004ac6] focus-within:ring-2 focus-within:ring-[#004ac6]/20 transition-all duration-200">
            <textarea name="description" placeholder="Ceritakan detail keluhan Anda di sini..." class="w-full bg-transparent border-none outline-none text-[#191b23] text-[15px] leading-relaxed placeholder-[#737686] min-h-[140px] resize-y" required>{{ old('description') }}</textarea>
          </div>
        </div>
        
        <div class="flex flex-col gap-2 w-full relative z-10"
             x-data="{
                files: [],
                maxFiles: 5,
                handleFileSelect(event) {
                    const newFiles = Array.from(event.target.files);
                    
                    // Validasi batas maksimal file
                    if (this.files.length + newFiles.length > this.maxFiles) {
                        alert('Maksimal hanya ' + this.maxFiles + ' lampiran yang diperbolehkan.');
                        this.syncInput(); // kembalikan state memori
                        return;
                    }
                    
                    newFiles.forEach(file => {
                        const isImg = file.type.startsWith('image/');
                        if (isImg) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.files.push({ file: file, name: file.name, isImage: true, preview: e.target.result });
                                this.syncInput();
                            };
                            reader.readAsDataURL(file);
                        } else {
                            this.files.push({ file: file, name: file.name, isImage: false, preview: '' });
                            this.syncInput();
                        }
                    });
                },
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.syncInput();
                },
                syncInput() {
                    // Trik manipulasi DataTransfer agar file input sinkron dengan array Alpine
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    $refs.fileInput.files = dt.files;
                }
             }">
             
          <div class="flex justify-between items-end">
            <label class="text-[#434655] text-[13px] font-semibold tracking-[0.65px]">Lampiran Bukti (Opsional)</label>
            <span class="text-xs text-[#737686] font-medium"><span x-text="files.length"></span>/5 File</span>
          </div>
          
          <div x-show="files.length < maxFiles" 
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 h-auto"
               x-transition:leave-end="opacity-0 h-0 overflow-hidden"
               class="bg-[#faf8ff] rounded-lg border-dashed border-2 border-[#c3c6d7] p-8 flex flex-col items-center justify-center relative group hover:border-[#004ac6] transition-all duration-300 cursor-pointer min-h-[140px]">
            
            <input type="file" name="attachment[]" multiple x-ref="fileInput" @change="handleFileSelect($event)" 
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                   accept=".png,.jpg,.jpeg,.pdf">
            
            <div class="flex flex-col items-center justify-center pointer-events-none transition-all">
                <svg class="w-8 h-8 mb-3 fill-[#737686] group-hover:fill-[#004ac6] group-hover:-translate-y-1 transition-all duration-300" viewBox="0 0 24 30" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 25.5H13.5V19.2375L15.9 21.6375L18 19.5L12 13.5L6 19.5L8.1375 21.6L10.5 19.2375V25.5ZM3 30C2.175 30 1.46875 29.7062 0.88125 29.1187C0.29375 28.5312 0 27.825 0 27V3C0 2.175 0.29375 1.46875 0.88125 0.88125C1.46875 0.29375 2.175 0 3 0H15L24 9V27C24 27.825 23.7062 28.5312 23.1187 29.1187C22.5312 29.7062 21.825 30 21 30H3ZM13.5 10.5V3H3V27H21V10.5H13.5ZM3 3V10.5V3V10.5V27V3Z"/></svg>
                <div class="flex flex-row gap-1 items-center relative z-0">
                  <span class="text-[#004ac6] text-[15px] font-semibold">Upload file</span>
                  <span class="text-[#434655] text-[15px]">atau tarik ke sini</span>
                </div>
                <div class="text-[#737686] text-sm mt-1.5 relative z-0">PNG, JPG, PDF (Maks. 5 file)</div>
            </div>
          </div>

          <div x-show="files.length > 0" 
               class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-3" style="display: none;">
              
              <template x-for="(file, index) in files" :key="index">
                  <div class="relative flex flex-col items-center justify-center p-3 bg-white border border-[#c3c6d7] rounded-xl shadow-sm hover:shadow-md transition group overflow-hidden animate-fade-in">
                      
                      <button type="button" @click.stop="removeFile(index)" 
                              class="absolute top-1.5 right-1.5 bg-white rounded-full w-6 h-6 flex items-center justify-center shadow-md border border-gray-100 text-red-500 hover:bg-red-500 hover:text-white transition-colors z-20">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                      </button>

                      <template x-if="file.isImage">
                          <div class="w-full aspect-square rounded-lg overflow-hidden mb-2 bg-gray-50 border border-gray-100">
                              <img :src="file.preview" class="w-full h-full object-cover">
                          </div>
                      </template>

                      <template x-if="!file.isImage">
                          <div class="w-full aspect-square rounded-lg mb-2 bg-[#f3f3fe] border border-[#d0e1fb] flex items-center justify-center">
                              <svg class="w-10 h-10 text-[#004ac6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                              </svg>
                          </div>
                      </template>
                      
                      <span class="text-[#191b23] font-semibold text-xs truncate w-full text-center px-1" x-text="file.name" :title="file.name"></span>
                  </div>
              </template>
              
          </div>
        </div>
        <div class="bg-gray-100 w-full h-[1px] my-2"></div>
        
        <div x-data="{ isAnon: {{ old('is_anonymous') ? 'true' : 'false' }}, tooltip: false }" 
             class="bg-[#faf8ff] rounded-xl border border-gray-200 p-5 flex flex-row gap-4 items-start w-full hover:border-[#d0e1fb] transition-colors shadow-sm cursor-pointer"
             @click="isAnon = !isAnon"> 
          
          <input type="checkbox" name="is_anonymous" value="1" class="hidden" x-model="isAnon">
          
          <div :class="isAnon ? 'bg-[#2563eb]' : 'bg-[#e1e2ed]'"
               class="w-12 h-6 rounded-full relative flex-shrink-0 transition-colors duration-300 ease-in-out mt-0.5 shadow-inner">
            <div :class="isAnon ? 'translate-x-6' : 'translate-x-0'"
                 class="bg-white rounded-full w-5 h-5 absolute top-[2px] left-[2px] transform transition-transform duration-300 ease-out shadow-md"></div>
          </div>
          
          <div class="flex flex-col gap-1 w-full">
            <div class="flex items-center gap-2 relative">
              <span class="text-[#191b23] text-[15px] font-bold">Kirim sebagai Anonim</span>
              
              <div @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="relative flex items-center justify-center cursor-help text-[#737686] hover:text-[#004ac6] transition-colors p-1" @click.stop>
                <svg width="18" height="18" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.75 11.25H8.25V6.75H6.75V11.25ZM7.5 5.25C7.7125 5.25 7.89062 5.17813 8.03438 5.03438C8.17813 4.89062 8.25 4.7125 8.25 4.5C8.25 4.2875 8.17813 4.10938 8.03438 3.96563C7.89062 3.82188 7.7125 3.75 7.5 3.75C7.2875 3.75 7.10938 3.82188 6.96562 3.96563C6.82187 4.10938 6.75 4.2875 6.75 4.5C6.75 4.7125 6.82187 4.89062 6.96562 5.03438C7.10938 5.17813 7.2875 5.25 7.5 5.25ZM7.5 15C6.4625 15 5.4875 14.8031 4.575 14.4094C3.6625 14.0156 2.86875 13.4812 2.19375 12.8062C1.51875 12.1312 0.984375 11.3375 0.590625 10.425C0.196875 9.5125 0 8.5375 0 7.5C0 6.4625 0.196875 5.4875 0.590625 4.575C0.984375 3.6625 1.51875 2.86875 2.19375 2.19375C2.86875 1.51875 3.6625 0.984375 4.575 0.590625C5.4875 0.196875 6.4625 0 7.5 0C8.5375 0 9.5125 0.196875 10.425 0.590625C11.3375 0.984375 12.1312 1.51875 12.8062 2.19375C13.4812 2.86875 14.0156 3.6625 14.4094 4.575C14.8031 5.4875 15 6.4625 15 7.5C15 8.5375 14.8031 9.5125 14.4094 10.425C14.0156 11.3375 13.4812 12.1312 12.8062 12.8062C12.1312 13.4812 11.3375 14.0156 10.425 14.4094C9.5125 14.8031 8.5375 15 7.5 15ZM7.5 13.5C9.175 13.5 10.5938 12.9188 11.7563 11.7563C12.9188 10.5938 13.5 9.175 13.5 7.5C13.5 5.825 12.9188 4.40625 11.7563 3.24375C10.5938 2.08125 9.175 1.5 7.5 1.5C5.825 1.5 4.40625 2.08125 3.24375 3.24375C2.08125 4.40625 1.5 5.825 1.5 7.5C1.5 9.175 2.08125 10.5938 3.24375 11.7563C4.40625 12.9188 5.825 13.5 7.5 13.5Z" fill="currentColor"/></svg>
                
                <div x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute bottom-[140%] left-1/2 transform -translate-x-1/2 w-[280px] bg-gray-900 text-white text-xs leading-relaxed p-3.5 rounded-lg shadow-xl z-50 text-center" style="display: none;">
                  Mode Anonim akan menyembunyikan nama dan NIM Anda dari staf yang menangani keluhan.
                  <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px] border-t-gray-900"></div>
                </div>
              </div>
            </div>
            <p class="text-[#737686] text-sm">Gunakan fitur ini jika Anda merasa khawatir tentang privasi atau potensi dampak dari pelaporan.</p>
          </div>
        </div>
        
        <div class="flex justify-end gap-3 w-full mt-2 pt-4 border-t border-gray-100">
          <a href="{{ route('dashboard') }}" class="bg-white rounded-lg border border-[#c3c6d7] py-2.5 px-6 hover:bg-gray-50 hover:text-red-600 transition-colors">
            <span class="font-semibold text-[14px]">Batal</span>
          </a>
          <button type="submit" class="bg-[#004ac6] rounded-lg py-2.5 px-6 flex items-center gap-2 hover:bg-blue-800 transition-all hover:shadow-lg transform hover:-translate-y-0.5">
            <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 12V0L14.25 6L0 12ZM1.5 9.75L10.3875 6L1.5 2.25V4.875L6 6L1.5 7.125V9.75ZM1.5 9.75V6V2.25V4.875V7.125V9.75Z" fill="white"/></svg>
            <span class="text-white text-[14px] font-bold">Kirim Pengaduan</span>
          </button>
        </div>
        
    </form>
</div>
@endsection