<?php
//session_start();
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
    <style>
    .btn-logout {
    width: 100%;
    padding: 4px;
    border: none;
    border-radius: 8px;
    background: #be1125;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    }

        .btn-logout:hover {
        background: #c40a10;
    }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="user.php">Data User</a>
    <a href="peserta.php">Data peserta magang</a>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <button class="btn-logout" role="button"><a href="../auth/logout.php" >Logout</a></button>
</div>

<div class="main">

    <div class="navbar">
        <h3>Dashboard Admin</h3>
        <span>Selamat Datang, Admin</span>
    </div>

    <div class="card">
        <h4>Ringkasan Sistem</h4>
        <p>Selamat datang di Sistem Pelaporan Magang, platform digital untuk mendokumentasikan perjalanan profesional Anda secara efisien.</p>
    </div>

</div>

</body>
</html>
