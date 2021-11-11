<?php 
session_start();
 ?>
<h1 class="h5 mb-4 text-gray-800">LAPORAN KEKURANGAN PEMBAYARAN</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <form method='post' class='d-sm-inline-block form-inline' action="">
        <select class="form-control" name="kelas" id="kelas">
          <option value="">Pilih Kelas</option>
          <?php
            $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
            while ($data = mysqli_fetch_assoc($query)) {
              $kelas = $data['kelas'];
            ?>
            <option value="<?= $kelas;?>"><?= $kelas;?></option>
          <?php } ?>
        </select>
        <select class="form-control" name="jurusan" id="jurusan">
          <option value="">Pilih Jurusan</option>
          <?php
            $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
            while ($data = mysqli_fetch_assoc($query)) {
              $jurusan = $data['jurusan'];
            ?>
            <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
          <?php } ?>
        </select>
        <button class="btn btn-primary" type="submit" name="search"><i class="fas fa-search fa-sm"></i></button>
    </form>
  </div>

  <!-- ////////////////////////////////////////////HOME/////////////////////////////// -->
<?php 
if (!isset($_POST['search'])) { ?>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
            <th class="text-center">NAMA SISWA</th>
            <th class="text-center">JENIS TAGIHAN</th>
            <th class="text-center">KEKURANGAN</th>
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


<!-- ////////////////////////////////////////////POST search/////////////////////////////// -->
<?php 
if (isset($_POST['search'])) {
  $kelas_post = $_POST['kelas'];
  $jurusan_post = $_POST['jurusan'];
  $kls_semua = "SEMUA";
  $jrsn_semua = "SEMUA";
?>

  <?php
    if ($kelas_post !== "") {
     if ($jurusan_post !== "") {
     $no =1;
   ?>
   <div class="card-header py-3">
        <table>
          <tr>
            <td><b>Kelas</b></td>
            <td><b>: <?= $kelas_post; ?></b></td>
          </tr>
          <tr>
            <td><b>Jurusan</b></td>
            <td><b>: <?= $jurusan_post; ?></b></td>
          </tr>
          <tr>
            <td><form method='post' class='d-sm-inline-block form-inline' action="index.php?page=tunggakan_preview">
                  <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
                  <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
                  <button class="btn btn-sm btn-primary" type="submit" name="preview"><i class="fas fa-print"></i> Print
                  </button>
                </form>
            </td>
            <td><form method='post' class='d-sm-inline-block form-inline' action="page/laporan/excel_tunggakan.php">
                  <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
                  <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
                  <button class="btn btn-sm btn-success" type="submit" name="excel"><i class="fas fa-download"></i> Excel</button>
                </form>
            </td>
          </tr>
        </table>
      </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
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

            <!-- <th class="text-center">BAYAR</th> -->
            <th class="text-center">JUMLAH</th>
            <!-- <th class="text-center">JUMLAH</th> -->
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
            <td class="text-center"><?=$no++;?></td>
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
                    $status1 = "";
                              }
                  if($status_byr1 == "Proses"){
                    if ($jml_byr1 < $jml_tghn1) {
                      $status1 = "$jumlah_tunggakan1";
                                }
                    if ($jml_byr1 > $jml_tghn1) {
                      $status1 = "$jumlah_tunggakan1";
                                }
                            }
                      }
                }
                if ($id_siswa !== $id_siswa_byr1) {
                  if ($id_jns_tghn1 !== $id_jns_tghn_byr1) {
                    $status1 = "$jumlah_tagihan1";
                    }
                }
                if ($id_siswa !== $id_siswa_byr1) {
                  if ($id_jns_tghn1 == $id_jns_tghn_byr1) {
                    $status1 = "$jumlah_tagihan1";
                    }
                }
                if ($id_siswa == $id_siswa_byr1) {
                  if ($id_jns_tghn1 !== $id_jns_tghn_byr1) {
                    $status1 = "$jumlah_tagihan1";
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
                    $status2 = "";
                              }
                  if($status_byr2 == "Proses"){
                    if ($jml_byr2 < $jml_tghn2) {
                      $status2 = "$jumlah_tunggakan2";
                                }
                    if ($jml_byr2 > $jml_tghn2) {
                      $status2 = "$jumlah_tunggakan2";
                                }
                              }
                      }
                }
                if ($id_siswa !== $id_siswa_byr2) {
                  if ($id_jns_tghn2 !== $id_jns_tghn_byr2) {
                    $status2 = "$jumlah_tagihan2";
                    }
                }
                if ($id_siswa !== $id_siswa_byr2) {
                  if ($id_jns_tghn2 == $id_jns_tghn_byr2) {
                    $status2 = "$jumlah_tagihan2";
                    }
                }
                if ($id_siswa == $id_siswa_byr2) {
                  if ($id_jns_tghn2 !== $id_jns_tghn_byr2) {
                    $status2 = "$jumlah_tagihan2";
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
                    $status3 = "";
                              }
                  if($status_byr3 == "Proses"){
                    if ($jml_byr3 < $jml_tghn3) {
                      $status3 = "$jumlah_tunggakan3";
                                }
                    if ($jml_byr3 > $jml_tghn3) {
                      $status3 = "$jumlah_tunggakan3";
                                }
                              }
                      }
                }
                if ($id_siswa !== $id_siswa_byr3) {
                  if ($id_jns_tghn3 !== $id_jns_tghn_byr3) {
                    $status3 = "$jumlah_tagihan3";
                    }
                }
                if ($id_siswa !== $id_siswa_byr3) {
                  if ($id_jns_tghn3 == $id_jns_tghn_byr3) {
                    $status3 = "$jumlah_tagihan3";
                    }
                }
                if ($id_siswa == $id_siswa_byr3) {
                  if ($id_jns_tghn3 !== $id_jns_tghn_byr3) {
                    $status3 = "$jumlah_tagihan3";
                    }
                }
            ?>
            <td class="text-center"><?=$status3;?></td>
            <?php } ?>  <!-- end tagihan semua -->
