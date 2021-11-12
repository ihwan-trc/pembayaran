<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 

// ==================================== KELAS 1 ==================================================
$query1 =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_jenis_tagihan ON tb_siswa.jurusan=tb_jenis_tagihan.jurusan WHERE tb_siswa.kelas='X'");
    $num1 = mysqli_num_rows($query1);
    while ($data = mysqli_fetch_assoc($query1)) {
      $jurusan = $data['jurusan'];

    $que =mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='X' AND jurusan='$jurusan'");
    while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn1_1 += $data['jumlah'];
        }

        $que =mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='X' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn1_2 += $data['jumlah'];
        }
        $jml1 = $jumlah_tghn1_1 + $jumlah_tghn1_2;
    }

$query2 = mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($query2)) {
          $jumlah1_1 += $data['jumlah'];
        }
$jumlah1 = $jumlah1_1 * $num1 + $jml1;

// ==================================== KELAS 2 ==================================================
$query1 =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_jenis_tagihan ON tb_siswa.jurusan=tb_jenis_tagihan.jurusan WHERE tb_siswa.kelas='XI'");
$num2 = mysqli_num_rows($query1);
// var_dump($num2);
    while ($data = mysqli_fetch_assoc($query1)) {
      $jurusan = $data['jurusan'];

      $que =mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='XI' AND jurusan='$jurusan'");
        while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn2_1 += $data['jumlah'];
        }

        $que =mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='XI' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn2_2 += $data['jumlah'];
        }
        $jml2 = $jumlah_tghn2_1 + $jumlah_tghn2_2;
    }

$query2 = mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($query2)) {
          $jumlah2_1 += $data['jumlah'];
        }
$jumlah2 = $jumlah2_1 * $num2 + $jml2;

// ==================================== KELAS 3 ==================================================
$query1 =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_jenis_tagihan ON tb_siswa.jurusan=tb_jenis_tagihan.jurusan WHERE tb_siswa.kelas='XII'");
$num3 = mysqli_num_rows($query1);
// var_dump($num3);
    while ($data = mysqli_fetch_assoc($query1)) {
      $jurusan = $data['jurusan'];

      $que=mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='XII' AND jurusan='$jurusan'");
        while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn3_1 += $data['jumlah'];
        }

        $que =mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='XII' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($que)) {
          $jumlah_tghn3_2 += $data['jumlah'];
        }
        $jml3 = $jumlah_tghn3_1 + $jumlah_tghn3_2;
    }

$query2 = mysqli_query($koneksi,"SELECT jumlah FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA'");
        while ($data = mysqli_fetch_array($query2)) {
          $jumlah3_1 += $data['jumlah'];
        }
$jumlah3 = $jumlah3_1 * $num3 + $jml3;

$total_umum = $jumlah1 + $jumlah2 + $jumlah3;
// ==================================== Tagihan siswa 1 ==================================================
$query =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_tagihan_siswa ON tb_siswa.id_siswa=tb_tagihan_siswa.id_siswa WHERE tb_siswa.kelas='X'");
    while ($data = mysqli_fetch_array($query)) {
          $tagihan_siswa1 += $data['jumlah'];
        }
// ==================================== Tagihan siswa 1 ==================================================
$query =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_tagihan_siswa ON tb_siswa.id_siswa=tb_tagihan_siswa.id_siswa WHERE tb_siswa.kelas='XI'");
    while ($data = mysqli_fetch_array($query)) {
          $tagihan_siswa2 += $data['jumlah'];
        }
// ==================================== Tagihan siswa 1 ==================================================
$query =mysqli_query($koneksi,"SELECT * FROM tb_siswa LEFT JOIN tb_tagihan_siswa ON tb_siswa.id_siswa=tb_tagihan_siswa.id_siswa WHERE tb_siswa.kelas='XII'");
    while ($data = mysqli_fetch_array($query)) {
          $tagihan_siswa3 += $data['jumlah'];
        }
// ==================================== TOTAL TAGIHAN SISWA==================================================

$total_tagihan_siswa = $tagihan_siswa1+$tagihan_siswa2+$tagihan_siswa3; // Total Tagihan Siswa
// ==================================== TOTAL TAGIHAN ==================================================

$total_tagihan = $total_umum + $total_tagihan_siswa;

/////////////////////////////////////////END TAGIHAN////////////////////////////////////////////////////////

