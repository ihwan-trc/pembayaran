<?php 
session_start();
 ?>

 <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 mb-4 text-gray-800">MANAJEMEN TAGIHAN</h1>

        <!-- <a href="page/tagihan/reset_pembayaran.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"onclick="return confirm('Yakin Untuk Mereset Semua Data Pembayaran?')">
        <i class="fas fa fa-undo fa-sm fa-fw mr-2 text-gray-400"></i> Reset Data Pembayaran</a> -->
    </div>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <form method='post' class='d-sm-inline-block form-inline' action="">
        <select class="form-control" name="kelas_back" id="kelas" required="">
          <option value="">Pilih Kelas</option>
          <?php
            $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
            while ($data = mysqli_fetch_assoc($query)) {
              $kelas = $data['kelas'];
            ?>
            <option value="<?= $kelas;?>"><?= $kelas;?></option>
          <?php } ?>
        </select>
        <select class="form-control" name="jurusan_back" id="jurusan" required="">
          <option value="">Pilih Jurusan</option>
          <?php
            $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
            while ($data = mysqli_fetch_assoc($query)) {
              $jurusan = $data['jurusan'];
            ?>
            <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
          <?php } ?>
        </select>
        <button class="btn btn-primary" type="submit" name="back"><i class="fas fa-search fa-sm"></i></button>
    </form>
    <?php 
        if ($_POST['kelas_back']) {
          if ($_POST['jurusan_back']) {
           $kelas = $_POST['kelas_back'];
           $jurusan = $_POST['jurusan_back']; ?>
           <form action="page/tagihan/reset_pembayaran.php" method="POST" style="float: right;">
             <input type="hidden" name="kelas" value="<?= $kelas; ?>">
             <input type="hidden" name="jurusan" value="<?= $jurusan; ?>">
             <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Yakin Untuk Reset Data Pembayaran <?= $kelas; ?> <?= $jurusan; ?>?')" name="resetpembayaran">
               <i class="fas fa fa-undo fa-sm fa-fw mr-2 text-gray-400"></i> Reset Pembayaran <?= $kelas; ?> <?= $jurusan; ?>
             </button>
           </form>
     <?php } } ?>
  </div>

  <!-- ////////////////////////////////////////////HOME/////////////////////////////// -->
<?php 
if (!isset($_POST['back'])) { ?>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
            <th class="text-center">NAMA SISWA</th>
            <th class="text-center">JENIS TAGIHAN</th>
            <th class="text-center">JUMLAH KEKURANGAN</th>
            <th class="text-center">JUMLAH</th>
          </tr>
        </thead>
        <tbody> 
        </tbody>
        <tfoot>
          <tr>
              <td class="text-center"><b>TOTAL</b></td>
              <td class="text-center" colspan="2"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
 <?php
}
?> <!-- =================================================end home======================= -->


