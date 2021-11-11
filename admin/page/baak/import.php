<h1 class="h5 mb-4 text-gray-800">IMPORT DATA</h1>
<div class="card shadow mb-4">
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="index.php?page=import_siswa">SISWA</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="baak-tab" data-toggle="tab" href="#baak" role="tab" aria-controls="baak" aria-selected="true"><b>BAAK</b></a>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">
<!-- ========================================BAAK=================================================== -->
      <div class="tab-pane fade show active" id="baak" role="tabpanel" aria-labelledby="baak-tab">

        <div class="py-3">
          <form action="page/baak/format_import.php" method="post">
            <button class="btn btn-sm btn-success" type="submit" name="format"><i class="fas fa-download"></i> Format Import BAAK</button>
          </form>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-5">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="dt-import_baak" name="file" required="" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Masukkan file Excel 2007 (*.xlsx)</label>
              </div>
            </div>
            <div>
              <button type="submit" class="btn  btn-info" name="preview_baak"><i class="fas fa-eye"></i> Preview</button>
            </div>
          </div>
        </form>
        <div class="table-responsive">
    <!-- Buat Preview Data -->
          <?php
          // Load file autoload.php
          require 'asset/lib/PHPOffice/vendor/autoload.php';

          // Include librari PhpSpreadsheet
          use PhpOffice\PhpSpreadsheet\Spreadsheet;
          use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
          // Jika user telah mengklik tombol Preview
          if(isset($_POST['preview_baak'])){

            $nama_file_baru = 'data-baak.xlsx';

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

              // Buat sebuah tag form untuk proses import data ke database
              echo "<form method='post' action='page/baak/proses_import.php'>";
              // Buat sebuah tombol untuk mengimport data ke database
                echo "<button type='submit' name='import_baak' class='btn btn-sm btn-primary'>
                <i class='fas fa-upload'></i> Import</button>";
              echo "<br>";
              echo "<br>";
              echo "<table class='table table-bordered'>
              <tr>
                <th colspan='4' class='text-center'>Preview Data</th>
              </tr>
              <tr>
                <th class='text-center'>NO</th>
                <th class='text-center'>NIP</th>
                <th class='text-center'>NAMA PEGAWAI</th>
                <th class='text-center'>JABATAN</th>
              </tr>";
              $numrow = 1;
              $kosong = 0;
              $no = 1;
              foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
                // Ambil data pada excel sesuai Kolom
                $nip = $row['A'];
                $nama_pegawai = $row['B'];
                $jabatan = $row['C'];

                // Cek jika semua data tidak diisi
                if($nip == "" && $nama_pegawai == "" && $jabatan == "")
                  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if($numrow > 1){
                  // Validasi apakah semua data telah diisi
                  $nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'"; // Jika nip kosong, beri warna merah
                  $nama_pegawai_td = ( ! empty($nama_pegawai))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                  $jabatan_td = ( ! empty($jabatan))? "" : " style='background: #E07171;'"; // Jika jabatan Kelamin kosong, beri warna merah
                  
                  // Jika salah satu data ada yang kosong
                  if($nip == "" or $nama_pegawai == "" or $jabatan == ""){
                    $kosong++; // Tambah 1 variabel $kosong
                  }

                  echo "<tr>";
                  echo "<td class='text-center'>".$no++."</td>";
                  echo "<td".$nip_td.">".$nip."</td>";
                  echo "<td".$nama_pegawai_td.">".$nama_pegawai."</td>";
                  echo "<td".$jabatan_td.">".$jabatan."</td>";
                  echo "</tr>";
                }

                $numrow++; // Tambah 1 setiap kali looping
              }

              echo "</table>";

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
              echo "</form>";
            }else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
              // Munculkan pesan validasi
              echo "<div class='alert alert-danger'>
                      Hanya File Excel 2007 (.xlsx) yang diperbolehkan
                    </div>";
            }
          }
          ?>
        </div> <!-- end tbl responsive -->
        
      </div> <!-- end baak -->
      <script type="text/javascript">
        var uploadField = document.getElementById("dt-import_baak");
        uploadField.onchange = function() {
            if(this.files[0].size > 2000000){
               alert("Maaf. Ukuran File Terlalu Besar ! Maksimal Upload 2 MB");
               this.value = "";
            };
                var inputFile = document.getElementById('dt-import_baak');
                var pathFile = inputFile.value;
                var ekstensiOk = /(\.xlsx|\.xls)$/i;
                if(!ekstensiOk.exec(pathFile)){
                    alert('Silahkan upload file yang memiliki ekstensi .xlsx');
                    inputFile.value = '';
                    return false;
                }
            };
        </script>
    </div> <!-- end class="tab-content" id="myTabContent" -->
  </div> <!-- end card body -->
</div> <!-- end card shadow mb-4 -->