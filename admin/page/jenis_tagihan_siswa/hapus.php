<?php
include "../../asset/inc/config.php";
$id_jns_tghn_siswa = $_GET['id_jns_tghn_siswa'];
$id_jns_tghn_siswa = mysqli_real_escape_string($koneksi,$_GET['id_jns_tghn_siswa']);
$query = mysqli_query($koneksi,"DELETE FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jns_tghn_siswa' ");
$query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_jns_tghn_siswa='$id_jns_tghn_siswa' ");
header('location:../../index.php?page=jenis_tagihan_siswa');
?>