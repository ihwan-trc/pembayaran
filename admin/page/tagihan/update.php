<?php 
include "../../asset/inc/config.php";
if (isset($_POST['update'])) {
    $kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];
    $id_siswa_up = $_POST['id_siswa_up'];
    $id_jenis_tagihan_up = $_POST['id_jenis_tagihan_up'];
    $id_jns_tghn_siswa_up = $_POST['id_jns_tghn_siswa_up'];
    $jml_tagihan_up = $_POST['jml_tagihan_up'];
    $jml_cicilan_up = $_POST['jml_bayar_up'];
    $jml_tunggakan_up = $_POST['jml_tunggakan_up'];
    $bayar_up = str_replace(".", "", $_POST['bayar_up']);
    $chart = date('m');
    $pembayaran_up = $jml_cicilan_up + $bayar_up;
    if ($pembayaran_up == $jml_tagihan_up) {
      $status_up = "Lunas";
    }elseif ($pembayaran_up >= $jml_tagihan_up){
      $status_up = "Proses";
    }elseif ($pembayaran_up <= $jml_tagihan_up){
      $status_up = "Proses";
    }
    $result_up = mysqli_query($koneksi, "UPDATE tb_pembayaran SET id_siswa='$id_siswa_up',id_jenis_tagihan='$id_jenis_tagihan_up',id_jns_tghn_siswa='$id_jns_tghn_siswa_up',status='$status_up',jumlah='$pembayaran_up',chart='$chart' WHERE id_siswa='$id_siswa_up' AND id_jenis_tagihan='$id_jenis_tagihan_up'");
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
include "../../asset/inc/config.php";
if (isset($_POST['hapus'])) {
    $id_pembayaran_hapus = $_POST['id_pembayaran_hapus'];
    $id_tagihan_siswa_hapus = $_POST['id_siswa_up'];
    $kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];


    $query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran_hapus' ");
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