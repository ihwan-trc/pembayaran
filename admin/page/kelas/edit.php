<?php 
include_once("../../asset/inc/config.php");

if (isset($_POST['edit_kelas'])) {
  	$id_kelas = $_POST['id_kelas'];
  	$kelas = $_POST['kelas'];
    $result = mysqli_query($koneksi, "UPDATE tb_kelas SET kelas='$kelas' WHERE id_kelas='$id_kelas'");
    header("Location:../../index.php?page=kelas");
  }

if (isset($_POST['edit_jurusan'])) {
    $id_jurusan = $_POST['id_jurusan'];
    $jurusan = $_POST['jurusan'];
    $result = mysqli_query($koneksi, "UPDATE tb_jurusan SET jurusan='$jurusan' WHERE id_jurusan='$id_jurusan'");
    header("Location:../../index.php?page=kelas");
  }

if (isset($_POST['edit_semester'])) {
    $id_semester = $_POST['id_semester'];
    $semester = $_POST['semester'];
    $result = mysqli_query($koneksi, "UPDATE tb_semester SET semester='$semester' WHERE id_semester='$id_semester'");
    header("Location:../../index.php?page=kelas");
  }

if (isset($_POST['edit_tahun'])) {
    $id_tahun = $_POST['id_tahun'];
    $tahun = $_POST['tahun'];
    $result = mysqli_query($koneksi, "UPDATE tb_tahun SET tahun='$tahun' WHERE id_tahun='$id_tahun'");
    header("Location:../../index.php?page=kelas");
  }
 ?>