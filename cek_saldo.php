<?php include '../koneksi.php'; 
if (!isset($_SESSION['id_user'])) { header("Location: ../index.php"); exit; }
$q = mysqli_query($koneksi, "CALL hitung_saldo({$_SESSION['id_user']})");
$d = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Portfolio Balance</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin-top: 100px;">
        <div class="card" style="text-align: center; border: 2px solid var(--primary);">
            <p style="color:var(--text-muted); font-size:12px; letter-spacing:2px;">TOTAL ESTIMATED BALANCE</p>
            <h1 style="font-size: 40px; color: #fff; margin: 10px 0;">
                Rp <?php echo number_format($d['saldo'] ?? 0, 0, ',', '.'); ?>
            </h1>
            <p style="color:var(--success); font-size:12px;">≈ 0.00245000 BTC</p>
            <hr style="border:0; border-top:1px solid #2d3748; margin:20px 0;">
            <a href="dashboard.php" style="color:var(--primary); text-decoration:none; font-size:13px; font-weight:bold;">← BACK TO TERMINAL</a>
        </div>
    </div>
</body>
</html>