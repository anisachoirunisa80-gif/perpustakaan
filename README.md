# 📚 Sistem Informasi Perpustakaan  

> Aplikasi web untuk mengelola **data buku**, **anggota**, serta **peminjaman & pengembalian buku** secara terstruktur dan efisien.  
> Dirancang untuk kebutuhan **perpustakaan sekolah / kampus** dengan sistem **dua role (Admin & Anggota)**.

---

## ✨ Fitur Unggulan

### 🔐 Autentikasi & Akses
- Login khusus anggota perpustakaan
- Registrasi akun anggota baru
- Admin memiliki akses penuh tanpa registrasi
- Hak akses dibatasi berdasarkan role

### 📊 Dashboard & Monitoring
- Dashboard admin dengan informasi lengkap
- Dashboard anggota dengan informasi peminjaman pribadi
- Monitoring buku yang sedang dipinjam
- Informasi buku populer

### 📖 Manajemen Buku
- Tambah, edit, dan hapus data buku
- Pencarian buku berdasarkan judul
- Informasi stok buku tersedia
- Detail buku lengkap

### 🔄 Transaksi Perpustakaan
- Peminjaman buku oleh anggota
- My Book untuk memantau pinjaman
- Pengembalian buku oleh admin
- Riwayat peminjaman

### 📈 Laporan
- Laporan peminjaman buku
- Export PDF & Excel
- Arsip data perpustakaan

---

## 🖼️ Tampilan Aplikasi & Fungsinya

### 🔐 Login Anggota
<p align="center">
  <img src="foto/Loginanggota.png" width="70%">
</p>

**Fungsi:**
- Autentikasi akun anggota perpustakaan  
- Menjaga keamanan sistem  
- Mengarahkan anggota ke dashboard  

---

### 📝 Registrasi Anggota
<p align="center">
  <img src="foto/Daftaranggota.png" width="70%">
</p>

**Fungsi:**
- Pendaftaran akun anggota baru  
- Menyimpan data anggota ke database  
- Memberikan akses peminjaman buku  

---

### 👤 Dashboard Anggota
<p align="center">
  <img src="foto/Dashboardanggota.png" width="85%">
</p>

**Fungsi:**
- Melihat buku yang tersedia  
- Melihat status peminjaman pribadi  
- Akses ke fitur pencarian dan My Book  

---

### 📖 My Book
<p align="center">
  <img src="foto/Mybook.png" width="80%">
</p>

**Fungsi:**
- Menampilkan daftar buku yang dipinjam  
- Menampilkan tanggal pinjam & pengembalian  
- Membantu anggota memantau pinjaman  

---

### 🧭 Dashboard Admin
<p align="center">
  <img src="foto/Dashboardadmin.png" width="85%">
</p>

**Fungsi:**
- Monitoring stok dan aktivitas perpustakaan  
- Akses cepat ke seluruh fitur admin  
- Ringkasan data buku & peminjaman  

---

### 🔍 Pencarian Buku
<p align="center">
  <img src="foto/Pencarianbuku.png" width="80%">
</p>

**Fungsi:**
- Mencari buku berdasarkan judul  
- Menampilkan ketersediaan buku  
- Mempermudah proses peminjaman  

---

### 📘 Peminjaman Buku
<p align="center">
  <img src="foto/Peminjamanbuku.png" width="80%">
</p>

**Fungsi:**
- Mencatat transaksi peminjaman buku  
- Mengurangi stok secara otomatis  
- Menyimpan data tanggal peminjaman  

---

### 🔄 Pengembalian Buku
<p align="center">
  <img src="foto/Pengembalian.png" width="80%">
</p>

**Fungsi:**
- Memproses pengembalian buku  
- Mengembalikan stok buku  
- Menyelesaikan status peminjaman  

---

### 📚 Kelola Buku
<p align="center">
  <img src="foto/Hapusbuku.png" width="80%">
</p>

**Fungsi:**
- Edit & hapus data buku  
- Menjaga keakuratan koleksi  
- Mengelola stok buku  

---

### ➕ Tambah Buku
<p align="center">
  <img src="foto/Tambahbukubaru.png" width="80%">
</p>

**Fungsi:**
- Menambahkan buku baru  
- Menginput detail buku  
- Memperbarui koleksi perpustakaan  

---

### 👥 Kelola Anggota
<p align="center">
  <img src="foto/Tambahanggota.png" width="80%">
</p>

**Fungsi:**
- Mengelola data anggota  
- Menambah anggota baru  
- Mendukung proses peminjaman  

---

### 📊 Laporan Peminjaman
<p align="center">
  <img src="foto/Laporanpinjaman.png" width="85%">
</p>

**Fungsi:**
- Menampilkan laporan peminjaman  
- Rekap data perpustakaan  
- Export laporan ke PDF & Excel  

---

## 👥 Role & Hak Akses

| Fitur | Admin | Anggota |
|------|-------|---------|
| Dashboard | ✅ Full | ✅ Full |
| Data Buku | ✅ CRUD | 👁️ View |
| Peminjaman | ✅ Kelola | ✅ Pinjam |
| Pengembalian | ✅ Ya | ❌ Tidak |
| My Book | ❌ Tidak | ✅ Ya |
| Laporan | ✅ Ya | ❌ Tidak |
| Tambah Anggota | ✅ Ya | ❌ Tidak |

---

## 🛠️ Teknologi

- **Backend:** PHP  
- **Database:** MySQL  
- **Export:** PDF & Excel  
- **Session:** PHP Session  

---

✨ *Dikembangkan sebagai sistem informasi perpustakaan yang modern, rapi, dan mudah digunakan.*
