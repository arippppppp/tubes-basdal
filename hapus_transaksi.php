<?php 
include '../koneksi.php';
if (!isset($_SESSION['id_user'])) { header("Location: ../index.php"); exit; }

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $id_user = $_SESSION['id_user'];

    // Hapus data berdasarkan ID transaksi dan pastikan miliki user yang sedang login
    $query = "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi' AND id_user = '$id_user'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Record Deleted Successfully'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: Deletion Failed'); window.location='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
}
?>