<?php 
include "../../asset/inc/config.php";
if (isset($_POST['bayar'])) {
	$kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];
    $id_siswa_plus = $_POST['id_siswa_plus'];
    $id_jenis_tagihan_plus = $_POST['id_jenis_tagihan_plus'];
    $id_jns_tghn_siswa_plus = $_POST['id_jns_tghn_siswa_plus'];
    $jml_tagihan_plus = str_replace(".", "", $_POST['jml_tagihan_plus']);
    $bayar_plus = str_replace(".", "", $_POST['bayar_plus']);
    if ($bayar_plus == $jml_tagihan_plus) {
      $status_plus = "Lunas";
      $chart = date('m');
    }elseif ($bayar_plus >= $jml_tagihan_plus){
      $status_plus = "Proses";
      $chart = date('m');
    }elseif ($bayar_plus <= $jml_tagihan_plus){
      $status_plus = "Proses";
      $chart = date('m');
    }

    $result = mysqli_query($koneksi, "INSERT INTO tb_pembayaran
      (id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart)
      VALUES
      ('$id_siswa_plus','$id_jenis_tagihan_plus','$id_jns_tghn_siswa_plus','$status_plus','$bayar_plus','$chart')");
    ?>
    <form action="../../index.php?page=tagihan" method="post" enctype="multipart/form-data" name="myform">
		<input type="hidden" name="jns_tghn_form" value="<?=$jenis_tghn_siswa;?>">
		<input type="hidden" name="kelas_back" value="<?=$kelas_back;?>">
		<input type="hidden" name="jurusan_back" value="<?=$jurusan_back;?>">
		<input type="hidden" name="back">
		<script type="text/javascript">
			document.myform.submit();
		</script>
	</form>
<?php
  }
?>


<?php
if (isset($_POST['hapus'])) {
    $id_tagihan_siswa_hapus = $_POST['id_tagihan_siswa_hapus'];
    $kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];

    if ($id_tagihan_siswa_hapus !== NULL) {
      $query2 = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE id_tagihan_siswa='$id_tagihan_siswa_hapus' ");
    }
    ?>
    <form action="../../index.php?page=tagihan" method="post" enctype="multipart/form-data" name="myform">
      <input type="hidden" name="kelas_back" value="<?=$kelas_back;?>">
      <input type="hidden" name="jurusan_back" value="<?=$jurusan_back;?>">
      <input type="hidden" name="back">
      <script type="text/javascript">
        document.myform.submit();
      </script>
    </form>
<?php
}
?>