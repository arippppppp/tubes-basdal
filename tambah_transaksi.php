<?php
include 'koneksi.php';

// Cek apakah tombol simpan sudah diklik
if (isset($_POST['simpan'])) {
    $id_user     = $_POST['id_user'];
    $id_kategori = $_POST['id_kategori'];
    $jumlah      = $_POST['jumlah'];
    $keterangan  = $_POST['keterangan'];
    $tanggal     = $_POST['tanggal'];

    // Memanggil Stored Procedure 'tambah_transaksi' dari file SQL kamu
    $query = "CALL tambah_transaksi($id_user, $id_kategori, $jumlah, '$keterangan', '$tanggal')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Berhasil Ditambah!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <style>
        body { font-family: sans-serif; background: #121212; color: white; padding: 20px; }
        form { max-width: 400px; background: #1e1e1e; padding: 20px; border-radius: 8px; }
        input, select, textarea { width: 100%; padding: 8px; margin: 10px 0; border: 1px solid #333; background: #252525; color: white; }
        button { background: #00adb5; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Input Transaksi Baru</h2>
    <form method="POST">
        <label>User ID (Sesuai tabel users):</label>
        <input type="number" name="id_user" placeholder="Contoh: 1" required>

        <label>Kategori ID (Sesuai tabel kategori):</label>
        <input type="number" name="id_kategori" placeholder="Contoh: 1 (Gaji) atau 4 (Makan)" required>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" required>

        <label>Keterangan:</label>
        <textarea name="keterangan"></textarea>

        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>

        <button type="submit" name="simpan">Simpan Transaksi</button>
        <a href="index.php" style="color: #aaa; text-decoration: none; margin-left: 10px;">Batal</a>
    </form>
</body>
</html>
