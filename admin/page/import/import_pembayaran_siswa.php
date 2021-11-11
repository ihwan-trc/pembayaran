<?php 
  session_start();
?>
<h1 class="h5 mb-4 text-gray-800">IMPORT DATA PEMBAYARAN</h1>
<div class="card shadow mb-4">
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="index.php?page=import_pembayaran_umum">PEMBAYARAN TAGIHAN <font color="red">(UMUM)</font></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="siswa-tab" data-toggle="tab" href="#siswa"  role="tab" aria-controls="siswa" aria-selected="true"><b>PEMBAYARAN TAGIHAN <font color="red">(SISWA)</font></b></a>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">
<!-- ========================================pembayaran=================================================== -->
      <div class="tab-pane fade show active" id="siswa" role="tabpanel" aria-labelledby="siswa-tab">
        <div class="py-3">
          <form method='post' class='d-sm-inline-block form-inline' action="">
              <select class="form-control" name="kelas" id="kelas" required="">
                <option value="">Kelas</option>
                <?php
                  $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
                  while ($data = mysqli_fetch_assoc($query)) {
                    $kelas = $data['kelas'];
                  ?>
                  <option value="<?= $kelas;?>"><?= $kelas;?></option>
                <?php } ?>
              </select>
              <select class="form-control" name="jurusan" id="jurusan" required="">
                <option value="">Jurusan</option>
                <?php
                  $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
                  while ($data = mysqli_fetch_assoc($query)) {
                    $jurusan = $data['jurusan'];
                  ?>
                  <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
                <?php } ?>
              </select>
              <select class="form-control" name="id_jns_tghn_siswa" id="id_jns_tghn_siswa" required="">
                <option value="">Jenis Tagihan</option>
                <?php
                  $query = mysqli_query($koneksi, "SELECT * FROM tb_jenis_tagihan_siswa ORDER BY id_jns_tghn_siswa ASC");
                  while ($data = mysqli_fetch_assoc($query)) {
                    $id_jns_tghn_siswa = $data['id_jns_tghn_siswa'];
                    $jenis_tagihan_siswa = $data['jenis_tagihan_siswa'];
                  ?>
                  <option value="<?= $id_jns_tghn_siswa;?>"><?= $jenis_tagihan_siswa;?></option>
                <?php } ?>
              </select>
              <button class="btn btn-primary" type="submit" name="cari"><i class="fas fa-search fa-sm"></i></button>
          </form>
        </div>
        <?php 
          if (isset($_POST['back_proses'])) {
            $jns_tghn_form = $_POST['jns_tghn_form'];
            $kelas_form = $_POST['kelas_form'];
            $jurusan_form = $_POST['jurusan_form'];

            echo "<div class='alert alert-success'>
                    <form action='index.php?page=tagihan' method='post'>
                      <input type='hidden' name='kelas_back' value='$kelas_form'>
                      <input type='hidden' name='jurusan_back' value='$jurusan_form'>
                      <button class='btn btn-sm btn-success' type='submit' name='back'>Lihat Pembayaran</button>
                    </form>
                    
                    <font color='green'> Import Pembayaran $jns_tghn_form $kelas_form $jurusan_form Berhasil...!   </font>
                </div>";
          }
        ?>
        

        <?php 
        include "../../asset/inc/config.php";
          if (isset($_POST['cari'])) {
            $kelas_post = $_POST['kelas'];
            $jurusan_post = $_POST['jurusan'];
            $id_jns_tghn_siswa_post = $_POST['id_jns_tghn_siswa'];

            $query = "SELECT * FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jns_tghn_siswa_post'";
            $result = mysqli_query($koneksi,$query);
            while ($data = mysqli_fetch_assoc($result)) {
             $jenis_tagihan_siswa_post= $data['jenis_tagihan_siswa'];
            }
            ?>
 <?php 
            if ($jenis_tagihan_siswa_post !== NULL) {?>
                  <form action="page/import/format.php" method="post">
                    <input type="hidden" name="kelas" value="<?=$kelas_post;?>">
                    <input type="hidden" name="jurusan" value="<?=$jurusan_post;?>">
                    <input type="hidden" name="id_jenis_tagihan" value="<?=$id_jns_tghn_siswa_post;?>">
                    <button class="btn btn-sm btn-success" type="submit" name="format_siswa"><i class="fas fa-download"></i> FORMAT : <?= $jenis_tagihan_siswa_post ?> <?= $kelas_post ?> <?= $jurusan_post ?></button>
                  </form>
                    <font color="red"><small>*Isi data pembayaran sesuai format!</small></font><br>
                <div class="py-3">
                  <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="kelas_preview" value="<?=$kelas_post;?>">
                    <input type="hidden" name="jurusan_preview" value="<?=$jurusan_post;?>">
                    <input type="hidden" name="id_jenis_tagihan_siswa_preview" value="<?=$id_jns_tghn_siswa_post;?>">
                    <div class="form-row">
                      <div class="form-group col-5">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="dt-import_pembayaran1" name="file" required="" onchange="return validasiFile()"/>
                          <label class="custom-file-label" for="customFile">Masukkan file Excel 2007 (*.xlsx)</label>
                        </div>
                      </div>
                      <div>
                        <button type="submit" class="btn  btn-info" name="preview_pembayaran"><i class="fas fa-eye"></i> Preview</button>
                      </div>
                    </div>
                  </form>
                </div>
      <?php   }  ?>            
<?php
    }
