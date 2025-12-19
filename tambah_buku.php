<?php
// tambah_buku.php
include 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Cek apakah semua field ada pada $_POST
    if (isset($_POST['judul'], $_POST['pengarang'], $_POST['tahun_terbit'], $_POST['stok'])) {
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $stok = $_POST['stok'];

        // Validasi sederhana: pastikan judul tidak kosong
        if (empty($judul)) {
            $error = "Judul tidak boleh kosong!";
        } else {
            try {
                $sql = "INSERT INTO buku (judul, pengarang, tahun_terbit, stok) VALUES (:judul, :pengarang, :tahun_terbit, :stok)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':judul' => $judul,
                    ':pengarang' => $pengarang,
                    ':tahun_terbit' => $tahun_terbit,
                    ':stok' => $stok,
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
<h3>Tambah Buku</h3>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="POST">
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Pengarang</label>
        <input type="text" name="pengarang" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
<?php include 'footer.php'; ?>
