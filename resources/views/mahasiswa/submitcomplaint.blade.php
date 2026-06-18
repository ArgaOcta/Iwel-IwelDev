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
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->department }})</option>
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
                <option value="Rendah" {{ old('priority') == 'Rendah' ? 'selected' : '' }}>Rendah - Tidak mendesak</option>
                <option value="Sedang" {{ old('priority') == 'Sedang' ? 'selected' : '' }}>Sedang - Perlu penanganan segera</option>
                <option value="Tinggi" {{ old('priority') == 'Tinggi' ? 'selected' : '' }}>Tinggi - Kritis & darurat</option>
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
            <label class="text-[#191b23] text-sm font-semibold tracking-[0.65px]">Lampiran Bukti (Opsional - Maks. 5 File)</label>
            <div class="flex items-center justify-center w-full">
                
                <div id="dropzone-area" onclick="document.getElementById('file-browser').click()" class="flex flex-col items-center justify-center w-full min-h-[9rem] py-6 border-2 border-[#c3c6d7] border-dashed rounded-lg cursor-pointer bg-[#faf8ff] transition-all duration-200 hover:border-[#004ac6] hover:bg-[#f3f3fe] relative overflow-hidden">
                    
                    <div id="dropzone-content" class="flex flex-col items-center justify-center w-full px-4 pointer-events-none">
                        <svg class="w-10 h-10 mb-3 text-[#737686] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-1 text-sm text-[#434655] text-center"><span class="font-semibold text-[#004ac6]">Klik</span> atau <span class="font-semibold text-[#004ac6]">Tarik & Lepaskan (Drag & Drop)</span> file ke sini</p>
                        <p class="text-xs text-[#737686] text-center mt-1">Mendukung: PNG, JPG, PDF, DOCX, XLSX (Maks. 5MB per file)</p>
                    </div>

                </div>

                <input id="file-browser" type="file" class="hidden" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileBrowse(this)"/>
                
                <input id="real-file-input" type="file" name="attachment[]" class="hidden" multiple>

            </div>
            @error('attachment.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @error('attachment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <p id="file-error-msg" class="text-red-500 text-xs mt-1 hidden font-medium">⚠️ Maksimal hanya 5 file yang diizinkan!</p>
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
                    Mode Anonim menyembunyikan identitas Anda dari staf pelaksana.
                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px] border-t-gray-900"></div>
                  </div>
                </div>
              </div>
              <p class="text-[#737686] text-sm">Gunakan fitur ini untuk menjaga kerahasiaan Anda saat melapor.</p>
            </div>
          </div>
          
          <div class="flex justify-end gap-3 w-full mt-2 pt-4 border-t border-gray-100">
            <a href="{{ route('dashboard') }}" class="bg-white rounded-lg border border-[#c3c6d7] py-2.5 px-6 hover:bg-gray-50 hover:text-red-600 transition-colors">
              <span class="font-semibold text-[14px]">Batal</span>
            </a>
            <button type="submit" class="bg-[#004ac6] rounded-lg py-2.5 px-6 flex items-center gap-2 hover:bg-blue-800 transition-all shadow-sm">
              <svg width="15" height="12" viewBox="0 0 15 12" fill="none"><path d="M0 12V0L14.25 6L0 12ZM1.5 9.75L10.3875 6L1.5 2.25V4.875L6 6L1.5 7.125V9.75Z" fill="white"/></svg>
              <span class="text-white font-semibold text-[14px]">Kirim Pengaduan</span>
            </button>
          </div>
        </div>
    </form>
</div>

