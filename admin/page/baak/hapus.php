<?php
include "../../asset/inc/config.php";
$id_pegawai = $_GET['id_pegawai'];
$sql = "SELECT * FROM tb_baak WHERE id_pegawai= '$id_pegawai'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$foto = $data['foto'];
		unlink("../../asset/images/baak/".$foto);
     }

$id_pegawai = mysqli_real_escape_string($koneksi,$_GET['id_pegawai']);
$query = mysqli_query($koneksi,"DELETE FROM tb_baak WHERE id_pegawai='$id_pegawai' ");
header('location:../../index.php?page=baak');
?>