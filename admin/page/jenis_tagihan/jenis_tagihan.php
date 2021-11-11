<h1 class="h5 mb-4 text-gray-800">JENIS TAGIHAN <font color="red">(UMUM)</font></h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_jenis_tagihanModal"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Jenis Tagihan</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Jurusan</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  

             $query = "SELECT * FROM tb_jenis_tagihan ORDER BY id_jenis_tagihan ASC";
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
            <td class=""><?= $data['jenis_tagihan']; ?></td>
            <td class=""><?= $data['kelas']; ?></td>
            <td class=""><?= $data['jurusan']; ?></td>
            <td class=""><?= number_format($data['jumlah'],0,",","."); ?></td>
            <td><center>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_jenis_tagihan_Modal"
              data-id_jenis_tagihan="<?= $data['id_jenis_tagihan'];?>"
              data-jenis_tagihan="<?= $data['jenis_tagihan'];?>"
              data-kelas="<?= $data['kelas'];?>"
              data-jurusan="<?= $data['jurusan'];?>"
              data-jumlah="<?= number_format($data['jumlah'],0,",",".");?>"
              ><i class="fas fa-edit"></i> Edit</a>

              <a href="page/jenis_tagihan/hapus.php?id_jenis_tagihan=<?= $data['id_jenis_tagihan'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
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
  <form action="page/jenis_tagihan/tambah.php" method="post" enctype="multipart/form-data">
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
            <label for="jenis_tagihan">Jenis Tagihan :<font color="red">*</font></label>
            <input type="text" class="form-control" name="jenis_tagihan" id="jenis_tagihan" placeholder=" Masukkan Jenis Tagihan" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-6">
            <label for="kelas">Kelas :<font color="red">*</font></label>
            <select class="form-control" name="kelas" id="kelas" required="">
              <option value="SEMUA">Semua Kelas</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
                while ($data = mysqli_fetch_assoc($query)) {
                  $kelas = $data['kelas'];
                ?>
                <option value="<?= $kelas;?>"><?= $kelas;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-6">
            <label for="jurusan">jurusan :<font color="red">*</font></label>
            <select class="form-control" name="jurusan" id="jurusan" required="">
              <option value="SEMUA">Semua Jurusan</option>
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
          <div class="form-group col-6">
            <label for="jumlah">Jumlah :<font color="red">*</font></label>
            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder=" Rp." required="">
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
<!-- format rupiah   -->
<script type="text/javascript"> 
    var jumlah = document.getElementById('jumlah');
    jumlah.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatjumlah() untuk mengubah angka yang di ketik menjadi format angka
      jumlah.value = formatjumlah(this.value);
    });

    /* Fungsi formatjumlah */
    function formatjumlah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      jumlah = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        jumlah += separator + ribuan.join('.');
      }

      jumlah = split[1] != undefined ? jumlah + ',' + split[1] : jumlah;
      return prefix == undefined ? jumlah : (jumlah ? jumlah : '');
    }
  </script>

<!-- Modal Edit Jenis Tagihan -->
<div class="modal fade" id="edit_jenis_tagihan_Modal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
  <form action="page/jenis_tagihan/edit.php" method="post" enctype="multipart/form-data">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UserModalLabel">Form Edit Jenis Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_jenis_tagihan" id="edit_id_jenis_tagihan">
        <div class="form-row">
          <div class="form-group col-12">
            <label for="edit_jenis_tagihan">Jenis Tagihan</label>
            <input type="text" class="form-control" name="jenis_tagihan" id="edit_jenis_tagihan">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-4">
            <label for="edit_kelas">Kelas</label>
            <select class='form-control' name='kelas' id="edit_kelas">>
              <option value="SEMUA">Semuah Kelas</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_kelas GROUP BY kelas");
                while ($data = mysqli_fetch_assoc($query)) {
                  $kelas = $data['kelas'];
                ?>
                <option value="<?= $kelas;?>"><?= $kelas;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-6">
            <label for="edit_jurusan">Jurusan</label>
            <select class='form-control' name='jurusan' id="edit_jurusan">>
              <option value="SEMUA">Semua Jurusan</option>
              <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_jurusan GROUP BY jurusan");
                while ($data = mysqli_fetch_assoc($query)) {
                  $jurusan = $data['jurusan'];
                ?>
                <option value="<?= $jurusan;?>"><?= $jurusan;?></option>
              <?php } ?>
            </select>
          </div>
        <div class="form-row">
          <div class="form-group col-6">
            <label for="edit_jumlah">Jumlah </small></label>
            <input type="text" class="form-control" name="jumlah" id="edit_jumlah">
          </div>
          <small><font color="red">*sebelum ubah jumlah tagihan: </font>pastikan jenis tagihan ini belum pernah digunakan untuk pembayaran! jika jenis tagihan sudah pernah digunakan untuk pembayaran, silahkan hapus data pembayaran yang berhubungan dengan jenis tagihan ini !</small>
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
    var id_jenis_tagihan_edit = $(this).attr('data-id_jenis_tagihan')
    var jenis_tagihan_edit = $(this).attr('data-jenis_tagihan')
    var kelas_edit = $(this).attr('data-kelas')
    var jurusan_edit = $(this).attr('data-jurusan')
    var jumlah_edit = $(this).attr('data-jumlah')

    $('#edit_id_jenis_tagihan').val(id_jenis_tagihan_edit)
    $('#edit_jenis_tagihan').val(jenis_tagihan_edit)
    $('#edit_kelas').val(kelas_edit)
    $('#edit_jurusan').val(jurusan_edit)
    $('#edit_jumlah').val(jumlah_edit)
  })
</script>
<!-- format rupiah   -->
<script type="text/javascript"> 
    var edit_jumlah = document.getElementById('edit_jumlah');
    edit_jumlah.addEventListener('keyup', function(e){
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatedit_jumlah() untuk mengubah angka yang di ketik menjadi format angka
      edit_jumlah.value = formatedit_jumlah(this.value);
    });

    /* Fungsi formatedit_jumlah */
    function formatedit_jumlah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      edit_jumlah = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        edit_jumlah += separator + ribuan.join('.');
      }

      edit_jumlah = split[1] != undefined ? edit_jumlah + ',' + split[1] : edit_jumlah;
      return prefix == undefined ? edit_jumlah : (edit_jumlah ? edit_jumlah : '');
    }
  </script>
