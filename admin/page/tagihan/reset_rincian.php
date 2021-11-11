<?php
include "../../asset/inc/config.php";
$id_siswa = $_GET['id_siswa'];
$query = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_siswa='$id_siswa' ");
$query = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa' ");
?>
<form action="../../index.php?page=rincian_tagihan" method="post" enctype="multipart/form-data" name="myform">
  <input type="hidden" name="id_siswa" value="<?= $id_siswa;?>">
  <input type="hidden" name="rincian">
  <script type="text/javascript">
    document.myform.submit();
  </script>
</form>