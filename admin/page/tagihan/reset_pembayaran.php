<?php
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST['resetpembayaran'])) {
	$kelas = $_POST['kelas'];
	$jurusan = $_POST['jurusan'];

	$sql = "SELECT * FROM tb_siswa WHERE kelas='$kelas' AND jurusan='$jurusan'";
	$result = mysqli_query($koneksi,$sql);
	while($data = mysqli_fetch_assoc($result))
	     { 
	     	$id_siswa = $data['id_siswa'];

			$query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_siswa='$id_siswa'");
			$query2 = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa'");
	     } ?>
	     <form action="../../index.php?page=tagihan" method="post" enctype="multipart/form-data" name="myform">
		  <input type="hidden" name="kelas_back" value="<?= $kelas;?>">
		  <input type="hidden" name="jurusan_back" value="<?= $jurusan;?>">
		  <input type="hidden" name="back">
		  <script type="text/javascript">
		    document.myform.submit();
		  </script>
		</form>
<?php } ?>