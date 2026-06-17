<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Diperbaiki agar VS Code tidak terlalu banyak merah

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%"); 
            });
        }

        // Logika Filter Role & Status
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.user', compact('users'));
    }

    // --- FUNGSI TAMBAH USER BARU ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,admin,superadmin',
            'nim' => 'nullable|string|max:50',
        ]);

        // PROTEKSI: Admin biasa tidak boleh membuat akun Super Admin
        if (Auth::user()->role === 'admin' && $request->role === 'superadmin') {
            return back()->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk membuat akun Super Admin.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->nim,
            'status' => 'active', 
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan!');
    }

    // --- FUNGSI EDIT USER ---
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:mahasiswa,admin,superadmin',
            'nim' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8', 
        ]);

        // PROTEKSI 1: Cegah ganti role diri sendiri (biar gak kena 403 lagi)
        if ($user->id === Auth::id() && $request->role !== $user->role) {
            return back()->with('error', 'Tindakan Ditolak: Anda tidak bisa mengubah jabatan/role Anda sendiri.');
        }

        // PROTEKSI 2: Admin biasa tidak boleh mengedit akun Super Admin
        if (Auth::user()->role === 'admin' && $user->role === 'superadmin') {
            return back()->with('error', 'Akses Ditolak: Anda tidak berhak mengedit data Super Admin.');
        }

        // PROTEKSI 3: Admin biasa tidak boleh menaikkan jabatan user lain jadi Super Admin
        if (Auth::user()->role === 'admin' && $request->role === 'superadmin') {
            return back()->with('error', 'Akses Ditolak: Anda tidak berhak mengangkat seseorang menjadi Super Admin.');
        }

        $data = $request->only(['name', 'email', 'role', 'nim']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    // --- FUNGSI HAPUS USER ---
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // PROTEKSI 1: Tidak boleh hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // PROTEKSI 2: Admin biasa tidak boleh menghapus Super Admin
        if (Auth::user()->role === 'admin' && $user->role === 'superadmin') {
            return back()->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk menghapus Super Admin.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus secara permanen!');
    }

    // --- FUNGSI SUSPEND / REACTIVATE ---
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // PROTEKSI 1: Tidak boleh suspend diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        // PROTEKSI 2: Admin biasa tidak boleh suspend Super Admin
        if (Auth::user()->role === 'admin' && $user->role === 'superadmin') {
            return back()->with('error', 'Akses Ditolak: Anda tidak berhak mengubah status Super Admin.');
        }

        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui!');
    }
}