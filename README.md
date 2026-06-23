
<p align="center">
  <img src="https://img.shields.io/badge/Laravel-9-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 9">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">🏥 QueuePro - Sistem Antrian Digital</h1>

<p align="center">
  <a href="#-tentang-proyek">Tentang</a> •
  <a href="#-fitur-utama">Fitur</a> •
  <a href="#-struktur-file">Struktur File</a> •
  <a href="#-struktur-database">Database</a> •
  <a href="#-tech-stack">Tech Stack</a>
</p>

---

## 📖 Tentang Proyek

**QueuePro** adalah sistem antrian digital terpadu yang dirancang khusus untuk rumah sakit, klinik, dan fasilitas layanan kesehatan. Sistem ini menggantikan antrian konvensional dengan solusi digital yang modern, efisien, dan profesional.

---

## ✨ Fitur Utama

### 🌐 Untuk Pasien (Layar Display)

- 📺 **Layar Antrian Real-time** - Auto-refresh AJAX tanpa flicker
- 🔔 **Current Queue Hero** - Highlight nomor yang sedang dipanggil
- 📊 **Status Badge** - Menunggu / Menuju Loket / Selesai
- 🕐 **Jam & Tanggal Live** - Format Bahasa Indonesia
- 📢 **Running Text** - Informasi & pengumuman berjalan

### 👨‍💼 Untuk Admin/Petugas

- 🎛️ **Dashboard Interaktif** - Statistik antrian real-time
- 🔊 **Voice Calling** - Panggilan otomatis dengan Text-to-Speech
- ⏱️ **Call Timer** - Countdown 20 detik saat memanggil
- 🔒 **Locking System** - Mencegah konflik antar petugas
- 🔍 **Search Filter** - Cari pasien berdasarkan nama/resep
- 📱 **Responsive Design** - Desktop & mobile friendly

### 👑 Untuk Superadmin

- 👥 **Manajemen User** - CRUD pegawai lengkap
- 🛡️ **Role Management** - Superadmin & Admin
- 🏪 **Loket Assignment** - Penugasan loket per admin
- 🗑️ **Full Access** - Hapus & edit semua antrian

---

## 📁 Struktur File

Struktur file QueuePro mengikuti **konvensi Laravel** dengan beberapa penyesuaian untuk kebutuhan spesifik sistem antrian:

```
queuepro/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php      # Autentikasi & manajemen user
│   │   │   └── QueueController.php     # CRUD antrian & panggilan
│   │   └── Middleware/
│   │       └── RoleMiddleware.php      # Role-based access control
│   └── Models/
│       ├── Queue.php                   # Model antrian
│       └── User.php                    # Model pengguna
│
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       └── create_queues_table.php
│
├── resources/
│   └── views/
│       ├── welcome.blade.php           # Layar TV ruang tunggu
│       ├── login.blade.php             # Halaman login
│       └── admin/
│           ├── dashboard.blade.php     # Dashboard admin
│           └── users/
│               └── index.blade.php     # Manajemen user
│
├── routes/
│   └── web.php                         # Definisi route aplikasi
│
└── public/                             # Asset publik
```

### 🎯 Alasan Pemilihan Struktur

#### 1. Pemisahan Controllers Berdasarkan Domain

```
AuthController.php   → Menghandle autentikasi & user
QueueController.php  → Menghandle antrian & panggilan
```

**Alasan:**

- ✅ **Single Responsibility Principle** - Setiap controller fokus pada satu domain
- ✅ **Mudah di-maintain** - Perubahan di antrian tidak mempengaruhi autentikasi
- ✅ **Scalable** - Bisa ditambah controller baru (misal: `ReportController`) tanpa konflik
- ❌ **Alternatif yang Ditolak:** Satu controller untuk semua → akan menjadi "God Controller" yang sulit di-maintain

#### 2. Struktur Views Hierarkis

