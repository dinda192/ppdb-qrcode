<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}
include "config/koneksi.php";
include "phpqrcode/qrlib.php"; // Library Generator QR Code

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

// Ambil Data Siswa jika login sebagai siswa
$data_siswa = null;
if ($role == 'siswa') {
    $q = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_user='$id_user'");
    $data_siswa = mysqli_fetch_assoc($q);

    // Generate QR Code otomatis jika belum ada
    if ($data_siswa && empty($data_siswa['qr_code'])) {
        $tempDir = "assets/qrcode/";
        $codeContents = $data_siswa['nisn'];
        $fileName = 'QR-' . $data_siswa['nisn'] . '.png';
        
        QRcode::png($codeContents, $tempDir.$fileName, QR_ECLEVEL_L, 4);
        
        // Update database
        mysqli_query($koneksi, "UPDATE siswa SET qr_code='$fileName' WHERE id_siswa='".$data_siswa['id_siswa']."'");
        $data_siswa['qr_code'] = $fileName;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PPDB</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">Darul Ihsan</div>
        <ul>
            <li><a href="dashboard.php" class="active">Beranda</a></li>
            <?php if($role == 'siswa'): ?>
                <li><a href="dokumen.php">Dokumen</a></li>
                <?php if($data_siswa && $data_siswa['status_verifikasi'] === 'Valid'): ?>
                    <li><a href="lulus.php">Lulus</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="scan.php">Scan QR</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Selamat Datang, <?= $_SESSION['nama']; ?></h2>
        
        <?php if($role == 'siswa'): ?>
            <div class="card" style="background:#62CB75; color:#fff;">
                <h3>PPDB Darul Ihsan 2026/2027</h3>
                <p>Portal PPDB Darul Ihsan</p>
            </div>

            <div style="display:flex; gap:20px;">
                <div class="card" style="flex:1;">
                    <h4>Status Pendaftaran</h4>
                    <p style="font-size:20px; font-weight:bold; color:#e67e22; margin-top:10px;">
                        <?= $data_siswa['status_verifikasi']; ?>
                    </p>
                </div>
                
                <div class="card" style="flex:1; text-align:center;">
                    <h4>QR Code Identitas Pendaftar</h4>
                    <?php if(!empty($data_siswa['qr_code'])): ?>
                        <img src="assets/qrcode/<?= $data_siswa['qr_code']; ?>" width="120" style="margin-top:10px;">
                        <br><a href="assets/qrcode/<?= $data_siswa['qr_code']; ?>" download class="btn btn-primary" style="margin-top:10px; font-size:12px;">Unduh QR Code</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <h3>Panel Panitia PPDB</h3>
                <p>Silakan pilih menu <b>Scan QR</b> di sidebar untuk melakukan verifikasi dokumen fisik pendaftar secara cepat.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>