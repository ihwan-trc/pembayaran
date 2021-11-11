<?php 
include "../../asset/inc/config.php";
if (isset($_POST['tambah_tagihan_siswa'])) {
	 $kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];
    $siswa_id = $_POST['siswa_id'];
    $id_jns_tghn_siswa_plus4 = $_POST['id_jns_tghn_siswa_plus4'];
    $nis_plus4 = $_POST['nis_plus4'];
    $nama_siswa_plus4 = $_POST['nama_siswa_plus4'];
    $kelas_plus4 = $_POST['kelas_plus4'];
    $jurusan_plus4 = $_POST['jurusan_plus4'];
    $jenis_tagihan_siswa_plus4 = $_POST['jenis_tagihan_siswa_plus4'];
    $jumlah_plus4 = str_replace(".", "", $_POST['jumlah_plus4']);
    $status_plus4 = $_POST['status_plus4'];
    if ($status_plus4 == "Lunas") {
      $chart = date('m');
    }
    if ($status_plus4 != "Lunas") {
      $chart = "";
    }
    

      if ($status_plus4 == "Proses") {
            $result = mysqli_query($koneksi, "INSERT INTO tb_tagihan_siswa
                    (id_siswa,id_jns_tghn_siswa,jumlah) 
                    VALUES
                    ('$siswa_id','$id_jns_tghn_siswa_plus4','$jumlah_plus4')");
      }else{
        $result1 = mysqli_query($koneksi, "INSERT INTO tb_tagihan_siswa
                    (id_siswa,id_jns_tghn_siswa,jumlah) 
                    VALUES
                    ('$siswa_id','$id_jns_tghn_siswa_plus4','$jumlah_plus4')");
        $result2 = mysqli_query($koneksi, "INSERT INTO tb_pembayaran
                    (id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart) 
                    VALUES
                    ('$siswa_id','','$id_jns_tghn_siswa_plus4','$status_plus4','$jumlah_plus4','$chart')");
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