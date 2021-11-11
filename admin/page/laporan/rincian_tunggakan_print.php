<?php 
include "../../asset/inc/config.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$query = mysqli_query($koneksi,"SELECT * FROM tb_info");
    while ($data = mysqli_fetch_assoc($query)) {
      $nama = $data['nama'];
      $alamat = $data['alamat'];
      $kode_pos = $data['kode_pos'];
      $telp = $data['telp'];
      $icon = $data['icon'];
      $logo = $data['logo'];
    }
  if (isset($_POST['print'])) {
  $id_siswa = $_POST['id_siswa'];
  $nama_siswa = $_POST['nama_siswa'];
  $kelas = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];
?>
<link rel="shortcut icon" href="../../asset/img/<?= $icon ?>" type="image/x-icon">
<!DOCTYPE html>
<html>
<head>
    <title>DATA KEKURANGAN</title>
    <style type="text/css">
        table {
            border-style: double;
            border-width: 3px;
            border-color: white;
        }
        table tr .text2 {
            text-align: right;
            font-size: 13px;
        }
        table tr .text {
            text-align: center;
            font-size: 13px;
        }
        table tr td {
            font-size: 13px;
        }

.border {
    border-collapse: collapse;
    border: 1px solid black;
}
#halaman{
    width: 640;
    border: 1px solid; 
    padding-top: 10px; 
    padding-left: 20px; 
    padding-right: 20px; 
    padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <center>
      <div id=halaman>
        <table width="625">
            <tr>
                <td width="80"><img src="../../asset/img/logo.jpg" width="80" height="80"></td>
                <td>
                <center>
                    <font size="4"><b><?= $nama ?></b></font><br>
                    <font size="2">Bidang Keahlian : Multimedia - Teknik Kendaraan Ringan Otomotif</font><br>
                    <font size="2"><?= $alamat?> <?= $kode_pos ?></font>
                    <font size="2">Telp : <?= $telp ?><br> <font color="blue">https://www.smkmu.sch.id/</font></font>
                </center>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
        </table>
    <h4>DATA KEKURANGAN PEMBAYARAN</h3>
    <table>
      <tr>
        <td><b>NAMA SISWA</b></td>
        <td width="520"><b>: <?= $nama_siswa; ?></b></td>
      </tr>
      <tr>
        <td><b>KELAS</b></td>
        <td width="520"><b>: <?= $kelas; ?></b></td>
      </tr>
      <tr>
        <td><b>JURUSAN</b></td>
        <td width="520"><b>: <?= $jurusan; ?></b></td>
      </tr>
    </table>

      <table class="border" width="625">
        <thead>
          <tr bgcolor="#e6e4df">
            <th class="border">NO</th>
            <th class="border">JENIS TAGIHAN</th>
            <th class="border">KEKURANGAN</th>
          </tr>
        </thead>
        <tbody>
        <!-- ================================================1=================================================== -->
          <?php
            $no=1;
            $query1 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='SEMUA' AND jurusan='SEMUA' ORDER BY id_jenis_tagihan ASC";
            $result1 = mysqli_query($koneksi,$query1);
            while ($data = mysqli_fetch_assoc($result1)) {
              $id_jenis_tagihan1 = $data['id_jenis_tagihan'];
              $jenis_tagihan1 = $data['jenis_tagihan'];
              $jml_tagihan1 = $data['jumlah'];
              $jumlah_tagihan1 = number_format($jml_tagihan1,0,",",".");

            $query_byr1 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan1' AND id_siswa='$id_siswa'";
            $result_byr1 = mysqli_query($koneksi,$query_byr1);
            while ($data = mysqli_fetch_assoc($result_byr1)) {
              $id_siswa_byr1 = $data['id_siswa']; 
              $id_jenis_tagihan_byr1 = $data['id_jenis_tagihan']; 
              $jumlah_byr1 = $data['jumlah'];
              $status_byr1 = $data['status'];
            }
            $tunggakan1 = $jml_tagihan1 - $jumlah_byr1;

                  if ($id_jenis_tagihan1 == $id_jenis_tagihan_byr1) {
                    $jumlah_bayar1 = number_format($jumlah_byr1,0,",",".");
                    if ($tunggakan1 != 0) {
                      $jumlah_tunggakan1 = number_format($tunggakan1,0,",",".") ;
                    }if ($tunggakan1 == 0) {
                      $jumlah_tunggakan1 = "";
                    }
                    if ($status_byr1=="Proses") {
                      $status1 = "BELUM LUNAS";
                    }if ($status_byr1=="Lunas") {
                      $status1 = "LUNAS";
                    }
                  }
                  if ($id_jenis_tagihan1 != $id_jenis_tagihan_byr1) {
                    $jumlah_bayar1 = "";
                    $jumlah_tunggakan1 = $jumlah_tagihan1;
                    $status1 =  "BELUM BAYAR";
                  }
          ?>
          <tr>
            <td class="border" align="center"><?=$no++;?></td>
            <td class="border"><?= $jenis_tagihan1;?></td>
            <td class="border"><?= $jumlah_tunggakan1; ?></td>
          </tr>
          <?php } ?>

