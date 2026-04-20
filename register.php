<?php 
include 'koneksi.php'; 

if (isset($_POST['register'])) {
    $user     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $pass     = md5($_POST['password']); // Menggunakan MD5 agar sinkron dengan sistem login kamu
    $role     = 'user'; // Default role untuk pendaftar baru

    // Cek apakah username sudah dipakai atau belum
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('ERROR: Username sudah terdaftar!');</script>";
    } else {
        // Query Insert ke tabel users
        $insert = mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, role) 
                                          VALUES ('$user', '$pass', '$nama', '$role')");
        
        if ($insert) {
            echo "<script>alert('REGISTRATION SUCCESS: Silakan Login.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('ERROR: Gagal mendaftarkan user baru.');</script>";
        }
    }
} 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Terminal | Financial System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Memastikan gaya body sama dengan index agar grid bergerak tetap ada */
        body {
            margin: 0; padding: 0; background-color: #05070a;
            display: flex; justify-content: center; align-items: center;
            height: 100vh; overflow: hidden; perspective: 1000px;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card" style="width: 400px;">
            <div class="login-header">
                <i class="fas fa-user-plus" style="color: var(--secondary); filter: drop-shadow(0 0 10px var(--secondary));"></i>
                <h2>CREATE_ACCOUNT</h2>
                <p>JOIN THE FINANCIAL TERMINAL</p>
            </div>
            
            <form method="POST">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="nama_lengkap" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Choose Username" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Create Password" required>
                </div>
                
                <button type="submit" name="register" style="background: linear-gradient(135deg, var(--secondary), #00d4aa);">
                    <i class="fas fa-paper-plane"></i> REGISTER_NOW
                </button>
            </form>
            
            <p style="font-size: 13px; color: #94a3b8; margin-top: 20px;">
                Sudah punya akun? <a href="index.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">LOG_IN</a>
            </p>
        </div>
    </div>
</body>
</html>