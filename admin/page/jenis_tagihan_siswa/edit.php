<?php 
include_once("../../asset/inc/config.php");

  if (isset($_POST['edit'])) {
  	$id_jns_tghn_siswa = $_POST['id_jns_tghn_siswa'];
    $jenis_tagihan_siswa = $_POST['jenis_tagihan_siswa'];
  	
    $result = mysqli_query($koneksi, "UPDATE tb_jenis_tagihan_siswa SET jenis_tagihan_siswa='$jenis_tagihan_siswa' WHERE id_jns_tghn_siswa='$id_jns_tghn_siswa'");

  header("Location:../../index.php?page=jenis_tagihan_siswa");
}
?>