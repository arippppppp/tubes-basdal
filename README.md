
WEB Manajemen Keuangan 

## 🛠️ Tech Stack
- **Backend:** PHP 8.x
- **Database:** MySQL
- **Frontend:** Vanilla CSS (Glassmorphism Style)
- **Icons:** Font Awesome 6.0
- **Analytics:** Chart.js

## ✨ Fitur Unggulan
- **3D Moving Grid Background:** UI interaktif dengan efek hologram yang bergerak.
- **Advanced Analytics Center:** Grafik *doughnut* interaktif yang menampilkan persentase pemasukan dan pengeluaran secara real-time.
- **Automated Database Triggers:** Sinkronisasi otomatis antara tabel transaksi dan log aktivitas.
- **Secure Access:** Sistem login dengan enkripsi MD5 dan proteksi role (Admin/User).

## ⚙️ Panduan Instalasi
1. Clone repositori ini ke folder `www` (Laragon) atau `htdocs` (XAMPP).
2. Buat database baru bernama `keuangan` di MySQL.
3. Import file database yang tersedia di folder `db/database_keuangan.sql`.
4. Buka file `koneksi.php` dan sesuaikan konfigurasi database (Username: `root`, Password: ` `).
5. Akses melalui browser di `localhost/tubes_keuangan`.

## 📂 Struktur Database
- `users`: Menyimpan data akun dan role.
- `transaksi`: Mencatat seluruh aliran uang masuk dan keluar.
- `kategori`: Klasifikasi jenis transaksi.
- `log_transaksi`: Audit trail otomatis menggunakan MySQL Trigger.