<script>
    // Memori Penyimpanan File
    const dt = new DataTransfer();
    const maxFiles = 5;
    const dropzoneArea = document.getElementById('dropzone-area');

    // 1. Fungsi Utama Memproses File yang Masuk
    function processFiles(files) {
        const errorMsg = document.getElementById('file-error-msg');
        errorMsg.classList.add('hidden');

        Array.from(files).forEach(file => {
            // Cek apakah belum melebihi limit 5 file
            if (dt.items.length < maxFiles) {
                // Cek apakah file ini sudah pernah dimasukkan (mencegah duplikat)
                let isDuplicate = false;
                for (let i = 0; i < dt.files.length; i++) {
                    if (dt.files[i].name === file.name && dt.files[i].size === file.size) {
                        isDuplicate = true; break;
                    }
                }
                if (!isDuplicate) dt.items.add(file);
            } else {
                errorMsg.classList.remove('hidden'); // Munculkan peringatan limit
            }
        });

        // Pindahkan data ke Input Asli agar bisa disubmit oleh Form
        document.getElementById('real-file-input').files = dt.files;
        renderPreview();
    }

    // 2. Dipanggil ketika memilih lewat klik kotak (File Explorer)
    function handleFileBrowse(input) {
        if (input.files && input.files.length > 0) {
            processFiles(input.files);
        }
        // RESET input klik agar jika user klik cancel, tidak ada data yang terhapus dari memori
        input.value = ""; 
    }

    // 3. Menghapus file secara spesifik
    function removeFile(index, event) {
        event.preventDefault(); 
        event.stopPropagation(); // Mencegah kotak file explorer terbuka saat tombol X diklik

        dt.items.remove(index);
        document.getElementById('real-file-input').files = dt.files;
        
        // Sembunyikan pesan error jika file sudah dikurangi
        if (dt.items.length < maxFiles) {
            document.getElementById('file-error-msg').classList.add('hidden');
        }
        
        renderPreview();
    }

    // 4. Me-render (menggambar) tampilan kotak Dropzone
    function renderPreview() {
        const content = document.getElementById('dropzone-content');
        
        if (dt.files.length > 0) {
            let previewsHtml = `<div class="flex flex-wrap gap-4 justify-center w-full mt-3 relative z-20">`;

            Array.from(dt.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const objectUrl = URL.createObjectURL(file);
                    previewsHtml += `
                        <div class="relative flex flex-col items-center gap-1.5 transition-transform hover:scale-105 group" onclick="event.stopPropagation()">
                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-[#c3c6d7] shadow-sm bg-white">
                                <img src="${objectUrl}" class="w-full h-full object-cover" alt="preview">
                            </div>
                            <span class="text-[10px] text-[#434655] font-medium max-w-[4.5rem] truncate" title="${file.name}">${file.name}</span>
                            <button type="button" onclick="removeFile(${index}, event)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-sm transform transition hover:scale-110">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    `;
                } else {
                    previewsHtml += `
                        <div class="relative flex flex-col items-center gap-1.5 transition-transform hover:scale-105 group" onclick="event.stopPropagation()">
                            <div class="w-16 h-16 rounded-lg border border-[#c3c6d7] bg-white flex items-center justify-center shadow-sm text-[#004ac6]">
                                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <span class="text-[10px] text-[#434655] font-medium max-w-[4.5rem] truncate" title="${file.name}">${file.name}</span>
                            <button type="button" onclick="removeFile(${index}, event)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-sm transform transition hover:scale-110">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    `;
                }
            });

            previewsHtml += `</div>`;

            content.innerHTML = `
                <div class="flex flex-col items-center w-full z-10 pointer-events-none">
                    <p class="text-sm text-[#004ac6] font-bold bg-[#e7e7f3] px-3 py-1 rounded-full mb-1 border border-[#c3c6d7]">
                        ${dt.files.length} / ${maxFiles} File Disertakan
                    </p>
                    <p class="text-xs text-[#737686]">Klik area kosong untuk menambah file lain</p>
                </div>
                ${previewsHtml}
            `;
            
            // Hapus animasi hover state
            dropzoneArea.classList.remove('py-6');
            dropzoneArea.classList.add('py-4');
        } else {
            // Tampilan Kosong (Awal)
            content.innerHTML = `
                <svg class="w-10 h-10 mb-3 text-[#737686] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                <p class="mb-1 text-sm text-[#434655] text-center"><span class="font-semibold text-[#004ac6]">Klik</span> atau <span class="font-semibold text-[#004ac6]">Tarik & Lepaskan (Drag & Drop)</span> file ke sini</p>
                <p class="text-xs text-[#737686] text-center mt-1">Mendukung: PNG, JPG, PDF, DOCX, XLSX (Maks. 5MB per file)</p>
            `;
            dropzoneArea.classList.remove('py-4');
            dropzoneArea.classList.add('py-6');
        }
    }

    // 5. Mendaftarkan Event Listener untuk Fitur Drag & Drop
    document.addEventListener("DOMContentLoaded", function() {
        // Mencegah browser membuka file saat di-drop di luar area kotak
        window.addEventListener("dragover", function(e) { e.preventDefault(); }, false);
        window.addEventListener("drop", function(e) { e.preventDefault(); }, false);

        dropzoneArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzoneArea.classList.add('border-[#004ac6]', 'bg-[#e1e2ed]');
            dropzoneArea.classList.remove('border-[#c3c6d7]', 'bg-[#faf8ff]');
        });

        dropzoneArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzoneArea.classList.remove('border-[#004ac6]', 'bg-[#e1e2ed]');
            dropzoneArea.classList.add('border-[#c3c6d7]', 'bg-[#faf8ff]');
        });

        dropzoneArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzoneArea.classList.remove('border-[#004ac6]', 'bg-[#e1e2ed]');
            dropzoneArea.classList.add('border-[#c3c6d7]', 'bg-[#faf8ff]');
            
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                processFiles(e.dataTransfer.files);
            }
        });
    });
</script>
@endsection