<?php
include_once("asset/inc/config.php");
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
// Load file autoload.php
require 'asset/lib/PHPOffice/vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// ===============================================================pembayaran==========================

if(isset($_POST['import_pembayaran_umum'])){ // Jika user mengklik tombol Import
	$id_jenis_tagihan_preview = $_POST['id_jtagihan'];
	$kelas_post = $_POST['kelas'];
	$jurusan_post = $_POST['jurusan'];
	$nama_file_baru = 'data-pembayaran-umum.xlsx';
	$chart = date('m');

	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$spreadsheet = $reader->load('asset/lib/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
	$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		$numrow = 1;
		foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		
		$nis = $row['A'];
		$query = "SELECT * FROM tb_siswa WHERE nis='$nis'";
		$result = mysqli_query($koneksi,$query);
		while ($data = mysqli_fetch_assoc($result)) {
			$id_siswa1 = $data['id_siswa'];

		$jumlah_row_sheet = str_replace(",", "", $row['E']);
		$query = "SELECT * FROM tb_jenis_tagihan WHERE id_jenis_tagihan='$id_jenis_tagihan_preview'";
		$result = mysqli_query($koneksi,$query);
		while ($data = mysqli_fetch_assoc($result)) {
			$id_jenis_tagihan1 = $data['id_jenis_tagihan'];
			$jenis_tghn_umum = $data['jenis_tagihan'];
			$jumlah1 = str_replace(",", "", $data['jumlah']);
			$query_bayar = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa1' AND id_jenis_tagihan='$id_jenis_tagihan1'";
			$result_bayar = mysqli_query($koneksi,$query_bayar);
			while ($data= mysqli_fetch_assoc($result_bayar)) {
				$id_siswa2 = $data['id_siswa'];
				$id_jenis_tagihan2= $data['id_jenis_tagihan'];
				$jumlah2 = str_replace(",", "", $data['jumlah']);
			}

			$jumlah_tghn = $jumlah1 + $jumlah_row_sheet;
			$jumlah_byr = $jumlah2 + $jumlah_row_sheet;

			if ($jumlah2 == NULL) {
				if ($jumlah_row_sheet == $jumlah1) {
					$status = "Lunas";
				}
			}
			if ($jumlah2 == NULL) {
				if ($jumlah_row_sheet != $jumlah1) {
					$status = "Proses";
				}
			}
			if ($jumlah2 == NULL) {
				if ($jumlah_row_sheet == NULL) {
					$status = "Kosong";
				}
			}

			if ($jumlah2 != NULL) {
				if ($jumlah_byr != $jumlah1) {
					$status = "Proses";
				}
			}
			if ($jumlah2 != NULL) {
				if ($jumlah_byr == $jumlah1) {
					$status = "Lunas";
				}
			}


		if($numrow > 0){

			if ($id_siswa1 !== $id_siswa2) {
				if ($id_jenis_tagihan1 !== $id_jenis_tagihan2) {
				$result = mysqli_query($koneksi, "INSERT INTO tb_pembayaran
			 	(id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart)
			 	VALUES
			 	('$id_siswa1','$id_jenis_tagihan1','','$status','$jumlah_row_sheet','$chart')");
				}
			} 
			if ($id_siswa1 == $id_siswa2) {
				if ($id_jenis_tagihan1 == $id_jenis_tagihan2) {
				$result = mysqli_query($koneksi, "UPDATE tb_pembayaran SET id_siswa='$id_siswa1',id_jenis_tagihan='$id_jenis_tagihan1',id_jns_tghn_siswa='',status='$status',jumlah='$jumlah_byr',chart='$chart' WHERE id_siswa='$id_siswa2' AND id_jenis_tagihan='$id_jenis_tagihan2'");
				}
			}
			$query_hapus = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE status='Kosong' ");
		
		$numrow++;
			}
		}
 	} 
  }
  ?>

<form action="index.php?page=import_pembayaran_umum" method="post" enctype="multipart/form-data" name="myform">
	<input type="hidden" name="jns_tghn_form" value="<?=$jenis_tghn_siswa;?>">
	<input type="hidden" name="kelas_form" value="<?=$kelas_post;?>">
	<input type="hidden" name="jurusan_form" value="<?=$jurusan_post;?>">
	<input type="hidden" name="back_proses">
	<script type="text/javascript">
		document.myform.submit();
	</script>
</form>
<?php	
}
?>
<!-- ===================================================================================================== -->

<?php
if(isset($_POST['import_pembayaran_siswa'])){ 
	$id_jenis_tagihan_preview = $_POST['id_jtagihan'];
	$kelas_post = $_POST['kelas'];
	$jurusan_post = $_POST['jurusan'];
	$nama_file_baru = 'data-pembayaran-siswa.xlsx';
	$chart = date('m');

	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$spreadsheet = $reader->load('asset/lib/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
	$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
 
	$numrow = 1;
	foreach($sheet as $row){
	// Ambil data pada excel sesuai Kolom
	
	$nis = $row['A'];
	$query = "SELECT * FROM tb_siswa WHERE nis='$nis'";
	$result = mysqli_query($koneksi,$query);
	while ($data = mysqli_fetch_assoc($result)) {
		$id_siswa = $data['id_siswa'];

	$jumlah_row_sheet = str_replace(",", "", $row['E']);
	$query = "SELECT * FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jenis_tagihan_preview'";
	$result = mysqli_query($koneksi,$query);
	while ($data = mysqli_fetch_assoc($result)) {
		$id_jns_tghn_siswa = $data['id_jns_tghn_siswa'];
		$jenis_tghn_siswa = $data['jenis_tagihan_siswa'];

			$query = "SELECT * FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa' AND id_jns_tghn_siswa='$id_jns_tghn_siswa'";
			$result = mysqli_query($koneksi,$query);
			while ($data = mysqli_fetch_assoc($result)) {
				$id_siswa1 = $data['id_siswa'];
				$id_jns_tghn_siswa1 = $data['id_jns_tghn_siswa'];
				$jumlah1 = str_replace(",", "", $data['jumlah']);

				$query_bayar = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa1' AND id_jns_tghn_siswa='$id_jns_tghn_siswa1'";
				$result_bayar = mysqli_query($koneksi,$query_bayar);
				while ($data= mysqli_fetch_assoc($result_bayar)) {
					$id_siswa2 = $data['id_siswa'];
					$id_jns_tghn_siswa2= $data['id_jns_tghn_siswa'];
					$status = $data['status'];
					$jumlah2 = str_replace(",", "", $data['jumlah']);	
				} // end tb_pembayaran
			} // end tb_tagihan_siswa

			$jumlah_tghn = $jumlah1 + $jumlah_row_sheet;
			$jumlah_byr = $jumlah2 + $jumlah_row_sheet;

			if ($jumlah_byr == $jumlah_tghn) {
				$status = 'Lunas';
			}
			elseif ($jumlah_byr != $jumlah1) {
				$status = 'Proses';
			}

		if($numrow > 0){
			if ($id_siswa == $id_siswa1) {
				if ($id_jns_tghn_siswa == $id_jns_tghn_siswa1) {

				$result1 = mysqli_query($koneksi, "UPDATE tb_tagihan_siswa SET id_siswa='$id_siswa',id_jns_tghn_siswa='$id_jns_tghn_siswa',jumlah='$jumlah_tghn' WHERE id_siswa='$id_siswa' AND id_jns_tghn_siswa='$id_jns_tghn_siswa'");

					if ($id_siswa == $id_siswa1) {
						if ($id_siswa1 == $id_siswa2) {
							if ($id_jns_tghn_siswa == $id_jns_tghn_siswa1) {
								if ($id_jns_tghn_siswa1 == $id_jns_tghn_siswa2) {
								$result2 = mysqli_query($koneksi, "UPDATE tb_pembayaran SET id_siswa='$id_siswa1',id_jenis_tagihan='',id_jns_tghn_siswa='$id_jns_tghn_siswa1',status='Proses',jumlah='$jumlah2',chart='$chart' WHERE id_siswa='$id_siswa' AND id_jns_tghn_siswa='$id_jns_tghn_siswa'");
								}
							}
						}
					}
				}
			}else{
					$result = mysqli_query($koneksi, "INSERT INTO tb_tagihan_siswa
				 	(id_siswa,id_jns_tghn_siswa,jumlah)
				 	VALUES
				 	('$id_siswa','$id_jns_tghn_siswa','$jumlah_row_sheet')");

					// $result = mysqli_query($koneksi, "INSERT INTO tb_pembayaran
				 	// (id_siswa,id_jenis_tagihan,id_jns_tghn_siswa,status,jumlah,chart)
				 	// VALUES
				 	// ('$id_siswa','','$id_jns_tghn_siswa','Proses','$jumlah_row_sheet','$chart')");
				}
			
			$query_hapus = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE jumlah='' ");
			// $query_hapus = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE jumlah='' ");
			// $query_hapus = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE status='Kosong' ");
		
		$numrow++; // Tambah 1 setiap kali looping

		} // end numrow			
	  } // end tb_jenis_tagihan_siswa	
	} // end siswa	
 } // end foreach
?>

<form action="index.php?page=import_pembayaran_siswa" method="post" enctype="multipart/form-data" name="myform">
	<input type="hidden" name="jns_tghn_form" value="<?=$jenis_tghn_siswa;?>">
	<input type="hidden" name="kelas_form" value="<?=$kelas_post;?>">
	<input type="hidden" name="jurusan_form" value="<?=$jurusan_post;?>">
	<input type="hidden" name="back_proses">
	<script type="text/javascript">
		document.myform.submit();
	</script>
</form>
<?php	
}
?>