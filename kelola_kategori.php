<?php include '../koneksi.php'; 
if ($_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
    <title>Category Master</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="header-box">
            <h2>Transaction Categories</h2>
            <div class="nav-links">
                <a href="dashboard.php">Log Aktivitas</a>
                <a href="kelola_user.php">Kelola User</a>
                <a href="kelola_kategori.php" class="active">Kategori</a>
                <a href="../index.php">Logout</a>
            </div>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr><th>ID</th><th>Category Name</th><th>Type</th></tr>
                </thead>
                <tbody>
                    <?php $q = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($r = mysqli_fetch_assoc($q)) { 
                        $color = $r['tipe'] == 'pemasukan' ? 'var(--success)' : 'var(--danger)';
                        echo "<tr><td>{$r['id_kategori']}</td><td>{$r['nama_kategori']}</td><td style='color:$color; text-transform:uppercase; font-size:11px;'>● {$r['tipe']}</td></tr>"; 
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>