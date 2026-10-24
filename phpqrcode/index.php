<?php
session_start();
include "config/koneksi.php";

$error = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        // Verifikasi password (menggunakan password_verify atau plain text dummy)
        if (password_verify($password, $row['password']) || $password == "admin123" || $password == "dinda123") {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama_lengkap'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - PPDB Darul Ihsan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-card">
        <h3>PPDB Darul Ihsan</h3>
        <p style="margin-bottom:20px; font-size:14px; color:#666;">Selamat Datang di aplikasi PPDB</p>
        <?php if($error): ?>
            <p style="color:red; font-size:12px;"><?= $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-primary" style="width:100%; margin-top:10px;">Masuk</button>
        </form>
    </div>
</body>
</html>