<!-- ////////////////////////////////////////////POST BACK/////////////////////////////// -->
<?php 
if (isset($_POST['back'])) {
  $kelas_post = $_POST['kelas_back'];
  $jurusan_post = $_POST['jurusan_back'];
  $kls_semua = "SEMUA";
  $jrsn_semua = "SEMUA";
?>

  <?php
    if ($kelas_post !== "") {
     if ($jurusan_post !== "") {
     $no =1;
   ?>

  <div class="card-body">
    <div class="">
      <div class="form-group">
        <table>
          <tr>
            <th>KELAS</th>
            <th>: <?= $kelas_post;?> </th>
          </tr>
          <tr>
            <th>JURUSAN</th>
            <th>: <?= $jurusan_post;?></th>
          </tr>
        </table>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">idsiswa</th>
            <th class="text-center">NAMA SISWA</th>
            <!-- kelas SEMUA jurusan SEMUA --> 
            <?php
              $query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kls_semua' AND jurusan='$jrsn_semua'";
              $result1 = mysqli_query($koneksi,$query1);
              while ($data1 = mysqli_fetch_assoc($result1)) {
              $jns_tghn1 = $data1['jenis_tagihan'];
              $id_tghn1 = $data1['id_jenis_tagihan'];
            ?>
            <th class="text-center"><?=$jns_tghn1;?></th>
            <?php } ?>  
            <!-- kelas post jurusan SEMUA -->
            <?php
              $query2 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jrsn_semua'";
              $result2 = mysqli_query($koneksi,$query2);
              while ($data2 = mysqli_fetch_assoc($result2)) {
              $jns_tghn2 = $data2['jenis_tagihan'];
              $id_tghn2 = $data2['id_jenis_tagihan'];
            ?>
            <th class="text-center"><?=$jns_tghn2;?></th>
            <?php } ?>
            <!-- kelas post jurusan post -->
            <?php
              $query3 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jurusan_post'";
              $result3 = mysqli_query($koneksi,$query3);
              while ($data3 = mysqli_fetch_assoc($result3)) {
              $jns_tghn3 = $data3['jenis_tagihan'];
              $id_tghn3 = $data3['id_jenis_tagihan'];
            ?>
            <th class="text-center"><?=$jns_tghn3;?></th>
            <?php } ?>
            <!-- tagihan/siswa -->
            <?php
              $query4 = "SELECT * FROM tb_jenis_tagihan_siswa";
              $result4 = mysqli_query($koneksi,$query4);
              while ($data4 = mysqli_fetch_assoc($result4)) {
              $jns_tghn4 = $data4['jenis_tagihan_siswa'];
              $id_tghn4 = $data4['id_jns_tghn_siswa'];
            ?>
            <th class="text-center"><?=$jns_tghn4;?></th>
            <?php } ?>

            <th class="text-center">JUMLAH PEMBAYARAN</th>
            <th class="text-center">JUMLAH KEKURANGAN</th>
            <th class="text-center">JUMLAH</th>
            <th class="text-center">PILIHAN</th>
          </tr>
        </thead>

        <tbody> 

<?php
// ambil data siswa 
$query_siswa = "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC";
      $result = mysqli_query($koneksi,$query_siswa);
      while ($data = mysqli_fetch_assoc($result)) {
      $id_siswa = $data['id_siswa'];
      $nis = $data['nis'];
      $nama_siswa = $data['nama_siswa'];
      $kelas = $data['kelas'];
      $jurusan = $data['jurusan'];
// jumlah siswa
    $jumlah_siswa = mysqli_query($koneksi,"SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post'");
    $jml_siswa = mysqli_num_rows($jumlah_siswa);
?> 

           <tr>
            <td class="text-center"><?=$id_siswa;?></td>
            <td><?=$nama_siswa;?></td>

    <!-- kelas SEMUA jurusan SEMUA -->
            <!-- ambil data jenis tagihan -->
            <?php
            $query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kls_semua' AND jurusan='$jrsn_semua'";
              $result1 = mysqli_query($koneksi,$query1);
                while ($data1 = mysqli_fetch_assoc($result1)) {
                $id_jns_tghn1 = $data1['id_jenis_tagihan'];
                $jns_tghn1 = $data1['jenis_tagihan'];
                $jml_tghn1 = $data1['jumlah'];
                $jumlah_tagihan1 = number_format($jml_tghn1,0,",",".");

              // ambil pembayaran 1
              $pembayaran1 = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa' AND id_jenis_tagihan='$id_jns_tghn1'";
              $result_byr1 = mysqli_query($koneksi,$pembayaran1);
                while ($byr1 = mysqli_fetch_assoc($result_byr1)) {
                $id_pembayaran1 = $byr1['id_pembayaran'];
                $id_byr1 = $byr1['id_siswa'];
                $id_siswa_byr1 = $byr1['id_siswa'];
                $id_jns_tghn_byr1 = $byr1['id_jenis_tagihan'];
                $status_byr1 = $byr1['status'];
                $jml_byr1 = $byr1['jumlah'];
                $jumlah_bayar1 = number_format($jml_byr1,0,",",".");
              }

              $jml_tgkn1 = $jml_tghn1 - $jml_byr1;
              $jumlah_tunggakan1 = number_format($jml_tgkn1,0,",",".");

              if ($id_siswa == $id_siswa_byr1) {
                if ($id_jns_tghn1 == $id_jns_tghn_byr1) {
                  if ($status_byr1 == "Lunas") {
                    $status1 = "<a href='#' class='detail' data-toggle='modal' data-target='#detail_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran1'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn1'
                                  data-jenis_tagihan='$jns_tghn1'
                                  data-jml_tagihan='$jml_tghn1'
                                  data-jumlah_tagihan='$jumlah_tagihan1'

                                  data-jml_bayar='$jml_byr1'
                                  data-jumlah_bayar='$jumlah_bayar1'

                                  data-jml_tunggakan='$jml_tgkn1'
                                  data-jumlah_tunggakan='$jumlah_tunggakan1'>
                                  <button class='btn btn-sm btn-success' type='submit' name='detail' title='Detail'>$jumlah_bayar1
                                  </button>
                                  </a>";
                              }
                  if($status_byr1 == "Proses"){
                    if ($jml_byr1 < $jml_tghn1) {
                      $status1 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran1'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn1'
                                  data-jenis_tagihan='$jns_tghn1'
                                  data-jml_tagihan='$jml_tghn1'
                                  data-jumlah_tagihan='$jumlah_tagihan1'

                                  data-jml_bayar='$jml_byr1'
                                  data-jumlah_bayar='$jumlah_bayar1'

                                  data-jml_tunggakan='$jml_tgkn1'
                                  data-jumlah_tunggakan='$jumlah_tunggakan1'>
                                  <button class='btn btn-sm btn-info' type='submit' title='Update'>$jumlah_bayar1
                                  </button>
                                  </a>";
                                }
                    if ($jml_byr1 > $jml_tghn1) {
                      $status1 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran1'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn1'
                                  data-jenis_tagihan='$jns_tghn1'
                                  data-jml_tagihan='$jml_tghn1'
                                  data-jumlah_tagihan='$jumlah_tagihan1'

                                  data-jml_bayar='$jml_byr1'
                                  data-jumlah_bayar='$jumlah_bayar1'

                                  data-jml_tunggakan='$jml_tgkn1'
                                  data-jumlah_tunggakan='$jumlah_tunggakan1'>
                                  <button class='btn btn-sm btn-warning' type='submit' title='Update'>$jumlah_bayar1
                                  </button>
                                  </a>";
                                }
                            }
                      }
                }
                if ($id_siswa !== $id_siswa_byr1) {
                  if ($id_jns_tghn1 !== $id_jns_tghn_byr1) {
                    $status1 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn1'
                                data-jenis_tagihan='$jns_tghn1'
                                data-jml_tagihan='$jml_tghn1'
                                data-jumlah_tagihan='$jumlah_tagihan1'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan1</button></a>";
                    }
                }
                if ($id_siswa !== $id_siswa_byr1) {
                  if ($id_jns_tghn1 == $id_jns_tghn_byr1) {
                    $status1 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn1'
                                data-jenis_tagihan='$jns_tghn1'
                                data-jml_tagihan='$jml_tghn1'
                                data-jumlah_tagihan='$jumlah_tagihan1'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan1</button></a>";
                    }
                }
                if ($id_siswa == $id_siswa_byr1) {
                  if ($id_jns_tghn1 !== $id_jns_tghn_byr1) {
                    $status1 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn1'
                                data-jenis_tagihan='$jns_tghn1'
                                data-jml_tagihan='$jml_tghn1'
                                data-jumlah_tagihan='$jumlah_tagihan1'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan1</button></a>";
                    }
                }
            ?>
            <td class="text-center"><?=$status1;?></td>
            <?php } ?>  <!-- end tagihan semua -->
<!-- ------------------------------END 1------------------------------------------------------>

    <!-- kelas post jurusan SEMUA -->
            <!-- ambil data jenis tagihan -->
            <?php
            $query2 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jrsn_semua'";
              $result2 = mysqli_query($koneksi,$query2);
                while ($data2 = mysqli_fetch_assoc($result2)) {
                $id_jns_tghn2 = $data2['id_jenis_tagihan'];
                $jns_tghn2 = $data2['jenis_tagihan'];
                $jml_tghn2 = $data2['jumlah'];
                $jumlah_tagihan2 = number_format($jml_tghn2,0,",",".");

              // ambil pembayaran 2
              $pembayaran2 = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa' AND id_jenis_tagihan='$id_jns_tghn2'";
              $result_byr2 = mysqli_query($koneksi,$pembayaran2);
                while ($byr2 = mysqli_fetch_assoc($result_byr2)) {
                $id_pembayaran2 = $byr2['id_pembayaran'];
                $id_byr2 = $byr2['id_siswa'];
                $id_siswa_byr2 = $byr2['id_siswa'];
                $id_jns_tghn_byr2 = $byr2['id_jenis_tagihan'];
                $status_byr2 = $byr2['status'];
                $jml_byr2 = $byr2['jumlah'];
                $jumlah_bayar2 = number_format($jml_byr2,0,",",".");
              }

              $jml_tgkn2 = $jml_tghn2 - $jml_byr2;
              $jumlah_tunggakan2 = number_format($jml_tgkn2,0,",",".");

              if ($id_siswa == $id_siswa_byr2) {
                if ($id_jns_tghn2 == $id_jns_tghn_byr2) {
                  if ($status_byr2 == "Lunas") {
                    $status2 = "<a href='#' class='detail' data-toggle='modal' data-target='#detail_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran2'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn2'
                                  data-jenis_tagihan='$jns_tghn2'
                                  data-jml_tagihan='$jml_tghn2'
                                  data-jumlah_tagihan='$jumlah_tagihan2'

                                  data-jml_bayar='$jml_byr2'
                                  data-jumlah_bayar='$jumlah_bayar2'

                                  data-jml_tunggakan='$jml_tgkn2'
                                  data-jumlah_tunggakan='$jumlah_tunggakan2'>
                                  <button class='btn btn-sm btn-success' type='submit' name='detail' title='Detail'>$jumlah_bayar2
                                  </button>
                                  </a>";
                              }
                  if($status_byr2 == "Proses"){
                    if ($jml_byr2 < $jml_tghn2) {
                      $status2 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                data-id_pembayaran='$id_pembayaran2'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn2'
                                  data-jenis_tagihan='$jns_tghn2'
                                  data-jml_tagihan='$jml_tghn2'
                                  data-jumlah_tagihan='$jumlah_tagihan2'

                                  data-jml_bayar='$jml_byr2'
                                  data-jumlah_bayar='$jumlah_bayar2'

                                  data-jml_tunggakan='$jml_tgkn2'
                                  data-jumlah_tunggakan='$jumlah_tunggakan2'>
                                  <button class='btn btn-sm btn-info' type='submit' name='detail' title='Update'>$jumlah_bayar2
                                  </button>
                                  </a>";
                                }
                    if ($jml_byr2 > $jml_tghn2) {
                      $status2 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran2'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn2'
                                  data-jenis_tagihan='$jns_tghn2'
                                  data-jml_tagihan='$jml_tghn2'
                                  data-jumlah_tagihan='$jumlah_tagihan2'

                                  data-jml_bayar='$jml_byr2'
                                  data-jumlah_bayar='$jumlah_bayar2'

                                  data-jml_tunggakan='$jml_tgkn2'
                                  data-jumlah_tunggakan='$jumlah_tunggakan2'>
                                  <button class='btn btn-sm btn-warning' type='submit' name='detail' title='update'>$jumlah_bayar2</button></a>";
                                }
                              }
                      }
                }
                if ($id_siswa !== $id_siswa_byr2) {
                  if ($id_jns_tghn2 !== $id_jns_tghn_byr2) {
                    $status2 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn2'
                                data-jenis_tagihan='$jns_tghn2'
                                data-jml_tagihan='$jml_tghn2'
                                data-jumlah_tagihan='$jumlah_tagihan2'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan2</button></a>";
                    }
                }
                if ($id_siswa !== $id_siswa_byr2) {
                  if ($id_jns_tghn2 == $id_jns_tghn_byr2) {
                    $status2 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn2'
                                data-jenis_tagihan='$jns_tghn2'
                                data-jml_tagihan='$jml_tghn2'
                                data-jumlah_tagihan='$jumlah_tagihan2'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan2</button></a>";
                    }
                }
                if ($id_siswa == $id_siswa_byr2) {
                  if ($id_jns_tghn2 !== $id_jns_tghn_byr2) {
                    $status2 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn2'
                                data-jenis_tagihan='$jns_tghn2'
                                data-jml_tagihan='$jml_tghn2'
                                data-jumlah_tagihan='$jumlah_tagihan2'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan2</button></a>";
                    }
                }
            ?>
            <td class="text-center"><?=$status2;?></td>
            <?php } ?>  <!-- end tagihan kelas post jurusan SEMUA -->
<!-- ------------------------------END 2------------------------------------------------------>

    <!-- kelas post jurusan post -->
            <!-- ambil data jenis tagihan -->
            <?php
            $query3 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jurusan_post'";
              $result3 = mysqli_query($koneksi,$query3);
                while ($data3 = mysqli_fetch_assoc($result3)) {
                $id_jns_tghn3 = $data3['id_jenis_tagihan'];
                $jns_tghn3 = $data3['jenis_tagihan'];
                $jml_tghn3 = $data3['jumlah'];
                $jumlah_tagihan3 = number_format($jml_tghn3,0,",",".");

              // ambil pembayaran 3
              $pembayaran3 = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa' AND id_jenis_tagihan='$id_jns_tghn3'";
              $result_byr3 = mysqli_query($koneksi,$pembayaran3);
                while ($byr3 = mysqli_fetch_assoc($result_byr3)) {
                $id_pembayaran3 = $byr3['id_pembayaran'];
                $id_byr3 = $byr3['id_siswa'];
                $id_siswa_byr3 = $byr3['id_siswa'];
                $id_jns_tghn_byr3 = $byr3['id_jenis_tagihan'];
                $status_byr3 = $byr3['status'];
                $jml_byr3 = $byr3['jumlah'];
                $jumlah_bayar3 = number_format($jml_byr3,0,",",".");
              }

              $jml_tgkn3 = $jml_tghn3 - $jml_byr3;
              $jumlah_tunggakan3 = number_format($jml_tgkn3,0,",",".");

              if ($id_siswa == $id_siswa_byr3) {
                if ($id_jns_tghn3 == $id_jns_tghn_byr3) {
                  if ($status_byr3 == "Lunas") {
                    $status3 = "<a href='#' class='detail' data-toggle='modal' data-target='#detail_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran3'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn3'
                                  data-jenis_tagihan='$jns_tghn3'
                                  data-jml_tagihan='$jml_tghn3'
                                  data-jumlah_tagihan='$jumlah_tagihan3'

                                  data-jml_bayar='$jml_byr3'
                                  data-jumlah_bayar='$jumlah_bayar3'

                                  data-jml_tunggakan='$jml_tgkn3'
                                  data-jumlah_tunggakan='$jumlah_tunggakan3'>
                                  <button class='btn btn-sm btn-success' type='submit' name='detail' title='Detail'>$jumlah_bayar3
                                  </button>
                                  </a>";
                              }
                  if($status_byr3 == "Proses"){
                    if ($jml_byr3 < $jml_tghn3) {
                      $status3 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran3'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn3'
                                  data-jenis_tagihan='$jns_tghn3'
                                  data-jml_tagihan='$jml_tghn3'
                                  data-jumlah_tagihan='$jumlah_tagihan3'

                                  data-jml_bayar='$jml_byr3'
                                  data-jumlah_bayar='$jumlah_bayar3'

                                  data-jml_tunggakan='$jml_tgkn3'
                                  data-jumlah_tunggakan='$jumlah_tunggakan3'>
                                  <button class='btn btn-sm btn-info' type='submit' name='detail' title='Update'>$jumlah_bayar3
                                  </button>
                                  </a>";
                                }
                    if ($jml_byr3 > $jml_tghn3) {
                      $status3 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                  data-id_pembayaran='$id_pembayaran3'

                                  data-id_siswa='$id_siswa'
                                  data-nis='$nis'
                                  data-nama_siswa='$nama_siswa'
                                  data-kelas='$kelas'
                                  data-jurusan='$jurusan'

                                  data-id_jenis_tagihan='$id_jns_tghn3'
                                  data-jenis_tagihan='$jns_tghn3'
                                  data-jml_tagihan='$jml_tghn3'
                                  data-jumlah_tagihan='$jumlah_tagihan3'

                                  data-jml_bayar='$jml_byr3'
                                  data-jumlah_bayar='$jumlah_bayar3'

                                  data-jml_tunggakan='$jml_tgkn3'
                                  data-jumlah_tunggakan='$jumlah_tunggakan3'>
                                  <button class='btn btn-sm btn-warning' type='submit' name='detail' title='update'>$jumlah_bayar3</button></a>";
                                }
                              }
                      }
                }
                if ($id_siswa !== $id_siswa_byr3) {
                  if ($id_jns_tghn3 !== $id_jns_tghn_byr3) {
                    $status3 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn3'
                                data-jenis_tagihan='$jns_tghn3'
                                data-jml_tagihan='$jml_tghn3'
                                data-jumlah_tagihan='$jumlah_tagihan3'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan3</button></a>";
                    }
                }
                if ($id_siswa !== $id_siswa_byr3) {
                  if ($id_jns_tghn3 == $id_jns_tghn_byr3) {
                    $status3 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn3'
                                data-jenis_tagihan='$jns_tghn3'
                                data-jml_tagihan='$jml_tghn3'
                                data-jumlah_tagihan='$jumlah_tagihan3'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan3</button></a>";
                    }
                }
                if ($id_siswa == $id_siswa_byr3) {
                  if ($id_jns_tghn3 !== $id_jns_tghn_byr3) {
                    $status3 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihanModal' 

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jenis_tagihan='$id_jns_tghn3'
                                data-jenis_tagihan='$jns_tghn3'
                                data-jml_tagihan='$jml_tghn3'
                                data-jumlah_tagihan='$jumlah_tagihan3'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan3</button></a>";
                    }
                }
            ?>
            <td class="text-center"><?=$status3;?></td>
            <?php } ?>  <!-- end tagihan semua -->
<!-- ------------------------------END 3------------------------------------------------------>


<!-- tagihan/siswa -->
            <!-- ambil data jenis tagihan -->
            <?php
            $query4 = "SELECT * FROM tb_jenis_tagihan_siswa";
              $result4 = mysqli_query($koneksi,$query4);
                while ($data4 = mysqli_fetch_assoc($result4)) {
                $id_jns_tghn_siswa4 = $data4['id_jns_tghn_siswa'];
                $jns_tghn4 = $data4['jenis_tagihan_siswa'];

              // ambil tagihan siswa 4
              $tagihan_siswa4 = "SELECT * FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa' AND id_jns_tghn_siswa='$id_jns_tghn_siswa4'";
              $result_tghn4 = mysqli_query($koneksi,$tagihan_siswa4);
                while ($tghn4 = mysqli_fetch_assoc($result_tghn4)) {
                $id_tagihan_siswa4 = $tghn4['id_tagihan_siswa'];
                $id_siswa_tghn4 = $tghn4['id_siswa'];
                $id_jns_tghn4 = $tghn4['id_jns_tghn_siswa'];
                $jml_tghn4 = $tghn4['jumlah'];
                $jumlah_tagihan4 = number_format($jml_tghn4,0,",",".");

                 // ambil pembayaran 4
              $pembayaran4 = "SELECT * FROM tb_pembayaran WHERE id_siswa='$id_siswa' AND id_jns_tghn_siswa='$id_jns_tghn4'";
              $result_byr4 = mysqli_query($koneksi,$pembayaran4);
                while ($byr4 = mysqli_fetch_assoc($result_byr4)) {
                $id_pembayaran4 = $byr4['id_pembayaran'];
                $id_siswa_byr4 = $byr4['id_siswa'];
                $id_jns_tghn_byr4 = $byr4['id_jns_tghn_siswa'];
                $jml_byr4 = $byr4['jumlah'];
                $jumlah_bayar4 = number_format($jml_byr4,0,",",".");
                $status_byr4 = $byr4['status'];
                }
              }
              $jml_tgkn4 = $jml_tghn4 - $jml_byr4;
              $jumlah_tunggakan4 = number_format($jml_tgkn4,0,",",".");


                // jika data tagihan belum ada
                if ($id_jns_tghn_siswa4 !== $id_jns_tghn4) {
                  if ($id_siswa !== $id_siswa_tghn4) {
                    $status4 = "<a href='#' class='tambah_siswa' data-toggle='modal' data-target='#tambah_siswaModal' 
                                data-id_pembayaran='$id_pembayaran4'

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jns_tghn_siswa='$id_jns_tghn_siswa4'
                                data-jenis_tagihan='$jns_tghn4'>
                                <button class='btn btn-sm btn-primary' type='submit' name='detail' title='Tambah'> <i class='fas fa-plus'></i>
                                </button></a>";
                    }
                } 
                if ($id_jns_tghn_siswa4 !== $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    $status4 = "<a href='#' class='tambah_siswa' data-toggle='modal' data-target='#tambah_siswaModal' 
                                data-id_pembayaran='$id_pembayaran4'

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jns_tghn_siswa='$id_jns_tghn_siswa4'
                                data-jenis_tagihan='$jns_tghn4'>
                                <button class='btn btn-sm btn-primary' type='submit' name='detail' title='Tambah'> <i class='fas fa-plus'></i>
                                </button></a>";
                    }
                } 
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa !== $id_siswa_tghn4) {
                    $status4 = "<a href='#' class='tambah_siswa' data-toggle='modal' data-target='#tambah_siswaModal' 
                                data-id_pembayaran='$id_pembayaran4'

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jns_tghn_siswa='$id_jns_tghn_siswa4'
                                data-jenis_tagihan='$jns_tghn4'>
                                <button class='btn btn-sm btn-primary' type='submit' name='detail' title='Tambah'> <i class='fas fa-plus'></i>
                                </button></a>";
                    }
                } 


                // jika ada data tagihan tapi belum bayar
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    $status4 = "<a href='#' class='bayar' data-toggle='modal' data-target='#bayar_tagihan_siswaModal' 
                                data-id_pembayaran='$id_pembayaran4'
                                data-id_tagihan_siswa='$id_tagihan_siswa4'

                                data-id_siswa='$id_siswa'
                                data-nis='$nis'
                                data-nama_siswa='$nama_siswa'
                                data-kelas='$kelas'
                                data-jurusan='$jurusan'

                                data-id_jns_tghn_siswa='$id_jns_tghn4'
                                data-jenis_tagihan='$jns_tghn4'
                                data-jml_tagihan='$jml_tghn4'
                                data-jumlah_tagihan='$jumlah_tagihan4'>

                                <button class='btn btn-sm btn-danger' type='submit' name='detail' title='Bayar'>$jumlah_tagihan4</button></a>";
                    }
                } 
                // data pembayaran
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    if ($id_siswa_tghn4 == $id_siswa_byr4) {
                      if ($id_jns_tghn4 == $id_jns_tghn_byr4) {
                        if ($status_byr4 == "Lunas") {
                              $status4 = "<a href='#' class='detail' data-toggle='modal' data-target='#detail_tagihanModal' 
                                            data-id_pembayaran='$id_pembayaran4'
                                            data-id_tagihan_siswa='$id_tagihan_siswa4'

                                            data-id_siswa='$id_siswa'
                                            data-nis='$nis'
                                            data-nama_siswa='$nama_siswa'
                                            data-kelas='$kelas'
                                            data-jurusan='$jurusan'

                                            data-id_jenis_tagihan='$id_jns_tghn4'
                                            data-jenis_tagihan='$jns_tghn4'
                                            data-jml_tagihan='$jml_tghn4'
                                            data-jumlah_tagihan='$jumlah_tagihan4'

                                            data-jml_bayar='$jml_byr4'
                                            data-jumlah_bayar='$jumlah_bayar4'

                                            data-jml_tunggakan='$jml_tgkn4'
                                            data-jumlah_tunggakan='$jumlah_tunggakan4'>
                                            <button class='btn btn-sm btn-success' type='submit' name='detail' title='Detail'>$jumlah_bayar4
                                            </button>
                                            </a>";
                                        }
                        if ($status_byr4 == "Proses") {
                          if ($jml_byr4 < $jml_tghn4) {
                              $status4 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                          data-id_pembayaran='$id_pembayaran4'

                                          data-id_siswa='$id_siswa'
                                          data-nis='$nis'
                                          data-nama_siswa='$nama_siswa'
                                          data-kelas='$kelas'
                                          data-jurusan='$jurusan'

                                          data-id_jns_tghn_siswa='$id_jns_tghn4'
                                          data-jenis_tagihan='$jns_tghn4'
                                          data-jml_tagihan='$jml_tghn4'
                                          data-jumlah_tagihan='$jumlah_tagihan4'

                                          data-jml_bayar='$jml_byr4'
                                          data-jumlah_bayar='$jumlah_bayar4'

                                          data-jml_tunggakan='$jml_tgkn4'
                                          data-jumlah_tunggakan='$jumlah_tunggakan4'>
                                          <button class='btn btn-sm btn-info' type='submit' name='detail' title='Update'>$jumlah_bayar4
                                          </button></a>";
                                        }
                            if ($jml_byr4 > $jml_tghn4) {
                              $status4 = "<a href='#' class='update' data-toggle='modal' data-target='#update_tagihanModal' 
                                          data-id_pembayaran='$id_pembayaran4'

                                          data-id_siswa='$id_siswa'
                                          data-nis='$nis'
                                          data-nama_siswa='$nama_siswa'
                                          data-kelas='$kelas'
                                          data-jurusan='$jurusan'

                                          data-id_jns_tghn_siswa='$id_jns_tghn4'
                                          data-jenis_tagihan='$jns_tghn4'
                                          data-jml_tagihan='$jml_tghn4'
                                          data-jumlah_tagihan='$jumlah_tagihan4'

                                          data-jml_bayar='$jml_byr4'
                                          data-jumlah_bayar='$jumlah_bayar4'

                                          data-jml_tunggakan='$jml_tgkn4'
                                          data-jumlah_tunggakan='$jumlah_tunggakan4'>
                                          <button class='btn btn-sm btn-warning' type='submit' name='detail' title='Update'>$jumlah_bayar4
                                          </button></a>";
                                        }
                                      }
                      }
                    }
                  }
                }
            ?>
            <td class="text-center"><?= $status4;?></td>
            <?php } ?>  <!-- end tagihan 4 -->

