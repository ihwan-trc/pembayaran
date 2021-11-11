<?php
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$id_siswa = $_GET['id_siswa'];
$sql = "SELECT * FROM tb_siswa WHERE id_siswa= '$id_siswa'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result)) { 
     	$id_siswa = $data['id_siswa'];
     	$kelas = $data['kelas'];
     	$jurusan = $data['jurusan'];
		$foto = $data['foto'];
		unlink("../../asset/images/siswa/".$foto);

		$query = mysqli_query($koneksi,"DELETE FROM tb_siswa WHERE id_siswa='$id_siswa'");
		$query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_siswa='$id_siswa'");
		$query2 = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa'");
	  ?>

<form action="../../index.php?page=siswa" method="post" name="myform">
  <input type="hidden" name="kelas" value="<?= $kelas;?>">
  <input type="hidden" name="jurusan" value="<?= $jurusan;?>">
  <input type="hidden" name="search">
  <script type="text/javascript">
    document.myform.submit();
  </script>
</form>

<?php } ?>