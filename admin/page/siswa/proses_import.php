<?php
// Load file koneksi.php
include_once("../../asset/inc/config.php");
// Load file autoload.php
require '../../asset/lib/PHPOffice/vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['import_siswa'])){ // Jika user mengklik tombol Import
	$nama_file_baru = 'data-siswa.xlsx';

	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
              $spreadsheet = $reader->load('../../asset/lib/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
              $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		
		$nis = $row['A'];
		$nama_siswa = $row['B'];
		$kelas = $row['C'];
		$jurusan = $row['D'];
		$foto = "";

		// Cek jika semua data tidak diisi
		if($nis == "" && $nama_siswa == "" && $kelas == "" && $jurusan == "" && $foto == "")
		continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
			 $result = mysqli_query($koneksi, "INSERT INTO tb_siswa
			 	(nis,nama_siswa,kelas,jurusan,foto)
			 	VALUES
			 	('$nis','$nama_siswa','$kelas','$jurusan','$foto')");


		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

header('Location:../../index.php?page=siswa'); // Redirect ke halaman awal
?>
