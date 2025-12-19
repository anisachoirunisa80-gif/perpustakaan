<?php
// tambah_buku.php
include 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan semua field ada
    if (isset($_POST['judul'], $_POST['pengarang'], $_POST['tahun_terbit'], $_POST['stok'], $_POST['cover'])) {
        $judul        = $_POST['judul'];
        $pengarang    = $_POST['pengarang'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $stok         = $_POST['stok'];
        $cover        = $_POST['cover']; // URL gambar cover

        // Validasi sederhana: cek apakah judul tidak kosong
        if (empty($judul)) {
            $error = "Judul tidak boleh kosong!";
        }

        if (empty($error)) {
            try {
                $sql = "INSERT INTO buku (judul, pengarang, tahun_terbit, stok, cover) 
                        VALUES (:judul, :pengarang, :tahun_terbit, :stok, :cover)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':judul'        => $judul,
                    ':pengarang'    => $pengarang,
                    ':tahun_terbit' => $tahun_terbit,
                    ':stok'         => $stok,
                    ':cover'        => $cover,
                ]);
                header('Location: tambah_buku.php');
                exit();
            } catch (PDOException $e) {
                $error = "Gagal menyimpan data buku: " . $e->getMessage();
            }
        }
    } else {
        $error = "Data tidak lengkap, pastikan semua field diisi!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="card-title mb-0 text-primary">
                        <i class="fas fa-book-medical me-2"></i>Tambah Buku Baru
                    </h3>
                    <p class="text-muted mb-0">Isi form berikut untuk menambahkan buku ke katalog</p>
                </div>
                
                <div class="card-body pt-1">
                    <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div class="flex-grow-1"><?= htmlspecialchars($error) ?></div>
                    </div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">Judul Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-heading text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="judul" 
                                       class="form-control ps-3"
                                       placeholder="Masukkan judul buku"
                                       required>
                            </div>
                        </div>

                        <!-- Pengarang -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">Pengarang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-edit text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="pengarang" 
                                       class="form-control ps-3"
                                       placeholder="Nama pengarang"
                                       required>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Tahun Terbit -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label text-muted fw-medium">Tahun Terbit</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar-alt text-muted"></i>
                                        </span>
                                        <input type="number" 
                                               name="tahun_terbit" 
                                               class="form-control ps-3"
                                               min="1900" 
                                               max="<?= date('Y') + 1 ?>"
                                               placeholder="Tahun terbit"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label text-muted fw-medium">Stok Awal</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-cubes text-muted"></i>
                                        </span>
                                        <input type="number" 
                                               name="stok" 
                                               class="form-control ps-3"
                                               min="1" 
                                               placeholder="Jumlah stok"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cover -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">URL Cover Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-image text-muted"></i>
                                </span>
                                <input type="url" 
                                       name="cover" 
                                       class="form-control ps-3"
                                       placeholder="https://example.com/cover.jpg"
                                       required>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-2"></i>
                                Gunakan URL gambar yang valid (contoh: .jpg, .png)
                            </small>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" 
                                    class="btn btn-primary btn-lg fw-medium py-2">
                                <i class="fas fa-save me-2"></i>Simpan Buku
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        margin-top: 2rem;
    }
    
    .input-group-text {
        min-width: 45px;
        justify-content: center;
    }
    
    .form-control {
        border-left: 0;
        padding-left: 0;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2c3e50, #3498db);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
</style>
<?php include 'footer.php'; ?>
