<?php 
include '../koneksi.php';

// Pastikan yang menghapus adalah Admin
if ($_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; }

if (isset($_GET['id'])) {
    $id_target = $_GET['id'];
    $id_admin  = $_SESSION['id_user'];

    // Validasi: Admin tidak boleh hapus akun sendiri lewat URL
    if ($id_target == $id_admin) {
        echo "<script>alert('ERROR: Tidak bisa menghapus akun sendiri!'); window.location='kelola_user.php';</script>";
        exit;
    }

    // 1. Bersihkan transaksi user tersebut (agar tidak error foreign key)
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_user = '$id_target'");

    // 2. Hapus akun user
    $hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_target'");
    
    if ($hapus) {
        echo "<script>alert('SUCCESS: User & Records Deleted'); window.location='kelola_user.php';</script>";
    } else {
        echo "<script>alert('ERROR: Database Failure'); window.location='kelola_user.php';</script>";
    }
} else {
    header("Location: kelola_user.php");
}
?>