<!-- ------------------------------END 3------------------------------------------------------>

<!-- tagihan/siswa tagihan 4 -->
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
                    $status4 = "";
                    }
                } 
                if ($id_jns_tghn_siswa4 !== $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    $status4 = "";
                    }
                } 
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa !== $id_siswa_tghn4) {
                    $status4 = "";
                    }
                } 


                // jika ada data tagihan tapi belum bayar
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    $status4 = "$jumlah_tagihan4";
                    }
                } 
                // data pembayaran
                if ($id_jns_tghn_siswa4 == $id_jns_tghn4) {
                  if ($id_siswa == $id_siswa_tghn4) {
                    if ($id_siswa_tghn4 == $id_siswa_byr4) {
                      if ($id_jns_tghn4 == $id_jns_tghn_byr4) {
                        if ($status_byr4 == "Lunas") {
                              $status4 = "";
                                        }
                        if ($status_byr4 == "Proses") {
                          if ($jml_byr4 < $jml_tghn4) {
                              $status4 = "$jumlah_tunggakan4";
                                        }
                            if ($jml_byr4 > $jml_tghn4) {
                              $status4 = "$jumlah_tunggakan4";
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
            <!-- <td class="text-center"><b><?= $jumlah_bayar; ?></b></td> -->
            <td class="text-center"><b><?= $jumlah_tunggakan; ?></b></td>
            <!-- <td class="text-center"><b><?= $jumlah_tagihan; ?></b></td>  -->
            <td>
              <form method='post' action='index.php?page=rincian_tunggakan'>
                <input type='hidden' name='id_siswa' value='<?=$id_siswa?>'>
                <button class='btn btn-sm btn-primary' type='submit' name='rincian' title='Lihat Rincian'> <i class="fas fa-eye"></i></button>
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
            <!-- <td class="text-center"><b><?= $total_bayar; ?></td> -->
            <td class="text-center"><b><?= $total_tunggakan; ?></b></td>
            <!-- <td class="text-center"><b><?= $total_tagihan; ?></b></td> -->
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