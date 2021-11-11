<?php
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

// Load file autoload.php
require '../../asset/lib/PHPOffice/vendor/autoload.php';
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

// Settingan awal fil excel
$spreadsheet->getProperties()
			->setCreator('SMK MIFTAHUL ULUM')
		   	->setLastModifiedBy('SMK MIFTAHUL ULUM')
		   	->setTitle("Format Pembayaran")
		   	->setSubject("Pembayaran")
		   	->setDescription("Format Import Data Pembayaran")
		   	->setKeywords("Format");

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = [
    'font' => ['bold' => true], // Set font nya jadi bold
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];


if (isset($_POST['format_umum'])) {
	$kelas_post = $_POST['kelas'];
    $jurusan_post = $_POST['jurusan'];
    $id_jenis_tagihan_post = $_POST['id_jenis_tagihan'];
    $query_nama = "SELECT * FROM tb_jenis_tagihan WHERE id_jenis_tagihan='$id_jenis_tagihan_post'";
    $result_nama = mysqli_query($koneksi,$query_nama);
    while ($data1 = mysqli_fetch_assoc($result_nama)) {
      $jenis_tagihan_nama = $data1['jenis_tagihan'];
    }

     if ($kelas_post !== "") {
	      if ($jurusan_post !== "") {

// Buat header tabel nya pada baris ke 3
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "NIS");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', "NAMA SISWA");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', "KELAS");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('D1', "JURUSAN");
$query1 = "SELECT * FROM tb_jenis_tagihan WHERE id_jenis_tagihan='$id_jenis_tagihan_post'";
$result = mysqli_query($koneksi,$query1);
while ($data1 = mysqli_fetch_assoc($result)) {
$spreadsheet->setActiveSheetIndex(0)->setCellValue('E1', $data1['jenis_tagihan']);
}
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$query_siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($query_siswa)){ // Ambil semua data dari hasil eksekusi $sql
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nis']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_siswa']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['kelas']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['jurusan']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$numrow,''); 

	
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);

// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("Format Pembayaran");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment; filename="Format Data Pembayaran.xlsx"'); // Set nama file excel nya
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=format-pembayaran $jenis_tagihan_nama  $kelas_post-$jurusan_post.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

 		}
	}
}

// ==============================================================================================

if (isset($_POST['format_siswa'])) {
	$kelas_post = $_POST['kelas'];
    $jurusan_post = $_POST['jurusan'];
    $id_jenis_tagihan_post = $_POST['id_jenis_tagihan'];
    $query_nama = "SELECT * FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jenis_tagihan_post'";
    $result_nama = mysqli_query($koneksi,$query_nama);
    while ($data1 = mysqli_fetch_assoc($result_nama)) {
      $jenis_tagihan_nama = $data1['jenis_tagihan_siswa'];
    }

     if ($kelas_post !== "") {
	      if ($jurusan_post !== "") {

// Buat header tabel nya pada baris ke 3
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "NIS"); // Set kolom B1 dengan tulisan "NIS"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', "NAMA"); // Set kolom C1 dengan tulisan "NAMA"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', "KELAS"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('D1', "JURUSAN"); // Set kolom E1 dengan tulisan "JURUSAN"
$query1 = "SELECT * FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jenis_tagihan_post'";
$result = mysqli_query($koneksi,$query1);
while ($data1 = mysqli_fetch_assoc($result)) {
$spreadsheet->setActiveSheetIndex(0)->setCellValue('E1', $data1['jenis_tagihan_siswa']); // Set kolom F3 dengan tulisan "FOTO"
}
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$query_siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($query_siswa)){ // Ambil semua data dari hasil eksekusi $sql
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nis']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_siswa']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['kelas']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['jurusan']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$numrow, ''); 

	
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);

// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("Data Pembayaran");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment; filename="Format Data Pembayaran.xlsx"'); // Set nama file excel nya
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=format-pembayaran $jenis_tagihan_nama  $kelas_post-$jurusan_post.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

 		}
	}
}
?>