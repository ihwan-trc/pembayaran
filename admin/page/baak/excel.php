<?php
include "../../asset/inc/config.php";
// Load file autoload.php
require '../../asset/lib/PHPOffice/vendor/autoload.php';
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

// Settingan awal fil excel
$spreadsheet->getProperties()->setCreator('SMK MIFTAHUL ULUM')
             ->setLastModifiedBy('SMK MIFTAHUL ULUM')
             ->setTitle("DATA BAAK")
             ->setSubject("Pegawai")
             ->setDescription("Data Pegawai BAAK")
             ->setKeywords("Pegawai");

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


$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "DATA BAAK"); // Set kolom A1 dengan tulisan "DATA SISWA"
$spreadsheet->getActiveSheet()->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai F1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Buat header tabel nya pada baris ke 3
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "NIP"); // Set kolom B3 dengan tulisan "NIS"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PEGAWAI"); // Set kolom C3 dengan tulisan "NAMA"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('D3', "JABATAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($koneksi, "SELECT * FROM tb_baak");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
  $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nip']);
  $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama_pegawai']);
  $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['jabatan']);
  
  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
  
  $spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    $spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Set text left untuk kolom NIS
  
  $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
  
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35); // Set width kolom C
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D

// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("DATA BAAK");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="DATA BAAK.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>