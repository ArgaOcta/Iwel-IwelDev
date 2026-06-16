<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintResponse;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    /**
     * 1. Menampilkan detail spesifik dari sebuah pengaduan
     */
    public function show($id, Request $request)
    {
        // Pastikan pengguna hanya bisa membuka detail keluhan miliknya sendiri
        $complaint = Complaint::with(['user', 'category', 'attachments', 'responses.user'])
            ->findOrFail($id);

        return view('mahasiswa.complaintdetail', compact('complaint'));
    }

    /**
     * 2. Menampilkan halaman riwayat pengaduan (History)
     */
    public function index(Request $request)
    {
        // Jalankan query dasar pengaduan milik user aktif
        $query = Complaint::with('category')->where('user_id', $request->user()->id);

        // Filter 1: Fitur Pencarian Kata Kunci (Berdasarkan Judul atau Nomor Tiket)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_no', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        // Filter 2: Dropdown Pilihan Status
        if ($request->filled('status') && $request->status !== 'All Statuses') {
            $query->where('status', $request->status);
        }

        // Filter 3: Dropdown Urutan Tanggal (Terbaru / Terlama)
        if ($request->get('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // Default terbaru
        }

        // Ambil data dengan pagination, pertahankan query string di URL saat pindah halaman
        $complaints = $query->paginate(5)->withQueryString();
            
        return view('mahasiswa.mycomplainthistory', compact('complaints'));
    }

    /**
     * 3. Menampilkan halaman form pembuatan pengaduan baru
     */
    public function create()
    {
        // Mengambil semua data kategori dari database untuk mengisi opsi dropdown
        $categories = Category::all();
        
        return view('mahasiswa.submitcomplaint', compact('categories'));
    }

    /**
     * 4. Memproses dan menyimpan pengaduan baru (Mendukung Multi-Upload hingga 5 file)
     */
    public function store(Request $request)
    {
        // Validasi input form, termasuk validasi array attachment
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'description' => 'required|string',
            'attachment' => 'nullable|array|max:5', // Maksimal 5 file
            'attachment.*' => 'file|mimes:png,jpg,jpeg,pdf|max:10240', // Maksimal 10MB per file
        ]);

        // Buat Nomor Tiket Otomatis (Format: CMP-TahunBulan-HurufAcak)
        $ticket_no = 'CMP-' . date('ym') . '-' . strtoupper(Str::random(4));

        // Simpan data inti ke tabel complaints terlebih dahulu
        $complaint = Complaint::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'ticket_no' => $ticket_no,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending',
            'priority' => $request->priority,
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
        ]);

        // Proses penyimpanan file jika pengguna mengunggah lampiran
        if ($request->hasFile('attachment')) {
            // Lakukan perulangan (loop) untuk setiap file yang diunggah
            foreach ($request->file('attachment') as $file) {
                // Simpan file secara fisik ke direktori storage/app/public/attachments
                $filePath = $file->store('attachments', 'public');
                
                // Simpan jejak/relasi file tersebut ke tabel attachments
                $complaint->attachments()->create([
                    'file_path' => $filePath,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
        

        // Alihkan (Redirect) kembali ke halaman dashboard dengan membawa pesan sukses
        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil dikirim dengan Nomor Tiket: ' . $ticket_no);
    }

    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);

        // Simpan data balasan ke database
        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'message' => $request->response,
            'is_internal' => $request->has('is_internal') ? true : false,
        ]);

        // Opsional cerdas: Jika status masih 'Pending', ubah otomatis menjadi 'In Progress' karena admin sudah merespons
        if ($complaint->status === 'Pending') {
            $complaint->update(['status' => 'In Progress']);
        }

        return back()->with('success', 'Balasan berhasil diposting!');
    }
}