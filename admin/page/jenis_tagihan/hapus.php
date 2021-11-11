<?php
include "../../asset/inc/config.php";
$id_jenis_tagihan = $_GET['id_jenis_tagihan'];
$id_jenis_tagihan = mysqli_real_escape_string($koneksi,$_GET['id_jenis_tagihan']);
$query = mysqli_query($koneksi,"DELETE FROM tb_jenis_tagihan WHERE id_jenis_tagihan='$id_jenis_tagihan' ");
$query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan'");
header('location:../../index.php?page=jenis_tagihan');
?>