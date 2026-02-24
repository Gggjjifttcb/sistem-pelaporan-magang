<?php
session_start();
include "../config/koneksi.php";
if($_SESSION['role']!='admin'){
    header("Location: ../auth/login.php");
}
$data = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola User</title>
    <link rel="stylesheet" href="../assets/css/user.css">
</head>
<body class="container mt-4">

<h3>Kelola User</h3>

<form method="POST" action="proses_user.php" class="mb-4">
    <div class="row">
        <div class="col">
            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
        </div>
        <div class="col">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="col">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col">
            <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="col">
            <button name="tambah" class="btn btn-success">Tambah</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

<?php 
$no=1;
while($row=mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['role'] ?></td>
    <td>
        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="proses_user.php?hapus=<?= $row['id'] ?>" 
           onclick="return confirm('Yakin hapus?')" 
           class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>

</body>
</html>
