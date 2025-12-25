# 📚 Sistem Informasi Perpustakaan

![Dashboard Admin](foto/Dashboardadmin.png)

## 📌 Deskripsi Proyek
Sistem Informasi Perpustakaan adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan data buku, anggota, serta transaksi peminjaman dan pengembalian buku secara efisien dan terstruktur. Aplikasi ini memiliki dua jenis pengguna, yaitu **Admin** dan **Anggota**, dengan hak akses yang berbeda.

---

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi
- Login Anggota
- Registrasi Anggota
- Admin tanpa login

### 📊 Dashboard & Monitoring
- Dashboard Admin (stok buku, riwayat peminjaman, buku populer)
- Dashboard Anggota (informasi buku & peminjaman)

### 📖 Manajemen Data Buku
- Tambah Buku
- Edit Buku
- Hapus Buku
- Pencarian Buku

### 🔄 Transaksi Perpustakaan
- Peminjaman Buku
- My Book
- Pengembalian Buku
- Riwayat Peminjaman

### 📈 Laporan
- Laporan Peminjaman
- Export PDF & Excel

### 👥 Manajemen Anggota
- Tambah Anggota
- Kelola Data Anggota

---

## 🖼️ Tampilan Aplikasi

### 🔑 Halaman Autentikasi

**Login Anggota**  
![Login Anggota](foto/Loginanggota.png)

**Daftar Anggota**  
![Daftar Anggota](foto/Daftar.png)

---

### 📊 Dashboard

**Dashboard Anggota**  
![Dashboard Anggota](foto/Dashboardanggota.png)

**Dashboard Admin**  
![Dashboard Admin](foto/Dashboardadmin.png)

---

### 📖 Transaksi & Peminjaman

**My Book**  
![My Book](foto/Peminjamanbuku.png)

**Pengembalian Buku**  
![Pengembalian Buku](foto/Pengembalian.png)

**Manajemen Peminjaman**  
![Manajemen Peminjaman](foto/Laporanpinjaman.png)

---

### 📚 Manajemen Data

**Tambah Buku**  
![Tambah Buku](assets/tambahBuku.png)

**Hapus / Edit Buku**  
![Kelola Buku](assets/kelolaBuku.png)

**Tambah Anggota**  
![Tambah Anggota](assets/kelolaAnggota.png)

---

### 📈 Laporan

**Laporan Peminjaman**  
![Laporan Peminjaman](assets/laporanPeminjaman.png)

**Riwayat Peminjaman**  
![Riwayat Peminjaman](assets/riwayatPeminjaman.png)

---

## 👥 Role & Hak Akses

| Fitur | Admin | Anggota |
|------|-------|---------|
| Dashboard | ✅ Full | ✅ Terbatas |
| Data Buku | ✅ CRUD | ❌ |
| Peminjaman Buku | ✅ Kelola | ✅ Pinjam |
| Pengembalian Buku | ✅ | ❌ |
| My Book | ❌ | ✅ |
| Laporan | ✅ PDF & Excel | ❌ |
| Tambah Anggota | ✅ | ❌ |

---

## 🚀 Hak Akses Pengguna

### 🔑 Admin
- Kelola buku dan anggota
- Kelola peminjaman & pengembalian
- Cetak laporan PDF & Excel
- Monitoring aktivitas perpustakaan

### 👤 Anggota
- Login & registrasi
- Lihat katalog buku
- Pinjam buku
- Lihat riwayat peminjaman

---

## 🛠️ Teknologi yang Digunakan
- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL
- Export: PDF & Excel
- Session: PHP Session Management
