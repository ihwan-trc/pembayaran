<?php
if(isset($_POST['tambah_kelas'])){
    $kelas = $_POST['kelas'];
    include_once("../../asset/inc/config.php");
    $result = mysqli_query($koneksi, "INSERT INTO tb_kelas(kelas) VALUES('$kelas')");
    header("Location:../../index.php?page=kelas");
    }

if(isset($_POST['tambah_jurusan'])){
    $jurusan = $_POST['jurusan'];
    include_once("../../asset/inc/config.php");
    $result = mysqli_query($koneksi, "INSERT INTO tb_jurusan(jurusan) VALUES('$jurusan')");
    header("Location:../../index.php?page=kelas");
    }

if(isset($_POST['tambah_semester'])){
    $semester = $_POST['semester'];
    include_once("../../asset/inc/config.php");
    $result = mysqli_query($koneksi, "INSERT INTO tb_semester(semester) VALUES('$semester')");
    header("Location:../../index.php?page=kelas");
    }

if(isset($_POST['tambah_tahun'])){
    $tahun = $_POST['tahun'];
    include_once("../../asset/inc/config.php");
    $result = mysqli_query($koneksi, "INSERT INTO tb_tahun(tahun) VALUES('$tahun')");
    header("Location:../../index.php?page=kelas");
    }
?>