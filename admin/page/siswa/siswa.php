<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h5 mb-0 text-gray-800">DATA SISWA</h1>
</div>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_siswaModal"><i class="fas fa-plus"></i> Tambah</a>
    <a href="index.php?page=import_siswa" class="btn btn-sm btn-info" ><i class="fas fa-upload"></i> Import</a>
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
            <option value="<?= $jurusan;?>" required><?= $jurusan;?></option>
          <?php } ?>
        </select>
        <button class="btn btn-primary" type="submit" name="search"><i class="fas fa-search fa-sm"></i></button>
    </form>
    <?php 
        if ($_POST['kelas']) {
          if ($_POST['jurusan']) {
           $kelas = $_POST['kelas'];
           $jurusan = $_POST['jurusan']; ?>
           <form action="page/siswa/reset_siswa.php" method="POST" style="float: right;">
             <input type="hidden" name="kelas" value="<?= $kelas; ?>">
             <input type="hidden" name="jurusan" value="<?= $jurusan; ?>">
             <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Yakin Untuk Mereset Data Siswa <?= $kelas; ?> <?= $jurusan; ?>?')" name="resetsiswa">
               <i class="fas fa fa-undo fa-sm fa-fw mr-2 text-gray-400"></i> Reset Siswa <?= $kelas; ?> <?= $jurusan; ?>
             </button>
           </form>
     <?php } } ?>
     
    
    </div>
    <?php if (isset($_POST['search'])) {
      $kelas_post = $_POST['kelas'];
      $jurusan_post = $_POST['jurusan'];
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
            <td><form method='post' class='d-sm-inline-block form-inline' action="index.php?page=siswa_print">
                  <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
                  <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
                  <button class="btn btn-sm btn-primary" type="submit" name="preview"><i class="fas fa-print"></i> Print
                  </button>
                </form>
            </td>
            <td><form method='post' class='d-sm-inline-block form-inline' action="page/siswa/excel.php">
                  <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
                  <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
                  <button class="btn btn-sm btn-success" type="submit" name="excel"><i class="fas fa-download"></i> Excel</button>
                </form>
            </td>
          </tr>
        </table>
      </div>
    <?php } ?>
  <div class="card-body">
    <div class="table-responsive">

<!-- ------------------------------------ HOME -------------------------------------------------------- -->
<!-- ------------------------------------ HOME -------------------------------------------------------- -->
<?php 
  if (!isset($_POST['search'])) { ?>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
            <th class="text-center">FOTO</th>
            <th class="text-center">NIS</th>
            <th class="text-center">NAMA SISWA</th>
            <th class="text-center">KELAS</th>
            <th class="text-center">JURUSAN</th>
            <th class="text-center">ACTION</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          $query = "SELECT * FROM tb_siswa ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
            }
          $no = 1;
          while($data = mysqli_fetch_assoc($result))
          { $foto = $data['foto'];
        ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50">
              <center>
                <?php 
                  if ($data['foto']=="") { ?>
                    <a href='asset/images/siswa.jpg' data-toggle='lightbox' data-title='Foto Siswa'>        
                    <img src='asset/images/siswa.jpg' width='30' height='30'  alt='' ></a>
                 <?php }else{?>
                <a href="asset/images/siswa/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto Siswa"> 
                <img src="asset/images/siswa/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
                <?php } ?>
              </center>
            </td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td class="text-center"><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_siswa_Modal"
              data-id_siswa="<?= $data['id_siswa'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nis="<?= $data['nis'];?>"
              data-nama="<?= $data['nama_siswa'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>
              
              <a href="page/siswa/hapus.php?id_siswa=<?= $data['id_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
              </center>
            </td>
          </tr>
        <?php
          $no++;
          } 
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center" colspan="7">
            </td>
          </tr>
        </tfoot>
      </table>
    
 <?php } ?>

<!-- ------------------------------------ ISSET -------------------------------------------------------- -->
<!-- ------------------------------------ ISSET -------------------------------------------------------- -->
<!-- ------------------------------------ ISSET -------------------------------------------------------- -->


