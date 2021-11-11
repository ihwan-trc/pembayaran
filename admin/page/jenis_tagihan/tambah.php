<?php
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['tambah'])){
    include_once("../../asset/inc/config.php");
    $jenis_tagihan = $_POST['jenis_tagihan'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $jumlah = str_replace(".", "", $_POST['jumlah']);

    $result = mysqli_query($koneksi, "INSERT INTO tb_jenis_tagihan(jenis_tagihan,kelas,jurusan,jumlah) VALUES('$jenis_tagihan','$kelas','$jurusan','$jumlah')");

    header("Location:../../index.php?page=jenis_tagihan");
}
?>