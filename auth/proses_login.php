<?php
session_start();
include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Cek apakah data terkirim
if(empty($username) || empty($password)){
    die("Username atau Password kosong");
}

// Ambil user dari database
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

if(!$query){
    die("Query Error: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($query);

// Jika user ditemukan
if($user){

    // LOGIN TANPA HASH (UNTUK TESTING)
    if($password == $user['password']){

        $_SESSION['login'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama'] = $user['nama'];

        if($user['role'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }

        exit;

    } else {
        echo "Password salah";
    }

} else {
    echo "Username tidak ditemukan";
}
?>
