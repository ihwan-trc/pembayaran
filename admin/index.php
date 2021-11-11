<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION["username"])) {
  header("Location: ../index.php ");
  exit;
}
include "asset/inc/config.php";
$query = mysqli_query($koneksi,"SELECT * FROM tb_info");
    while ($data = mysqli_fetch_assoc($query)) {
      $alamat = $data['alamat'];
      $kode_pos = $data['kode_pos'];
      $telp = $data['telp'];
      $icon = $data['icon'];
      $logo = $data['logo'];
      $banner_admin = $data['banner_admin'];
    }

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$uri_path = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$uri_segments = explode('/', $uri_path);
$uri_segments[5];
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SMK MIFTAHUL ULUM</title>

  <!-- Custom fonts for this template-->
  <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="asset/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="asset/css/ekko-lightbox.css">
  <link href="asset/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="asset/img/<?= $icon ?>" type="image/x-icon">

  <!-- tambahan plugin modal -->
  <script src="asset/js/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=dashboard">
          <div class="sidebar-brand-icon">SMKMU
          <img src="asset/img/admin.png" width="100%" alt="">
        </div>
      </a> -->

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=dashboard">
          <div class="sidebar-brand-icon">
              <img src="asset/img/<?= $banner_admin ?>" width="100%" alt="">
          </div>
          <!-- <div class="sidebar-brand-text mx-3"><strong><font color="#9ad98b">SMKMU</font></strong></div> -->
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if ($uri_segments[5] == "index.php?page=dashboard") {echo 'active';} ?>">
        <a class="nav-link" href="index.php?page=dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>DASHBOARD</span></a>
      </li>

       <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - siswa Collapse Menu -->
      <li class="nav-item
      <?php
        if ($uri_segments[5] == "index.php?page=siswa-x") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=siswa") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=kelas") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=jurusan") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=baak") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_siswa") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_baak") {echo 'active';}
      ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapserencana" aria-expanded="true" aria-controls="collapserencana">
          <i class="fas fa-fw fa-edit"></i>
          <span>MASTER</span>
        </a>
        <div id="collapserencana" class="collapse" aria-labelledby="headingrencana" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MENU MASTER:</h6>

            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=kelas") {echo 'active';} ?>" href="?page=kelas">KELAS - JURUSAN</a>

            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=siswa") {echo 'active';} ?>" href="?page=siswa">DATA SISWA</a>

            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=baak") {echo 'active';} ?>" href="?page=baak">DATA BAAK</a>

            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=import_siswa") {echo 'active';}
            if ($uri_segments[5] == "index.php?page=import_siswa") {echo 'active';} ?>" href="?page=import_siswa">IMPORT</a>

          </div>
        </div>
      </li>

       <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Pelaksanaan Collapse Menu -->
      <li class="nav-item
      <?php
        if ($uri_segments[5] == "index.php?page=tagihan") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=rincian_tagihan") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=jenis_tagihan") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=jenis_tagihan_siswa") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_jenis_tagihan_umum") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_jenis_tagihan_siswa") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_pembayaran_umum") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_pembayaran_siswa") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_tunggakan_umum") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=import_tunggakan_siswa") {echo 'active';}
      ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepelaksanaan" aria-expanded="true" aria-controls="collapsepelaksanaan">
          <i class="fas fa-fw fa-table"></i>
          <span>TAGIHAN</span>
        </a>
        <div id="collapsepelaksanaan" class="collapse" aria-labelledby="headingpelaksanaan" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MENU TAGIHAN:</h6>
            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=tagihan") {echo 'active';} ?>" href="?page=tagihan">MANAJEMEN TAGIHAN</a>
             <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=jenis_tagihan") {echo 'active';} ?>" href="?page=jenis_tagihan">JENIS TAGIHAN <font color="red">(UMUM)</font></a>
             <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=jenis_tagihan_siswa") {echo 'active';} ?>" href="?page=jenis_tagihan_siswa">JENIS TAGIHAN <font color="red">(SISWA)</font></a>

             <a class="collapse-item <?php 
              if ($uri_segments[5] == "index.php?page=import_pembayaran_umum") {echo 'active';}
              if ($uri_segments[5] == "index.php?page=import_pembayaran_siswa") {echo 'active';}
               ?>" href="?page=import_pembayaran">IMPORT PEMBAYARAN</a>
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Pelaporan Collapse Menu -->
      <li class="nav-item
      <?php
        if ($uri_segments[5] == "index.php?page=laporan_pembayaran_x") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=pembayaran") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=rincian_pembayaran") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=tunggakan") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=rincian_tunggakan") {echo 'active';}
      ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapselaporan" aria-expanded="true" aria-controls="collapselaporan">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>LAPORAN</span>
        </a>
        <div id="collapselaporan" class="collapse" aria-labelledby="headinglaporan" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MENU LAPORAN</h6>
            <a class="collapse-item
              <?php if ($uri_segments[5] == "index.php?page=pembayaran") {echo 'active';}
              if ($uri_segments[5] == "index.php?page=rincian_pembayaran") {echo 'active';}?>"
              href="?page=pembayaran">PEMBAYARAN
            </a>
            <a class="collapse-item
              <?php if ($uri_segments[5] == "index.php?page=tunggakan") {echo 'active';}
              if ($uri_segments[5] == "index.php?page=rincian_tunggakan") {echo 'active';}?>"
              href="?page=tunggakan">KEKURANGAN
            </a>
          </div>
        </div>
      </li>

       <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Setting Collapse Menu -->
      <li class="nav-item
      <?php
        if ($uri_segments[5] == "index.php?page=ganti_pass") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=backup") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=user") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=info") {echo 'active';}
        elseif ($uri_segments[5] == "index.php?page=reset_default") {echo 'active';}
      ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesetting" aria-expanded="true" aria-controls="collapsesetting">
          <i class="fas fa-fw fa-cogs"></i>
          <span>PENGATURAN</span>
        </a>
        <div id="collapsesetting" class="collapse" aria-labelledby="headingsetting" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MENU PENGATURAN:</h6>
            <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=ganti_pass") {echo 'active';} ?>" href="?page=ganti_pass">GANTI PASSWORD</a>
            <?php 
              if ($_SESSION['level']=="admin") {
            ?>
                <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=backup") {echo 'active';} ?>" href="?page=backup">BACKUP & RESTORE</a>

                <a class="collapse-item text-danger <?php if ($uri_segments[5] == "index.php?page=reset_default") {echo 'active';} ?>" href="?page=reset_default">RESET DEFAULT</a>

                 <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=user") {echo 'active';} ?>" href="?page=user">USERS</a>

                 <!-- <a class="collapse-item <?php if ($uri_segments[5] == "index.php?page=info") {echo 'active';} ?>" href="?page=info">DATA SEKOLAH</a> -->
            <?php
            }else{
             echo '';
            }
           ?>
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if ($uri_segments[5] == "index.php?page=petunjuk") {echo 'active';} ?>">
        <a class="nav-link" href="index.php?page=petunjuk">
          <i class="fas fa-fw fa-question"></i>
          <span>PEDOMAN SYSTEM</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <!-- <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i> -->
                    <!-- Counter - Alerts -->
                    <!-- <?php 
                      include 'asset/inc/config.php';
                      $status = "Proses";
                      $query = mysqli_query($koneksi,"SELECT * FROM tb_pembayaran WHERE status='$status' ");
                      $jumlah_pembayaran = mysqli_num_rows($query);
                      if ($jumlah_pembayaran != 0 ) {
                        echo "<span class='badge badge-danger badge-counter'>$jumlah_pembayaran</span>";
                      }
                     ?> -->
                    
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    <?php
                     $query = "SELECT * FROM tb_pembayaran INNER JOIN tb_tagihan
                     ON tb_pembayaran.id_tagihan=tb_tagihan.id_tagihan 
                     INNER JOIN tb_siswa ON tb_pembayaran.nis=tb_siswa.nis AND tb_pembayaran.status='$status' LIMIT 0,3 ";
                      $result = mysqli_query($koneksi, $query);
                      while($data = mysqli_fetch_assoc($result)){
                    ?>
                    <a class="dropdown-item d-flex align-items-center" href="index.php?page=proses">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500"><?=$data['tanggal'];?></div>
                            <span class="font-weight">Pembayaran baru <font color="red"> <?=$data['nama_tagihan'];?> <?=$data['semester'];?> <?=$data['bulan'];?> <?=$data['tahun'];?></font> atas nama <font color="blue"><?=$data['nama_siswa'];?></font> menunggu <font color="green">validasi!</font></span>
                        </div>
                      <?php } ?>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="index.php?page=proses">Lihat Semua</a>
                </div>
            </li>

           <!--  <div class="topbar-divider d-none d-sm-block"></div> -->

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                <?php
                   $nama_pegawai = $_SESSION['nama_user'];
                   $query = "SELECT * FROM tb_baak WHERE nama_pegawai='$nama_pegawai'";
                   $result = mysqli_query($koneksi, $query);
                    while($data = mysqli_fetch_assoc($result))
                    {
                      $nama_pegawai = $data['nama_pegawai'];
                      $foto = $data['foto'];
                      $nip = $data['nip'];
                      $jabatan = $data['jabatan'];
                    }
                 ?>
                 <?=$nama_pegawai;?>
                </span>
              <?php 
              if ($foto=="") { ?>      
                <img class="img-profile rounded-circle" src="asset/images/baak.jpg">
                <?php }else{?>      
                <img class="img-profile rounded-circle" src="asset/images/baak/<?=$foto;?>">
                <?php } ?>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php if ($_SESSION['level']=="admin") { ?>
                <a class="dropdown-item" href="?page=user">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Setting
                </a>
                <?php
                  }else{
                   echo '';
                  }
                 ?>
                <a class="dropdown-item" href="?page=ganti_pass">
                  <i class="fas fa-unlock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ganti Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <?php include('asset/inc/content.php'); ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <!-- <span>Copyright &copy; <a href="#" target="_blank"> SMK MIFTAHUL ULUM</a> 2021</span> -->
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Klik "Logout" jika yakin untuk mengakhiri sesi ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="asset/vendor/jquery/jquery.min.js"></script>
  <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="asset/js/sb-admin-2.min.js"></script>  
  <script src="asset/js/ekko-lightbox.js"></script>
  <script src="asset/js/ekko-lightbox.min.js"></script>
  <!-- Page level plugins -->
  <script src="asset/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="asset/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="asset/js/demo/datatables-demo.js"></script>

    <!-- Page level plugins -->
    <script src="asset/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="asset/js/demo/chart-area-demo.js"></script> -->
    <!-- <script src="asset/js/demo/chart-pie-demo.js"></script> -->

  <script>
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  </script>

