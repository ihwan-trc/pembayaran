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
					   ->setTitle("DATA SISWA")
					   ->setSubject("Kelas-Jurusan")
					   ->setDescription("Data Siswa")
					   ->setKeywords("Siswa");

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

if (isset($_POST['excel'])) {
	$kelas_post = $_POST['kelas'];
	$jurusan_post = $_POST['jurusan'];

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
$spreadsheet->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai F1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A2',"KELAS : ".$kelas_post);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A3',"JURUSAN : ".$jurusan_post);

// Buat header tabel nya pada baris ke 4
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A4 dengan tulisan "NO"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B4', "NIS"); // Set kolom B4 dengan tulisan "NIS"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C4', "NAMA SISWA"); // Set kolom C4 dengan tulisan "NAMA"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('D4', "KELAS"); // Set kolom D4 dengan tulisan "JENIS KELAMIN"
$spreadsheet->setActiveSheetIndex(0)->setCellValue('E4', "JURUSAN"); // Set kolom E4 dengan tulisan "JURUSAN"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 5
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql

	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nis']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama_siswa']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['kelas']);
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['jurusan']);
	
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Set text left untuk kolom NIS
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40); // Set width kolom C
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10); // Set width kolom D
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E

// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("DATA SISWA");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=DATA SISWA : $kelas_post-$jurusan_post.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

}
?>
