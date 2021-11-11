<?php 
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST['tambah_tagihan_siswa'])) {
  $id_siswa_post = $_POST['id_siswa'];
  $id_jns_tghn_siswa_post = $_POST['id_jns_tghn_siswa'];
  $jml_post = str_replace(".", "", $_POST['jumlah']);
  $status_post = $_POST['status'];
  $chart = date('m');

      $cek_tb_tghn_siswa = mysqli_query($koneksi,"SELECT * FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");
      while ($data = mysqli_fetch_assoc($cek_tb_tghn_siswa)) {
        $id_siswa1 = $data['id_siswa'];
        $id_jns_tghn_siswa1 = $data['id_jns_tghn_siswa'];
        $jml1 = $data['jumlah'];
$jumlah1 = $jml_post + $jml1;

      $cek_tb_pembayaran = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'";
      $result_2 = mysqli_query($koneksi,$cek_tb_pembayaran);
      while ($data = mysqli_fetch_assoc($result_2)) {
        $id_siswa2 = $data['id_siswa'];
        $id_jns_tghn_siswa2 = $data['id_jns_tghn_siswa'];
        $jml2 = $data['jumlah'];
$jumlah2 = $jml_post + $jml2;

  }
}  
if ($jumlah1 == $jumlah2) {
  $status = "Lunas";
}
if ($jumlah1 != $jumlah2) {
  $status = "Proses";
}

if ($id_siswa_post !== $id_siswa1) {
  if ($id_siswa_post !== $id_siswa2) {
    if ($id_jns_tghn_siswa_post !== $id_jns_tghn_siswa1) {
      if ($id_jns_tghn_siswa_post !== $id_jns_tghn_siswa2) {
        if ($status_post == "Proses") {
          $result1 = mysqli_query($koneksi, "INSERT INTO tb_tagihan_siswa(id_siswa,id_jns_tghn_siswa,jumlah) VALUES('$id_siswa_post','$id_jns_tghn_siswa_post','$jml_post')");
        }
        if ($status_post == "Lunas") {
          $result1 = mysqli_query($koneksi, "INSERT INTO tb_tagihan_siswa(id_siswa,id_jns_tghn_siswa,jumlah) VALUES('$id_siswa_post','$id_jns_tghn_siswa_post','$jml_post')");

          $result2 = mysqli_query($koneksi, "INSERT INTO tb_pembayaran(id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart) VALUES('$id_siswa_post','','$id_jns_tghn_siswa_post','$status','$jml_post','$chart')");
        } 
      }
    }
  }
}

if ($id_siswa_post == $id_siswa1) {
  if ($id_siswa_post !== $id_siswa2) {
    if ($id_jns_tghn_siswa_post == $id_jns_tghn_siswa1) {
      if ($id_jns_tghn_siswa_post !== $id_jns_tghn_siswa2) {
        if ($status_post == "Proses") {
          $result1 = mysqli_query($koneksi, "UPDATE tb_tagihan_siswa SET id_siswa='$id_siswa_post',id_jns_tghn_siswa='$id_jns_tghn_siswa_post',jumlah='$jumlah1' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");
        }
        if ($status_post == "Lunas") {
          $result1 = mysqli_query($koneksi, "UPDATE tb_tagihan_siswa SET id_siswa='$id_siswa_post',id_jns_tghn_siswa='$id_jns_tghn_siswa_post',jumlah='$jumlah1' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");

        $result2 = mysqli_query($koneksi, "INSERT INTO tb_pembayaran(id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart) VALUES('$id_siswa_post','','$id_jns_tghn_siswa_post','$status','$jml_post','$chart')");
        } 
      }
    }
  }
}


if ($id_siswa_post == $id_siswa1) {
  if ($id_siswa_post == $id_siswa2) {
    if ($id_jns_tghn_siswa_post == $id_jns_tghn_siswa1) {
      if ($id_jns_tghn_siswa_post == $id_jns_tghn_siswa2) {
        if ($status_post == "Proses") {
          $result1 = mysqli_query($koneksi, "UPDATE tb_tagihan_siswa SET id_siswa='$id_siswa_post',id_jns_tghn_siswa='$id_jns_tghn_siswa_post',jumlah='$jumlah1' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");
          $result2 = mysqli_query($koneksi, "UPDATE tb_pembayaran SET status='Proses',chart='$chart' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");
        }
        if ($status_post == "Lunas") {
          $result1 = mysqli_query($koneksi, "UPDATE tb_tagihan_siswa SET id_siswa='$id_siswa_post',id_jns_tghn_siswa='$id_jns_tghn_siswa_post',jumlah='$jumlah1' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");

        $result2 = mysqli_query($koneksi, "UPDATE tb_pembayaran SET id_siswa='$id_siswa_post',id_jenis_tagihan='',id_jns_tghn_siswa='$id_jns_tghn_siswa_post',status='$status',jumlah='$jumlah2',chart='$chart' WHERE id_siswa='$id_siswa_post' AND id_jns_tghn_siswa='$id_jns_tghn_siswa_post'");
        } 
      }
    }
  }
}

?>

<form action="../../index.php?page=rincian_tagihan" method="post" enctype="multipart/form-data" name="myform">
  <input type="hidden" name="id_siswa" value="<?= $id_siswa_post;?>">
  <input type="hidden" name="rincian">
  <script type="text/javascript">
    document.myform.submit();
  </script>
</form>
<?php
}
?>