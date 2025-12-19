<?php
session_start();
include 'koneksi.php';
include 'header.php';

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user']['id'];

// Proses pengembalian
if (isset($_GET['kembali']) && is_numeric($_GET['kembali'])) {
    $id_peminjaman = $_GET['kembali'];
    $tanggal_kembali = date('Y-m-d');

    // Tambahkan data ke tabel pengembalian
    $stmt = $pdo->prepare("INSERT INTO pengembalian (id_peminjaman, tanggal_kembali) VALUES (:id_peminjaman, :tgl)");
    $stmt->execute([
        ':id_peminjaman' => $id_peminjaman,
        ':tgl' => $tanggal_kembali
    ]);

    // Hapus detail peminjaman (atau bisa pakai update status kalau pakai sistem status)
    $stmt = $pdo->prepare("DELETE FROM detail_peminjaman WHERE id_peminjaman = :id");
    $stmt->execute([':id' => $id_peminjaman]);

    echo '<div class="alert alert-success m-3">Buku berhasil dikembalikan!</div>';
}

// Ambil daftar buku yang dipinjam user dan belum dikembalikan
$sql = "
    SELECT peminjaman.id_peminjaman, peminjaman.tanggal_pinjam, buku.judul, buku.cover
    FROM peminjaman
    JOIN detail_peminjaman ON peminjaman.id_peminjaman = detail_peminjaman.id_peminjaman
    JOIN buku ON detail_peminjaman.id_buku = buku.id_buku
    WHERE peminjaman.id_anggota = :id_user
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_user' => $id_user]);
$pinjaman = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h3>Daftar Buku yang Dipinjam</h3>

    <?php if (count($pinjaman) > 0): ?>
        <div class="row">
            <?php foreach ($pinjaman as $data): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($data['cover']) ?: 'https://via.placeholder.com/300x400?text=No+Cover'; ?>" class="card-img-top" alt="Cover Buku">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($data['judul']) ?></h5>
                            <p class="card-text"><strong>Tanggal Pinjam:</strong> <?= htmlspecialchars($data['tanggal_pinjam']) ?></p>
                            <a href="pengembalian.php?kembali=<?= $data['id_peminjaman'] ?>" class="btn btn-danger">Kembalikan</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Tidak ada buku yang sedang dipinjam.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
