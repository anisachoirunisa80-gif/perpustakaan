<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_anggota    = $_POST['id_anggota'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    // Karena untuk buku dan jumlah kita menggunakan array
    $id_buku_arr   = $_POST['id_buku'];
    $jumlah_arr    = $_POST['jumlah_pinjam'];

    try {
        // Mulai transaksi
        $pdo->beginTransaction();

        // Insert ke tabel peminjaman (header)
        $sql = "INSERT INTO peminjaman (id_anggota, tanggal_pinjam) VALUES (:id_anggota, :tanggal_pinjam)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_anggota'    => $id_anggota,
            ':tanggal_pinjam'=> $tanggal_pinjam
        ]);
        $id_peminjaman = $pdo->lastInsertId();

        // Persiapkan query untuk insert detail dan update stok
        $sqlInsertDetail = "INSERT INTO detail_peminjaman (id_peminjaman, id_buku, jumlah) 
                            VALUES (:id_peminjaman, :id_buku, :jumlah)";
        $stmtInsertDetail = $pdo->prepare($sqlInsertDetail);

        $sqlCekStok = "SELECT stok FROM buku WHERE id_buku = :id_buku FOR UPDATE";
        $stmtCekStok = $pdo->prepare($sqlCekStok);

        $sqlUpdateStok = "UPDATE buku SET stok = stok - :jumlah WHERE id_buku = :id_buku";
        $stmtUpdateStok = $pdo->prepare($sqlUpdateStok);

        // Proses setiap entri buku
        for ($i = 0; $i < count($id_buku_arr); $i++) {
            $id_buku   = $id_buku_arr[$i];
            $jumlah    = $jumlah_arr[$i];

            // Cek ketersediaan stok buku dengan FOR UPDATE agar konsisten
            $stmtCekStok->execute([':id_buku' => $id_buku]);
            $buku = $stmtCekStok->fetch();

            if (!$buku || $buku['stok'] < $jumlah) {
                throw new Exception("Stok buku dengan ID $id_buku tidak mencukupi!");
            }

            // Insert ke detail peminjaman
            $stmtInsertDetail->execute([
                ':id_peminjaman' => $id_peminjaman,
                ':id_buku'       => $id_buku,
                ':jumlah'        => $jumlah
            ]);

            // Update stok buku
            $stmtUpdateStok->execute([
                ':jumlah'  => $jumlah,
                ':id_buku' => $id_buku
            ]);
        }

        // Commit transaksi
        $pdo->commit();
        $message = "Peminjaman berhasil, stok buku telah diperbarui!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Gagal meminjam buku: " . $e->getMessage();
    }
}
?>

<?php include 'header.php'; ?>
<h3>Proses Peminjaman Buku (Multiple)</h3>

<?php if(isset($message)): ?>
    <div class="alert alert-info"><?= $message ?></div>
<?php endif; ?>

<form method="POST" id="formPeminjaman">
    <div class="mb-3">
        <label>Anggota</label>
        <select name="id_anggota" class="form-control" required>
            <option value="">Pilih anggota</option>
            <?php
            // Ambil data anggota
            $stmt = $pdo->query("SELECT * FROM anggota");
            while($row = $stmt->fetch()){
                echo "<option value='{$row['id_anggota']}'>{$row['nama']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>

    <!-- Container untuk entri buku -->
    <div id="book-container">
        <div class="book-entry row mb-3">
            <div class="col-md-6">
                <label>Buku</label>
                <select name="id_buku[]" class="form-control" required>
                    <option value="">Pilih buku</option>
                    <?php
                    // Ambil data buku
                    $stmtBuku = $pdo->query("SELECT * FROM buku");
                    while($buku = $stmtBuku->fetch()){
                        echo "<option value='{$buku['id_buku']}'>{$buku['judul']} - Stok: {$buku['stok']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah_pinjam[]" class="form-control" required min="1">
            </div>
            <div class="col-md-3 mt-4">
                <button type="button" class="btn btn-danger remove-entry">Hapus</button>
            </div>
        </div>
    </div>
    <button type="button" id="addBook" class="btn btn-secondary mb-3">Tambah Buku</button>
    <br>
    <button type="submit" class="btn btn-primary">Proses Peminjaman</button>
</form>

<script>
// Tambah entri baru untuk buku
document.getElementById('addBook').addEventListener('click', function() {
    var container = document.getElementById('book-container');
    var newEntry = document.createElement('div');
    newEntry.className = 'book-entry row mb-3';
    newEntry.innerHTML = `
        <div class="col-md-6">
            <label>Buku</label>
            <select name="id_buku[]" class="form-control" required>
                <option value="">Pilih buku</option>
                <?php
                // Query ulang untuk data buku
                $stmtBuku = $pdo->query("SELECT * FROM buku");
                while($buku = $stmtBuku->fetch()){
                    echo "<option value='{$buku['id_buku']}'>{$buku['judul']} - Stok: {$buku['stok']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah_pinjam[]" class="form-control" required min="1">
        </div>
        <div class="col-md-3 mt-4">
            <button type="button" class="btn btn-danger remove-entry">Hapus</button>
        </div>
    `;
    container.appendChild(newEntry);
});

// Hapus entri buku jika tombol "Hapus" diklik
document.getElementById('book-container').addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('remove-entry')) {
        e.target.closest('.book-entry').remove();
    }
});
</script>

<?php include 'footer.php'; ?>