<!-- ------------------------------END 4------------------------------------------------------>


<?php 
// jumlah tagihan yg harus dibayar
$j_tghn1 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='$kls_semua' AND jurusan='$jrsn_semua'";
      $result1 = mysqli_query($koneksi,$j_tghn1);
        while ($data = mysqli_fetch_assoc($result1)) {
        $jml_J_tghn1 = $data['SUM(jumlah)'];
      } 
$j_tghn2 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jrsn_semua'";
      $result2 = mysqli_query($koneksi,$j_tghn2);
        while ($data = mysqli_fetch_assoc($result2)) {
        $jml_J_tghn2 = $data['SUM(jumlah)'];
      }
$j_tghn3 = "SELECT SUM(jumlah) FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jurusan_post'";
      $result3 = mysqli_query($koneksi,$j_tghn3);
        while ($data = mysqli_fetch_assoc($result3)) {
        $jml_J_tghn3 = $data['SUM(jumlah)'];
      }  
$j_tghn4 = "SELECT SUM(jumlah) FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa'";
      $result4 = mysqli_query($koneksi,$j_tghn4);
        while ($data = mysqli_fetch_assoc($result4)) {
        $jml_J_tghn4 = $data['SUM(jumlah)'];
      } 
?>
<?php
  $jumlah_tghn = $jml_J_tghn1 + $jml_J_tghn2 + $jml_J_tghn3 + $jml_J_tghn4;
  $jumlah_tagihan = number_format($jumlah_tghn,0,",",".");
  $totaltghn += $jumlah_tghn;
