<?php
// laporan_peminjaman.php
include 'koneksi.php';

$sql = "SELECT u.nama AS nama, p.id_peminjaman, p.tanggal_pinjam, p.tanggal_kembali,
               GROUP_CONCAT(b.judul SEPARATOR ', ') as daftar_buku
        FROM peminjaman p
        JOIN anggota u ON p.id_anggota = u.id_anggota
        JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
        JOIN buku b ON dp.id_buku = b.id_buku
        GROUP BY p.id_peminjaman, u.nama, p.tanggal_pinjam, p.tanggal_kembali
        ORDER BY p.tanggal_pinjam DESC";
$stmt = $pdo->query($sql);
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-primary">
                    <i class="fas fa-file-alt me-2"></i>Laporan Peminjaman
                </h3>
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="fas fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
        
        <div class="card-body pt-1">
            <?php if ($stmt->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Anggota</th>
                            <th>ID Transaksi</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Buku Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $stmt->fetch()): ?>
                        <tr>
                            <td class="ps-4 fw-medium">
                                <i class="fas fa-user-circle me-2 text-muted"></i>
                                <?= htmlspecialchars($row['nama']) ?>
                            </td>
                            <td>#<?= $row['id_peminjaman'] ?></td>
                            <td>
                                <i class="fas fa-calendar-day me-2 text-muted"></i>
                                <?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?>
                            </td>
                            <td>
                                <?php if ($row['tanggal_kembali']): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <?= date('d M Y', strtotime($row['tanggal_kembali'])) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-2"></i>
                                        Dalam Peminjaman
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-grid">
                                    <?php 
                                    $bukuList = explode(', ', $row['daftar_buku']);
                                    foreach($bukuList as $buku): ?>
                                        <span class="badge bg-light text-dark mb-1 text-start">
                                            <i class="fas fa-book me-2 text-primary"></i>
                                            <?= htmlspecialchars($buku) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-file-excel fa-3x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada data peminjaman</h4>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85em;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    
    .badge {
        padding: 0.5em 0.75em;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .empty-state {
        opacity: 0.7;
    }
</style>

<?php include 'footer.php'; ?>
