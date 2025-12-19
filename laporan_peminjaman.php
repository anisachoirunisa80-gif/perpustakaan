<?php
// laporan_peminjaman.php
include 'koneksi.php';

$sql = "SELECT a.nama, p.id_peminjaman, p.tanggal_pinjam, p.tanggal_kembali,
               GROUP_CONCAT(b.judul SEPARATOR ', ') as daftar_buku
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id_anggota
        JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
        JOIN buku b ON dp.id_buku = b.id_buku
        GROUP BY p.id_peminjaman, a.nama, p.tanggal_pinjam, p.tanggal_kembali
        ORDER BY p.tanggal_pinjam DESC";
$stmt = $pdo->query($sql);
?>

<?php include 'header.php'; ?>
<h3>Laporan Peminjaman Per Anggota</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Anggota</th>
            <th>ID Peminjaman</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Daftar Buku</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $stmt->fetch()): ?>
        <tr>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['id_peminjaman'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?></td>
            <td><?= $row['daftar_buku'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
