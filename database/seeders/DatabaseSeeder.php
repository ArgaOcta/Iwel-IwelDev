<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Super Admin (Pimpinan) untuk Akses Analitik
        User::create([
            'name' => 'Pimpinan Institusi',
            'nim' => null,
            'email' => 'superadmin@kampus.ac.id',
            'password' => Hash::make('password123'), // Password untuk login
            'role' => 'superadmin',
            'program_studi' => null,
        ]);

        // 2. Membuat Akun Admin Departemen (Staf Unit Kerja)
        User::create([
            'name' => 'Staf Sarpras & Fasilitas',
            'nim' => null,
            'email' => 'admin.sarpras@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'program_studi' => null,
        ]);

        // 3. Membuat Akun Mahasiswa Contoh untuk Testing Submit Pengaduan
        User::create([
            'name' => 'Ahmad Mahasiswa',
            'nim' => '0110224001',
            'email' => 'mahasiswa@mhs.kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'program_studi' => 'Teknik Informatika',
        ]);

        // 4. Membuat Data Kategori Keluhan Awal sesuai Ruang Lingkup PRD
        Category::create([
            'name' => 'Fasilitas & Sarpras',
            'description' => 'Keluhan terkait AC kelas, proyektor rusak, kursi patah, atau fasilitas fisik lainnya.',
            'department' => 'Bagian Sarana dan Prasarana',
        ]);

        Category::create([
            'name' => 'Layanan Akademik',
            'description' => 'Keluhan terkait pengurusan KRS, jadwal kuliah, atau surat keterangan mahasiswa.',
            'department' => 'Bagian Administrasi Akademik',
        ]);

        Category::create([
            'name' => 'Keuangan & Pembayaran',
            'description' => 'Keluhan terkait sistem pembayaran UKT, beasiswa, atau birokrasi keuangan.',
            'department' => 'Bagian Keuangan',
        ]);
    }
}