<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'panitia') {
    header("Location: index.php");
    exit;
}
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scan QR Verifikasi - Panitia</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Library HTML5 QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
<div class="app-container">
    <div class="sidebar">
        <div class="brand">Darul Ihsan</div>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="scan.php" class="active">Scan QR</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Pemindaian Verifikasi QR Code</h2>
        
        <div style="display:flex; gap:20px; margin-top:20px;">
            <!-- Frame Kamera -->
            <div class="card" style="flex:1;">
                <h4>Kamera Pemindai</h4>
                <div id="reader" style="width:100%; margin-top:15px;"></div>
            </div>

            <!-- Hasil Data Pendaftar -->
            <div class="card" style="flex:1;" id="result-card">
                <h4>Hasil Verifikasi Data</h4>
                <p style="color:#777; margin-top:20px;">Arahkan kamera ke QR Code pendaftar untuk menampilkan data pendaftar...</p>
                <form id="nisn-form" style="margin-top:20px;">
                    <label for="nisn"><b>Atau masukkan NISN</b></label>
                    <div style="display:flex; gap:10px; margin-top:10px;">
                        <input type="text" id="nisn" name="nisn" placeholder="NISN siswa" required style="flex:1; padding:10px; border:1px solid #ccc; border-radius:5px;">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function onScanSuccess(decodedText, decodedResult) {
    // Ajax request untuk mengambil data pendaftar berdasarkan NISN dari QR Code
    tampilkanDataPendaftar(decodedText);
}

function tampilkanDataPendaftar(nisn) {
    fetch('verifikasi.php?nisn=' + encodeURIComponent(nisn))
        .then(response => response.text())
        .then(data => {
            document.getElementById('result-card').innerHTML = data;
        });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 }
);
html5QrcodeScanner.render(onScanSuccess);

document.getElementById('nisn-form').addEventListener('submit', function (event) {
    event.preventDefault();
    tampilkanDataPendaftar(document.getElementById('nisn').value);
});
</script>
</body>
</html>