<?php 
  if (isset($_POST['search'])) {
    $kelas_post = $_POST['kelas'];
    $jurusan_post = $_POST['jurusan'];

// -------------------------------------- 1 ------------------kosong-----------------------
// -------------------------------------- 1 --------------------------------------------------------
    if ($kelas_post == "") {
     if ($jurusan_post == "") { ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">NIS</th>
            <th class="text-center">Nama Siswa</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          $query = "SELECT * FROM tb_siswa ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
            }
          $no = 1;
          while($data = mysqli_fetch_assoc($result))
          { $foto = $data['foto'];
        ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50">
              <center>
                <?php 
                  if ($data['foto']=="") { ?>
                    <a href='asset/images/siswa.jpg' data-toggle='lightbox' data-title='Foto Siswa'>        
                    <img src='asset/images/siswa.jpg' width='30' height='30'  alt='' ></a>
                 <?php }else{?>
                <a href="asset/images/siswa/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto Siswa"> 
                <img src="asset/images/siswa/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
                <?php } ?>
              </center>
            </td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td class="text-center"><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_siswa_Modal"
              data-id_siswa="<?= $data['id_siswa'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nis="<?= $data['nis'];?>"
              data-nama="<?= $data['nama_siswa'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/siswa/hapus.php?id_siswa=<?= $data['id_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
              </center>
            </td>
          </tr>
        <?php
          $no++;
          } 
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center" colspan="7">
            </td>
          </tr>
        </tfoot>
      </table>
      
<?php  
     }
    }
?>

<!-- // -------------------------------------- 2 --------------------kelas jurusan------------------------
// -------------------------------------- 2 -------------------------------------------------------- -->

<?php
    if ($kelas_post != "") {
     if ($jurusan_post != "") { ?>
       
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">NIS</th>
            <th class="text-center">Nama Siswa</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          $query = "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
            }
          $no = 1;
          while($data = mysqli_fetch_assoc($result))
          { $foto = $data['foto'];
        ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50">
              <center>
                <?php 
                  if ($data['foto']=="") { ?>
                    <a href='asset/images/siswa.jpg' data-toggle='lightbox' data-title='Foto Siswa'>        
                    <img src='asset/images/siswa.jpg' width='30' height='30'  alt='' ></a>
                 <?php }else{?>
                <a href="asset/images/siswa/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto Siswa"> 
                <img src="asset/images/siswa/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
                <?php } ?>
              </center>
            </td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td class="text-center"><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_siswa_Modal"
              data-id_siswa="<?= $data['id_siswa'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nis="<?= $data['nis'];?>"
              data-nama="<?= $data['nama_siswa'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/siswa/hapus.php?id_siswa=<?= $data['id_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
              </center>
            </td>
          </tr>
        <?php
          $no++;
          } 
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center" colspan="7">
            </td>
          </tr>
        </tfoot>
      </table>

      <?php
      }
    }
?>


<!-- // -------------------------------------- 3 --------------------kelas------------------------------
// -------------------------------------- 3 -------------------------------------------------------- -->

<?php
    if ($kelas_post != "") {
     if ($jurusan_post == "") { ?>
      
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">NIS</th>
            <th class="text-center">Nama Siswa</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          $query = "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
            }
          $no = 1;
          while($data = mysqli_fetch_assoc($result))
          { $foto = $data['foto'];
        ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50">
              <center>
                <?php 
                  if ($data['foto']=="") { ?>
                    <a href='asset/images/siswa.jpg' data-toggle='lightbox' data-title='Foto Siswa'>        
                    <img src='asset/images/siswa.jpg' width='30' height='30'  alt='' ></a>
                 <?php }else{?>
                <a href="asset/images/siswa/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto Siswa"> 
                <img src="asset/images/siswa/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
                <?php } ?>
              </center>
            </td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td class="text-center"><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_siswa_Modal"
              data-id_siswa="<?= $data['id_siswa'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nis="<?= $data['nis'];?>"
              data-nama="<?= $data['nama_siswa'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/siswa/hapus.php?id_siswa=<?= $data['id_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
              </center>
            </td>
          </tr>
        <?php
          $no++;
          } 
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center" colspan="7">
            </td>
          </tr>
        </tfoot>
      </table>
      
<?php
     }
    }
?>


<!-- // -------------------------------------- 4 -----------------jurusan----------------------------
// -------------------------------------- 4 -------------------------------------------------------- -->

<?php
    if ($kelas_post == "") {
     if ($jurusan_post != "") { ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">NIS</th>
            <th class="text-center">Nama Siswa</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php  
          $query = "SELECT * FROM tb_siswa WHERE jurusan='$jurusan_post' ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
            }
          $no = 1;
          while($data = mysqli_fetch_assoc($result))
          { $foto = $data['foto'];
        ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50">
              <center>
                <?php 
                  if ($data['foto']=="") { ?>
                    <a href='asset/images/siswa.jpg' data-toggle='lightbox' data-title='Foto Siswa'>        
                    <img src='asset/images/siswa.jpg' width='30' height='30'  alt='' ></a>
                 <?php }else{?>
                <a href="asset/images/siswa/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto Siswa"> 
                <img src="asset/images/siswa/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
                <?php } ?>
              </center>
            </td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td class="text-center"><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_siswa_Modal"
              data-id_siswa="<?= $data['id_siswa'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nis="<?= $data['nis'];?>"
              data-nama="<?= $data['nama_siswa'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/siswa/hapus.php?id_siswa=<?= $data['id_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
              </center>
            </td>
          </tr>
        <?php
          $no++;
          } 
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center" colspan="7">
            </td>
          </tr>
        </tfoot>
      </table>
      
<?php
     }
    }
