<?php include '../koneksi.php'; 
if ($_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; } ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User Management | Admin Terminal</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header-box">
            <h2 style="margin:0; color:var(--primary);"><i class="fas fa-users-gear"></i> USER_DATABASE</h2>
            <div class="nav-links">
                <a href="dashboard.php"><i class="fas fa-chart-line"></i> DASHBOARD</a>
                <a href="../index.php" style="color:var(--danger);"><i class="fas fa-power-off"></i> LOGOUT</a>
            </div>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID_USER</th>
                        <th>USERNAME</th>
                        <th>FULL_NAME</th>
                        <th>ACCESS_ROLE</th>
                        <th style="text-align:center;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $current_admin_id = $_SESSION['id_user'];
                    $q = mysqli_query($koneksi, "SELECT * FROM users");
                    while($r = mysqli_fetch_assoc($q)) { 
                        echo "<tr>
                                <td>#{$r['id_user']}</td>
                                <td style='color:var(--primary); font-weight:bold;'>{$r['username']}</td>
                                <td>{$r['nama_lengkap']}</td>
                                <td><span style='background:rgba(0,242,255,0.1); padding:4px 10px; border-radius:4px; font-size:11px; color:var(--primary); border: 1px solid rgba(0,242,255,0.2);'>".strtoupper($r['role'])."</span></td>
                                <td style='text-align:center;'>";
                                
                                // Jika ID bukan milik admin yang sedang login, tampilkan tombol hapus
                                if ($r['id_user'] != $current_admin_id) {
                                    echo "<a href='hapus_user.php?id={$r['id_user']}' 
                                             onclick=\"return confirm('DANGER: Hapus user ini beserta seluruh riwayat transaksinya?')\" 
                                             style='color:var(--danger); text-decoration:none; font-size:16px;'>
                                             <i class='fas fa-trash-can'></i>
                                          </a>";
                                } else {
                                    // Jika itu akun sendiri, tampilkan ikon lock (tidak bisa dihapus)
                                    echo "<i class='fas fa-user-shield' style='color:#444;' title='Your Account'></i>";
                                }

                        echo "</td>
                              </tr>"; 
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>