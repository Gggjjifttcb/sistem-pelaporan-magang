<?php
//session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f1f5f9;
    font-family:Segoe UI, sans-serif;
}

/* NAVBAR */

.navbar{
    box-shadow:0 2px 10px rgba(12, 77, 129, 0.08);
}

/* HERO */

.hero{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    padding:50px 30px;
    border-radius:12px;
    margin-top:20px;
    background-attachment: fixed;
    
}

/* CARD MENU */

.menu-card{
    border:none;
    border-radius:12px;
    padding:25px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    transition:0.3s;
}

.menu-card:hover{
    transform:translateY(-6px);
    box-shadow:0 8px 18px rgba(0,0,0,0.15);
}

/* ICON STYLE */

.icon-box{
    font-size:40px;
    margin-bottom:10px;
}

/* RESPONSIVE */

@media (max-width:768px){

.hero{
    padding:30px 20px;
    text-align:center;
}

}

</style>

</head>
<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand" href="#"><strong>MagangHub</strong></a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse justify-content-end" id="menu">

<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link" href="dashboard.php">Dashboard</a>
</li>

<li class="nav-item">
<a class="nav-link" href="user.php">Data User</a>
</li>

<li class="nav-item">
<a class="nav-link" href="peserta.php">Peserta Magang</a>
</li>

<li class="nav-item">
<a class="btn btn-danger ms-2" href="../auth/logout.php">Logout</a>
</li>

</ul>

</div>

</div>
</nav>

<div class="container">

<!-- HERO -->

<div class="hero">

<h3>Dashboard Admin</h3>

<p>
Selamat datang di <strong>Portal Pelaporan Magang Terintegrasi</strong>.
Sistem ini digunakan untuk pengelolaan laporan kegiatan magang secara
digital, efisien, dan terorganisir.
</p>

</div>


<!-- MENU -->

<div class="row mt-4">

<div class="col-md-6 mb-4">

<div class="menu-card text-center">

<div class="icon-box">👤</div>

<h5>Data User</h5>

<p>Kelola seluruh data pengguna sistem.</p>

<a href="user.php" class="btn btn-primary">Buka Menu</a>

</div>

</div>


<div class="col-md-6 mb-4">

<div class="menu-card text-center">

<div class="icon-box">📄</div>

<h5>Peserta Magang</h5>

<p>Kelola data peserta dan informasi magang.</p>

<a href="peserta.php" class="btn btn-success">Buka Menu</a>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