// ===================================== PEMBAYARAN ================================================
$query = mysqli_query($koneksi,"SELECT SUM(jumlah) FROM tb_siswa INNER JOIN tb_pembayaran ON tb_siswa.id_siswa=tb_pembayaran.id_siswa AND tb_siswa.kelas='X'");
while ($data = mysqli_fetch_assoc($query)) {
  $jumlah_bayar1 += $data['SUM(jumlah)'];
}
$query = mysqli_query($koneksi,"SELECT SUM(jumlah) FROM tb_siswa INNER JOIN tb_pembayaran ON tb_siswa.id_siswa=tb_pembayaran.id_siswa AND tb_siswa.kelas='XI'");
while ($data = mysqli_fetch_assoc($query)) {
  $jumlah_bayar2 += $data['SUM(jumlah)'];
}
$query = mysqli_query($koneksi,"SELECT SUM(jumlah) FROM tb_siswa INNER JOIN tb_pembayaran ON tb_siswa.id_siswa=tb_pembayaran.id_siswa AND tb_siswa.kelas='XII'");
while ($data = mysqli_fetch_assoc($query)) {
  $jumlah_bayar3 += $data['SUM(jumlah)'];
}
// ===============================================TOTAL PEMBAYARAN==============================
$total_pembayaran = $jumlah_bayar1 + $jumlah_bayar2 + $jumlah_bayar3;
// ===============================================TOTAL TUNGGAKAN==============================
$total_tunggakan = $total_tagihan - $total_pembayaran;


// ===============================================PERSENTASE==============================
$tghn1 = $jumlah1 + $tagihan_siswa1;
$tghn2 = $jumlah2 + $tagihan_siswa2;
$tghn3 = $jumlah3 + $tagihan_siswa3;

$persen1 = $jumlah_bayar1 / $tghn1 * 100;
$kelas1 = round($persen1,2,PHP_ROUND_HALF_UP);

$persen2 = $jumlah_bayar2 / $tghn2 * 100;
$kelas2 = round($persen2,2,PHP_ROUND_HALF_UP);

$persen3 = $jumlah_bayar3 / $tghn3 * 100;
$kelas3 = round($persen3,2,PHP_ROUND_HALF_UP);

$persen_tunggakan = $total_tunggakan / $total_tagihan * 100;
$tunggakan = round($persen_tunggakan,2,PHP_ROUND_HALF_UP);

$persen_pembayaran = $total_pembayaran / $total_tagihan * 100;
$pembayaran = round($persen_pembayaran,2,PHP_ROUND_HALF_UP);
?>

<!-- Page Heading -->
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 mb-0 text-gray-800">DASHBOARD</h1>
    </div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Tagihan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                           Rp<?= number_format($total_tagihan,0,",","."); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pembayaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                           Rp<?= number_format($total_pembayaran,0,",","."); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Kekurangan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                           Rp<?= number_format($total_tunggakan,0,",","."); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Keuangan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <h4 class="small font-weight-bold">Kelas X : Rp<?= number_format($jumlah_bayar1,0,",","."); ?>
                    <span class="float-right"><?= $kelas1; ?>%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?= $kelas1; ?>%"
                        aria-valuenow="<?= $kelas1; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <h4 class="small font-weight-bold">Kelas XI : Rp<?= number_format($jumlah_bayar2,0,",","."); ?>    <span class="float-right"><?= $kelas2; ?>%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $kelas2; ?>%"
                        aria-valuenow="<?= $kelas2; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <h4 class="small font-weight-bold">Kelas XII : Rp<?= number_format($jumlah_bayar3,0,",","."); ?>     <span class="float-right"><?= $kelas3; ?>%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $kelas3; ?>%"
                        aria-valuenow="<?= $kelas3; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <h4 class="small font-weight-bold">Kekurangan
                    <span class="float-right"><?= $tunggakan; ?>%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $tunggakan; ?>%" aria-valuenow="<?= $tunggakan; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <h4 class="small font-weight-bold">Pembayaran 
                    <span class="float-right"><?= $pembayaran; ?>%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pembayaran; ?>%"
                        aria-valuenow="<?= $pembayaran; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="mt-2 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> <?= $num1; ?> siswa
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> <?= $num2; ?> siswa
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> <?= $num3; ?> siswa
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>