<!-- ================================================2=================================================== -->

          <?php
            $query2 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='SEMUA' ORDER BY id_jenis_tagihan ASC";
            $result2 = mysqli_query($koneksi,$query2);
            while ($data = mysqli_fetch_assoc($result2)) {
              $id_jenis_tagihan2 = $data['id_jenis_tagihan'];
              $jenis_tagihan2 = $data['jenis_tagihan'];
              $jml_tagihan2 = $data['jumlah'];
              $jumlah_tagihan2 = number_format($jml_tagihan2,0,",",".");

            $query_byr2 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan2' AND id_siswa='$id_siswa'";
            $result_byr2 = mysqli_query($koneksi,$query_byr2);
            while ($data = mysqli_fetch_assoc($result_byr2)) {
              $id_siswa_byr2 = $data['id_siswa']; 
              $id_jenis_tagihan_byr2 = $data['id_jenis_tagihan']; 
              $jumlah_byr2 = $data['jumlah'];
              $status_byr2 = $data['status'];
            }
            $tunggakan2 = $jml_tagihan2 - $jumlah_byr2;

                  if ($id_jenis_tagihan2 == $id_jenis_tagihan_byr2) {
                    $jumlah_bayar2 = number_format($jumlah_byr2,0,",",".");
                    if ($tunggakan2 != 0) {
                      $jumlah_tunggakan2 = number_format($tunggakan2,0,",",".") ;
                    }if ($tunggakan2 == 0) {
                      $jumlah_tunggakan2 = "";
                    }
                    if ($status_byr2=="Proses") {
                      $status2 = "BELUM LUNAS";
                    }if ($status_byr2=="Lunas") {
                      $status2 = "LUNAS";
                    }
                  }
                  if ($id_jenis_tagihan2 != $id_jenis_tagihan_byr2) {
                    $jumlah_bayar2 = "";
                    $jumlah_tunggakan2 = $jumlah_tagihan2;
                    $status2 =  "BELUM BAYAR";
                  }
          ?>
          <tr>
            <td class="border" align="center"><?=$no++;?></td>
            <td class="border"><?= $jenis_tagihan2;?></td>
            <td class="border"><?= $jumlah_tunggakan2; ?></td>
          </tr>
          <?php } ?>

<!-- ================================================3=================================================== -->

          <?php
            $query3 = "SELECT * FROM tb_jenis_tagihan WHERE kelas='$kelas' AND jurusan='$jurusan' ORDER BY id_jenis_tagihan ASC";
            $result3 = mysqli_query($koneksi,$query3);
            while ($data = mysqli_fetch_assoc($result3)) {
              $id_jenis_tagihan3 = $data['id_jenis_tagihan'];
              $jenis_tagihan3 = $data['jenis_tagihan'];
              $jml_tagihan3 = $data['jumlah'];
              $jumlah_tagihan3 = number_format($jml_tagihan3,0,",",".");

            $query_byr3 = "SELECT * FROM tb_pembayaran WHERE id_jenis_tagihan='$id_jenis_tagihan3' AND id_siswa='$id_siswa'";
            $result_byr3 = mysqli_query($koneksi,$query_byr3);
            while ($data = mysqli_fetch_assoc($result_byr3)) {
              $id_siswa_byr3 = $data['id_siswa']; 
              $id_jenis_tagihan_byr3 = $data['id_jenis_tagihan']; 
              $jumlah_byr3 = $data['jumlah'];
              $status_byr3 = $data['status'];
            }
            $tunggakan3 = $jml_tagihan3 - $jumlah_byr3;

                  if ($id_jenis_tagihan3 == $id_jenis_tagihan_byr3) {
                    $jumlah_bayar3 = number_format($jumlah_byr3,0,",",".");
                    if ($tunggakan3 != 0) {
                      $jumlah_tunggakan3 = number_format($tunggakan3,0,",",".") ;
                    }if ($tunggakan3 == 0) {
                      $jumlah_tunggakan3 = "";
                    }
                    if ($status_byr3=="Proses") {
                      $status3 = "BELUM LUNAS";
                    }if ($status_byr3=="Lunas") {
                      $status3 = "LUNAS";
                    }
                  }
                  if ($id_jenis_tagihan3 != $id_jenis_tagihan_byr3) {
                    $jumlah_bayar3 = "";
                    $jumlah_tunggakan3 = $jumlah_tagihan3;
                    $status3 =  "BELUM BAYAR";
                  }
          ?>
          <tr>
            <td class="border" align="center"><?=$no++;?></td>
            <td class="border"><?= $jenis_tagihan3;?></td>
            <td class="border"><?= $jumlah_tunggakan3; ?></td>
          </tr>
          <?php } ?>

