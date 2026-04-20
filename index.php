<?php 
include 'koneksi.php'; // session_start sudah ada di dalam file ini

if (isset($_POST['login'])) {
    // Keamanan tambahan: escape string untuk mencegah SQL Injection
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = md5($_POST['password']);
    
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    
    if (mysqli_num_rows($query) > 0) {
        $d = mysqli_fetch_assoc($query);
        $_SESSION['id_user'] = $d['id_user'];
        $_SESSION['role'] = $d['role'];
        $_SESSION['nama'] = $d['nama_lengkap'];
        
        // Redirect stabil menggunakan JavaScript
        if ($d['role'] == 'admin') {
            echo "<script>window.location='admin/dashboard.php';</script>";
        } else {
            echo "<script>window.location='user/dashboard.php';</script>";
        }
        exit; 
    } else { 
        echo "<script>alert('ACCESS DENIED: Username atau Password Salah!');</script>"; 
    }
} 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Terminal | Financial System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Khusus Halaman Login agar posisinya pas di tengah */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-header i {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 15px;
            filter: drop-shadow(0 0 10px var(--primary));
        }
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #57606a;
        }
        .input-group input {
            padding-left: 45px; /* Memberi ruang untuk ikon */
        }
        .register-link {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 25px;
        }
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 800;
            transition: 0.3s;
        }
        .register-link a:hover {
            text-shadow: 0 0 10px var(--primary);
        }
    </style>
</head>
<body>

    <div class="login-card card">
        <div class="login-header">
            <i class="fas fa-shield-halved"></i>
            <h2>TERMINAL_LOGIN</h2>
            <p style="font-size: 11px; color: #57606a; letter-spacing: 1px; margin-bottom: 30px;">
                SECURE ACCESS REQUIRED
            </p>
        </div>
        
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            
            <button type="submit" name="login">
                <i class="fas fa-bolt"></i> EXECUTE LOGIN
            </button>
        </form>

        <div class="register-link">
            Belum punya akses? <a href="register.php">DAFTAR AKUN BARU</a>
        </div>
        
        <p style="font-size: 10px; color: #333; margin-top: 30px;">
            &copy; 2026 Crypto-Management Terminal. All Rights Reserved.
        </p>
    </div>

</body>
</html>