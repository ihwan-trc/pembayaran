<?php
include "../../asset/inc/config.php";
// Load file autoload.php
require '../../asset/lib/PHPOffice/vendor/autoload.php';
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

// Settingan awal fil excel
$spreadsheet->getProperties()->setCreator('Muhamad Ihwan')
					   ->setLastModifiedBy('Muhamad Ihwan')
					   ->setTitle("Format Import BAAK")
					   ->setSubject("Format")
					   ->setDescription("Format Data BAAK")
					   ->setKeywords("Format BAAK");

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

// Buat header tabel nya pada baris ke 3
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "NIP"); // Set kolom A1 dengan tulisan "NO"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', "NAMA PEGAWAI"); // Set kolom B1 dengan tulisan "NIS"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', "JABATAN"); // Set kolom C1 dengan tulisan "NAMA"

$spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "JABATAN :");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('E4', "KEPALA BAAK");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', "STAFF BAAK");
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
if (isset($_POST['format'])) {
	$numrow = 2;
    $query = "SELECT * FROM tb_baak";
    $result = mysqli_query($koneksi,$query);
    while ($data = mysqli_fetch_assoc($result)) {
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nip']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_pegawai']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['jabatan']);

	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	  $spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	  $spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	  $spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Set text left untuk kolom NIS
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	$numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15); // Set width kolom A
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35); // Set width kolom B
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C

// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("Format Import BAAK");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=format-import-BAAK.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
}
?>
