<?php
// pencarian_buku.php
include 'koneksi.php';

// Pencarian buku
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$sqlCari = "SELECT * FROM buku WHERE judul LIKE :cari OR pengarang LIKE :cari";
$stmtCari = $pdo->prepare($sqlCari);
$stmtCari->execute([':cari' => "%$cari%"]);
$hasilCari = $stmtCari->fetchAll();

// Laporan buku paling sering dipinjam
$sqlLaporan = "SELECT b.judul, b.pengarang, SUM(dp.jumlah) AS total_pinjam
               FROM detail_peminjaman dp
               JOIN buku b ON dp.id_buku = b.id_buku
               GROUP BY dp.id_buku
               HAVING total_pinjam > 0
               ORDER BY total_pinjam DESC";
$stmtLaporan = $pdo->query($sqlLaporan);
?>

<?php include 'header.php'; ?>
<h3>Pencarian Buku</h3>
<form method="GET">
    <div class="mb-3">
        <input type="text" name="cari" class="form-control" placeholder="Cari berdasarkan judul atau pengarang..." value="<?= htmlspecialchars($cari) ?>">
    </div>
    <button type="submit" class="btn btn-secondary">Cari</button>
</form>

<?php if($cari): ?>
    <h5 class="mt-4">Hasil Pencarian untuk: "<?= htmlspecialchars($cari) ?>"</h5>
    <?php if(count($hasilCari)>0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun Terbit</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($hasilCari as $buku): ?>
                    <tr>
                        <td><?= $buku['judul'] ?></td>
                        <td><?= $buku['pengarang'] ?></td>
                        <td><?= $buku['tahun_terbit'] ?></td>
                        <td><?= $buku['stok'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada buku yang ditemukan.</p>
    <?php endif; ?>
<?php endif; ?>

<h3 class="mt-5">Laporan Buku Paling Sering Dipinjam</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Total Dipinjam</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $stmtLaporan->fetch()): ?>
        <tr>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['pengarang'] ?></td>
            <td><?= $row['total_pinjam'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
