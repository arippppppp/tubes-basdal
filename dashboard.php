<?php include '../koneksi.php'; 
if ($_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; }

// Statistik Ringkasan
$u = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_user FROM users"));
$k = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_kategori FROM kategori"));
$l = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_log FROM log_transaksi"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="header-box">
            <h2>Financial Admin</h2>
            <div class="nav-links">
                <a href="dashboard.php" class="active">Log Aktivitas</a>
                <a href="kelola_user.php">Kelola User</a>
                <a href="kelola_kategori.php">Kategori</a>
                <a href="../index.php" class="logout">Logout</a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="card"><h3>Total Users</h3><h1 style="color:var(--primary)"><?php echo $u; ?></h1></div>
            <div class="card"><h3>Categories</h3><h1 style="color:var(--primary)"><?php echo $k; ?></h1></div>
            <div class="card"><h3>System Logs</h3><h1 style="color:var(--primary)"><?php echo $l; ?></h1></div>
        </div>

        <div class="card">
            <h3>Audit Trail (Trigger Logs)</h3>
            <table>
                <thead>
                    <tr><th>ID</th><th>Activity</th><th>Timestamp</th></tr>
                </thead>
                <tbody>
                    <?php $q = mysqli_query($koneksi, "SELECT * FROM log_transaksi ORDER BY waktu DESC");
                    while($r = mysqli_fetch_assoc($q)) { 
                        echo "<tr><td>#{$r['id_log']}</td><td>{$r['keterangan_log']}</td><td>{$r['waktu']}</td></tr>"; 
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>