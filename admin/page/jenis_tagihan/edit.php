<?php 
include_once("../../asset/inc/config.php");

  if (isset($_POST['edit'])) {
  	$id_jenis_tagihan = $_POST['id_jenis_tagihan'];
    $jenis_tagihan = $_POST['jenis_tagihan'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $jumlah = str_replace(".", "", $_POST['jumlah']);
  	
    $result = mysqli_query($koneksi, "UPDATE tb_jenis_tagihan SET jenis_tagihan='$jenis_tagihan',kelas='$kelas',jurusan='$jurusan',jumlah='$jumlah' WHERE id_jenis_tagihan='$id_jenis_tagihan'");

  header("Location:../../index.php?page=jenis_tagihan");
}
?>