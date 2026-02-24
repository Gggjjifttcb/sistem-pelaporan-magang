<?php
session_start();
include "../config/koneksi.php";

if(isset($_POST['tambah'])){

    $user_id = $_POST['user_id'];
    $posisi  = $_POST['posisi'];
    $lokasi  = $_POST['lokasi'];
    $periode = $_POST['periode'];

    mysqli_query($conn,"
    INSERT INTO peserta_magang (user_id,posisi,lokasi,periode)
    VALUES ('$user_id','$posisi','$lokasi','$periode')
    ");

    header("Location: peserta.php");
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM peserta_magang WHERE id='$id'");
    header("Location: peserta.php");
}
?>
