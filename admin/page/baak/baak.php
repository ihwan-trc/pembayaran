<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 mb-4 text-gray-800">DATA BAGIAN ADMINISTRASI AKADEMIK</h1>
    </div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <?php 
      if (isset($_POST['preview'])) { ?>
        <a href="index.php?page=baak" class="btn btn-sm btn-danger" ><i class="fas fa-backward"></i> Back</a>
        <form method='post' class='d-sm-inline-block form-inline' action="page/baak/print.php" target="blank">
          <button class="btn btn-sm btn-primary" type="submit" name="print"><i class="fas fa-print"></i> Print</button>
        </form>
     <?php }else{
     ?>
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_baakModal"><i class="fas fa-plus"></i> Tambah</a>
    <a href="index.php?page=import_baak" class="btn btn-sm btn-info" ><i class="fas fa-upload"></i> Import</a>
    <form method='post' class='d-sm-inline-block form-inline' action="page/baak/excel.php">
      <button class="btn btn-sm btn-success" type="submit" name="excel"><i class="fas fa-download"></i> Excel</button>
    </form>
    <form method='post' class='d-sm-inline-block form-inline' action="">
      <button class="btn btn-sm btn-primary" type="submit" name="preview"><i class="fas fa-print"></i> Print</button>
    </form>
  <?php } ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <?php 
        if (isset($_POST['preview'])) { ?>
          <table class='table table-bordered'>
            <thead>
              <tr>
                <th colspan='4' class='text-center'>Preview Data</th>
              </tr>
              <tr>
                <th>NO</th>
                <th>NIP</th>
                <th>NAMA PEGAWAI</th>
                <th>JABATAN</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              $no = 1;
              $query = "SELECT * FROM tb_baak ORDER BY id_pegawai ASC";
              $result = mysqli_query($koneksi, $query);
              while ($data=mysqli_fetch_assoc($result)) {           
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nip']; ?></td>
                <td><?= $data['nama_pegawai']; ?></td>
                <td><?= $data['jabatan']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
<?php }else{ ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
            <th class="text-center">FOTO</th>
            <th class="text-center">NIP</th>
            <th class="text-center">NAMA PEGAWAI</th>
            <th class="text-center">JABATAN</th>
            <th class="text-center">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php  
            $query = "SELECT * FROM tb_baak ORDER BY id_pegawai ASC";
            $result = mysqli_query($koneksi, $query);

            $no = 1;
            while($data = mysqli_fetch_assoc($result)){ 
              $foto = $data['foto'];
            ?>
          <tr>
            <td class="text-center"><?=$no; ?></td>
            <td width="50"><center>
              <?php 
                if ($data['foto']=="") { ?>
                  <a href='asset/images/baak.jpg' data-toggle='lightbox' data-title='Foto Pegawai'>        
                  <img src='asset/images/baak.jpg' width='30' height='30'  alt='' ></a>
               <?php }else{?>
              <a href="asset/images/baak/<?= $foto; ?>" data-toggle="lightbox" data-title="Foto pegawai">        
              <img src="asset/images/baak/<?= $foto; ?>" width="30" height="30"  alt="" ></a>
              <?php } ?>
            </center></td>
            <td>
              <?= $data['nip']; ?>
            </td>
            <td>
              <?= $data['nama_pegawai']; ?>
            </td>
            <td class="text-center"><?=$data['jabatan'];?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info update" data-toggle="modal" data-target="#update_baak_Modal"
              data-id_pegawai="<?= $data['id_pegawai'];?>"
              data-foto="<?= $data['foto'];?>"
              data-nip="<?= $data['nip'];?>"
              data-nama="<?= $data['nama_pegawai'];?>"
              data-jabatan="<?= $data['jabatan'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/baak/hapus.php?id_pegawai=<?= $data['id_pegawai'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
            </center></td>
          </tr>
          <?php $no++; } ?>
        </tbody>
        <tfoot>
        </tfoot>
      </table>
    <?php
     }
     ?>
    </div>
  </div>
</div>

<!-- Modal add baak -->
<div class="modal fade" id="add_baakModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah BAAK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/baak/tambah.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">NIP</label>
            <input type="text" class="form-control" name="nip" id="" placeholder=" Masukkan NIP" required="">
          </div>
          <div class="form-group">
            <label for="">Nama Pegawai</label>
            <input type="text" class="form-control" name="nama" id="" placeholder=" Masukkan Nama Pegawai" required="">
          </div>
          <div class="form-group">
            <label for="level">Jabatan</label>
            <select class="form-control" name="jabatan" id="" required="">
              <option>- Pilih -</option>
              <option value="KEPALA BAAK">KEPALA BAAK</option>
              <option value="STAFF BAAK">STAFF BAAK</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Foto Pegawai</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto" name="foto" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Ukuran Foto Maks 2 MB</label>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah">Simpan</button>
      </div>
      </form>
    </div>
  </div>
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

<!-- Modal update BAAK -->
<div class="modal fade" id="update_baak_Modal" tabindex="-1" aria-labelledby="baakModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="baakModalLabel">Form Edit BAAK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/baak/edit.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_pegawai" id="edit_id_pegawai">
          <div class="form-group">
            <label for="">NIP</label>
            <input type="text" class="form-control" name="nip" id="edit_nip">
          </div>
          <div class="form-group">
            <label for="">Nama Pegawai</label>
            <input type="text" class="form-control" name="nama_pegawai" id="edit_nama">
          </div>
          <div class="form-group">
            <label for="level">Jabatan</label>
            <select class="form-control" name="jabatan" id="edit_jabatan">
              <option>- Pilih -</option>
              <option value="KEPALA BAAK">KEPALA BAAK</option>
              <option value="STAFF BAAK">STAFF BAAK</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Foto Pegawai</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto_pegawai" name="foto" onchange="return validasiFile()"/>
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
        <button type="submit" class="btn btn-sm btn-primary" name="update">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.update').click(function(){
    $('#edit_baak_Modal').modal();
    var id_pegawai_edit = $(this).attr('data-id_pegawai')
    var foto_edit = $(this).attr('data-foto')
    var nip_edit = $(this).attr('data-nip')
    var nama_edit = $(this).attr('data-nama')
    var jabatan_edit = $(this).attr('data-jabatan')

    $('#edit_id_pegawai').val(id_pegawai_edit)
    $('#edit_foto').attr("src","asset/images/baak/"+foto_edit)
    $('#edit_nip').val(nip_edit)
    $('#edit_nama').val(nama_edit)
    $('#edit_jabatan').val(jabatan_edit)
  })

  var uploadField = document.getElementById("foto_pegawai");
  uploadField.onchange = function() {
    if(this.files[0].size > 2000000){ // 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 2 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto_pegawai');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg .jpeg .png');
            inputFile.value = '';
            return false;
        }
    };
</script>