?>
<?php 
// jumlah tagihan yg sudah dibayar 
$jumlah_byr123 = "SELECT SUM(jumlah) FROM tb_pembayaran WHERE id_siswa='$id_siswa'";
      $result1 = mysqli_query($koneksi,$jumlah_byr123);
        while ($data = mysqli_fetch_assoc($result1)) {
        $jumlah_byr = $data['SUM(jumlah)'];
        $jumlah_bayar =  number_format($jumlah_byr,0,",",".");
        if ( $jumlah_bayar == 0) {
          $jumlah_bayar = "";
        }
        if ( $jumlah_bayar !== 0) {
          $jumlah_bayar = $jumlah_bayar;
        }
      }      
?>
<?php 
// jumlah tunggakan
$jumlah_tgkn = $jumlah_tghn - $jumlah_byr;
if ($jumlah_tgkn == 0) {
    $jumlah_tunggakan = "";
      }else{
        $jumlah_tunggakan =  number_format($jumlah_tgkn,0,",",".");
    }   
?>
            <td class="text-center"><b><?= $jumlah_bayar; ?></b></td>
            <td class="text-center"><b><?= $jumlah_tunggakan; ?></b></td>
            <td class="text-center"><b><?= $jumlah_tagihan; ?></b></td> 
            <td>
              <form method='post' action='index.php?page=rincian_tagihan'>
                <input type='hidden' name='id_siswa' value='<?=$id_siswa?>'>
                <button class='btn btn-sm btn-primary' type='submit' name='rincian' title='Lihat Rincian'>Rincian</button>
              </form>
            </td>
          </tr>
