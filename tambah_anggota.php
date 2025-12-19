<?php
// tambah_anggota.php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_daftar = $_POST['tanggal_daftar'];

    $sql = "INSERT INTO anggota (nama, alamat, tanggal_daftar) VALUES (:nama, :alamat, :tanggal_daftar)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama' => $nama,
        ':alamat' => $alamat,
        ':tanggal_daftar' => $tanggal_daftar,
    ]);
    header('Location: tambah_anggota.php');
    exit();
}
?>

<?php include 'header.php'; ?>
<h3>Tambah Anggota</h3>
<form method="POST">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Tanggal Daftar</label>
        <input type="date" name="tanggal_daftar" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
<?php include 'footer.php'; ?>
