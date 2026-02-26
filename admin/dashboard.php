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
    .logout-button {
        /* Warna Dasar */
        background-color: #f44336; /* Merah */
        color: white; /* Warna Teks */
        
        /* Bentuk dan Padding */
        padding: 8px 18px;
        border-radius: 5px; /* Ujung melengkung */
        text-decoration: none; /* Menghilangkan garis bawah link */
        font-family: Arial, sans-serif;
        font-weight: bold;
        display: inline-block;
        
        /* Transisi halus */
        transition: background-color 0.3s ease;

        text-align: center; /* Menyelaraskan teks di tengah */
    }

    /* Efek saat Kursor di atas tombol (Hover) */
    .logout-button:hover {
        background-color: #d32f2f; /* Merah lebih gelap */
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="user.php">Data User</a>
    <a href="peserta.php">Data peserta magang</a>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="../auth/logout.php" class="logout-button" >Logout</a>
</div>

<div class="main">

    <div class="navbar">
        <h3>Sisten Pelaporan MaganHub</h3>
        <span>Sesi Aktif: <strong>Administrator Utama</strong></span>
    </div>

    <div class="card">
        <p>
            Selamat datang di <strong>Portal Pelaporan Magang Terintegrasi</strong>. 
            Platform digital ini difungsikan untuk standarisasi dokumentasi, 
            efisiensi pelaporan, serta pemantauan perkembangan kompetensi profesional 
            secara akurat dan transparan.
        </p>
    </div>

</div>

</body>
</html>