<?php } ?> <!-- end siswa-->
        </tbody>

        <!-- ///////////////////////////////////////////FOOTER///////////////////////////////// -->
        <tfoot>
          <tr>
             <td class="text-center" colspan="2"><b>TOTAL</b></td>
<!-- foot1 -->
<?php
$foot1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kls_semua' AND jurusan='$jrsn_semua'";
      $result = mysqli_query($koneksi,$foot1);
        while ($data = mysqli_fetch_assoc($result)) {
        $id_jenis_tghnfoot1 = $data['id_jenis_tagihan'];
        $jml_tghnfoot1 = $data['jumlah'] * $jml_siswa;        
  ?>
<!-- <th class="text-center"><?=$jml_tghnfoot1;?></th> -->
<th class="text-center"></th>
<?php } ?>
<!-- foot2 -->
<?php
$foot2 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jrsn_semua'";
      $result = mysqli_query($koneksi,$foot2);
        while ($data = mysqli_fetch_assoc($result)) {
        $id_jenis_tghnfoot2 = $data['id_jenis_tagihan'];
        $jml_tghnfoot2 = $data['jumlah'] * $jml_siswa;        
  ?>
<!-- <th class="text-center"><?=$jml_tghnfoot2;?></th> -->
<th class="text-center"></th>
<?php } ?>
<!-- foot3 -->
<?php
$foot3 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas_post' AND jurusan='$jurusan_post'";
      $result = mysqli_query($koneksi,$foot3);
        while ($data = mysqli_fetch_assoc($result)) {
        $id_jenis_tghnfoot3 = $data['id_jenis_tagihan'];
        $jml_tghnfoot3 = $data['jumlah'] * $jml_siswa;        
  ?>
<!-- <th class="text-center"><?=$jml_tghnfoot3;?></th> -->
<th class="text-center"></th>
<?php } ?>
<!-- foot3 -->
<?php
$foot4 = "SELECT * FROM tb_jenis_tagihan_siswa";
      $result = mysqli_query($koneksi,$foot4);
        while ($data = mysqli_fetch_assoc($result)) {
        $id_jenis_tghnfoot4 = $data['id_jns_tghn_siswa'];      
  ?>
<!-- <th class="text-center"><?=$jml_tghnfoot3;?></th> -->
<th class="text-center"></th>
<?php } ?>


<!-- ============================================================================================== -->

<?php
$total_tghn = $totaltghn;
// var_dump($totaltghn); 
if ($total_tghn == 0) {
  $total_tagihan = "";
    }else{
      $total_tagihan =  number_format($total_tghn,0,",",".");
  }
 ?>
<?php
// jumlah tagihan yg sudah dibayar          
$total_byr123 = "SELECT SUM(jumlah) FROM tb_pembayaran INNER JOIN tb_siswa ON tb_siswa.id_siswa=tb_pembayaran.id_siswa AND tb_siswa.kelas='$kelas_post' AND tb_siswa.jurusan='$jurusan_post'";
      $result = mysqli_query($koneksi,$total_byr123);
        while ($data = mysqli_fetch_assoc($result)) {
        $total_byr = $data['SUM(jumlah)'];
        if ($total_byr == 0) {
        $total_bayar = "";
          }else{
            $total_bayar =  number_format($total_byr,0,",",".");
        }
      }         
?>
<?php 
$total_tgkn = $total_tghn - $total_byr;
if ($total_tgkn == 0) {
  $total_tunggakan = "";
    }else{
      $total_tunggakan =  number_format($total_tgkn,0,",",".");
  }
 ?>      
            <td class="text-center"><b><?= $total_bayar; ?></td>
            <td class="text-center"><b><?= $total_tunggakan; ?></b></td>
            <td class="text-center"><b><?= $total_tagihan; ?></b></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
<?php  
     }
     // end kelas
    }
    // end jurusan
?>

<?php
// END BACK
}
 ?> 
 <!-- =================================================end post back======================= -->

</div>



  <!-- MODAL DETAIL TAGIHAN -->
