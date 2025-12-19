<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
include 'header.php';

// Ambil keyword pencarian jika ada
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';

// Jika ada pencarian, gunakan prepared statement untuk query pencarian
if ($cari !== '') {
    $sqlCari = "SELECT * FROM buku WHERE judul LIKE :cari OR pengarang LIKE :cari";
    $stmtCari = $pdo->prepare($sqlCari);
    $stmtCari->execute([':cari' => "%$cari%"]);
} else {
    $stmtCari = null;
}

// Query untuk mengambil buku populer
$sqlPopuler = "SELECT b.id_buku, b.judul, b.pengarang, b.cover, SUM(dp.jumlah) AS total_pinjam 
               FROM detail_peminjaman dp 
               JOIN buku b ON dp.id_buku = b.id_buku 
               GROUP BY dp.id_buku 
               ORDER BY total_pinjam DESC 
               LIMIT 5";
$stmtPopuler = $pdo->query($sqlPopuler);

// Query untuk mengambil semua buku
$sqlSemua = "SELECT * FROM buku ORDER BY judul";
$stmtSemua = $pdo->query($sqlSemua);
?>

<!-- FORM PENCARIAN BUKU -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <form action="index.php" method="GET" class="shadow-lg rounded-pill">
            <div class="input-group">
                <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" 
                       class="form-control form-control-lg rounded-pill ps-4 py-3" 
                       placeholder="Cari buku berdasarkan judul atau pengarang...">
                <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

<?php if ($cari !== ''): ?>
<!-- HASIL PENCARIAN BUKU -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-search me-2"></i>Hasil pencarian untuk "<?= htmlspecialchars($cari) ?>"
                </h4>
            </div>
            <div class="card-body">
                <?php if ($stmtCari && $stmtCari->rowCount() > 0): ?>
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php while ($rowCari = $stmtCari->fetch()): ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-hover">
                                    <?php if (!empty($rowCari['cover'])): ?>
                                        <img src="<?= htmlspecialchars($rowCari['cover']) ?>" 
                                             class="card-img-top book-cover" 
                                             alt="<?= htmlspecialchars($rowCari['judul']) ?>">
                                    <?php else: ?>
                                        <div class="book-cover-placeholder">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($rowCari['judul']) ?></h5>
                                        <p class="card-text text-muted">Oleh <?= htmlspecialchars($rowCari['pengarang']) ?></p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="peminjaman.php?id_buku=<?= $rowCari['id_buku'] ?>" 
                                           class="btn btn-primary w-100">
                                            <i class="fas fa-cart-plus me-2"></i>Pinjam
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-book-dead fa-3x text-muted mb-4"></i>
                            <h4 class="text-muted">Buku tidak ditemukan</h4>
                            <p class="text-muted">Coba kata kunci lain atau lihat koleksi kami</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- BUKU POPULER -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-fire me-2"></i>Buku Populer
                </h4>
            </div>
            <div class="card-body">
                <?php if ($stmtPopuler->rowCount() > 0): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                        <?php while ($row = $stmtPopuler->fetch()): ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-hover">
                                    <?php if (!empty($row['cover'])): ?>
                                        <img src="<?= htmlspecialchars($row['cover']) ?>" 
                                             class="card-img-top book-cover" 
                                             alt="<?= htmlspecialchars($row['judul']) ?>">
                                    <?php else: ?>
                                        <div class="book-cover-placeholder">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($row['judul']) ?></h5>
                                        <p class="card-text text-muted">Oleh <?= htmlspecialchars($row['pengarang']) ?></p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-chart-line me-2"></i><?= $row['total_pinjam'] ?>x
                                        </span>
                                        <a href="peminjaman.php?id_buku=<?= $row['id_buku'] ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                            <h4 class="text-muted">Belum ada buku populer</h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- SEMUA BUKU -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-books me-2"></i>Semua Buku
                </h4>
                <span class="badge bg-primary">Total: <?= $stmtSemua->rowCount() ?></span>
            </div>
            <div class="card-body">
                <?php if ($stmtSemua->rowCount() > 0): ?>
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
                        <?php while ($rowAll = $stmtSemua->fetch()): ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-hover">
                                    <?php if (!empty($rowAll['cover'])): ?>
                                        <img src="<?= htmlspecialchars($rowAll['cover']) ?>" 
                                             class="card-img-top book-cover" 
                                             alt="<?= htmlspecialchars($rowAll['judul']) ?>">
                                    <?php else: ?>
                                        <div class="book-cover-placeholder">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($rowAll['judul']) ?></h5>
                                        <p class="card-text text-muted">Oleh <?= htmlspecialchars($rowAll['pengarang']) ?></p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="peminjaman.php?id_buku=<?= $rowAll['id_buku'] ?>" 
                                           class="btn btn-primary w-100">
                                            <i class="fas fa-cart-plus me-2"></i>Pinjam
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                            <h4 class="text-muted">Belum ada buku tersedia</h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
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
    
    .empty-state {
        opacity: 0.7;
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
</style>

<?php include 'footer.php'; ?>
