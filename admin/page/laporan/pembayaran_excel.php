<?php
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST['pembayaran_excel'])) {
	$kelas = $_POST['kelas'];
	$jurusan = $_POST['jurusan'];

// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
// Load plugin PHPExcel nya
require_once '../../asset/lib/PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$excel = new PHPExcel();

// Settingan awal fil excel
$excel->getProperties()->setCreator('SMK MU')
					   ->setLastModifiedBy('SMK MU')
					   ->setTitle("Laporan Pembayaran")
					   ->setSubject("Pembayaran")
					   ->setDescription("Data Pembayaran")
					   ->setKeywords("Pembayaran");

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
	'font' => array('bold' => true), // Set font nya jadi bold
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	),
	'borders' => array(
		'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	)
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
	'alignment' => array(
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	),
	'borders' => array(
		'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	)
);

$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PEMBAYARAN");
$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 

$excel->setActiveSheetIndex(0)->setCellValue('A2',"KELAS : ".$kelas);
$excel->setActiveSheetIndex(0)->setCellValue('A3',"JURUSAN : ".$jurusan);


// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); 
$excel->setActiveSheetIndex(0)->setCellValue('B4', "NAMA SISWA");

$query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'";
$result1 = mysqli_query($koneksi,$query1);
while ($data = mysqli_fetch_assoc($result1)) {
	$id_jenis_tagihan = $data['id_jenis_tagihan'];
  	$jenis_tagihan = $data['jenis_tagihan'];
$excel->setActiveSheetIndex(0)->setCellValue('C4',"".$jenis_tagihan);
}

$excel->setActiveSheetIndex(0)->setCellValue('D4', "TAGIHAN 2"); 
$excel->setActiveSheetIndex(0)->setCellValue('E4', "TAGIHAN 3"); 
$excel->setActiveSheetIndex(0)->setCellValue('F4', "TAGIHAN 4"); 
$excel->setActiveSheetIndex(0)->setCellValue('G4', "TAGIHAN 5"); 
$excel->setActiveSheetIndex(0)->setCellValue('H4', "TAGIHAN 6"); 
$excel->setActiveSheetIndex(0)->setCellValue('I4', "TAGIHAN 7"); 
$excel->setActiveSheetIndex(0)->setCellValue('J4', "TAGIHAN 8"); 
$excel->setActiveSheetIndex(0)->setCellValue('K4', "PEMBAYARAN"); 
$excel->setActiveSheetIndex(0)->setCellValue('L4', "TUNGGAKAN"); 
$excel->setActiveSheetIndex(0)->setCellValue('M4', "JUMLAH"); 

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);


// Set height baris ke 1, 2 dan 3
$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$no = 1;
$numrow = 5;
$query = "SELECT * FROM tb_siswa WHERE kelas='$kelas' AND jurusan='$jurusan' ORDER BY id_siswa ASC";
$result = mysqli_query($koneksi,$query);
$nums = mysqli_num_rows($result);
while ($data = mysqli_fetch_assoc($result)) {
	$id_siswa = $data['id_siswa'];
  	$nama_siswa = $data['nama_siswa'];

$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $nama_siswa);

$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

$no++;
$numrow++;
}

// Buat query untuk menampilkan semua data siswa
$numrow = 5;
$query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'";
$result1 = mysqli_query($koneksi,$query1);
$nums1 = mysqli_num_rows($result1);
while ($data = mysqli_fetch_assoc($result1)) {
	$id_jenis_tagihan = $data['id_jenis_tagihan'];
  	$nama_tagihan = $data['nama_tagihan'];
  	$jumlah = $data['jumlah'];

$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jumlah);

$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

$no++;
$numrow++;
}


$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Laporan Pembayaran");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd-ms-excel');
header("Content-Disposition: attachment; filename=LAPORAN PEMBAYARAN $kelas-$jurusan.xlsx");
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
}
?>
