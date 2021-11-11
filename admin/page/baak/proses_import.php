<?php
// Load file koneksi.php
include_once("../../asset/inc/config.php");
// Load file autoload.php
require '../../asset/lib/PHPOffice/vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['import_baak'])){ // Jika user mengklik tombol Import
	$nama_file_baru = 'data-baak.xlsx';

	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$spreadsheet = $reader->load('../../asset/lib/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
	$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		
		$nip = $row['A'];
		$nama_pegawai = $row['B'];
		$jabatan = $row['C'];
		$foto = "";

		// Cek jika semua data tidak diisi
		if($nip == "" && $nama_pegawai == "" && $jabatan == "" && $foto == "" )
		continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
			// Buat query Insert
			// $barang = "INSERT INTO tabel_barang VALUES('".$nip."','".$nama_pegawai."','".$jabatan."','".$sub_kelas."','".$foto."','".$hrg_jual."','".$hrg_beli."')";
			// $query = mysqli_query($connect,$barang);

			 $result = mysqli_query($koneksi, "INSERT INTO tb_baak
			 	(nip,nama_pegawai,jabatan,foto)
			 	VALUES
			 	('$nip','$nama_pegawai','$jabatan','$foto')");


		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

header('Location:../../index.php?page=baak'); // Redirect ke halaman awal
?>