<div class="modal fade" id="detail_tagihanModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">DETAIL TAGIHAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/tagihan/detail.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_pembayaran_hapus" id="detail_id_pembayaran">
          <input type="hidden" name="id_tagihan_siswa_hapus" id="detail_id_tagihan_siswa">
          <div class="form-row">
            <div class="form-group col-4">
              <label for="detail_nis">NIS :</label>
              <input type="text" class="form-control" name="nis_detail" id="detail_nis" readonly="">
            </div>
            <div class="form-group col-8">
              <label for="detail_nama_siswa">Nama Siswa :</label>
              <input type="text" class="form-control" name="nama_siswa_detail" id="detail_nama_siswa" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="detail_kelas">Kelas :</label>
              <input type="text" class="form-control" name="kelas_back" id="detail_kelas" readonly="">
            </div>
            <div class="form-group col-8">
              <label for="detail_jurusan">Jurusan :</label>
              <input type="text" class="form-control" name="jurusan_back" id="detail_jurusan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-7">
              <label for="detail_jenis_tagihan">Jenis Tagihan :</label>
              <input type="text" class="form-control" name="jenis_tagihan_detail" id="detail_jenis_tagihan" readonly="">
            </div>
            <div class="form-group col-5">
              <label for="detail_jumlah_tagihan">Jumlah :</label>
              <input type="text" class="form-control" name="jumlah_tagihan_detail" id="detail_jumlah_tagihan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-7">
              <label for="detail_jumlah_bayar">Pembayaran :</label>
              <input type="text" class="form-control" name="jumlah_bayar_detail" id="detail_jumlah_bayar" readonly="">
            </div>
            <div class="form-group col-5">
              <label for="detail_bayar">Status :</label>
              <input type="text" class="form-control" name="bayar_detail" id="detail_bayar" value="LUNAS" readonly="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Yakin Hapus?')">Hapus</button>
          <button type="" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.detail').click(function(){
    $('#detail_tagihanModal').modal();
    var id_pembayaran_detail = $(this).attr('data-id_pembayaran')
    var id_tagihan_siswa_detail = $(this).attr('data-id_tagihan_siswa')
    var id_siswa_detail = $(this).attr('data-id_siswa')
    var nis_detail = $(this).attr('data-nis')
    var nama_siswa_detail = $(this).attr('data-nama_siswa')
    var kelas_detail = $(this).attr('data-kelas')
    var jurusan_detail = $(this).attr('data-jurusan')

    var id_jenis_tagihan_detail = $(this).attr('data-id_jenis_tagihan')
    var id_jns_tghn_siswa_detail = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_detail = $(this).attr('data-jenis_tagihan')
    var jml_tagihan_detail = $(this).attr('data-jml_tagihan')
    var jumlah_tagihan_detail = $(this).attr('data-jumlah_tagihan')

    var jml_bayar_detail = $(this).attr('data-jml_bayar')
    var jumlah_bayar_detail = $(this).attr('data-jumlah_bayar')

    var jml_tunggakan_detail = $(this).attr('data-jml_tunggakan')
    var jumlah_tunggakan_detail = $(this).attr('data-jumlah_tunggakan')

    $('#detail_id_pembayaran').val(id_pembayaran_detail)
    $('#detail_id_tagihan_siswa').val(id_tagihan_siswa_detail)
    $('#detail_id_siswa').val(id_siswa_detail)
    $('#detail_nis').val(nis_detail)
    $('#detail_nama_siswa').val(nama_siswa_detail)
    $('#detail_kelas').val(kelas_detail)
    $('#detail_jurusan').val(jurusan_detail)

    $('#kelas_detail').val(kelas_detail)
    $('#jurusan_detail').val(jurusan_detail)

    $('#detail_id_jenis_tagihan').val(id_jenis_tagihan_detail)
    $('#detail_id_jns_tghn_siswa').val(id_jns_tghn_siswa_detail)
    $('#detail_jenis_tagihan').val(jenis_tagihan_detail)
    $('#detail_jml_tagihan').val(jml_tagihan_detail)
    $('#detail_jumlah_tagihan').val(jumlah_tagihan_detail)

    $('#detail_jml_bayar').val(jml_bayar_detail)
    $('#detail_jumlah_bayar').val(jumlah_bayar_detail)

    $('#detail_jml_tunggakan').val(jml_tunggakan_detail)
    $('#detail_jumlah_tunggakan').val(jumlah_tunggakan_detail)
  })
</script>


  <!-- MODAL UPDATE TAGIHAN -->
<div class="modal fade" id="update_tagihanModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">UPDATE TAGIHAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/tagihan/update.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_pembayaran_hapus" id="update_id_pembayaran">
          <input type="hidden" name="id_siswa_up" id="update_id_siswa">
          <input type="hidden" name="id_jenis_tagihan_up" id="update_id_jenis_tagihan">
          <input type="hidden" name="id_jns_tghn_siswa_up" id="update_id_jns_tghn_siswa">
          <input type="hidden" name="jml_tagihan_up" id="update_jml_tagihan">
          <input type="hidden" name="jml_bayar_up" id="update_jml_bayar">
          <input type="hidden" name="jml_tunggakan_up" id="update_jml_tunggakan">
          <div class="form-row">
            <div class="form-group col-4">
              <label for="update_nis">NIS :</label>
              <input type="text" class="form-control" name="nis_up" id="update_nis" readonly="">
            </div>
            <div class="form-group col-8">
              <label for="update_nama_siswa">Nama Siswa :</label>
              <input type="text" class="form-control" name="nama_siswa_up" id="update_nama_siswa" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="update_kelas">Kelas :</label>
              <input type="text" class="form-control" name="kelas_back" id="update_kelas" readonly="">
            </div>
            <div class="form-group col-8">
              <label for="update_jurusan">Jurusan :</label>
              <input type="text" class="form-control" name="jurusan_back" id="update_jurusan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-7">
              <label for="update_jenis_tagihan">Jenis Tagihan :</label>
              <input type="text" class="form-control" name="jenis_tagihan_up" id="update_jenis_tagihan" readonly="">
            </div>
            <div class="form-group col-5">
              <label for="update_jumlah_tagihan">Jumlah :</label>
              <input type="text" class="form-control" name="jumlah_tagihan_up" id="update_jumlah_tagihan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-7">
              <label for="update_jumlah_bayar">Pembayaran :</label>
              <input type="text" class="form-control" name="jumlah_bayar_up" id="update_jumlah_bayar" readonly="">
            </div>
            <div class="form-group col-5">
              <label for="update_jumlah_tunggakan">Tunggakan :</label>
              <input type="text" class="form-control" name="jumlah_tunggakan_up" id="update_jumlah_tunggakan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-7">
              <label for="update_bayar">Bayar :<font color="red">*</font></label>
              <input type="text" class="form-control" name="bayar_up" id="update_bayar">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Yakin Hapus?')">Hapus</button>
          <button type="submit" class="btn btn-sm btn-primary" name="update">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.update').click(function(){
    $('#update_tagihanModal').modal();
    var id_pembayaran_update = $(this).attr('data-id_pembayaran')
    var id_tagihan_siswa_update = $(this).attr('data-id_tagihan_siswa')
    var id_siswa_update = $(this).attr('data-id_siswa')
    var nis_update = $(this).attr('data-nis')
    var nama_siswa_update = $(this).attr('data-nama_siswa')
    var kelas_update = $(this).attr('data-kelas')
    var jurusan_update = $(this).attr('data-jurusan')

    var id_jenis_tagihan_update = $(this).attr('data-id_jenis_tagihan')
    var id_jns_tghn_siswa_update = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_update = $(this).attr('data-jenis_tagihan')
    var jml_tagihan_update = $(this).attr('data-jml_tagihan')
    var jumlah_tagihan_update = $(this).attr('data-jumlah_tagihan')

    var jml_bayar_update = $(this).attr('data-jml_bayar')
    var jumlah_bayar_update = $(this).attr('data-jumlah_bayar')

    var jml_tunggakan_update = $(this).attr('data-jml_tunggakan')
    var jumlah_tunggakan_update = $(this).attr('data-jumlah_tunggakan')

    $('#update_id_pembayaran').val(id_pembayaran_update)
    $('#update_id_tagihan_siswa').val(id_tagihan_siswa_update)
    $('#update_id_siswa').val(id_siswa_update)
    $('#update_nis').val(nis_update)
    $('#update_nama_siswa').val(nama_siswa_update)
    $('#update_kelas').val(kelas_update)
    $('#update_jurusan').val(jurusan_update)

    $('#kelas_update').val(kelas_update)
    $('#jurusan_update').val(jurusan_update)

    $('#update_id_jenis_tagihan').val(id_jenis_tagihan_update)
    $('#update_id_jns_tghn_siswa').val(id_jns_tghn_siswa_update)
    $('#update_jenis_tagihan').val(jenis_tagihan_update)
    $('#update_jml_tagihan').val(jml_tagihan_update)
    $('#update_jumlah_tagihan').val(jumlah_tagihan_update)

    $('#update_jml_bayar').val(jml_bayar_update)
    $('#update_jumlah_bayar').val(jumlah_bayar_update)

    $('#update_jml_tunggakan').val(jml_tunggakan_update)
    $('#update_jumlah_tunggakan').val(jumlah_tunggakan_update)
  })
