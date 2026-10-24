<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'panitia') {
    http_response_code(403);
    exit('Akses ditolak.');
}

include "config/koneksi.php";

// Jika dipanggil via Ajax GET untuk menampilkan data
if (isset($_GET['nisn'])) {
    $nisn = mysqli_real_escape_string($koneksi, $_GET['nisn']);
    $q = mysqli_query($koneksi, "SELECT s.*, u.nama_lengkap FROM siswa s JOIN users u ON s.id_user=u.id_user WHERE s.nisn='$nisn'");
    
    if (mysqli_num_rows($q) > 0) {
        $siswa = mysqli_fetch_assoc($q);
        ?>
        <h4>Detail Pendaftar</h4>
        <table style="width:100%; margin-top:15px; border-collapse:collapse;">
            <tr><td><b>Nama</b></td><td>: <?= $siswa['nama_lengkap']; ?></td></tr>
            <tr><td><b>NISN</b></td><td>: <?= $siswa['nisn']; ?></td></tr>
            <tr><td><b>No HP</b></td><td>: <?= $siswa['no_hp']; ?></td></tr>
            <tr><td><b>Status</b></td><td>: <b><?= $siswa['status_verifikasi']; ?></b></td></tr>
        </table>

        <form action="verifikasi.php" method="POST" style="margin-top:20px;">
            <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">
            <button type="submit" name="status" value="Valid" class="btn btn-success" style="width:100%; margin-bottom:10px;">[V] SETUJUI / VERIFIKASI (Valid)</button>
            <button type="submit" name="status" value="Tidak Valid" class="btn btn-danger" style="width:100%;">[X] TOLAK / BERKAS TIDAK LENGKAP</button>
        </form>
        <?php
    } else {
        echo "<p style='color:red;'>Data NISN tidak ditemukan di sistem!</p>";
    }
    exit;
}

// Jika dipanggil via POST untuk simpan status
if (isset($_POST['id_siswa']) && isset($_POST['status'])) {
    $id_siswa = $_POST['id_siswa'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "UPDATE siswa SET status_verifikasi='$status' WHERE id_siswa='$id_siswa'");
    header("Location: scan.php");
    exit;
}
?>