<script>
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
     event.preventDefault();
     $(this).ekkoLightbox();
  });
</script>

<script type="text/javascript">
  // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    datasets: [{
      label: "Saldo",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [
              <?php 
                $query_jan = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='01'");
                while ($data = mysqli_fetch_array($query_jan)) {
                  $jml_jan[] = $data['jumlah'];
                }
                $jumlah_jan = array_sum($jml_jan);
              ?>
              <?=  $jumlah_jan; ?>,
              <?php 
                $query_feb = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='02'");
                while ($data = mysqli_fetch_array($query_feb)) {
                  $jml_feb[] = $data['jumlah'];
                }
                $jumlah_feb = array_sum($jml_feb);
              ?>
              <?=  $jumlah_feb; ?>,
              <?php 
                $query_mar = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='03'");
                while ($data = mysqli_fetch_array($query_mar)) {
                  $jml_mar[] = $data['jumlah'];
                }
                $jumlah_mar = array_sum($jml_mar);
              ?>
              <?=  $jumlah_mar; ?>,
              <?php 
                $query_apr = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='04'");
                while ($data = mysqli_fetch_array($query_apr)) {
                  $jml_apr[] = $data['jumlah'];
                }
                $jumlah_apr = array_sum($jml_apr);
              ?>
              <?=  $jumlah_apr; ?>,
              <?php 
                $query_may = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='05'");
                while ($data = mysqli_fetch_array($query_may)) {
                  $jml_may[] = $data['jumlah'];
                }
                $jumlah_may = array_sum($jml_may);
              ?>
              <?=  $jumlah_may; ?>,
              <?php 
                $query_jun = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='06'");
                while ($data = mysqli_fetch_array($query_jun)) {
                  $jml_jun[] = $data['jumlah'];
                }
                $jumlah_jun = array_sum($jml_jun);
              ?>
              <?=  $jumlah_jun; ?>,
              <?php 
                $query_jul = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='07'");
                while ($data = mysqli_fetch_array($query_jul)) {
                  $jml_jul[] = $data['jumlah'];
                }
                $jumlah_jul = array_sum($jml_jul);
              ?>
              <?=  $jumlah_jul; ?>,
              <?php 
                $query_aug = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='08'");
                while ($data = mysqli_fetch_array($query_aug)) {
                  $jml_aug[] = $data['jumlah'];
                }
                $jumlah_aug = array_sum($jml_aug);
              ?>
              <?=  $jumlah_aug; ?>,
              <?php 
                $query_sep = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='09'");
                while ($data = mysqli_fetch_array($query_sep)) {
                  $jml_sep[] = $data['jumlah'];
                }
                $jumlah_sep = array_sum($jml_sep);
              ?>
              <?=  $jumlah_sep; ?>,
              <?php 
                $query_oct = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='10'");
                while ($data = mysqli_fetch_array($query_oct)) {
                  $jml_oct[] = $data['jumlah'];
                }
                $jumlah_oct = array_sum($jml_oct);
              ?>
              <?=  $jumlah_oct; ?>,
              <?php 
                $query_nov = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='11'");
                while ($data = mysqli_fetch_array($query_nov)) {
                  $jml_nov[] = $data['jumlah'];
                }
                $jumlah_nov = array_sum($jml_nov);
              ?>
              <?=  $jumlah_nov; ?>,
              <?php 
                $query_dec = mysqli_query ($koneksi,"SELECT * FROM tb_pembayaran WHERE chart='12'");
                while ($data = mysqli_fetch_array($query_dec)) {
                  $jml_dec[] = $data['jumlah'];
                }
                $jumlah_dec = array_sum($jml_dec);
              ?>
              <?=  $jumlah_dec; ?>
            ],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return 'Rp' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': Rp' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

</script>

</body>

</html>