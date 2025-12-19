<?php
include 'koneksi.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Query Buku Populer
$sqlPopuler = "SELECT b.id_buku, b.judul, b.pengarang, b.cover, SUM(dp.jumlah) AS total_pinjam 
               FROM detail_peminjaman dp 
               JOIN buku b ON dp.id_buku = b.id_buku 
               GROUP BY dp.id_buku 
               ORDER BY total_pinjam DESC 
               LIMIT 5";
$stmtPopuler = $pdo->query($sqlPopuler);

// Query Riwayat Peminjaman (menggunakan tabel anggota)
$sqlRiwayat = "SELECT p.id_peminjaman, u.nama as username, p.tanggal_pinjam, p.tanggal_kembali,
                      GROUP_CONCAT(b.judul SEPARATOR ', ') as daftar_buku
               FROM peminjaman p
               JOIN anggota u ON p.id_anggota = u.id_anggota
               JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
               JOIN buku b ON dp.id_buku = b.id_buku
               GROUP BY p.id_peminjaman, u.nama, p.tanggal_pinjam, p.tanggal_kembali
               ORDER BY p.tanggal_pinjam DESC
               LIMIT 5";
$stmtRiwayat = $pdo->query($sqlRiwayat);

include 'header.php';
?>

<!-- Pencarian -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <form action="pencarian_buku.php" method="GET" class="shadow-lg rounded-pill">
            <div class="input-group">
                <span class="input-group-text bg-white border-0 rounded-pill ps-4">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" 
                       name="cari" 
                       class="form-control form-control-lg border-0 rounded-pill"
                       placeholder="Cari buku berdasarkan judul atau pengarang...">
                <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Buku Populer -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-fire me-2"></i>Buku Populer
                </h4>
            </div>
            <div class="card-body">
                <?php if ($stmtPopuler->rowCount() > 0): ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
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
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                            <h4 class="text-muted">Belum ada data buku populer</h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                </h4>
            </div>
            <div class="card-body">
                <?php if ($stmtRiwayat->rowCount() > 0): ?>
                    <div class="timeline">
                        <?php while ($row = $stmtRiwayat->fetch()): ?>
                            <div class="timeline-item">
                                <div class="timeline-badge bg-primary"></div>
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-primary">#<?= $row['id_peminjaman'] ?></h6>
                                            <small class="text-muted"><?= $row['tanggal_pinjam'] ?></small>
                                        </div>
                                        <p class="mb-1"><strong><?= htmlspecialchars($row['username']) ?></strong></p>
                                        <p class="text-muted small mb-2">
                                            <?= htmlspecialchars($row['daftar_buku']) ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-<?= $row['tanggal_kembali'] ? 'success' : 'warning' ?>">
                                                <?= $row['tanggal_kembali'] ?: 'Dalam peminjaman' ?>
                                            </span>
                                            <a href="laporan_peminjaman.php" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-clock fa-3x text-muted mb-4"></i>
                            <h4 class="text-muted">Belum ada riwayat peminjaman</h4>
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
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-badge {
        position: absolute;
        left: -20px;
        top: 15px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .empty-state {
        opacity: 0.7;
    }
</style>

<?php include 'footer.php'; ?>
