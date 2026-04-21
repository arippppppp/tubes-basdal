<?php include '../koneksi.php'; 
if (!isset($_SESSION['id_user'])) { header("Location: ../index.php"); exit; } ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Execute Order | Financial</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Memperbaiki tampilan kalender browser agar sesuai tema dark */
        ::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Membuat icon kalender jadi putih */
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <div class="header-box">
            <h2 style="margin:0; color:var(--primary);"><i class="fas fa-file-invoice-dollar"></i> NEW_ORDER</h2>
            <div class="nav-links">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i> CANCEL</a>
            </div>
        </div>

        <div class="card">
            <form method="POST" id="transaksiForm">
                <label style="color:var(--primary); font-size:11px;">SELECT_CATEGORY</label>
                <select name="kat" required>
                    <?php 
                    $qk = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($rk = mysqli_fetch_assoc($qk)) {
                        echo "<option value='{$rk['id_kategori']}'>".strtoupper($rk['nama_kategori'])."</option>";
                    } ?>
                </select>

                <label style="color:var(--primary); font-size:11px;">NOMINAL_AMOUNT</label>
                <input type="text" id="display_jumlah" placeholder="e.g. 3,000,000" required>
                <input type="hidden" name="jml" id="real_jumlah">

                <label style="color:var(--primary); font-size:11px;">TRANSACTION_NOTE</label>
                <textarea name="ket" rows="3" placeholder="Notes..."></textarea>

                <label style="color:var(--primary); font-size:11px;">EXECUTION_DATE</label>
                <input type="date" name="tgl" value="<?php echo date('Y-m-d'); ?>" required>

                <button type="submit" name="simpan"><i class="fas fa-bolt"></i> EXECUTE TRANSACTION</button>
            </form>

            <?php 
            if(isset($_POST['simpan'])){
                $u=$_SESSION['id_user']; $k=$_POST['kat']; $j=$_POST['jml']; $ket=$_POST['ket']; $t=$_POST['tgl'];
                mysqli_query($koneksi, "CALL tambah_transaksi($u,$k,$j,'$ket','$t')");
                echo "<script>window.location='dashboard.php';</script>";
            } ?>
        </div>
    </div>

    <script>
        const displayInput = document.getElementById('display_jumlah');
        const realInput = document.getElementById('real_jumlah');

        displayInput.addEventListener('input', function(e) {
            // Ambil angka saja
            let value = this.value.replace(/[^0-9]/g, '');
            
            // Simpan angka asli ke hidden input
            realInput.value = value;
            
            // Format angka dengan koma untuk tampilan
            if (value) {
                this.value = parseInt(value).toLocaleString('en-US');
            } else {
                this.value = '';
            }
        });

        // Pastikan saat submit, data terkirim
        document.getElementById('transaksiForm').onsubmit = function() {
            if(!realInput.value) {
                alert("Please enter amount!");
                return false;
            }
        };
    </script>
</body>
</html>