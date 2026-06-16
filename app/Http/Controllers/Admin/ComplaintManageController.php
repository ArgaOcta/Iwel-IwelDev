<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintResponse; // Pastikan model ini di-import

class ComplaintManageController extends Controller
{
    /**
     * Menampilkan daftar semua pengaduan dengan filter dan pencarian
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qUser) use ($search) {
                      $qUser->where('name', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }

        // Logika Filter Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Logika Filter Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.complainmanagement', compact('complaints', 'categories'));
    }

    /**
     * Menampilkan detail spesifik pengaduan untuk ditangani Admin
     */
    public function show($id)
    {
        // Pastikan memanggil relasi 'responses.user' agar timeline bisa menampilkan nama pembalas
        $complaint = Complaint::with(['user', 'category', 'attachments', 'responses.user'])->findOrFail($id);

        return view('admin.complaintresolution', compact('complaint'));
    }

    /**
     * FUNGSI BARU: Menyimpan balasan/tanggapan dari Admin
     */
    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);

        // Simpan data balasan ke database
        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(), // Mengambil ID admin yang sedang login
            'message' => $request->response,
            'is_internal' => $request->has('is_internal') ? true : false,
        ]);

        // Opsional cerdas: Jika status masih 'Pending', ubah otomatis menjadi 'In Progress' karena admin sudah mulai merespons
        if ($complaint->status === 'Pending') {
            $complaint->update(['status' => 'In Progress']);
        }

        return back()->with('success', 'Balasan berhasil diposting!');
    }
}