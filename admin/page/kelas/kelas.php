<h1 class="h5 mb-0 text-gray-800">DATA KELAS - JURUSAN</h1>
<div class="py-3"></div>
<div class="row">
  <!-- Area Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3">
          <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_kelas"><i class="fas fa-plus"></i> Kelas</a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="" width="100%" cellspacing="0">
              <thead class="bg-dark text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Kelas</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php  
                $query = "SELECT * FROM tb_kelas ORDER BY id_kelas ASC";
                $result = mysqli_query($koneksi, $query);
                if(!$result){
                  die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
                  }
                $no = 1;
                while($data = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $data['kelas']; ?></td>
                  <td class="text-center">
                    <a href="#" class="btn btn-sm btn-info editkelas" data-toggle="modal" data-target="#edit_kelas"data-id_kelas="<?= $data['id_kelas'];?>"data-kelas="<?= $data['kelas'];?>">
                    <i class="fas fa-edit"></i></a>

                    <a href="page/kelas/hapus.php?id_kelas=<?= $data['id_kelas'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  <!-- Jurusan -->
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header-->
        <div class="card-header py-3">
          <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_jurusan"><i class="fas fa-plus"></i> Jurusan</a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="" width="100%" cellspacing="0">
              <thead class="bg-dark text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Jurusan</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php  
                $query = "SELECT * FROM tb_jurusan ORDER BY id_jurusan ASC";
                $result = mysqli_query($koneksi, $query);
                if(!$result){
                  die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
                  }
                $no = 1;
                while($data = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $data['jurusan']; ?></td>
                  <td class="text-center">
                    <a href="#" class="btn btn-sm btn-info editjurusan" data-toggle="modal" data-target="#edit_jurusan"data-id_jurusan="<?= $data['id_jurusan'];?>"data-jurusan="<?= $data['jurusan'];?>"><i class="fas fa-edit"></i></a>

                    <a href="page/kelas/hapus.php?id_jurusan=<?= $data['id_jurusan'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> <!--End Jurusan -->
</div><!--End row -->

<div class="row">
  <!-- semester -->
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header-->
        <div class="card-header py-3">
          <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_semester"><i class="fas fa-plus"></i> Semester</a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="" width="100%" cellspacing="0">
              <thead class="bg-dark text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Semester</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php  
                $query = "SELECT * FROM tb_semester ORDER BY id_semester ASC";
                $result = mysqli_query($koneksi, $query);
                if(!$result){
                  die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
                  }
                $no = 1;
                while($data = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $data['semester']; ?></td>
                  <td class="text-center">
                    <a href="#" class="btn btn-sm btn-info editsemester" data-toggle="modal" data-target="#edit_semester"data-id_semester="<?= $data['id_semester'];?>"data-semester="<?= $data['semester'];?>"><i class="fas fa-edit"></i></a>

                    <a href="page/kelas/hapus.php?id_semester=<?= $data['id_semester'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> <!--End semester -->

  <!-- tahun -->
    <div class="col-xl-6 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header-->
        <div class="card-header py-3">
          <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah_tahun"><i class="fas fa-plus"></i> Tahun Ajaran</a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="" width="100%" cellspacing="0">
              <thead class="bg-dark text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Tahun Ajaran</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php  
                $query = "SELECT * FROM tb_tahun ORDER BY id_tahun ASC";
                $result = mysqli_query($koneksi, $query);
                if(!$result){
                  die ("Query Error: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
                  }
                $no = 1;
                while($data = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $data['tahun']; ?></td>
                  <td class="text-center">
                    <a href="#" class="btn btn-sm btn-info edittahun" data-toggle="modal" data-target="#edit_tahun"data-id_tahun="<?= $data['id_tahun'];?>"data-tahun="<?= $data['tahun'];?>"><i class="fas fa-edit"></i></a>

                    <a href="page/kelas/hapus.php?id_tahun=<?= $data['id_tahun'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> <!--End tahun -->
</div>


<!-- Area Modal Tambah -->

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambah_kelas" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/tambah.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="kelas">Kelas :</label>
          <input type="text" class="form-control" name="kelas" id="kelas" placeholder=" Masukkan Nama Kelas" required="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah_kelas">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="tambah_jurusan" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/tambah.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="jurusan">Jurusan :</label>
          <input type="text" class="form-control" name="jurusan" id="jurusan" placeholder=" Masukkan Nama Jurusan" required="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah_jurusan">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!-- Modal Tambah Semester -->
<div class="modal fade" id="tambah_semester" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/tambah.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="semester">Semester :</label>
          <input type="text" class="form-control" name="semester" id="semester" placeholder=" Masukkan Nama semester" required="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah_semester">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!-- Modal Tambah Tahun -->
<div class="modal fade" id="tambah_tahun" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/tambah.php" method="post">
  <div class="modal-dialog  modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah Tahun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="tahun">Tahun Ajaran :</label>
          <input type="text" class="form-control" name="tahun" id="tahun" placeholder=" Masukkan Tahun Ajaran" required="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="tambah_tahun">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!-- Area Modal Edit -->

<!-- Modal Edit Kelas -->
<div class="modal fade" id="edit_kelas" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/edit.php" method="post">
  <div class="modal-dialog  modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_kelas" id="edit_id_kelas">
        <div class="form-group">
          <label for="">Kelas :</label>
          <input type="text" class="form-control" name="kelas" id="edit_kelas_plc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit_kelas">Simpan</button>
      </div>  
    </div>
  </div>
  </form>
</div>
<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.editkelas').click(function(){
    $('#edit_kelas').modal();
    var id_kelas_edit = $(this).attr('data-id_kelas')
    var kelas_edit = $(this).attr('data-kelas')

    $('#edit_id_kelas').val(id_kelas_edit)
    $('#edit_kelas_plc').val(kelas_edit)
  })
</script>

<!-- Modal Edit jurusan -->
<div class="modal fade" id="edit_jurusan" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/edit.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_jurusan" id="edit_id_jurusan">
        <div class="form-group">
          <label for="">Jurusan :</label>
          <input type="text" class="form-control" name="jurusan" id="edit_jurusan_plc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit_jurusan">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.editjurusan').click(function(){
    $('#edit_jurusan').modal();
    var id_jurusan_edit = $(this).attr('data-id_jurusan')
    var jurusan_edit = $(this).attr('data-jurusan')

    $('#edit_id_jurusan').val(id_jurusan_edit)
    $('#edit_jurusan_plc').val(jurusan_edit)
  })
</script>

<!-- Modal Edit Semester -->
<div class="modal fade" id="edit_semester" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/edit.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_semester" id="edit_id_semester">
        <div class="form-group">
          <label for="">Semester :</label>
          <input type="text" class="form-control" name="semester" id="edit_semester_plc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit_semester">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.editsemester').click(function(){
    $('#edit_semester').modal();
    var id_semester_edit = $(this).attr('data-id_semester')
    var semester_edit = $(this).attr('data-semester')

    $('#edit_id_semester').val(id_semester_edit)
    $('#edit_semester_plc').val(semester_edit)
  })
</script>

<!-- Modal Edit tahun -->
<div class="modal fade" id="edit_tahun" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <form action="page/kelas/edit.php" method="post">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit Tahun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_tahun" id="edit_id_tahun">
        <div class="form-group">
          <label for="">Tahun Ajaran :</label>
          <input type="text" class="form-control" name="tahun" id="edit_tahun_plc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit_tahun">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.edittahun').click(function(){
    $('#edit_tahun').modal();
    var id_tahun_edit = $(this).attr('data-id_tahun')
    var tahun_edit = $(this).attr('data-tahun')

    $('#edit_id_tahun').val(id_tahun_edit)
    $('#edit_tahun_plc').val(tahun_edit)
  })
</script>