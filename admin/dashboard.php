<?php
include "../config/koneksi.php";
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: ../auth/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="user.php">Data User</a>
    <a href="peserta.php">Data peserta magang</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main">

    <div class="navbar">
        <h3>Dashboard Admin</h3>
        <span>Selamat Datang, Admin</span>
    </div>

    <div class="card">
        <h4>Ringkasan Sistem</h4>
        <p>Selamat datang di Sistem Pelaporan Magang.</p>
    </div>

</div>

</body>
</html>
