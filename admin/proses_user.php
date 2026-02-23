<?php
include "../config/koneksi.php";

if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $username = $_POST['username'];
      $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($conn,"INSERT INTO users (nama,username,password,role)
    VALUES ('$nama','$username','$password','$role')");

    header("Location: user.php");
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM users WHERE id='$id'");
    header("Location: user.php");
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    if(!empty($_POST['password'])){
         $password = $_POST['password']; 
        mysqli_query($conn,"UPDATE users SET 
            nama='$nama',
            username='$username',
            password='$password',
            role='$role'
            WHERE id='$id'");
    } else {
        mysqli_query($conn,"UPDATE users SET 
            nama='$nama',
            username='$username',
            role='$role'
            WHERE id='$id'");
    }

    header("Location: user.php");
}
?>
