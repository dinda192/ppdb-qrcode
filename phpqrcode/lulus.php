<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'siswa') {
    header("Location: index.php");
    exit;
}

include "config/koneksi.php";

$id_user = mysqli_real_escape_string($koneksi, (string) $_SESSION['id_user']);
$query = mysqli_query(
    $koneksi,
    "SELECT s.*, u.nama_lengkap
     FROM siswa s
     JOIN users u ON s.id_user = u.id_user
     WHERE s.id_user='$id_user' AND s.status_verifikasi='Valid'
     LIMIT 1"
);
$data_siswa = mysqli_fetch_assoc($query);

if (!$data_siswa) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lulus - PPDB</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-container">
    <div class="sidebar">
        <div class="brand">Darul Ihsan</div>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="dokumen.php">Dokumen</a></li>
            <li><a href="lulus.php" class="active">Lulus</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Pengumuman Kelulusan</h2>
        <div class="card" style="border-left:5px solid #62CB75;">
            <h3 style="color:#2D3B32;">Selamat, <?= htmlspecialchars($data_siswa['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?>!</h3>
            <p style="margin-top:15px;">Berdasarkan hasil verifikasi berkas PPDB Darul Ihsan, Anda dinyatakan:</p>
            <p style="font-size:28px; font-weight:bold; color:#2e9d48; margin-top:15px;">LULUS</p>
            <p style="margin-top:15px;">Status verifikasi: <b><?= htmlspecialchars($data_siswa['status_verifikasi'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        </div>
    </div>
</div>
</body>
</html>
