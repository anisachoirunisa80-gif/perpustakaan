<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
include 'header.php';

// Ambil ID user dari session (diambil dari field 'id_anggota' pada tabel anggota)
$id_user = $_SESSION['user']['id_anggota'];

// PROSES PENGEMBALIAN:
// Jika ada parameter GET 'return', proses pengembalian buku
if (isset($_GET['return']) && is_numeric($_GET['return'])) {
    $id_peminjaman = intval($_GET['return']);
    $tanggal_kembali = date('Y-m-d');
    
    // Update record peminjaman hanya jika buku belum dikembalikan (tanggal_kembali IS NULL)
    $stmt = $pdo->prepare("UPDATE peminjaman 
                           SET tanggal_kembali = :tgl 
                           WHERE id_peminjaman = :id_peminjaman 
                             AND id_anggota = :id_user 
                             AND tanggal_kembali IS NULL");
    $stmt->execute([
        ':tgl' => $tanggal_kembali,
        ':id_peminjaman' => $id_peminjaman,
        ':id_user' => $id_user
    ]);
    
    echo "<div class='alert alert-success m-3'>Buku berhasil dikembalikan!</div>";
}

// Ambil daftar buku yang sedang dipinjam (peminjaman dengan tanggal_kembali NULL)
$sql = "
    SELECT p.id_peminjaman, p.tanggal_pinjam, b.id_buku, b.judul, b.cover, dp.jumlah
    FROM peminjaman p
    JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
    JOIN buku b ON dp.id_buku = b.id_buku
    WHERE p.id_anggota = :id_user AND p.tanggal_kembali IS NULL
    ORDER BY p.tanggal_pinjam DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_user' => $id_user]);
$borrowedBooks = $stmt->fetchAll();
?>

<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h3 class="card-title mb-0 text-primary">
                <i class="fas fa-book-reader me-2"></i>Buku yang Sedang Dipinjam
            </h3>
            <p class="text-muted mb-0">Daftar buku yang saat ini berada dalam peminjaman</p>
        </div>
        
        <div class="card-body pt-1">
            <?php if(isset($_GET['return'])): ?>
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div class="flex-grow-1">Buku berhasil dikembalikan!</div>
            </div>
            <?php endif; ?>

            <?php if(count($borrowedBooks) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach($borrowedBooks as $book): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-hover">
                        <?php if(!empty($book['cover'])): ?>
                        <img src="<?= htmlspecialchars($book['cover']) ?>" 
                             class="card-img-top book-cover"
                             alt="<?= htmlspecialchars($book['judul']) ?>">
                        <?php else: ?>
                        <div class="book-cover-placeholder">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= htmlspecialchars($book['judul']) ?></h5>
                            <div class="text-muted small mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <?= date('d M Y', strtotime($book['tanggal_pinjam'])) ?>
                                    </span>
                                    <span class="badge bg-primary">
                                        <?= $book['jumlah'] ?> Item
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0">
                            <a href="mybook.php?return=<?= $book['id_peminjaman'] ?>" 
                               class="btn btn-danger w-100 py-2"
                               onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                <i class="fas fa-undo me-2"></i>Kembalikan
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                    <h4 class="text-muted">Tidak ada buku yang dipinjam</h4>
                    <p class="text-muted">Silakan pinjam buku melalui katalog kami</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .book-cover {
        height: 250px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }
    
    .book-cover-placeholder {
        height: 250px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 3rem;
        border-radius: 10px 10px 0 0;
    }
    
    .shadow-hover {
        transition: all 0.3s ease;
        border-radius: 10px;
    }
    
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220,53,69,0.3);
    }
    
    .empty-state {
        opacity: 0.7;
    }
</style>

<?php include 'footer.php'; ?>
