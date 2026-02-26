<?php
session_start();
include "../config/koneksi.php";

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    header("Location: login.php?error=invalid");
    exit();
}

$username = mysqli_real_escape_string($conn, $username);
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

if ($user && $password == $user['password']) {

    $_SESSION['login'] = true;
    $_SESSION['id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['nama'] = $user['nama'];

    if ($user['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/dashboard.php");
    }
    exit();

} else {
    // Jika username tidak ada ATAU password salah
    header("Location: login.php?error=invalid");
    exit();
}
?>