```
views/
├── welcome.blade.php        # Public (tanpa prefix)
├── login.blade.php          # Public (tanpa prefix)
└── admin/                   # Protected (folder admin)
    ├── dashboard.blade.php
    └── users/
```

**Alasan:**

- ✅ **Pemisahan Public vs Protected** - Views public di root, admin di folder `admin/`
- ✅ **Organisasi Logis** - Semua views admin terkumpul dalam satu folder
- ✅ **Mudah Ditemukan** - Developer tahu persis di mana mencari view tertentu
- ✅ **Scalable** - Bisa ditambah folder `admin/reports/`, `admin/settings/`, dll

#### 3. Models yang Sederhana

```
Queue.php  → Hanya data antrian
User.php   → Hanya data user (extend Authenticatable)
```

**Alasan:**

- ✅ **KISS Principle** - Model hanya berisi data dan relasi, business logic di controller
- ✅ **Eloquent Relationship** - `Queue` belongsTo `User` (admin yang menangani)
- ❌ **Alternatif yang Ditolak:** Fat models dengan banyak method → sulit di-test

#### 4. Middleware Role-Based

```php
Route::middleware(['role:superadmin'])->group(function () {
    // Route khusus superadmin
});
```

**Alasan:**

- ✅ **Reusable** - Middleware bisa dipakai di banyak route
- ✅ **Clean Routes** - Route file tetap ringkas dan mudah dibaca
- ✅ **Centralized Logic** - Logika pengecekan role di satu tempat
- ❌ **Alternatif yang Ditolak:** Pengecekan role di setiap controller → duplikasi kode

---

## 🗄️ Struktur Database

Database QueuePro dirancang dengan prinsip **normalisasi** dan **integritas data**. Hanya 2 tabel utama yang dibutuhkan:

### 📊 Diagram Relasi

```
┌─────────────────┐         ┌─────────────────────┐
│     users       │         │       queues        │
├─────────────────┤         ├─────────────────────┤
│ id (PK)         │◄────────│ admin_id (FK)       │
│ name            │    1:N  │ id (PK)             │
│ username        │         │ queue_date          │
│ password        │         │ queue_number        │
│ role            │         │ no_resep            │
│ loket           │         │ nama_pasien         │
│ remember_token  │         │ status              │
│ timestamps      │         │ timestamps          │
└─────────────────┘         └─────────────────────┘
```

### 📋 Detail Tabel

#### Tabel `users`

| Kolom | Tipe | Alasan |
|-------|------|--------|
| `id` | BIGINT UNSIGNED PK | Primary key auto-increment standar Laravel |
| `name` | VARCHAR(255) | Nama lengkap pegawai |
| `username` | VARCHAR(100) UNIQUE | Login identifier, lebih fleksibel dari email |
| `password` | VARCHAR(255) | Hash bcrypt (Laravel default) |
| `role` | ENUM('admin','superadmin') | Batasi role, cegah invalid data |
| `loket` | VARCHAR(50) NULLABLE | Hanya admin yang butuh loket, superadmin tidak |
| `remember_token` | VARCHAR(100) | Fitur "Ingat Saya" di login |
| `timestamps` | created_at, updated_at | Audit trail otomatis |

**Mengapa `username` bukan `email`?**

- ✅ Konteks rumah sakit/klinik: pegawai lebih familiar dengan username
- ✅ Lebih pendek, mudah diingat
- ✅ Tidak tergantung domain email perusahaan
- ❌ Email bisa berubah jika pegawai pindah

**Mengapa `loket` nullable?**

- ✅ Superadmin tidak ditugaskan di loket tertentu
- ✅ Hemat storage (NULL lebih kecil dari string kosong)
- ✅ Query lebih mudah: `WHERE loket IS NOT NULL`

#### Tabel `queues`