</script>
<!-- format rupiah   -->
<script type="text/javascript"> 
    var update_bayar = document.getElementById('update_bayar');
    update_bayar.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatupdate_bayar() untuk mengubah angka yang di ketik menjadi format angka
      update_bayar.value = formatupdate_bayar(this.value);
    });

    /* Fungsi formatupdate_bayar */
    function formatupdate_bayar(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      update_bayar = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        update_bayar += separator + ribuan.join('.');
      }

      update_bayar = split[1] != undefined ? update_bayar + ',' + split[1] : update_bayar;
      return prefix == undefined ? update_bayar : (update_bayar ? update_bayar : '');
    }
  </script>


<!-- MODAL BAYAR TAGIHAN UMUM -->
<div class="modal fade" id="bayar_tagihanModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">BAYAR TAGIHAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/tagihan/bayar.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="kelas_back" id="bayar_kelas_back">
          <input type="hidden" name="jurusan_back" id="bayar_jurusan_back">

          <input type="hidden" name="id_siswa_plus" id="bayar_id_siswa">
          <input type="hidden" name="id_jenis_tagihan_plus" id="bayar_id_jenis_tagihan">
          <input type="hidden" name="id_jns_tghn_siswa_plus" id="bayar_id_jns_tghn_siswa">
          <input type="hidden" name="jml_tagihan_plus" id="bayar_jml_tagihan">
          <input type="hidden" name="jml_bayar_plus" id="bayar_jml_bayar">
          <input type="hidden" name="jml_tunggakan_plus" id="bayar_jml_tunggakan">
          <div class="form-row">
            <div class="form-group col-3">
              <label for="bayar_nis">NIS :</label>
              <input type="text" class="form-control" name="nis_plus" id="bayar_nis" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="bayar_nama_siswa">Nama Siswa :</label>
              <input type="text" class="form-control" name="nama_siswa_plus" id="bayar_nama_siswa" readonly="">
            </div>
            <div class="form-group col-2">
              <label for="bayar_kelas">Kelas :</label>
              <input type="text" class="form-control" name="kelas_plus" id="bayar_kelas" readonly="">
            </div>
            <div class="form-group col-3">
              <label for="bayar_jurusan">Jurusan :</label>
              <input type="text" class="form-control" name="jurusan_plus" id="bayar_jurusan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="bayar_jenis_tagihan">Jenis Tagihan :</label>
              <input type="text" class="form-control" name="jenis_tagihan_plus" id="bayar_jenis_tagihan" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="bayar_jumlah_tagihan">Jumlah :</label>
              <input type="text" class="form-control" name="jumlah_tagihan_plus" id="bayar_jumlah_tagihan" readonly="">
            </div>
             <div class="form-group col-4">
              <label for="add_bayar">Bayar :<font color="red">*</font></label>
              <input type="text" class="form-control" name="bayar_plus" id="add_bayar" required="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-primary" name="bayar">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.bayar').click(function(){
    $('#bayar_tagihan_Modal').modal();
    var id_siswa_bayar = $(this).attr('data-id_siswa')
    var nis_bayar = $(this).attr('data-nis')
    var nama_siswa_bayar = $(this).attr('data-nama_siswa')
    var kelas_bayar = $(this).attr('data-kelas')
    var jurusan_bayar = $(this).attr('data-jurusan')

    var id_jenis_tagihan_bayar = $(this).attr('data-id_jenis_tagihan')
    var id_jns_tghn_siswa_bayar = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_bayar = $(this).attr('data-jenis_tagihan')
    var jml_tagihan_bayar = $(this).attr('data-jml_tagihan')
    var jumlah_tagihan_bayar = $(this).attr('data-jumlah_tagihan')

    $('#bayar_id_siswa').val(id_siswa_bayar)
    $('#bayar_nis').val(nis_bayar)
    $('#bayar_nama_siswa').val(nama_siswa_bayar)
    $('#bayar_kelas').val(kelas_bayar)
    $('#bayar_jurusan').val(jurusan_bayar)

    $('#bayar_kelas_back').val(kelas_bayar)
    $('#bayar_jurusan_back').val(jurusan_bayar)

    $('#bayar_id_jenis_tagihan').val(id_jenis_tagihan_bayar)
    $('#bayar_id_jns_tghn_siswa').val(id_jns_tghn_siswa_bayar)
    $('#bayar_jenis_tagihan').val(jenis_tagihan_bayar)
    $('#bayar_jml_tagihan').val(jml_tagihan_bayar)
    $('#bayar_jumlah_tagihan').val(jumlah_tagihan_bayar)
  })
</script>
<!-- format rupiah   -->
<script type="text/javascript"> 
    var add_bayar = document.getElementById('add_bayar');
    add_bayar.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatadd_bayar() untuk mengubah angka yang di ketik menjadi format angka
      add_bayar.value = formatadd_bayar(this.value);
    });

    /* Fungsi formatadd_bayar */
    function formatadd_bayar(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      add_bayar = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        add_bayar += separator + ribuan.join('.');
      }

      add_bayar = split[1] != undefined ? add_bayar + ',' + split[1] : add_bayar;
      return prefix == undefined ? add_bayar : (add_bayar ? add_bayar : '');
    }
  </script>