?>

 <?php
  }
?>
    </div>
  </div>
</div>

<!-- Area Modal -->

<!-- Modal add siswa -->
<div class="modal fade" id="add_siswaModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/siswa/tambah.php" method="post" enctype="multipart/form-data">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-4">
            <label for="nis">NIS :</label>
            <input type="text" class="form-control" name="nis" id="nis" placeholder=" Masukkan NIS" required="">
          </div>
          <div class="form-group col-8">
            <label for="nama">Nama Siswa :</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder=" Masukkan Nama Siswa" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-4">
            <label for="kelas">Kelas :</label>
            <select class="form-control" name="kelas" id="kelas">
              <option>Pilih Kelas</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
                while ($data = mysqli_fetch_assoc($query)) {
                  $kelas = $data['kelas'];
                ?>
                <option value="<?= $kelas;?>"><?= $kelas;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-8">
            <label for="jurusan">Jurusan :</label>
            <select class='form-control' name='jurusan' id="jurusan">>
              <option>Pilih Jurusan</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
                while ($data = mysqli_fetch_assoc($query)) {
                  $jurusan = $data['jurusan'];
                ?>
                <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="">Foto Siswa :</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto" name="foto" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Ukuran Foto Maks 2 MB</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
var uploadField = document.getElementById("foto");
uploadField.onchange = function() {
    if(this.files[0].size > 2000000){
       alert("Maaf. Ukuran File Terlalu Besar ! Maksimal Upload 2 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg .jpeg .png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal Edit Siswa -->
<div class="modal fade" id="edit_siswa_Modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/siswa/edit.php" method="post" enctype="multipart/form-data">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="siswaModalLabel">Form Edit Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id_siswa" id="edit_id_siswa">
          <div class="form-group">
            <label for="edit_nis">NIS</label>
            <input type="text" class="form-control" name="nis" id="edit_nis">
          </div>
          <div class="form-group">
            <label for="edit_nama">Nama Siswa</label>
            <input type="text" class="form-control" name="nama_siswa" id="edit_nama">
          </div>
          <div class="form-group">
            <label for="edit_kelas">Kelas</label>
            <select class="form-control" name="kelas" id="edit_kelas" required="">
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
                while ($data = mysqli_fetch_assoc($query)) {
                  $kelas = $data['kelas'];
                ?>
                <option value="<?= $kelas;?>"><?= $kelas;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_jurusan">Jurusan</label>
            <select class="form-control" name="jurusan" id="edit_jurusan">
              <option>Pilih Jurusan</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
                while ($data = mysqli_fetch_assoc($query)) {
                  $jurusan = $data['jurusan'];
                ?>
                <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="foto_siswa">Foto Siswa</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto_siswa" name="foto" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Ukuran Foto Maks 2 MB</label>
            </div>
          </div>
          <div class="form-row">
              <div class="form-group col-4">
              <label for="">Preview</label>
                <img src="" id="edit_foto"  alt="" width="100%">
              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.edit').click(function(){
    $('#edit_siswa_Modal').modal();
    var id_siswa_edit = $(this).attr('data-id_siswa')
    var foto_edit = $(this).attr('data-foto')
    var nis_edit = $(this).attr('data-nis')
    var nama_edit = $(this).attr('data-nama')
    var kelas_edit = $(this).attr('data-kelas')
    var jurusan_edit = $(this).attr('data-jurusan')

    $('#edit_id_siswa').val(id_siswa_edit)
    $('#edit_foto').attr("src","asset/images/siswa/"+foto_edit)
    $('#edit_nis').val(nis_edit)
    $('#edit_nama').val(nama_edit)
    $('#edit_kelas').val(kelas_edit)
    $('#edit_jurusan').val(jurusan_edit)
  })

  var uploadField = document.getElementById("foto_siswa");
  uploadField.onchange = function() {
    if(this.files[0].size > 2000000){ // 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 2 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto_siswa');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg .jpeg .png');
            inputFile.value = '';
            return false;
        }
    };
</script>