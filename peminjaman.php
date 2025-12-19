<?php
session_start();
include 'koneksi.php';
include 'header.php';

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID user yang login (diambil dari field 'id_anggota' pada tabel anggota)
$id_user = $_SESSION['user']['id_anggota'];

// Ambil ID buku dari URL
$id_buku = isset($_GET['id_buku']) ? intval($_GET['id_buku']) : 0;

// Ambil detail buku dari database
$buku = null;
if ($id_buku > 0) {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE id_buku = :id");
    $stmt->execute([':id' => $id_buku]);
    $buku = $stmt->fetch();
}

// Proses simpan peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $buku) {
    $tanggal_pinjam = date('Y-m-d');
    
    // Simpan ke tabel peminjaman (pastikan kolom id_anggota dan tanggal_pinjam tersedia)
    $stmt = $pdo->prepare("INSERT INTO peminjaman (id_anggota, tanggal_pinjam) VALUES (:id_user, :tgl)");
    $stmt->execute([
        ':id_user' => $id_user,
        ':tgl' => $tanggal_pinjam
    ]);

    $id_peminjaman = $pdo->lastInsertId();

    // Simpan ke tabel detail_peminjaman
    $stmt = $pdo->prepare("INSERT INTO detail_peminjaman (id_peminjaman, id_buku, jumlah) VALUES (:id_peminjaman, :id_buku, 1)");
    $stmt->execute([
        ':id_peminjaman' => $id_peminjaman,
        ':id_buku' => $id_buku
    ]);

    echo '<div class="alert alert-success m-3">Peminjaman berhasil!</div>';
}
?>

<div class="container mt-4">
    <h3>Peminjaman Buku</h3>

    <?php if ($buku): ?>
        <div class="row mb-4">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($buku['cover']) ?: 'https://via.placeholder.com/300x400?text=No+Cover'; ?>" 
                     class="img-fluid" alt="Cover Buku">
            </div>
            <div class="col-md-8">
                <h4><?= htmlspecialchars($buku['judul']); ?></h4>
                <p><strong>Pengarang:</strong> <?= htmlspecialchars($buku['pengarang']); ?></p>

                <form method="POST">
                    <input type="hidden" name="id_buku" value="<?= $id_buku; ?>">
                    <button type="submit" class="btn btn-success">Konfirmasi Pinjam</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Klik tombol "Pinjam" pada buku untuk melakukan peminjaman.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