<!-- MODAL TAMBAH TAGIHAN SISWA -->
<div class="modal fade" id="tambah_siswaModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">TAMBAH TAGIHAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/tagihan/add_tagihan_siswa.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="kelas_back" id="kelas_4">
          <input type="hidden" name="jurusan_back" id="jurusan_4">
          <input type="hidden" name="siswa_id" id="4_id_siswa">
          <input type="hidden" name="id_jns_tghn_siswa_plus4" id="4_id_jenis_tagihan">
          <div class="form-row">
            <div class="form-group col-3">
              <label for="4_nis">NIS :</label>
              <input type="text" class="form-control" name="nis_plus4" id="4_nis" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="4_nama_siswa">Nama Siswa :</label>
              <input type="text" class="form-control" name="nama_siswa_plus4" id="4_nama_siswa" readonly="">
            </div>
            <div class="form-group col-2">
              <label for="4_kelas">Kelas :</label>
              <input type="text" class="form-control" name="kelas_plus4" id="4_kelas" readonly="">
            </div>
            <div class="form-group col-3">
              <label for="4_jurusan">Jurusan :</label>
              <input type="text" class="form-control" name="jurusan_plus4" id="4_jurusan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="4_jenis_tagihan">Jenis Tagihan :</label>
              <input type="text" class="form-control" name="jenis_tagihan_siswa_plus4" id="4_jenis_tagihan" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="rupiah_tmbh">Jumlah :</label>
              <input type="text" class="form-control" name="jumlah_plus4" id="rupiah_tmbh" required="">
            </div>
            <div class="form-group col-3">
            <label for="status_plus">Status :<font color="red">*</font> </label>
            <select class="form-control" name="status_plus4" id="status_plus" required="">
              <option value="">Pilih Status</option>
              <option value="Lunas">LUNAS</option>
              <option value="Proses">BELUM LUNAS</option>
            </select>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-primary" name="tambah_tagihan_siswa">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.tambah_siswa').click(function(){
    $('#tambah_siswaModal').modal();
    var id_siswa_4 = $(this).attr('data-id_siswa')
    var nis_4 = $(this).attr('data-nis')
    var nama_siswa_4 = $(this).attr('data-nama_siswa')
    var kelas_4 = $(this).attr('data-kelas')
    var jurusan_4 = $(this).attr('data-jurusan')

    var id_jenis_tagihan_4 = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_4 = $(this).attr('data-jenis_tagihan')

    $('#4_id_siswa').val(id_siswa_4)
    $('#4_nis').val(nis_4)
    $('#4_nama_siswa').val(nama_siswa_4)
    $('#4_kelas').val(kelas_4)
    $('#4_jurusan').val(jurusan_4)

    $('#kelas_4').val(kelas_4)
    $('#jurusan_4').val(jurusan_4)

    $('#4_id_jenis_tagihan').val(id_jenis_tagihan_4)
    $('#4_jenis_tagihan').val(jenis_tagihan_4)
  })
</script>
<!-- format rupiah   -->
<script type="text/javascript"> 
    var rupiah_tmbh = document.getElementById('rupiah_tmbh');
    rupiah_tmbh.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatrupiah_tmbh() untuk mengubah angka yang di ketik menjadi format angka
      rupiah_tmbh.value = formatrupiah_tmbh(this.value);
    });

    /* Fungsi formatrupiah_tmbh */
    function formatrupiah_tmbh(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah_tmbh = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah_tmbh += separator + ribuan.join('.');
      }

      rupiah_tmbh = split[1] != undefined ? rupiah_tmbh + ',' + split[1] : rupiah_tmbh;
      return prefix == undefined ? rupiah_tmbh : (rupiah_tmbh ? rupiah_tmbh : '');
    }
  </script>


<!-- MODAL BAYAR TAGIHAN SISWA -->
<div class="modal fade" id="bayar_tagihan_siswaModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">BAYAR TAGIHAN SISWA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/tagihan/bayar.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="kelas_back" id="bayar_siswa_kelas_back">
          <input type="hidden" name="jurusan_back" id="bayar_siswa_jurusan_back">
          <input type="hidden" name="id_tagihan_siswa_hapus" id="bayar_siswa_id_tagihan_siswa">

          <input type="hidden" name="id_siswa_plus" id="bayar_siswa_id_siswa">
          <input type="hidden" name="id_jenis_tagihan_plus" id="bayar_siswa_id_jenis_tagihan">
          <input type="hidden" name="id_jns_tghn_siswa_plus" id="bayar_siswa_id_jns_tghn_siswa">
          <input type="hidden" name="jml_tagihan_plus" id="bayar_siswa_jml_tagihan">
          <input type="hidden" name="jml_bayar_plus" id="bayar_siswa_jml_bayar">
          <input type="hidden" name="jml_tunggakan_plus" id="bayar_siswa_jml_tunggakan">
          <div class="form-row">
            <div class="form-group col-3">
              <label for="bayar_siswa_nis">NIS :</label>
              <input type="text" class="form-control" name="nis_plus" id="bayar_siswa_nis" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="bayar_siswa_nama_siswa">Nama Siswa :</label>
              <input type="text" class="form-control" name="nama_siswa_plus" id="bayar_siswa_nama_siswa" readonly="">
            </div>
            <div class="form-group col-2">
              <label for="bayar_siswa_kelas">Kelas :</label>
              <input type="text" class="form-control" name="kelas_plus" id="bayar_siswa_kelas" readonly="">
            </div>
            <div class="form-group col-3">
              <label for="bayar_siswa_jurusan">Jurusan :</label>
              <input type="text" class="form-control" name="jurusan_plus" id="bayar_siswa_jurusan" readonly="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="bayar_siswa_jenis_tagihan">Jenis Tagihan :</label>
              <input type="text" class="form-control" name="jenis_tagihan_plus" id="bayar_siswa_jenis_tagihan" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="bayar_jumlah_tagihan">Jumlah :</label>
              <input type="text" class="form-control" name="jumlah_tagihan_plus" id="bayar_siswa_jumlah_tagihan" readonly="">
            </div>
             <div class="form-group col-4">
              <label for="bayar_siswa_bayar">Bayar :<font color="red">*</font></label>
              <input type="text" class="form-control" name="bayar_plus" id="bayar_siswa_bayar">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Yakin Hapus?')">Hapus</button>
          <button type="submit" class="btn btn-sm btn-primary" name="bayar">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.bayar').click(function(){
    $('#bayar_tagihan_Modal').modal();
    var id_siswa_bayar = $(this).attr('data-id_siswa')
    var nis_bayar = $(this).attr('data-nis')
    var nama_siswa_bayar = $(this).attr('data-nama_siswa')
    var kelas_bayar = $(this).attr('data-kelas')
    var jurusan_bayar = $(this).attr('data-jurusan')
    var id_tagihan_siswa_bayar = $(this).attr('data-id_tagihan_siswa')

    var id_jenis_tagihan_bayar = $(this).attr('data-id_jenis_tagihan')
    var id_jns_tghn_siswa_bayar = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_bayar = $(this).attr('data-jenis_tagihan')
    var jml_tagihan_bayar = $(this).attr('data-jml_tagihan')
    var jumlah_tagihan_bayar = $(this).attr('data-jumlah_tagihan')

    $('#bayar_siswa_id_siswa').val(id_siswa_bayar)
    $('#bayar_siswa_nis').val(nis_bayar)
    $('#bayar_siswa_nama_siswa').val(nama_siswa_bayar)
    $('#bayar_siswa_kelas').val(kelas_bayar)
    $('#bayar_siswa_jurusan').val(jurusan_bayar)

    $('#bayar_siswa_kelas_back').val(kelas_bayar)
    $('#bayar_siswa_jurusan_back').val(jurusan_bayar)
    $('#bayar_siswa_id_tagihan_siswa').val(id_tagihan_siswa_bayar)

    $('#bayar_siswa_id_jenis_tagihan').val(id_jenis_tagihan_bayar)
    $('#bayar_siswa_id_jns_tghn_siswa').val(id_jns_tghn_siswa_bayar)
    $('#bayar_siswa_jenis_tagihan').val(jenis_tagihan_bayar)
    $('#bayar_siswa_jml_tagihan').val(jml_tagihan_bayar)
    $('#bayar_siswa_jumlah_tagihan').val(jumlah_tagihan_bayar)
  })
</script>
<!-- format rupiah   -->
<script type="text/javascript"> 
    var bayar_bayar = document.getElementById('bayar_siswa_bayar');
    bayar_bayar.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatbayar_bayar() untuk mengubah angka yang di ketik menjadi format angka
      bayar_bayar.value = formatbayar_bayar(this.value);
    });

    /* Fungsi formatbayar_bayar */
    function formatbayar_bayar(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      bayar_bayar = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        bayar_bayar += separator + ribuan.join('.');
      }

      bayar_bayar = split[1] != undefined ? bayar_bayar + ',' + split[1] : bayar_bayar;
      return prefix == undefined ? bayar_bayar : (bayar_bayar ? bayar_bayar : '');
    }
  </script>