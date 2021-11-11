<?php 
include_once("../../asset/inc/config.php");

if (isset($_GET['id_kelas'])) {
  	$id_kelas = $_GET['id_kelas'];
  	$sql = "SELECT * FROM tb_kelas WHERE id_kelas='$id_kelas'";
	$result = mysqli_query($koneksi,$sql);
	$id_kelas = mysqli_real_escape_string($koneksi,$_GET['id_kelas']);
	$query = mysqli_query($koneksi,"DELETE FROM tb_kelas WHERE id_kelas='$id_kelas' ");
	header('location:../../index.php?page=kelas');
  }

if (isset($_GET['id_jurusan'])) {
  	$id_jurusan = $_GET['id_jurusan'];
  	$sql = "SELECT * FROM tb_jurusan WHERE id_jurusan='$id_jurusan'";
	$result = mysqli_query($koneksi,$sql);
	$id_jurusan = mysqli_real_escape_string($koneksi,$_GET['id_jurusan']);
	$query = mysqli_query($koneksi,"DELETE FROM tb_jurusan WHERE id_jurusan='$id_jurusan' ");
	header('location:../../index.php?page=kelas');
  }

if (isset($_GET['id_semester'])) {
  	$id_semester = $_GET['id_semester'];
  	$sql = "SELECT * FROM tb_semester WHERE id_semester='$id_semester'";
	$result = mysqli_query($koneksi,$sql);
	$id_semester = mysqli_real_escape_string($koneksi,$_GET['id_semester']);
	$query = mysqli_query($koneksi,"DELETE FROM tb_semester WHERE id_semester='$id_semester' ");
	header('location:../../index.php?page=kelas');
  }

 if (isset($_GET['id_tahun'])) {
  	$id_tahun = $_GET['id_tahun'];
  	$sql = "SELECT * FROM tb_tahun WHERE id_tahun='$id_tahun'";
	$result = mysqli_query($koneksi,$sql);
	$id_tahun = mysqli_real_escape_string($koneksi,$_GET['id_tahun']);
	$query = mysqli_query($koneksi,"DELETE FROM tb_tahun WHERE id_tahun='$id_tahun' ");
	header('location:../../index.php?page=kelas');
  }
 ?>