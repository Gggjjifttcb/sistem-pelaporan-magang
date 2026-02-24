<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: ../auth/login.php");
    exit;
}

// Ambil semua peserta
$data = mysqli_query($conn,"
SELECT peserta_magang.*, users.nama 
FROM peserta_magang
JOIN users ON peserta_magang.user_id = users.id
");

// Ambil user yang belum punya data magang
$user = mysqli_query($conn,"
SELECT * FROM users 
WHERE role='user' 
AND id NOT IN (SELECT user_id FROM peserta_magang)
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Input Data Magang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Input Data Magang</h3>

<form method="POST" action="proses_peserta.php" class="mb-4">
<div class="row">

<div class="col">
<select name="user_id" class="form-control" required>
<option value="">Pilih User</option>
<?php while($u=mysqli_fetch_assoc($user)){ ?>
<option value="<?= $u['id'] ?>"><?= $u['nama'] ?></option>
<?php } ?>
</select>
</div>

<div class="col">
<input type="text" name="posisi" class="form-control" placeholder="Posisi Magang" required>
</div>

<div class="col">
<input type="text" name="lokasi" class="form-control" placeholder="Lokasi Magang" required>
</div>

<div class="col">
<input type="text" name="periode" class="form-control" placeholder=" Periode magang" required>
</div>

<div class="col">
<button name="tambah" class="btn btn-success">Simpan</button>
</div>

</div>
</form>

<h4>Data Peserta Magang</h4>

<table class="table table-bordered">
<tr>
<th>No</th>
<th>Nama</th>
<th>Posisi</th>
<th>Lokasi</th>
<th>Periode</th>
<th>Aksi</th>
</tr>

<?php 
$no=1;
while($d=mysqli_fetch_assoc($data)){ 
?>
<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['posisi'] ?></td>
<td><?= $d['lokasi'] ?></td>
<td><?= $d['periode'] ?></td>
<td>
<a href="proses_peserta.php?hapus=<?= $d['id'] ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin hapus?')">
Hapus
</a>
</td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</body>
</html>
