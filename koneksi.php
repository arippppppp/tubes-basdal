<?php
// Memulai session hanya jika belum aktif untuk menghindari Notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan standar Laragon
$db   = "keuangan";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>