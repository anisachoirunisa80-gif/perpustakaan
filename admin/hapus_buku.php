<?php
include 'koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_buku'])) {
    $id_buku = intval($_POST['id_buku']);
    
    try {
        $stmtDelete = $pdo->prepare("DELETE FROM buku WHERE id_buku = :id_buku");
        $stmtDelete->execute([':id_buku' => $id_buku]);
        $success = "Buku dengan ID {$id_buku} berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus buku: " . $e->getMessage();
    }
}

include 'header.php';

$sql = "SELECT * FROM buku ORDER BY judul";
$stmt = $pdo->query($sql);
$daftarBuku = $stmt->fetchAll();
?>

<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h3 class="card-title mb-0 text-danger">
                <i class="fas fa-trash-alt me-2"></i>Kelola Buku
            </h3>
            <p class="text-muted mb-0">Kelola koleksi buku perpustakaan</p>
        </div>
        
        <div class="card-body pt-1">
            <!-- Notifikasi -->
            <?php if (isset($success)): ?>
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div class="flex-grow-1"><?= htmlspecialchars($success) ?></div>
            </div>
            <?php elseif (isset($error)): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                <div class="flex-grow-1"><?= htmlspecialchars($error) ?></div>
            </div>
            <?php endif; ?>

            <?php if (count($daftarBuku) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                <?php foreach ($daftarBuku as $buku): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-hover">
                        <?php if (!empty($buku['cover'])): ?>
                        <img src="<?= htmlspecialchars($buku['cover']) ?>" 
                             class="card-img-top book-cover"
                             alt="<?= htmlspecialchars($buku['judul']) ?>">
                        <?php else: ?>
                        <div class="book-cover-placeholder">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= htmlspecialchars($buku['judul']) ?></h5>
                            <div class="text-muted small mb-2">
                                <div class="mb-1">
                                    <i class="fas fa-user-edit me-2"></i>
                                    <?= htmlspecialchars($buku['pengarang']) ?>
                                </div>
                                <div>
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <?= htmlspecialchars($buku['tahun_terbit']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0">
                            <form method="POST" action="hapus_buku.php" 
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                <input type="hidden" name="id_buku" value="<?= $buku['id_buku'] ?>">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                    <h4 class="text-muted">Tidak ada buku tersedia</h4>
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
    
    .empty-state {
        opacity: 0.7;
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
</style>

<?php include 'footer.php'; ?>