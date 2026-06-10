# Product Requirements Document (PRD)
## Student Complaint Management System (SCMS)

| | |
|---|---|
| **Versi** | 1.0 |
| **Status** | Draft |
| **Tech Stack** | Laravel + Tailwind CSS |
| **Database** | MySQL |

---

## Daftar Isi

1. [Pendahuluan](#1-pendahuluan)
2. [Gambaran Produk](#2-gambaran-produk)
3. [Tech Stack & Arsitektur Sistem](#3-tech-stack--arsitektur-sistem)
4. [Spesifikasi Fitur Fungsional](#4-spesifikasi-fitur-fungsional)
5. [Kebutuhan Non-Fungsional](#5-kebutuhan-non-fungsional)
6. [Alur Proses Utama](#6-alur-proses-utama)
7. [Manajemen Risiko Teknis](#7-manajemen-risiko-teknis)
8. [Timeline Pengembangan](#8-timeline-pengembangan)
9. [Kriteria Keberhasilan](#9-kriteria-keberhasilan)

---

## 1. Pendahuluan

### 1.1 Latar Belakang

Di lingkungan kampus, aspirasi dan keluhan mahasiswa merupakan instrumen vital dalam peningkatan mutu layanan dan fasilitas. Namun selama ini, penyampaian pengaduan masih bergantung pada media informal yang tidak terstruktur — mulai dari grup WhatsApp, direct message ke staf tertentu, hingga keluhan di media sosial. Kondisi ini menyebabkan pengaduan sulit dipantau, sulit ditindaklanjuti secara sistematis, dan rawan tidak tertangani sama sekali.

**Student Complaint Management System (SCMS)** hadir sebagai solusi digital resmi berbasis web yang memberikan satu saluran terpusat, transparan, dan terstruktur bagi seluruh pemangku kepentingan kampus — mahasiswa, admin departemen, dan pimpinan institusi.

### 1.2 Tujuan Dokumen

Dokumen PRD ini bertujuan untuk:

- Mendefinisikan kebutuhan fungsional dan non-fungsional sistem SCMS secara lengkap
- Menjadi acuan teknis bagi tim developer (Laravel + Tailwind CSS) dalam proses implementasi
- Menjadi landasan QA dalam menyusun test plan dan skenario pengujian
- Memastikan seluruh deliverable selaras dengan MOV dan Project Charter yang telah disepakati

### 1.3 Ruang Lingkup Dokumen

PRD ini mencakup seluruh fitur yang akan dikembangkan pada fase pertama (Go-Live 23 Juni 2026), meliputi modul autentikasi, modul pengaduan mahasiswa, modul manajemen admin, modul pelaporan & analitik, serta spesifikasi teknis implementasi dengan Laravel + Tailwind CSS.

### 1.4 Referensi Dokumen

| Dokumen | Keterangan | Tanggal |
|---|---|---|
| Project Charter SCMS | Dokumen inisiasi dan perencanaan proyek | 28 April 2026 |
| Software Development Plan (SDP) | WBS, DSC, Use Case Diagram, Estimasi | Mei 2026 |
| MOV Agreement | Measurable Organizational Value yang disepakati tim | April 2026 |

---

## 2. Gambaran Produk

### 2.1 Deskripsi Produk

SCMS (Student Complaint Management System) adalah aplikasi web berbasis **Laravel** yang dibangun dengan antarmuka **Tailwind CSS**. Sistem ini berfungsi sebagai platform digital resmi bagi mahasiswa untuk mengajukan pengaduan terkait fasilitas, layanan akademik, dan administrasi kampus, sekaligus menyediakan panel manajemen lengkap bagi admin dan dashboard pelaporan bagi pimpinan.

### 2.2 Visi Produk

> *"Menjadi satu-satunya platform digital resmi pengaduan kampus yang transparan, responsif, dan berbasis data — sehingga setiap suara mahasiswa didengar dan ditindaklanjuti."*

### 2.3 Measurable Organizational Value (MOV)

| No | Pernyataan MOV | Kategori | Indikator Pengukuran |
|---|---|---|---|
| 1 | Mengurangi waktu pengelolaan laporan minimal 30% vs sistem manual | Improve – Efisiensi Operasional | Perbandingan waktu rata-rata sebelum & sesudah sistem |
| 2 | Tingkat penyelesaian laporan minimal 80% dari total laporan masuk | Increase – Kualitas Layanan | Persentase tiket berstatus Resolved |
| 3 | Waktu respons admin maksimal 1×24 jam pada hari kerja | Improve – Efektivitas Proses | Rata-rata waktu first response admin |
| 4 | Kepuasan mahasiswa ≥ 80% berdasarkan survei pasca implementasi | Improve – Kepuasan Pengguna | Hasil survei kepuasan pengguna |
| 5 | Mayoritas mahasiswa aktif menggunakan SCMS sebagai saluran resmi | Better – Perbaikan Proses | Rasio pengguna aktif / total mahasiswa |
| 6 | Laporan statistik otomatis tersedia sebagai bahan evaluasi manajemen | Do New Things – Inovasi | Ketersediaan laporan analitik bulanan |

### 2.4 Aktor & Peran Pengguna

| Aktor | Peran | Akses Utama |
|---|---|---|
| **Mahasiswa** | Pelapor pengaduan | Submit pengaduan, lacak status tiket, berikan tanggapan, lihat riwayat |
| **Admin / Staf Departemen** | Pengelola pengaduan | Dashboard admin, kelola tiket, update status, disposisi, beri tanggapan |
| **Super Admin / Pimpinan** | Pengawas & pelaporan | Dashboard analitik, laporan statistik, export data, manajemen pengguna |

### 2.5 Batasan Sistem

#### ✅ In Scope

- Modul autentikasi multi-role (Mahasiswa, Admin, Super Admin) berbasis Laravel Breeze
- Modul pengajuan & pengelolaan pengaduan dengan kategori, prioritas, dan lampiran
- Fitur pengaduan anonim dengan enkripsi identitas
- Real-time status tracking via dashboard mahasiswa
- Panel admin: disposisi, tanggapan, update status, close ticket
- Notifikasi email otomatis via Laravel Mail (SMTP/Queue)
- Dashboard analitik & export laporan (PDF / Excel) untuk Super Admin
- Role-Based Access Control (RBAC) menggunakan Laravel Gates & Policies

#### ❌ Out of Scope

- Aplikasi mobile native (Android/iOS) — hanya akses via browser (responsive web)
- Integrasi otomatis sistem pembayaran atau sistem nilai akademik
- Live Chat / Video Call — komunikasi asinkron melalui komentar tiket
- Migrasi data pengaduan lama dari WhatsApp / media sosial
- Eksekusi tindakan fisik (perbaikan gedung, perubahan kebijakan, dll.)

---

## 3. Tech Stack & Arsitektur Sistem

### 3.1 Stack Teknologi

| Layer | Teknologi | Versi | Keterangan |
|---|---|---|---|
| Backend Framework | Laravel | 11.x | MVC, Eloquent ORM, Artisan CLI, Queue, Jobs |
| Frontend Styling | Tailwind CSS | 4.x | Utility-first CSS, responsive grid, custom components |
| Templating Engine | Blade | Laravel 11 | Server-side rendering, component, layout inheritance |
| Database | MySQL | 8.0+ | Relasional, migrasi via Artisan, Eloquent query builder |
| Autentikasi | Laravel Breeze | 2.x | Session-based auth, CSRF protection, multi-role |
| Otorisasi | Laravel Gates & Policies | Built-in | Role-Based Access Control (RBAC) untuk 3 role |
| Email Notifikasi | Laravel Mail + Mailtrap/SMTP | Built-in | Mailable class, queue-based sending |
| File Storage | Laravel Storage | Built-in | Upload bukti pengaduan (PDF, JPG, PNG, maks 5MB) |
| Export PDF | barryvdh/laravel-dompdf | 3.x | Template laporan profesional |
| Export Excel | maatwebsite/laravel-excel | 3.x | Raw data + sheet ringkasan statistik |
| Charting | Chart.js | 4.x | Grafik interaktif dashboard analitik |
| Build Tool | Vite | 5.x | Bundling asset JS/CSS, Hot Module Replacement |
| Version Control | Git + GitHub | — | Branching: `main` / `develop` / `feature/*` |
| Project Management | Jira | Cloud | Sprint planning, issue tracking, burndown chart |
| Desain UI/UX | Figma | Cloud | Wireframe, prototype, design system komponen |
| Hosting | VPS / Shared Hosting | — | Domain + SSL (Let's Encrypt), Nginx, PHP 8.2+ |

### 3.2 Arsitektur Aplikasi

SCMS menggunakan arsitektur **monolitik berbasis MVC** dengan Laravel sebagai backend dan Blade + Tailwind CSS sebagai frontend. Operasi berat (email, export) dijalankan asinkron melalui Laravel Queue.

| Komponen | Deskripsi |
|---|---|
| **Routes** (`web.php`) | Mendefinisikan semua URL endpoint; dikelompokkan per middleware role (`auth`, `admin`, `superadmin`) |
| **Controller** | Menangani request HTTP, memanggil Service/Model, mengembalikan Blade view |
| **Service Layer** | Logika bisnis utama (`ComplaintService`, `NotificationService`, `ReportService`) — dipisah dari Controller |
| **Model + Eloquent** | Representasi tabel DB; relasi antar entitas (User, Complaint, Category, Comment, Attachment) |
| **Blade View** | Template HTML yang di-extend dari layout utama; menggunakan komponen Tailwind yang konsisten |
| **Middleware** | `RoleMiddleware` untuk RBAC; `ThrottleRequests` untuk rate limiting |
| **Laravel Queue** | Job pengiriman email dan export laporan dijalankan asinkron via database driver |
| **Storage** | Lampiran file disimpan di `storage/app/public`; diakses via symbolic link `storage:link` |

### 3.3 Struktur Database (ERD Summary)

| Tabel | Kolom Utama | Relasi |
|---|---|---|
| `users` | id, name, nim, email, password, role, program_studi | `hasMany` Complaints, `hasMany` Comments |
| `complaints` | id, user_id, category_id, title, description, status, priority, is_anonymous, ticket_no | `belongsTo` User, `hasMany` Comments, `hasMany` Attachments |
| `categories` | id, name, description, department | `hasMany` Complaints |
| `comments` | id, complaint_id, user_id, body, is_admin_reply | `belongsTo` Complaint, `belongsTo` User |
| `attachments` | id, complaint_id, file_path, file_type, file_size | `belongsTo` Complaint |
| `notifications` | id, user_id, complaint_id, type, message, is_read, sent_at | `belongsTo` User, `belongsTo` Complaint |
| `audit_logs` | id, user_id, complaint_id, action, old_status, new_status, created_at | Riwayat perubahan status tiket |

---

## 4. Spesifikasi Fitur Fungsional

> Prioritas: 🔴 High | 🟡 Medium | 🟢 Low

### 4.1 Modul Autentikasi & Manajemen Pengguna

| ID | Nama Fitur | Aktor | Prioritas | Deskripsi | Acceptance Criteria |
|---|---|---|---|---|---|
| AUTH-01 | Login Multi-Role | Semua | 🔴 High | Login via email/password dengan redirect otomatis ke dashboard sesuai role (mahasiswa / admin / superadmin) | Redirect benar per role; session dibuat; CSRF token valid |
| AUTH-02 | Registrasi Mahasiswa | Mahasiswa | 🔴 High | Mahasiswa mendaftar dengan NIM, nama, email kampus, program studi, dan password. NIM divalidasi format | Data tersimpan, email verifikasi terkirim |
| AUTH-03 | Logout | Semua | 🔴 High | Logout mengakhiri session dan menghapus token; redirect ke halaman login | Session destroyed; tidak bisa akses halaman protected |
| AUTH-04 | Lupa Password | Semua | 🟡 Medium | Reset password via link email dengan expiry 60 menit | Link terkirim; password berhasil diubah; link expired setelah dipakai |
| AUTH-05 | Manajemen User | Super Admin | 🟡 Medium | Super Admin dapat create/edit/deactivate akun admin dan mahasiswa | CRUD user berfungsi; role assignment berjalan; deactivated user tidak bisa login |

### 4.2 Modul Pengaduan Mahasiswa

| ID | Nama Fitur | Aktor | Prioritas | Deskripsi | Acceptance Criteria |
|---|---|---|---|---|---|
| COMP-01 | Form Pengajuan Pengaduan | Mahasiswa | 🔴 High | Form dengan field: judul, kategori (Akademik/Fasilitas/Keuangan/Layanan Staf), deskripsi (min. 50 karakter), tingkat urgensi (Rendah/Sedang/Tinggi) | Validasi server-side; tiket tersimpan; nomor tiket otomatis terbuat |
| COMP-02 | Upload Lampiran Bukti | Mahasiswa | 🔴 High | Upload file PDF, JPG, PNG maks. 5MB per file, maks. 3 file per pengaduan. File disimpan di storage Laravel | File tersimpan; preview ditampilkan; ukuran & tipe divalidasi |
| COMP-03 | Pengaduan Anonim | Mahasiswa | 🔴 High | Toggle "Sembunyikan Identitas" pada form. Admin hanya melihat ID anonim; data asli tetap tersimpan terenkripsi di DB | Identitas tidak tampil di panel admin; data tersimpan terenkripsi |
| COMP-04 | Tracking Status Tiket | Mahasiswa | 🔴 High | Dashboard menampilkan semua tiket milik mahasiswa beserta status real-time: Pending → Reviewing → In Progress → Resolved / Rejected | Status akurat; histori perubahan status tercatat di audit_log |
| COMP-05 | Komentar / Tanggapan pada Tiket | Mahasiswa, Admin | 🔴 High | Kolom komentar pada tiket untuk komunikasi asinkron antara mahasiswa dan admin. Admin reply ditandai badge khusus | Komentar tersimpan; notifikasi email terkirim ke pihak lawan |
| COMP-06 | Riwayat Pengaduan | Mahasiswa | 🟡 Medium | Halaman riwayat menampilkan semua pengaduan (filter: status, kategori, tanggal) dengan pagination 10 item/halaman | Filter berfungsi; pagination akurat; data sesuai user yang login |

### 4.3 Modul Admin & Pengelolaan Pengaduan

| ID | Nama Fitur | Aktor | Prioritas | Deskripsi | Acceptance Criteria |
|---|---|---|---|---|---|
| ADMIN-01 | Dashboard Admin | Admin | 🔴 High | Overview: total tiket per status, tiket baru hari ini, alert SLA breach (>20 jam tanpa respons), grafik tren mingguan via Chart.js | Data real-time; grafik akurat; badge alert muncul jika ada SLA breach |
| ADMIN-02 | Lihat & Filter Pengaduan | Admin | 🔴 High | Tabel pengaduan dengan filter: status, kategori, urgensi, tanggal. Kolom sortable. Search berdasarkan nomor tiket atau kata kunci | Filter & sort berfungsi; search accurate; pagination 15 item/hal |
| ADMIN-03 | Disposisi Pengaduan | Admin | 🔴 High | Admin dapat meneruskan tiket ke admin unit kerja lain dengan catatan disposisi | Notifikasi email ke admin tujuan; log disposisi tercatat |
| ADMIN-04 | Update Status Tiket | Admin | 🔴 High | Admin mengubah status: Pending → Reviewing → In Progress → Resolved / Rejected disertai catatan alasan | Status berubah; notifikasi email ke mahasiswa; audit log tercatat |
| ADMIN-05 | Close Ticket | Admin | 🔴 High | Admin menutup tiket setelah resolusi. Tiket yang ditutup tidak bisa diedit kembali | Status berubah ke Closed; email konfirmasi terkirim; edit diblok |
| ADMIN-06 | Manajemen Kategori | Super Admin | 🟡 Medium | CRUD kategori pengaduan dan assignment ke departemen penanggung jawab | Kategori baru muncul di form mahasiswa; departemen tersimpan |

### 4.4 Modul Notifikasi

| ID | Nama Fitur | Aktor | Prioritas | Deskripsi | Acceptance Criteria |
|---|---|---|---|---|---|
| NOTIF-01 | Email Notifikasi ke Mahasiswa | System | 🔴 High | Email dikirim via Laravel Queue ke mahasiswa saat: tiket diterima, status berubah, ada komentar admin | Email terkirim dalam <5 menit; konten akurat; queue tidak gagal |
| NOTIF-02 | Email Notifikasi ke Admin | System | 🔴 High | Email dikirim ke admin saat ada tiket baru atau tiket didisposisi ke mereka | Email terkirim; link ke tiket terkait berfungsi |
| NOTIF-03 | Notifikasi In-App | Semua | 🟡 Medium | Bell icon di navbar menampilkan jumlah notifikasi belum dibaca. Klik redirect ke tiket terkait | Badge count akurat; notifikasi tercentang read setelah diklik |
| NOTIF-04 | SLA Alert | System | 🟡 Medium | Sistem menandai tiket yang mendekati breach SLA 24 jam dengan highlight merah di dashboard admin | Alert muncul pada tiket yang belum direspons >20 jam |

### 4.5 Modul Pelaporan & Analitik

| ID | Nama Fitur | Aktor | Prioritas | Deskripsi | Acceptance Criteria |
|---|---|---|---|---|---|
| RPT-01 | Dashboard Analitik | Super Admin | 🔴 High | Grafik interaktif (Chart.js): distribusi kategori, tren bulanan, rata-rata waktu penyelesaian, top kategori keluhan, perbandingan resolved vs pending | Grafik akurat, responsif, data sesuai filter periode yang dipilih |
| RPT-02 | Export Laporan PDF | Super Admin, Admin | 🔴 High | Export rekapitulasi pengaduan periode tertentu ke PDF via `barryvdh/laravel-dompdf`. Template laporan profesional dengan header institusi | PDF ter-download; data akurat; format rapi dan terbaca |
| RPT-03 | Export Laporan Excel | Super Admin, Admin | 🔴 High | Export data pengaduan ke `.xlsx` via `maatwebsite/laravel-excel`. Sheet terpisah untuk raw data dan ringkasan statistik | File xlsx ter-download; data lengkap; sheet summary akurat |
| RPT-04 | Filter Periode Laporan | Super Admin, Admin | 🟡 Medium | Filter laporan berdasarkan: rentang tanggal, kategori, status, departemen | Filter berpengaruh pada data grafik dan export |

---

## 5. Kebutuhan Non-Fungsional

### 5.1 Keamanan (Security)

- Autentikasi berbasis session dengan CSRF token di setiap form (Laravel default)
- Password di-hash menggunakan **Bcrypt** (cost factor 12) via Laravel `Hash` facade
- Proteksi XSS: output di Blade selalu menggunakan `{{ }}` (auto-escape), bukan `{!! !!}`
- SQL Injection prevention: semua query menggunakan Eloquent ORM atau prepared statements
- Role-Based Access Control via Laravel Gates & Policies — setiap endpoint dilindungi middleware role
- Identitas pengaduan anonim dienkripsi menggunakan **AES-256-CBC** via Laravel `Crypt` facade
- File upload divalidasi tipe MIME (bukan hanya ekstensi) dan disimpan di luar public root
- HTTPS wajib di production; **HSTS** diaktifkan di konfigurasi Nginx
- Rate limiting pada endpoint login: maksimal **5 percobaan per menit per IP**

### 5.2 Performa (Performance)

- Halaman dashboard admin harus load dalam **< 3 detik** pada koneksi broadband standar
- Query database dioptimasi dengan eager loading (`with()`) untuk mencegah N+1 query problem
- Indeks database ditambahkan pada kolom: `status`, `category_id`, `user_id`, `created_at` di tabel `complaints`
- Asset CSS/JS di-bundle dan diminifikasi via Vite pada environment production
- Operasi berat (export PDF/Excel, kirim email) dijalankan asinkron melalui Laravel Queue
- Response time target **< 500ms** untuk 95% request

### 5.3 Usabilitas (Usability)

- Desain responsif **mobile-first** menggunakan breakpoint Tailwind (`sm` / `md` / `lg` / `xl`)
- Antarmuka menggunakan Bahasa Indonesia sebagai bahasa utama (`locale: id`)
- Feedback visual pada setiap aksi: loading spinner, success/error toast notification
- Form validasi menampilkan pesan error yang jelas dan spesifik di bawah field terkait
- Nomor tiket menggunakan format yang mudah dibaca: **`SCMS-YYYY-XXXXX`**
- Status tiket divisualisasikan dengan **badge berwarna** yang konsisten di seluruh halaman

### 5.4 Keandalan & Ketersediaan (Reliability)

- Target uptime minimal **99%** selama jam operasional kampus (08.00–20.00 WIB)
- Semua operasi database dibungkus dalam database transaction untuk menjaga konsistensi data
- Laravel Queue menggunakan database driver dengan **retry otomatis (maks. 3×)** untuk failed jobs
- Error logging menggunakan Laravel Log (channel: `stack`) dengan level `warning` ke atas
- Backup database dijadwalkan setiap malam via cron job Laravel Scheduler

### 5.5 Pemeliharaan (Maintainability)

- Kode mengikuti **PSR-12** coding standard dan konvensi naming Laravel
- Logika bisnis dipisah ke Service class (bukan di Controller atau Model)
- Setiap fitur dikembangkan di branch terpisah (`feature/*`) dan di-merge via Pull Request
- Unit test ditulis menggunakan PHPUnit (min. **70% code coverage** pada Service class)
- Database migration digunakan untuk semua perubahan skema; tidak ada perubahan DB manual

---

## 6. Alur Proses Utama

### 6.1 Alur Pengajuan Pengaduan (Happy Path)

| Step | Aksi | Aktor | Output / Hasil |
|---|---|---|---|
| 1 | Mahasiswa login ke SCMS | Mahasiswa | Session aktif, redirect ke dashboard mahasiswa |
| 2 | Klik "Buat Pengaduan Baru" | Mahasiswa | Form pengaduan tampil |
| 3 | Isi form: judul, kategori, deskripsi, urgensi, opsi anonim | Mahasiswa | Data tervalidasi client-side |
| 4 | Upload lampiran bukti (opsional) | Mahasiswa | File tervalidasi tipe & ukuran; preview tampil |
| 5 | Submit form | Mahasiswa | Validasi server-side; jika valid → tiket tersimpan di DB |
| 6 | Sistem generate nomor tiket (`SCMS-YYYY-XXXXX`) | System | Tiket dibuat dengan status **Pending** |
| 7 | Email konfirmasi terkirim ke mahasiswa | System (Queue) | Email berisi nomor tiket dan estimasi respons |
| 8 | Notifikasi email terkirim ke Admin departemen terkait | System (Queue) | Admin mendapat notifikasi tiket baru |
| 9 | Admin mereview dan mengubah status ke **Reviewing** | Admin | Mahasiswa menerima notifikasi email |
| 10 | Admin memberikan tanggapan / disposisi / update status | Admin | Interaksi tercatat; notifikasi terkirim |
| 11 | Admin menutup tiket (Resolved/Rejected) + catatan | Admin | Tiket berstatus **Closed**; email konfirmasi ke mahasiswa |

### 6.2 Status Lifecycle Tiket Pengaduan

```
[Pending] → [Reviewing] → [In Progress] → [Resolved] → [Closed]
                ↘                               ↗
             [Rejected]                    ————
```

| Status | Transisi Dari | Deskripsi | Siapa yang Mengubah |
|---|---|---|---|
| **Pending** | — | Tiket baru dikirim, belum diproses admin | System (otomatis saat submit) |
| **Reviewing** | Pending | Admin sedang mempelajari pengaduan | Admin |
| **In Progress** | Reviewing | Pengaduan sedang dalam proses penanganan | Admin |
| **Resolved** | In Progress | Masalah telah diselesaikan | Admin |
| **Rejected** | Pending / Reviewing | Pengaduan ditolak (di luar scope atau duplikat) | Admin |
| **Closed** | Resolved / Rejected | Tiket ditutup secara resmi; tidak bisa diedit | Admin |

---

## 7. Manajemen Risiko Teknis

| ID | Level | Risiko | Strategi Mitigasi |
|---|---|---|---|
| R-01 | 🔴 Tinggi | Kebocoran data pengaduan dan identitas mahasiswa anonim | Enkripsi AES-256 di DB, HTTPS wajib, RBAC ketat, audit log semua akses data sensitif |
| R-02 | 🔴 Tinggi | Keterlambatan pengembangan dari target timeline 2 bulan | Sprint planning 1 minggu, daily standup, freeze scope ketat, weekly progress report ke PM |
| R-03 | 🟡 Sedang | Respons admin melebihi SLA 1×24 jam | SLA alert otomatis (>20 jam), notifikasi eskalasi ke Super Admin, SOP kerja tertulis untuk admin |
| R-04 | 🟡 Sedang | Kegagalan integrasi data NIM dengan infrastruktur IT kampus | Koordinasi teknis dini dengan tim IT/Puskom; fallback: mahasiswa input NIM manual + validasi format |
| R-05 | 🟡 Sedang | Rendahnya adopsi mahasiswa karena kurang sosialisasi | Kampanye sosialisasi via kanal resmi kampus; user manual dalam Bahasa Indonesia yang simpel |
| R-06 | 🟢 Rendah | Queue email gagal menyebabkan notifikasi tidak terkirim | `failed_jobs` table; retry otomatis 3×; monitoring queue via Laravel Horizon (opsional) |
| R-07 | 🟢 Rendah | Server down menyebabkan sistem tidak dapat diakses | Backup nightly, prosedur restore terdokumentasi, SLA hosting min. 99% uptime |

---

## 8. Timeline Pengembangan

| Sprint | Milestone | Periode | Deliverable Utama | Fitur (ID) |
|---|---|---|---|---|
| S-0 | Perencanaan & Desain | 24 Apr – 9 Mei 2026 | Project Charter, SRS, Figma wireframe, ERD, setup environment Laravel + Vite | — |
| S-1 | Pengembangan Modul Inti | 10 – 25 Mei 2026 | Autentikasi multi-role, modul pengaduan dasar, CRUD admin, DB migration | AUTH-01~05, COMP-01~02 |
| S-2 | Fitur Tambahan & Integrasi | 26 Mei – 5 Jun 2026 | Anonim, komentar, disposisi, notifikasi email via Queue, tracking status | COMP-03~06, ADMIN-01~06, NOTIF-01~04 |
| S-3 | Pengujian & Revisi | 6 – 12 Jun 2026 | Test plan, pengujian fungsional & keamanan, bug fixing, UAT | Semua ID |
| S-4 | Pelatihan & Persiapan Go-Live | 13 – 19 Jun 2026 | User manual, pelatihan admin, sosialisasi mahasiswa, konfigurasi produksi | RPT-01~04 |
| S-5 | Go-Live & Monitoring | 20 – 23 Jun 2026 | Deployment produksi, monitoring aktif, hotfix bug kritis post-launch | Semua ID |

---

## 9. Kriteria Keberhasilan

| Kriteria | Target | Cara Pengukuran |
|---|---|---|
| Efisiensi pengelolaan pengaduan | Waktu proses berkurang ≥ 30% | Perbandingan waktu rata-rata sebelum & sesudah sistem |
| Tingkat penyelesaian laporan | ≥ 80% tiket berstatus Resolved | Query laporan dari dashboard Super Admin |
| Waktu respons admin (SLA) | Respons pertama ≤ 1×24 jam | Rata-rata first response dari `audit_logs` |
| Kepuasan pengguna | ≥ 80% berdasarkan survei post-launch | Google Form survei kepuasan setelah 2 minggu Go-Live |
| Adopsi platform | Mayoritas mahasiswa aktif menggunakan SCMS | Rasio user aktif / total mahasiswa terdaftar |
| Ketersediaan laporan analitik | Dashboard & export tersedia tanpa error | QA smoke test setelah Go-Live |
| Performa sistem | Load time < 3 detik; uptime ≥ 99% | Monitoring server dan Google PageSpeed Insights |