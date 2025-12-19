<?php
// register.php
session_start();
include 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan field terisi: nama, alamat, password, dan konfirmasi password
    if (isset($_POST['nama'], $_POST['alamat'], $_POST['password'], $_POST['confirm_password'])) {
        $nama             = trim($_POST['nama']);
        $alamat           = trim($_POST['alamat']);
        $password         = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi dasar
        if (empty($nama) || empty($alamat) || empty($password) || empty($confirm_password)) {
            $error = "Semua field wajib diisi!";
        } elseif ($password !== $confirm_password) {
            $error = "Password dan konfirmasi tidak sama!";
        } else {
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Sesuaikan query INSERT untuk tabel anggota
                $sql = "INSERT INTO anggota (nama, alamat, password) VALUES (:nama, :alamat, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nama'    => $nama,
                    ':alamat'  => $alamat,
                    ':password'=> $hashedPassword,
                ]);
                // Redirect ke halaman login setelah pendaftaran berhasil
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                // Jika terjadi error, misalnya data sudah ada
                $error = "Gagal mendaftar: " . $e->getMessage();
            }
        }
    } else {
        $error = "Data tidak lengkap!";
    }
}

include 'header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">BUAT AKUN</h3>
                        <p class="text-muted">Isi form berikut untuk mendaftar</p>
                    </div>

                    <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="register.php">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <!-- Field nama -->
                                <input type="text" 
                                       name="nama" 
                                       class="form-control"
                                       placeholder="Masukkan nama"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <!-- Field alamat, menggantikan email -->
                                <input type="email" 
                                       name="alamat" 
                                       class="form-control"
                                       placeholder="contoh@email.com"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control"
                                       placeholder="Minimal 8 karakter"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       name="confirm_password" 
                                       class="form-control"
                                       placeholder="Ketik ulang password"
                                       required>
                            </div>
                        </div>

                        <button type="submit" 
                                class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fas fa-user-plus me-2"></i>DAFTAR SEKARANG
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Sudah punya akun? 
                            <a href="login.php" class="text-decoration-none fw-bold">
                                Login disini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .input-group-text {
        background: white;
        border-right: 0;
    }
    
    .form-control {
        border-left: 0;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2c3e50, #3498db);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
    
    .password-strength {
        height: 3px;
        background: #eee;
        margin-top: 5px;
        position: relative;
    }
</style>

<?php include 'footer.php'; ?>