| Kolom | Tipe | Alasan |
|-------|------|--------|
| `id` | BIGINT UNSIGNED PK | Primary key standar |
| `queue_date` | DATE | Pisahkan tanggal agar bisa query per hari |
| `queue_number` | INT UNSIGNED | Nomor urut, auto-increment per hari |
| `no_resep` | VARCHAR(100) | Nomor resep dari dokter |
| `nama_pasien` | VARCHAR(255) | Nama pasien |
| `status` | ENUM('menunggu','dipanggil','selesai') | State machine yang jelas |
| `admin_id` | BIGINT UNSIGNED FK NULLABLE | Tracking siapa yang menangani |
| `timestamps` | created_at, updated_at | Audit trail |

### 🎯 Alasan Pemilihan Struktur Database

#### 1. Pemisahan `queue_date` dan `queue_number`

```php
// ❌ SALAH: Menggunakan timestamp untuk nomor antrian
'queue_number' => '20260624001'  // Sulit di-query, boros storage

// ✅ BENAR: Pisahkan tanggal dan nomor
'queue_date' => '2026-06-24',
'queue_number' => 1
```

**Alasan:**

- ✅ **Mudah di-query per hari:** `WHERE queue_date = today()`
- ✅ **Nomor antrian kecil:** Hanya 1, 2, 3 (bukan 20260624001)
- ✅ **Reset harian otomatis:** Max `queue_number` per hari
- ✅ **Reporting mudah:** Hitung antrian per tanggal

#### 2. Status sebagai ENUM String

```php
// ❌ SALAH: Menggunakan integer
'status' => 1  // Apa artinya 1? Menunggu? Dipanggil?

// ✅ BENAR: Menggunakan ENUM string
'status' => 'menunggu'  // Self-documenting, mudah dibaca
```

**Alasan:**

- ✅ **Self-documenting** - Nilai menjelaskan dirinya sendiri
- ✅ **Mudah di-debug** - Langsung terlihat status di database
- ✅ **Type-safe** - Database menolak nilai invalid
- ✅ **Blade friendly** - `@if($q->status == 'menunggu')` lebih readable

#### 3. Foreign Key `admin_id` untuk Locking

```php
// Saat admin memanggil antrian
$queue->update([
    'status' => 'dipanggil',
    'admin_id' => auth()->id()  // Kunci ke admin ini
]);

// Admin lain tidak bisa edit
if ($queue->admin_id !== auth()->id()) {
    abort(403, 'Antrian sedang ditangani admin lain');
}
```

**Alasan:**

- ✅ **Mencegah konflik** - 2 admin tidak bisa handle antrian yang sama
- ✅ **Audit trail** - Tahu siapa yang menangani antrian
- ✅ **Nullable** - Antrian baru belum di-handle siapa pun
- ✅ **Superadmin bypass** - Superadmin bisa edit semua (override)

#### 4. Tidak Ada Tabel `loket` Terpisah

```php
// ❌ OVER-ENGINEERING: Membuat tabel loket
loket: id, nama_loket, keterangan
users: loket_id (FK)

// ✅ SIMPLE: Langsung di users
users: loket (VARCHAR)
```

**Alasan:**

- ✅ **Yakni principle** - "You Aren't Gonna Need It"
- ✅ **Loket sederhana** - Hanya "Loket 1", "Loket 2", tidak butuh tabel terpisah
- ✅ **Performa** - Tidak perlu JOIN untuk tampilkan loket
- ❌ **Jika loket kompleks** (ada jadwal, kapasitas, dll) → baru pisah tabel

---

## 🛠️ Tech Stack

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **Laravel** | 9.x | Backend framework |
| **PHP** | 8.2+ | Server-side language |
| **MySQL** | 8.0+ | Database |
| **Bootstrap** | 5.3 | CSS framework |
| **Font Awesome** | 6.4 | Icons |
| **jQuery** | 3.6 | DOM manipulation |
| **SweetAlert2** | 11.x | Beautiful alerts |
| **Web Speech API** | Native | Text-to-Speech |
| **AJAX** | Fetch API | Smooth refresh |
