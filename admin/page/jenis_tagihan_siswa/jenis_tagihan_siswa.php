<h1 class="h5 mb-4 text-gray-800">JENIS TAGIHAN <font color="red">(SISWA)</font></h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_jenis_tagihanModal"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">NO</th>
            <th class="text-center">JENIS TAGIHAN</th>
            <th class="text-center">ACTION</th>
          </tr>
        </thead>
        <tbody>

          <?php  

             $query = "SELECT * FROM tb_jenis_tagihan_siswa ORDER BY id_jns_tghn_siswa ASC";
            $result = mysqli_query($koneksi, $query);
            
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data siswa_kelas_x
            $no = 1;
            while($data = mysqli_fetch_assoc($result)) {
            ?>
          <tr>
            <td class="text-center"><?= "$no"; ?></td>
            <td class=""><?= $data['jenis_tagihan_siswa']; ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_jenis_tagihan_Modal"
              data-id_jns_tghn_siswa="<?= $data['id_jns_tghn_siswa'];?>"
              data-jenis_tagihan_siswa="<?= $data['jenis_tagihan_siswa'];?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/jenis_tagihan_siswa/hapus.php?id_jns_tghn_siswa=<?= $data['id_jns_tghn_siswa'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
            </center></td>
          </tr>
          <?php
          $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Jenis Tagihan -->
<div class="modal fade" id="tambah_jenis_tagihanModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/jenis_tagihan_siswa/tambah.php" method="post" enctype="multipart/form-data">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Jenis Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-12">
            <label for="jenis_tagihan_siswa">Jenis Tagihan :<font color="red">*</font></label>
            <input type="text" class="form-control" name="jenis_tagihan_siswa" id="jenis_tagihan_siswa" placeholder=" Masukkan Jenis Tagihan" required="">
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

<!-- Modal Edit Jenis Tagihan -->
<div class="modal fade" id="edit_jenis_tagihan_Modal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
  <form action="page/jenis_tagihan_siswa/edit.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_jns_tghn_siswa" id="edit_id_jns_tghn_siswa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UserModalLabel">Form Edit Jenis Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-12">
            <label for="edit_jenis_tagihan_siswa">Jenis Tagihan</label>
            <input type="text" class="form-control" name="jenis_tagihan_siswa" id="edit_jenis_tagihan_siswa">
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.edit').click(function(){
    $('#edit_jenis_tagihan_Modal').modal();
    var id_jns_tghn_siswa_edit = $(this).attr('data-id_jns_tghn_siswa')
    var jenis_tagihan_siswa_edit = $(this).attr('data-jenis_tagihan_siswa')

    $('#edit_id_jns_tghn_siswa').val(id_jns_tghn_siswa_edit)
    $('#edit_jenis_tagihan_siswa').val(jenis_tagihan_siswa_edit)
  })
</script>
