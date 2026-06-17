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
    
    <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-8 flex flex-col gap-6 w-full shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-[rgba(195,198,215,0.30)]">
        @csrf
        
        <div class="flex flex-col gap-5 w-full">
          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Judul Pengaduan <span class="text-red-500">*</span></label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Tuliskan judul singkat tentang masalah ini" class="bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] p-3 px-4 text-[#191b23] text-sm focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6] transition shadow-sm placeholder-[#737686]">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          
          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Kategori Pengaduan <span class="text-red-500">*</span></label>
            <div class="relative bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6] transition shadow-sm">
              <select name="category_id" required class="w-full appearance-none bg-transparent outline-none p-3 px-4 text-[#191b23] text-sm cursor-pointer">
                <option value="" disabled selected>Pilih Kategori Masalah...</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->department }})</option>
                @endforeach
              </select>
              <svg class="absolute right-4 top-3.5 pointer-events-none text-[#737686]" width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 5.25L7 8.75L10.5 5.25"></path></svg>
            </div>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          
          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Lokasi Insiden / Masalah</label>
            <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Gedung A Lantai 2, Ruang Lab Komputer" class="bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] p-3 px-4 text-[#191b23] text-sm focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6] transition shadow-sm placeholder-[#737686]">
          </div>
          
          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Tingkat Urgensi <span class="text-red-500">*</span></label>
            <div class="relative bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] focus-within:border-[#004ac6] focus-within:ring-1 focus-within:ring-[#004ac6] transition shadow-sm">
              <select name="priority" required class="w-full appearance-none bg-transparent outline-none p-3 px-4 text-[#191b23] text-sm cursor-pointer">
                <option value="Rendah" selected>Rendah - Tidak mendesak</option>
                <option value="Sedang">Sedang - Perlu penanganan segera</option>
                <option value="Tinggi">Tinggi - Kritis & darurat</option>
              </select>
              <svg class="absolute right-4 top-3.5 pointer-events-none text-[#737686]" width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 5.25L7 8.75L10.5 5.25"></path></svg>
            </div>
            @error('priority') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Deskripsi Detail <span class="text-red-500">*</span></label>
            <textarea name="description" required rows="5" placeholder="Jelaskan masalah secara rinci. Sertakan waktu kejadian, kronologi, atau informasi penting lainnya..." class="bg-[#f3f3fe] rounded-lg border border-[#c3c6d7] p-3 px-4 text-[#191b23] text-sm focus:outline-none focus:border-[#004ac6] focus:ring-1 focus:ring-[#004ac6] transition shadow-sm resize-y placeholder-[#737686]">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          
          <div class="flex flex-col gap-1.5 w-full">
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Lampiran (Opsional)</label>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#c3c6d7] border-dashed rounded-lg cursor-pointer bg-[#faf8ff] hover:bg-[#f3f3fe] transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-[#737686]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-1 text-sm text-[#434655]"><span class="font-semibold text-[#004ac6]">Klik untuk mengunggah</span> atau seret file ke sini</p>
                        <p class="text-xs text-[#737686]">PNG, JPG, PDF atau DOC (Maks. 5MB)</p>
                    </div>
                    <input id="dropzone-file" type="file" name="attachment[]" class="hidden" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx"/>
                </label>
            </div>
            @error('attachment.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="border-t border-gray-100 pt-5 mt-2 flex items-start gap-3 w-full">
            <div class="flex items-center h-5 mt-0.5">
              <input type="checkbox" name="is_anonymous" value="1" class="w-4 h-4 text-[#004ac6] bg-white border-[#c3c6d7] rounded focus:ring-[#004ac6] cursor-pointer shadow-sm">
            </div>
            <div class="flex flex-col gap-1">
              <div class="flex items-center gap-2">
                <span class="text-[#191b23] text-[13px] font-bold tracking-[0.65px]">Kirim sebagai Anonim</span>
                <div class="group relative flex items-center justify-center w-4 h-4 rounded-full bg-gray-200 text-gray-500 text-[10px] font-bold cursor-help hover:bg-gray-300">
                  ?
                  <div class="absolute bottom-full mb-2 hidden group-hover:block w-48 p-2 bg-gray-900 text-white text-xs rounded shadow-lg z-10 text-center">
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
              <svg width="15" height="12" viewBox="0 0 15 12" fill="none"><path d="M0 12V0L14.25 6L0 12ZM1.5 9.75L10.3875 6L1.5 2.25V4.875L6 6L1.5 7.125V9.75Z" fill="white"/></svg>
              <span class="text-white font-semibold text-[14px]">Kirim Pengaduan</span>
            </button>
          </div>
        </div>
    </form>
</div>
@endsection