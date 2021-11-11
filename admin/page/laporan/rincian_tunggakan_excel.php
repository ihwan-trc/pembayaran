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
			->setTitle("Data Kekurangan")
			->setSubject("Kekurangan")
			->setDescription("Data Kekurangan Siswa")
			->setKeywords("Kekurangan");

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

if (isset($_POST['rincian_excel'])) {
	$id_siswa = $_POST['id_siswa'];
	$nama_siswa = $_POST['nama_siswa'];
	$kelas = $_POST['kelas'];
	$jurusan = $_POST['jurusan'];
	date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('d-m-Y h:i');

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "DATA KEKURANGAN");
$spreadsheet->getActiveSheet()->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai F1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
$spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE); // Set bold kolom A1

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A2',"NAMA SISWA : ".$nama_siswa);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A3',"KELAS : ".$kelas);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4',"JURUSAN : ".$jurusan);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F4',"Cetak : ".$tanggal);
// $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('F4')->getFont()->setItalic(TRUE);

// Buat header tabel nya pada baris ke 3
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', "NO");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', "JENIS TAGIHAN");
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', "KEKURANGAN");
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', "PEMBAYARAN");
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', "KEKURANGAN");
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', "KETERANGAN");

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$spreadsheet->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
$spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
// $spreadsheet->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
// $spreadsheet->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
// $spreadsheet->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

// Buat query untuk menampilkan semua data siswa
$query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA' ORDER BY id_jenis_tagihan ASC";
$result1 = mysqli_query($koneksi,$query1);
$nums1 = mysqli_num_rows($result1);
$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
while ($data = mysqli_fetch_assoc($result1)) {
	$id_jenis_tagihan1 = $data['id_jenis_tagihan'];
  	$jenis_tagihan1 = $data['jenis_tagihan'];
  	$jml_tagihan1 = $data['jumlah'];

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $jenis_tagihan1);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jml_tagihan1);
 		$query_byr1 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan1' AND id_siswa='$id_siswa'";
            $result_byr1 = mysqli_query($koneksi,$query_byr1);
            while ($data = mysqli_fetch_assoc($result_byr1)) {
              $id_siswa_byr1 = $data['id_siswa']; 
              $id_jenis_tagihan_byr1 = $data['id_jenis_tagihan']; 
              $jumlah_byr1 = $data['jumlah'];
              $status_byr1 = $data['status'];
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $jumlah_byr1);
          }
$tunggakan1 = $jml_tagihan1 - $jumlah_byr1;

	if ($tunggakan1 != 0) {
	  $tunggakan1 = $tunggakan1;
	}if ($tunggakan1 == 0) {
	  $tunggakan1 = "";
	}
	if ($id_jenis_tagihan1 != $id_jenis_tagihan_byr1) {
	$tunggakan1 = $jml_tagihan1;
	}

$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $tunggakan1);

          if ($status_byr1=="Proses") {
                  $status1 = "BELUM LUNAS";
                }if ($status_byr1=="Lunas") {
                  $status1 = "LUNAS";
                }
          if ($id_jenis_tagihan1 != $id_jenis_tagihan_byr1) {
                $tunggakan1 = $jml_tagihan1;
                $status1 =  "BELUM BAYAR";
             }
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $status1);

	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	$spreadsheet->getActiveSheet()->getStyle('C' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('D' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('F' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}
// =============================================END 1 =============================================

// Buat query untuk menampilkan semua data siswa
$query2 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='SEMUA' ORDER BY id_jenis_tagihan ASC";
$result2 = mysqli_query($koneksi,$query2);
$nums2 = mysqli_num_rows($result2);
$numrow = $nums1 + 6; // Set baris pertama untuk isi tabel adalah baris ke 4
while ($data = mysqli_fetch_assoc($result2)) {
	$id_jenis_tagihan2 = $data['id_jenis_tagihan'];
  	$jenis_tagihan2 = $data['jenis_tagihan'];
  	$jml_tagihan2 = $data['jumlah'];
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $jenis_tagihan2);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jml_tagihan2);
 		$query_byr2 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan2' AND id_siswa='$id_siswa'";
            $result_byr2 = mysqli_query($koneksi,$query_byr2);
            while ($data = mysqli_fetch_assoc($result_byr2)) {
              $id_siswa_byr2 = $data['id_siswa']; 
              $id_jenis_tagihan_byr2 = $data['id_jenis_tagihan']; 
              $jumlah_byr2 = $data['jumlah'];
              $status_byr2 = $data['status'];
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $jumlah_byr2);
          }
$tunggakan2 = $jml_tagihan2 - $jumlah_byr2;

	if ($tunggakan2 != 0) {
	  $tunggakan2 = $tunggakan2;
	}if ($tunggakan2 == 0) {
	  $tunggakan2 = "";
	}
	if ($id_jenis_tagihan2 != $id_jenis_tagihan_byr2) {
	$tunggakan2 = $jml_tagihan2;
	}

