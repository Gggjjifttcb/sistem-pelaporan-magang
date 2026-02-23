<?php
include "../config/koneksi.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Edit User</h3>

<form method="POST" action="proses_user.php">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">

    <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control mb-2" required>

    <input type="text" name="username" value="<?= $data['username'] ?>" class="form-control mb-2" required>

    <input type="password" name="password" class="form-control mb-2" placeholder="Kosongkan jika tidak ganti password">

    <select name="role" class="form-control mb-2">
        <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
        <option value="user" <?= $data['role']=='user'?'selected':'' ?>>User</option>
    </select>

    <button name="update" class="btn btn-primary">Update</button>
</form>

</body>
</html>
