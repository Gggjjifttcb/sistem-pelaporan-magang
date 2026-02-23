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
    echo "<script>
            alert('Anda sudah menginput laporan di tanggal ini!');
            window.location='dashboard.php';
          </script>";
    exit;
}

// INSERT
mysqli_query($conn,"INSERT INTO laporan 
(user_id,tanggal,status,uraian,pembelajaran,kendala,alasan)
VALUES 
('$id','$tanggal','$status','$uraian','$pembelajaran','$kendala','$alasan')");

echo "<script>
        alert('Laporan berhasil disimpan!');
        window.location='dashboard.php';
      </script>";
?>
