# 📚 Sistem Informasi Perpustakaan

Aplikasi web untuk mengelola **data buku**, **anggota**, serta **peminjaman & pengembalian buku** secara terstruktur dan efisien.  
Dirancang untuk kebutuhan **perpustakaan sekolah / kampus** dengan sistem **dua role (Admin & Anggota)**.

---

## 🖼️ Preview Aplikasi

![Dashboard Perpustakaan](foto/Dashboardadmin.png)

**Gambar 1.** Tampilan dashboard utama Sistem Informasi Perpustakaan yang menampilkan informasi stok buku, riwayat peminjaman, serta ringkasan aktivitas perpustakaan.

---

## 📌 Deskripsi Proyek

**Sistem Informasi Perpustakaan** adalah aplikasi berbasis web yang membantu pengelolaan koleksi buku, data anggota, serta transaksi peminjaman dan pengembalian buku.  
Sistem ini mendukung **pengelolaan buku**, **manajemen anggota**, **peminjaman**, serta **laporan peminjaman** untuk mendukung operasional perpustakaan secara digital dan terstruktur.

---

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi
- Login Anggota menggunakan akun terdaftar
- Registrasi akun untuk calon anggota
- Admin memiliki akses langsung ke sistem
- Pembatasan hak akses sesuai role

---

### 📊 Dashboard & Monitoring
- Dashboard Admin menampilkan stok buku dan riwayat peminjaman
- Dashboard Anggota menampilkan informasi buku dan status pinjaman
- Monitoring buku yang sedang dipinjam
- Informasi buku populer di perpustakaan

---

### 📖 Manajemen Data Buku
- Tambah, edit, dan hapus data buku (Admin)
- Pencarian buku berdasarkan judul dan kategori
- Informasi stok buku (tersedia / dipinjam)
- Detail buku lengkap (judul, penulis, tahun terbit)

---

### 🔄 Transaksi Perpustakaan
- Peminjaman buku oleh anggota
- My Book untuk melihat buku yang sedang dipinjam
- Pengembalian buku oleh admin
- Riwayat peminjaman anggota

---

### 📈 Laporan Peminjaman
- Laporan data peminjaman buku
- Informasi anggota, ID peminjam, tanggal pinjam & kembali
- Export laporan ke **PDF** dan **Excel**
- Arsip laporan perpustakaan

---

### 👥 Manajemen Anggota
- Tambah anggota baru (Admin)
- Pengelolaan data anggota perpustakaan
- Informasi akun anggota

---

## 🖼️ Tampilan Aplikasi

### 🔑 Autentikasi & Dashboard

| Login Anggota | Daftar Anggota | Dashboard Admin |
|--------------|---------------|----------------|
| ![](foto/Loginanggota.png) | ![](foto/Daftar.png) | ![](foto/Dashboardadmin.png) |

**Gambar 2.** Halaman login anggota untuk masuk ke sistem.  
**Gambar 3.** Halaman pendaftaran akun bagi calon anggota perpustakaan.  
**Gambar 4.** Dashboard admin yang menampilkan informasi utama pengelolaan perpustakaan.

---

### 📊 Dashboard Berdasarkan Role

| Admin | Anggota |
|------|---------|
| ![](foto/Dashboardadmin.png) | ![](foto/Dashboardanggota.png) |

**Gambar 5.** Dashboard admin dengan akses penuh pengelolaan buku dan peminjaman.  
**Gambar 6.** Dashboard anggota yang menampilkan informasi buku dan status peminjaman pribadi.

---

### 📖 Data & Peminjaman Buku

| My Book | Pengembalian Buku | Peminjaman |
|--------|------------------|------------|
| ![](foto/Peminjamanbuku.png) | ![](foto/Pengembalian.png) | ![](foto/Laporanpinjaman.png) |

**Gambar 7.** Halaman My Book yang menampilkan daftar buku yang sedang dipinjam oleh anggota.  
**Gambar 8.** Halaman pengembalian buku yang digunakan admin untuk memproses pengembalian.  
**Gambar 9.** Halaman peminjaman buku untuk mengelola transaksi peminjaman anggota.

---

### 📚 Manajemen Buku

| Hapus / Edit Buku | Tambah Buku | Tambah Anggota |
|------------------|------------|---------------|
| ![](foto/Hapusbuku.png) | ![](foto/Tambahbukubaru.png) | ![](foto/Tambahanggota.png) |

**Gambar 10.** Halaman kelola buku untuk mengedit dan menghapus data buku.  
**Gambar 11.** Halaman tambah buku untuk menambahkan koleksi buku baru.  
**Gambar 12.** Halaman tambah anggota untuk memasukkan data anggota baru ke sistem.

---

### 📈 Laporan & Riwayat

| Laporan Peminjaman | Riwayat Peminjaman |
|-------------------|-------------------|
| ![](foto/Laporanpinjaman.png) | ![](foto/Dashboardadmin.png) |

**Gambar 13.** Halaman laporan peminjaman buku yang dapat diekspor ke PDF dan Excel.  
**Gambar 14.** Halaman riwayat peminjaman buku anggota.

---

## 👥 Role & Hak Akses

| Fitur | Admin | Anggota |
|------|-------|---------|
| Dashboard | ✅ Full Access | ✅ Limited |
| Data Buku | ✅ CRUD | 👁️ View |
| Peminjaman Buku | ✅ Kelola | ✅ Pinjam |
| Pengembalian Buku | ✅ Ya | ❌ Tidak |
| My Book | ❌ | ✅ Ya |
| Laporan | ✅ + Export | 👁️ View |
| Tambah Anggota | ✅ Ya | ❌ Tidak |

---

## 🛠️ Teknologi yang Digunakan

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP (Native / MVC)
- **Database:** MySQL
- **Export:** PDF & Excel
- **Session:** PHP Session Management

---



✨ *Dikembangkan sebagai sistem informasi perpustakaan yang sederhana, rapi, dan mudah digunakan.*
