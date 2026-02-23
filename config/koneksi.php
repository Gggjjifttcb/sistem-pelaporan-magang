<?php
$conn = mysqli_connect("localhost", "root", "", "magang");

if (!$conn) {
    die("Koneksi gagal");
}
session_start();
?>