?>   
        <div class="table-responsive">
    <!-- Buat Preview Data -->
          <?php
          // Load file autoload.php
          require 'asset/lib/PHPOffice/vendor/autoload.php';

          // Include librari PhpSpreadsheet
          use PhpOffice\PhpSpreadsheet\Spreadsheet;
          use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
          // Jika user telah mengklik tombol Preview
          if(isset($_POST['preview_pembayaran'])){
            $kelas_preview = $_POST['kelas_preview'];
            $jurusan_preview = $_POST['jurusan_preview'];
            $id_jtagihan_siswa_preview = $_POST['id_jenis_tagihan_siswa_preview'];
            // var_dump($_POST['id_jenis_tagihan_siswa_preview']);

            $nama_file_baru = 'data-pembayaran-siswa.xlsx';

            // Cek apakah terdapat file data.xlsx pada folder tmp
            if(is_file('asset/lib/tmp/'.$nama_file_baru)) // Jika file tersebut ada
              unlink('asset/lib/tmp/'.$nama_file_baru); // Hapus file tersebut

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];

            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if($ext == "xlsx"){
              // Upload file yang dipilih ke folder tmp
              move_uploaded_file($tmp_file, 'asset/lib/tmp/'.$nama_file_baru);

              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
              $spreadsheet = $reader->load('asset/lib/tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
              $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
?>
              <!-- Buat sebuah tag form untuk proses import data ke database -->
              <form method='post' action='index.php?page=proses_import_pembayaran_siswa'>
                <input type="hidden" name="id_jtagihan" value="<?=$id_jtagihan_siswa_preview;?>">
                <input type="hidden" name="kelas" value="<?=$kelas_preview;?>">
                <input type="hidden" name="jurusan" value="<?=$jurusan_preview;?>">
                <button type='submit' name='import_pembayaran_siswa' class='btn btn-sm btn-success'><i class='fas fa-upload'></i> Import</button>
                <hr>
              <table class='table table-bordered'>
                <thead>
                  <tr>
                    <th colspan='7' class='text-center'>Preview Data</th>
                  </tr>
                  <tr>
                    <th>NO</th>
                    <th>NIS</th>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>JURUSAN</th>
<?php
                    $query1 = "SELECT * FROM tb_jenis_tagihan_siswa WHERE id_jns_tghn_siswa='$id_jtagihan_siswa_preview'";
                    $result = mysqli_query($koneksi,$query1);
                    while ($data1 = mysqli_fetch_assoc($result)) {
                      $id_jenis_tagihan1 = $data1['id_jns_tghn_siswa'];
                      $jenis_tagihan1 = $data1['jenis_tagihan_siswa'];
?>
                    <th><?=$jenis_tagihan1;?></th>
                    <?php } ?>  

                  </tr>
                </thead>
                <tbody>
<?php 
              // $numrow = 1;
              $kosong = 0;
              $no = 1;
              foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
                // Ambil data pada excel sesuai Kolom
                $nis = $row['A'];
                $nama_siswa = $row['B'];
                $kelas = $row['C'];
                $jurusan = $row['D'];
                $jumlah = number_format($row['E'],0,",",".");
                if ($jumlah == 0) {
                  $jumlah = "";
                }

                // Cek jika semua data tidak diisi
                if($nis == "" && $nama_siswa == "" && $kelas == "" && $jurusan == "" && $jumlah == "")
                  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                if($numrow > 0){
                  $td_2 = ( ! empty($nis))? "" : " style='background: #E07171;'";
                  $td_3 = ( ! empty($nama_siswa))? "" : " style='background: #E07171;'"; 
                  $td_4 = ( ! empty($kelas))? "" : " style='background: #E07171;'"; 
                  $td_5 = ( ! empty($jurusan))? "" : " style='background: #E07171;'"; 
                  $td_6 = ( ! empty($jumlah))? "" : " style='background: #E07171;'";
                  
                  // Jika salah satu data ada yang kosong
                  if($nis == "" or $nama_siswa == "" or $kelas == "" or $jurusan == "" or $jumlah == ""){
                    $kosong++; // Tambah 1 variabel $kosong
                  }
?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td <?=$td_2;?>>
                      <?= $nis; ?>
                    </td>
                    <td <?=$td_3;?>>
                      <?=$nama_siswa; ?>
                    </td>
                    <td <?=$td_4;?>>
                      <?=$kelas; ?>
                    </td>
                    <td <?=$td_5;?>>
                      <?=$jurusan; ?>
                    </td>
                    <td <?=$td_6;?>>
                      <?= $jumlah; ?>
                    </td>
                  </tr>
<?php
               } 

                $numrow++; // Tambah 1 setiap kali looping
              }
?>
                </tbody>
              </table>
              
<?php
              // Cek apakah variabel kosong lebih dari 1
              // Jika lebih dari 1, berarti ada data yang masih kosong
              if($kosong > 1){
              ?>
                <script>
                $(document).ready(function(){
                  // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                  $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                  $("#kosong").show(); // Munculkan alert validasi kosong
                });
                </script>
              <?php
              } 
              ?>
                
              </form>
<?php
            }else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
              // Munculkan pesan validasi
              echo "<div class='alert alert-danger'>
                      Hanya File Excel 2007 (.xlsx) yang diperbolehkan
                    </div>";
            }
          }
          ?>
        </div> <!-- end tbl responsive -->   
      </div> <!-- end pembayaran siswa -->
    </div> <!-- end class="tab-content" id="myTabContent" -->
  </div> <!-- end card body -->
</div> <!-- end card shadow mb-4 -->
<script type="text/javascript">
  var uploadField = document.getElementById("dt-import_pembayaran1");
  uploadField.onchange = function() {
      if(this.files[0].size > 2000000){
         alert("Maaf. Ukuran File Terlalu Besar ! Maksimal Upload 2 MB");
         this.value = "";
      };
          var inputFile = document.getElementById('dt-import_pembayaran1');
          var pathFile = inputFile.value;
          var ekstensiOk = /(\.xlsx|\.xls)$/i;
          if(!ekstensiOk.exec(pathFile)){
              alert('Silahkan upload file yang memiliki ekstensi .xlsx');
              inputFile.value = '';
              return false;
          }
      };
</script>