<?php

session_start();
include 'koneksi.php';

$error = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama'], $_POST['password'])) {
        $nama = trim($_POST['nama']);
        $password = $_POST['password'];
        
        try {
            $sql = "SELECT * FROM anggota WHERE nama = :nama";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nama' => $nama]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } else {
                $error = "Nama atau password salah!";
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    } else {
        $error = "Harap isi nama dan password!";
    }
}

include 'header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">MASUK</h3>
                        <p class="text-muted">Silakan masuk ke akun Anda</p>
                    </div>

                    <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       name="nama" 
                                       class="form-control"
                                       placeholder="Masukkan nama"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control"
                                       placeholder="Masukkan password"
                                       required>
                            </div>
                        </div>

                        <button type="submit" 
                                class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>MASUK
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Belum punya akun? 
                            <a href="register.php" class="text-decoration-none fw-bold">
                                Daftar disini
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
</style>

<?php include 'footer.php'; ?>
