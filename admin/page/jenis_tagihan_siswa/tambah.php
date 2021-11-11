<?php
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['tambah'])){
    include_once("../../asset/inc/config.php");
    $jenis_tagihan_siswa = $_POST['jenis_tagihan_siswa'];

    $result = mysqli_query($koneksi, "INSERT INTO tb_jenis_tagihan_siswa(jenis_tagihan_siswa) VALUES('$jenis_tagihan_siswa')");

    header("Location:../../index.php?page=jenis_tagihan_siswa");
}
?>