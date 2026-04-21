<?php include '../koneksi.php'; 
if (!isset($_SESSION['id_user'])) { header("Location: ../index.php"); exit; }
$nama_user = $_SESSION['nama'];
$id_user = $_SESSION['id_user'];

// --- LOGIKA HITUNG DATA ---
$q_in = mysqli_query($koneksi, "SELECT SUM(transaksi.jumlah) as total FROM transaksi 
                                JOIN kategori ON transaksi.id_kategori = kategori.id_kategori 
                                WHERE transaksi.id_user = '$id_user' AND kategori.tipe = 'pemasukan'");
$res_in = mysqli_fetch_assoc($q_in);
$total_in = $res_in['total'] ?? 0;

$q_out = mysqli_query($koneksi, "SELECT SUM(transaksi.jumlah) as total FROM transaksi 
                                 JOIN kategori ON transaksi.id_kategori = kategori.id_kategori 
                                 WHERE transaksi.id_user = '$id_user' AND kategori.tipe = 'pengeluaran'");
$res_out = mysqli_fetch_assoc($q_out);
$total_out = $res_out['total'] ?? 0;

// HITUNG PERSENTASE UNTUK SUMMARY
$grand_total = $total_in + $total_out;
$persen_in = ($grand_total > 0) ? round(($total_in / $grand_total) * 100, 1) : 0;
$persen_out = ($grand_total > 0) ? round(($total_out / $grand_total) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Trading Dashboard | Financial Analytics</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <div class="header-box">
            <div>
                <h2 style="margin:0; letter-spacing:-1px; color:var(--primary);"><i class="fas fa-chart-pie"></i> ANALYTICS_CENTER</h2>
                <p style="color:var(--text-dim); margin:0; font-size:12px;">Active Account: <?php echo $nama_user; ?></p>
            </div>
            <div class="nav-links">
                <a href="tambah_transaksi1.php"><i class="fas fa-plus"></i> NEW ORDER</a>
                <a href="cek_saldo.php"><i class="fas fa-wallet"></i> MY PORTFOLIO</a>
                <a href="../index.php" style="color:var(--danger)"><i class="fas fa-power-off"></i> LOGOUT</a>
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div class="card" style="flex: 1.2; display: flex; align-items: center; justify-content: center; min-height: 300px;">
                <div style="width: 260px; position: relative;">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>

            <div class="card" style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                <h3 style="margin-top:0; font-size:14px; color:var(--text-dim); border-bottom: 1px solid var(--border); padding-bottom: 10px;">
                    MARKET_SUMMARY
                </h3>
                
                <div style="margin: 20px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <small style="color:var(--secondary);">TOTAL_INCOME</small>
                        <b style="color:var(--secondary);"><?php echo $persen_in; ?>%</b>
                    </div>
                    <h2 style="margin:5px 0 0 0; color:var(--secondary); font-family: monospace;">
                        Rp <?php echo number_format($total_in, 0, ',', '.'); ?>
                    </h2>
                </div>

                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between;">
                        <small style="color:var(--danger);">TOTAL_EXPENSE</small>
                        <b style="color:var(--danger);"><?php echo $persen_out; ?>%</b>
                    </div>
                    <h2 style="margin:5px 0 0 0; color:var(--danger); font-family: monospace;">
                        Rp <?php echo number_format($total_out, 0, ',', '.'); ?>
                    </h2>
                </div>

                <div style="padding-top: 15px; border-top: 1px solid var(--border);">
                    <small style="color:var(--primary);">DATA_STATUS</small>
                    <p style="margin:5px 0 0 0; font-size: 11px; color: #57606a;">Live percentages updated via SQL aggregation.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top:0; font-size:16px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
                <i class="fas fa-history"></i> TRANSACTION HISTORY
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Amount (IDR)</th>
                        <th>Note</th>
                        <th>Execution Date</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $q = mysqli_query($koneksi, "SELECT * FROM view_transaksi WHERE nama_user = '$nama_user' ORDER BY tanggal DESC");
                    while($r = mysqli_fetch_assoc($q)) {
                        $warna = ($r['tipe'] == 'pemasukan') ? 'var(--success)' : 'var(--danger)';
                        echo "<tr>
                                <td><span style='color:var(--primary)'>[ ".strtoupper($r['kategori'])." ]</span></td>
                                <td style='color:$warna; font-family: monospace; font-size:16px; font-weight:bold;'>
                                    " . ($r['tipe'] == 'pemasukan' ? '▲' : '▼') . " Rp " . number_format($r['jumlah'], 0, ',', '.') . "
                                </td>
                                <td style='color:var(--text-dim)'>{$r['keterangan']}</td>
                                <td>" . date('Y-m-d', strtotime($r['tanggal'])) . "</td>
                                <td style='text-align:center;'>
                                    <a href='hapus_transaksi.php?id={$r['id_transaksi']}' onclick=\"return confirm('Confirm Delete?')\" style='color:var(--danger);'><i class='fas fa-trash-alt'></i></a>
                                </td>
                              </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        
        // Data dari PHP
        const valIn = <?php echo $total_in; ?>;
        const valOut = <?php echo $total_out; ?>;
        const pIn = <?php echo $persen_in; ?>;
        const pOut = <?php echo $persen_out; ?>;

        const financeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expense'],
                datasets: [{
                    data: [valIn, valOut],
                    backgroundColor: ['#00ff88', '#ff4d4d'],
                    borderColor: '#0d1117',
                    borderWidth: 5,
                    hoverOffset: 15
                }]
            },
            options: {
                cutout: '80%', // Membuat lubang tengah lebih besar untuk teks
                plugins: {
                    legend: { display: false }
                }
            },
            // PLUGIN UNTUK MENULIS PERSENTASE DI DALAM GRAFIK
            plugins: [{
                id: 'centerText',
                afterDraw: function(chart) {
                    const { width, height, ctx } = chart;
                    ctx.restore();
                    
                    // Style Teks Utama
                    ctx.textBaseline = "middle";
                    
                    // Baris 1: Persentase Income (Hijau)
                    const fontSize1 = (height / 180).toFixed(2);
                    ctx.font = "bold " + fontSize1 + "em Plus Jakarta Sans";
                    ctx.fillStyle = "#00ff88"; 
                    const tIn = pIn + "%",
                          tInX = Math.round((width - ctx.measureText(tIn).width) / 2),
                          tInY = height / 2 - 12;
                    ctx.fillText(tIn, tInX, tInY);

                    // Baris 2: Persentase Expense (Merah)
                    const fontSize2 = (height / 220).toFixed(2);
                    ctx.font = "bold " + fontSize2 + "em Plus Jakarta Sans";
                    ctx.fillStyle = "#ff4d4d"; 
                    const tOut = pOut + "%",
                          tOutX = Math.round((width - ctx.measureText(tOut).width) / 2),
                          tOutY = height / 2 + 15;
                    ctx.fillText(tOut, tOutX, tOutY);

                    ctx.save();
                }
            }]
        });
    </script>
</body>
</html>