<!-- ================================================4=================================================== -->
<?php 
$id_siswatghn = "SELECT * FROM tb_tagihan_siswa WHERE id_siswa='$id_siswa'";
$result_4 = mysqli_query($koneksi,$id_siswatghn);
  while ($id4 = mysqli_fetch_assoc($result_4)) {
  $idsiswa4 = $id4['id_siswa'];
}
if ($idsiswa4 == NULL) {

}
if ($idsiswa4 !== NULL) {
 ?>
          <?php
              // ambil tagihan siswa 4
             
              $ambil_tghn = "SELECT * FROM tb_tagihan_siswa INNER JOIN tb_jenis_tagihan_siswa ON tb_jenis_tagihan_siswa.id_jns_tghn_siswa=tb_tagihan_siswa.id_jns_tghn_siswa AND tb_tagihan_siswa.id_siswa='$id_siswa'";
              $resultambil = mysqli_query($koneksi,$ambil_tghn);
              while ($tghn4 = mysqli_fetch_assoc($resultambil)) {
                $jenis_tagihan4 = $tghn4['jenis_tagihan_siswa'];
                $id_tagihan_siswa4 = $tghn4['id_tagihan_siswa'];
                $id_siswa_tghn4 = $tghn4['id_siswa'];
                $id_jns_tghn4 = $tghn4['id_jns_tghn_siswa'];
                $jml_tghn4 = $tghn4['jumlah'];
                $jumlah_tagihan4 = number_format($jml_tghn4,0,",",".");

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
              
              $jml_tgkn4 = $jml_tghn4 - $jml_byr4;
              $jumlah_tunggakan4 = number_format($jml_tgkn4,0,",",".");

              if ($jumlah_tunggakan4 != 0) {
                 $jumlah_tunggakan4 = $jumlah_tunggakan4;
                }
              if ($jumlah_tunggakan4 == 0) {
                $jumlah_tunggakan4 = "";
              }
              if ($status_byr4=="Proses") {
                $status_byr4 = "BELUM LUNAS";
               }
              if ($status_byr4=="Lunas") {
                $status_byr4 = "LUNAS";
              }

                if ($id_siswa_tghn4 == $id_siswa_byr4) {
                  if ($id_jns_tghn4 == $id_jns_tghn_byr4) {
                 $bayar4 = $jumlah_bayar4;
                 $tunggakan4 = $jumlah_tunggakan4;
                 $status4 = $status_byr4;
                  }
                }
                if ($id_siswa_tghn4 == $id_siswa_byr4) {
                    if ($id_jns_tghn4 !== $id_jns_tghn_byr4) {
                   $bayar4 = "";
                   $tunggakan4 = $jumlah_tagihan4;
                   $status4 = "BELUM BAYAR";
                  }
                }
                if ($id_siswa_tghn4 !== $id_siswa_byr4) {
                    if ($id_jns_tghn4 !== $id_jns_tghn_byr4) {
                   $bayar4 = "";
                   $tunggakan4 = $jumlah_tagihan4;
                   $status4 = "BELUM BAYAR";
                  }
                }
          ?>
          <tr>
            <td class="border" align="center"><?=$no++;?></td>
            <td class="border"><?=$jenis_tagihan4;?></td>
            <td class="border"><?= $tunggakan4;?></td>
          </tr><?php } ?>
          <?php  } ?>
        </tbody>
                                <!-- FOOTER -->

        <tfoot>
          <?php 

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
                 $jumlah_bayar = number_format($jml_bayar,0,",",".");
               }
            }

            $foot_tunggakan = $jumlah_tagihan - $jml_bayar;
            if ($foot_tunggakan == 0) {
               $jumlah_tunggakan = "";
               }
               if ($foot_tunggakan != 0) {
                 $jumlah_tunggakan = number_format($foot_tunggakan,0,",",".");
               }
          ?>
          <tr>
            <td class="border" colspan="2" align="center"><b>TOTAL</b></td>
            <td class="border"><b><?=$jumlah_tunggakan;?></b></td>
          </tr>
        </tfoot>
      </table>
      <br>
       <table width="625">
           <tr>
               <td>
                <?php 
                date_default_timezone_set('Asia/Jakarta');
                $tanggal = date('d/m/Y h:i');
               ?>
                Cetak : <?= $tanggal; ?>
               </td>
           </tr>
       </table>
      </div>
    </center>
</body>
</html>
<script type="text/javascript">
  window.print();
</script>
<?php } ?>