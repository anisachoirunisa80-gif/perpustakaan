<?php
// pengembalian.php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    try {
        $pdo->beginTransaction();

        // Update tanggal kembali di peminjaman
        $sql = "UPDATE peminjaman SET tanggal_kembali = :tanggal_kembali WHERE id_peminjaman = :id_peminjaman";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tanggal_kembali' => $tanggal_kembali,
            ':id_peminjaman' => $id_peminjaman
        ]);

        // Dapatkan detail buku yang dipinjam
        $sql = "SELECT id_buku, jumlah FROM detail_peminjaman WHERE id_peminjaman = :id_peminjaman";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_peminjaman' => $id_peminjaman]);
        $details = $stmt->fetchAll();

        // Kembalikan stok buku untuk tiap item
        $sql = "UPDATE buku SET stok = stok + :jumlah WHERE id_buku = :id_buku";
        $stmt = $pdo->prepare($sql);
        foreach($details as $detail) {
            $stmt->execute([
                ':jumlah' => $detail['jumlah'],
                ':id_buku' => $detail['id_buku']
            ]);
        }

        $pdo->commit();
        $message = "Buku berhasil dikembalikan!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Pengembalian gagal: " . $e->getMessage();
    }
}
?>

<?php include 'header.php'; ?>
<h3>Proses Pengembalian Buku</h3>

<?php if(isset($message)): ?>
    <div class="alert alert-info"><?= $message ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Pilih Peminjaman (yang belum dikembalikan)</label>
        <select name="id_peminjaman" class="form-control" required>
            <option value="">Pilih peminjaman</option>
            <?php
            // Ambil peminjaman yang belum memiliki tanggal_kembali
            $sql = "SELECT p.id_peminjaman, a.nama, p.tanggal_pinjam
                    FROM peminjaman p
                    JOIN anggota a ON p.id_anggota = a.id_anggota
                    WHERE p.tanggal_kembali IS NULL";
            $stmt = $pdo->query($sql);
            while($row = $stmt->fetch()){
                echo "<option value='{$row['id_peminjaman']}'>ID: {$row['id_peminjaman']} - {$row['nama']} - Tgl Pinjam: {$row['tanggal_pinjam']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
</form>
<?php include 'footer.php'; ?>
