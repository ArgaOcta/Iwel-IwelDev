<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 1. Logika Pencarian (Nama, Email, atau NIM/NIP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%"); 
            });
        }

        // 2. Logika Filter Role
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // 3. Logika Filter Status 
        // Asumsi kamu memiliki kolom 'status' di tabel users (berisi 'active' atau 'suspended')
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Ambil data dengan Pagination (10 baris per halaman)
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.user', compact('users'));
    }

    // Fungsi untuk Mengubah Status User (Suspend / Reactivate)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Cek status saat ini dan balikkan
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui!');
    }
}