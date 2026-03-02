<?php
session_start();
include "../config/koneksi.php";

$id = $_SESSION['id'];
$tanggal = $_POST['tanggal'];
$status = $_POST['status'];

$uraian = $_POST['uraian'] ?? '';
$pembelajaran = $_POST['pembelajaran'] ?? '';
$kendala = $_POST['kendala'] ?? '';
$alasan = $_POST['alasan'] ?? '';

// CEK DUPLIKAT
$cek = mysqli_query($conn,"SELECT * FROM laporan 
                           WHERE user_id='$id' 
                           AND tanggal='$tanggal'");

if(mysqli_num_rows($cek) > 0){
    header("Location: dashboard.php?date=$tanggal&error=1");
    exit;
}

// INSERT
mysqli_query($conn,"INSERT INTO laporan 
(user_id,tanggal,status,uraian,pembelajaran,kendala,alasan)
VALUES 
('$id','$tanggal','$status','$uraian','$pembelajaran','$kendala','$alasan')");

header("Location: dashboard.php?date=$tanggal&success=1");
exit;
?>
