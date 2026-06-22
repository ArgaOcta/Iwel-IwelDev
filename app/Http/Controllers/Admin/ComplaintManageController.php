<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintResponse;
use App\Models\AuditLog; 

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
        // Memanggil relasi responses dan auditLogs
        $complaint = Complaint::with(['user', 'category', 'attachments', 'responses.user', 'auditLogs'])->findOrFail($id);

        return view('admin.complaintresolution', compact('complaint'));
    }

    /**
     * Menyimpan balasan/tanggapan dari Admin
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
            'user_id' => auth()->id(),
            'message' => $request->response,
            'is_internal' => $request->filled('is_internal'),
        ]);

        // Opsional cerdas: Jika status masih 'Pending', ubah otomatis menjadi 'In Progress'
        if ($complaint->status === 'Pending') {
            $oldStatus = $complaint->status;
            $newStatus = 'In Progress';
            
            $complaint->update(['status' => $newStatus]);
            
            // Mencatat log perubahan status
            AuditLog::create([
                'user_id' => auth()->id(),
                'complaint_id' => $complaint->id,
                'action' => 'Auto Update (Admin Response)',
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);
        }

        return back()->with('success', 'Balasan berhasil diposting!');
    }

    /**
     * Memperbarui Status Pengaduan secara Manual dan Mencatat Log 
     */
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,Reviewing,In Progress,Resolved,Rejected,Closed'
        ]);

        $oldStatus = $complaint->status;
        $newStatus = $request->status;

        if ($oldStatus !== $newStatus) {
            $complaint->update(['status' => $newStatus]);

            // Mencatat log perubahan status manual
            AuditLog::create([
                'user_id' => auth()->id(),
                'complaint_id' => $complaint->id,
                'action' => 'Manual Status Update', 
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);
        }

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    /**
     * Menghapus Pengaduan beserta data terkait
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        // Catatan: Jika ada logic untuk menghapus file fisik lampiran dari Storage, letakkan di sini
        // foreach($complaint->attachments as $attachment) { Storage::delete($attachment->file_path); }

        $complaint->delete();

        return back()->with('success', 'Tiket pengaduan berhasil dihapus permanen.');
    }
}