$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $tunggakan2);

          if ($status_byr2=="Proses") {
                  $status2 = "BELUM LUNAS";
                }if ($status_byr2=="Lunas") {
                  $status2 = "LUNAS";
                }
          if ($id_jenis_tagihan2 != $id_jenis_tagihan_byr2) {
                $tunggakan2 = $jml_tagihan2;
                $status2 =  "BELUM BAYAR";
             }
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $status2);
            
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	$spreadsheet->getActiveSheet()->getStyle('C' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('D' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('F' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// =============================================END 2 =============================================

// Buat query untuk menampilkan semua data siswa
$query3 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='$jurusan' ORDER BY id_jenis_tagihan ASC";
$result3 = mysqli_query($koneksi,$query3);
$nums3 = mysqli_num_rows($result3);
$numrow = $nums1 + $nums2 + 6; // Set baris pertama untuk isi tabel adalah baris ke 4
while ($data = mysqli_fetch_assoc($result3)) {
	$id_jenis_tagihan3 = $data['id_jenis_tagihan'];
  	$jenis_tagihan3 = $data['jenis_tagihan'];
  	$jml_tagihan3 = $data['jumlah'];
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $jenis_tagihan3);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jml_tagihan3);
 		$query_byr3 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan3' AND id_siswa='$id_siswa'";
            $result_byr3 = mysqli_query($koneksi,$query_byr3);
            while ($data = mysqli_fetch_assoc($result_byr3)) {
              $id_siswa_byr3 = $data['id_siswa']; 
              $id_jenis_tagihan_byr3 = $data['id_jenis_tagihan']; 
              $jumlah_byr3 = $data['jumlah'];
              $status_byr3 = $data['status'];
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $jumlah_byr3);
          }
$tunggakan3 = $jml_tagihan3 - $jumlah_byr3;

	if ($tunggakan3 != 0) {
	  $tunggakan3 = $tunggakan3;
	}if ($tunggakan3 == 0) {
	  $tunggakan3 = "";
	}
	if ($id_jenis_tagihan3 != $id_jenis_tagihan_byr3) {
	$tunggakan3 = $jml_tagihan3;
	}

$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $tunggakan3);

          if ($status_byr3=="Proses") {
                  $status3 = "BELUM LUNAS";
                }if ($status_byr3=="Lunas") {
                  $status3 = "LUNAS";
                }
          if ($id_jenis_tagihan3 != $id_jenis_tagihan_byr3) {
                $tunggakan3 = $jml_tagihan3;
                $status3 =  "BELUM BAYAR";
             }
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $status3);
            
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	$spreadsheet->getActiveSheet()->getStyle('C' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('D' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('F' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// =============================================END 3 =============================================

$numrow = $nums1 + $nums2 + $nums3 + 6;

	$query_tghn4 = "SELECT * FROM tb_tagihan_siswa INNER JOIN tb_jenis_tagihan_siswa ON tb_tagihan_siswa.id_jns_tghn_siswa=tb_jenis_tagihan_siswa.id_jns_tghn_siswa AND tb_tagihan_siswa.id_siswa='$id_siswa'";
	$result_tghn4 = mysqli_query($koneksi,$query_tghn4);
	$nums4 = mysqli_num_rows($result_tghn4);
	while ($data = mysqli_fetch_assoc($result_tghn4)) {
		$id_siswa_tghn4 = $data['id_siswa'];
		$id_jns_tghn_siswa4 = $data['id_jns_tghn_siswa'];
		$jenis_tagihan4 = $data['jenis_tagihan_siswa'];
		$jml_tagihan4 = $data['jumlah'];
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $jenis_tagihan4);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jml_tagihan4);
 		$query_byr4 = "SELECT * FROM tb_pembayaran WHERE id_jns_tghn_siswa='$id_jns_tghn_siswa4' AND id_siswa='$id_siswa_tghn4'";
            $result_byr4 = mysqli_query($koneksi,$query_byr4);
            while ($data = mysqli_fetch_assoc($result_byr4)) {
              $id_siswa_byr4 = $data['id_siswa']; 
              $id_jenis_tagihan_byr4 = $data['id_jns_tghn_siswa']; 
              $jumlah_byr4 = $data['jumlah'];
              $status_byr4 = $data['status'];
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $jumlah_byr4);
          }
$tunggakan4 = $jml_tagihan4 - $jumlah_byr4;

	if ($tunggakan4 != 0) {
	  $tunggakan4 = $tunggakan4;
	}if ($tunggakan4 == 0) {
	  $tunggakan4 = "";
	}
	if ($id_jns_tghn_siswa4 != $id_jenis_tagihan_byr4) {
	$tunggakan4 = $jml_tagihan4;
	}

$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $tunggakan4);

          if ($status_byr4=="Proses") {
                  $status4 = "BELUM LUNAS";
                }if ($status_byr4=="Lunas") {
                  $status4 = "LUNAS";
                }
          if ($id_jns_tghn_siswa4 != $id_jenis_tagihan_byr4) {
                $tunggakan4 = $jml_tagihan4;
                $status4 =  "BELUM BAYAR";
             }
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $status4);
            
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
  	$spreadsheet->getActiveSheet()->getStyle('B' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	$spreadsheet->getActiveSheet()->getStyle('C' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('D' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('E' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
  	// $spreadsheet->getActiveSheet()->getStyle('F' .$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	
	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// =============================================END 4 =============================================
$numrow = $nums1 + $nums2 + $nums3 + $nums4 + 6;
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "TOTAL");
$spreadsheet->getActiveSheet()->mergeCells('A'.$numrow .':'.'B'.$numrow); // Set Merge Cell pada kolom A1 sampai F1
$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getFont()->setBold(TRUE);
$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setBold(TRUE);
$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->getFont()->setBold(TRUE);
// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->getFont()->setBold(TRUE);
// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->getFont()->setBold(TRUE);
// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->getFont()->setBold(TRUE);

$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// jumlah tagihan
          $foot_total1 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'";
            $resultfoot_total1 = mysqli_query($koneksi,$foot_total1);
            while ($data = mysqli_fetch_assoc($resultfoot_total1)) {
              $jml_total1 =$data['SUM(jumlah)'];
              $jumlah_total1=number_format($jml_total1,0,",","."); 
            }
            $foot_total2 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='SEMUA'";
            $resultfoot_total2 = mysqli_query($koneksi,$foot_total2);
            while ($data = mysqli_fetch_assoc($resultfoot_total2)) {
              $jml_total2 =$data['SUM(jumlah)'];
              $jumlah_total2=number_format($jml_total2,0,",","."); 
            }
            $foot_total3 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='$jurusan'";
            $resultfoot_total3 = mysqli_query($koneksi,$foot_total3);
            while ($data = mysqli_fetch_assoc($resultfoot_total3)) {
              $jml_total3 =$data['SUM(jumlah)'];
              $jumlah_total3=number_format($jml_total3,0,",","."); 
            }
            $j_tghn4 = "SELECT id_siswa, SUM(jumlah) FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa' GROUP BY id_siswa";
            $result4 = mysqli_query($koneksi,$j_tghn4);
              while ($data = mysqli_fetch_assoc($result4)) {
              $jml_J_tghn4 = $data['SUM(jumlah)'];
            } 

            $jumlah_tagihan = $jml_total1 + $jml_total2 + $jml_total3 + $jml_J_tghn4;

// jumlah bayar
            $foot_bayar = "SELECT SUM(jumlah) FROM tb_pembayaran WHERE id_siswa='$id_siswa'";
            $resultfoot_bayar = mysqli_query($koneksi,$foot_bayar);
            while ($datafoot_bayar = mysqli_fetch_assoc($resultfoot_bayar)) {
              $jml_bayar =$datafoot_bayar['SUM(jumlah)'];
               if ($jml_bayar == 0) {
               $jumlah_bayar = "";
               }
               if ($jml_bayar != 0) {
                 $jumlah_bayar = $jml_bayar;
               }
            }

            $foot_tunggakan = $jumlah_tagihan - $jml_bayar;
            if ($foot_tunggakan == 0) {
               $jumlah_tunggakan = "";
               }
               if ($foot_tunggakan != 0) {
                 $jumlah_tunggakan = $foot_tunggakan;
               }

             if ($jumlah_tagihan == $jumlah_bayar) {
             	$status_total = "LUNAS";
             }
             if ($jumlah_tagihan != $jumlah_bayar) {
             	$status_total = "BELUM LUNAS";
             }
             if ($jumlah_bayar == NULL) {
             	$status_total = "BELUM ADA PEMBAYARAN";
             }

// $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jumlah_tagihan);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $jumlah_bayar);
$spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $jumlah_tunggakan);
// $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $status_total);
            
	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	$spreadsheet->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	$spreadsheet->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	// $spreadsheet->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

	$spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
	

// =============================================END TOTAL =============================================



// Set width kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
// $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
// $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
// $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
$numcetak = $nums1 + $nums2 + $nums3 + $nums4 + 8;
$spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$numcetak,"Cetak : ".$tanggal);
$spreadsheet->getActiveSheet()->getStyle('B'.$numcetak)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('B'.$numcetak)->getFont()->setItalic(TRUE);


// Set orientasi kertas jadi LANDSCAPE
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$spreadsheet->getActiveSheet(0)->setTitle("Data Kekurangan");
$spreadsheet->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=Kekurangan_$nama_siswa $kelas-$jurusan.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
}
?>
