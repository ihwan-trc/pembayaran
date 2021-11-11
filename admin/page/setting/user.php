<h1 class="h5 mb-4 text-gray-800">HALAMAN USER</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_userModal"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">Username</th>
            <th class="text-center">Level</th>
            <th class="text-center">Password</th>
            <th width="18%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "asset/inc/config.php";

            $query = "SELECT * FROM tb_user ORDER BY id_user ASC";
            $result = mysqli_query($koneksi, $query);
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }

            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td class="text-center"><?php echo $data['nama_user']; ?></td>
            <td class="text-center"><?php echo $data['username']; ?></td>
            <td class="text-center"><?php echo $data['level']; ?></td>
            <td class="text-center">
              <a href="#" class="btn btn-sm btn-warning reset" data-toggle="modal" data-target="#reset_userModal"
              data-iduser="<?php echo $data['id_user']; ?>"
              data-username="<?php echo $data['username']; ?>"
              data-nmuser="<?php echo $data['nama_user']; ?>"
              data-level="<?php echo $data['level']; ?>">
              <i class="fas fa-check"></i> Reset</a>
            </td>
            <td class="text-center">
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_userModal"
              data-iduser="<?php echo $data['id_user']; ?>"
              data-username="<?php echo $data['username']; ?>"
              data-nmuser="<?php echo $data['nama_user']; ?>"
              data-level="<?php echo $data['level']; ?>"><i class="fas fa-edit"></i> edit</a>

              <a href="page/setting/hapus.php?id_user=<?php echo $data['id_user'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
            </td>
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


<!-- Modal add user -->
<div class="modal fade" id="add_userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/setting/tambah.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">Nama User</label><br/>
            <i style="color: red;">Pilihan Nama user diambil dari data pegawai BAAK</i>
            <select class="form-control" name="nama_user" id="">
                <?php
                  $query    =mysqli_query($koneksi, "SELECT * FROM tb_baak GROUP BY nama_pegawai ORDER BY id_pegawai");
                  while ($data = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?=$data['nama_pegawai'];?>"><?php echo $data['nama_pegawai'];?></option>
                  <?php
                  }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Username</label>
            <input type="text" class="form-control" name="username" id="" placeholder=" Masukkan Username" required="">
          </div>
          <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password" id="" placeholder=" Masukkan Password" required="">
          </div>
          <div class="form-group">
            <label for="">Level :</label>
            <select class="form-control" name="level" id="">
                <?php
                  $query    =mysqli_query($koneksi, "SELECT * FROM tb_user GROUP BY level");
                  while ($data = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?=$data['level'];?>"><?php echo $data['level'];?></option>
                  <?php
                  }
                ?>
            </select>
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

<!-- Modal edit user -->
<div class="modal fade" id="edit_userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/setting/edit.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_user" id="edit_id_user">
          <div class="form-group">
            <label for="">Nama User</label>
            <select class="form-control" name="nama_user" id="edit_nama_user">
                <?php
                  $query    =mysqli_query($koneksi, "SELECT * FROM tb_baak GROUP BY nama_pegawai ORDER BY id_pegawai");
                  while ($data = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?=$data['nama_pegawai'];?>"><?php echo $data['nama_pegawai'];?></option>
                  <?php
                  }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Username</label>
            <input type="text" class="form-control" name="username" id="edit_username" placeholder=" Masukkan Username" required="">
          </div>
          <div class="form-group">
            <label for="">Level :</label>
            <select class="form-control" name="level" id="edit_level">
                <?php
                  $query    =mysqli_query($koneksi, "SELECT * FROM tb_user GROUP BY level");
                  while ($data = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?=$data['level'];?>"><?php echo $data['level'];?></option>
                  <?php
                  }
                ?>
            </select>
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
    $('#edit_userModal').modal();
    var id_user = $(this).attr('data-iduser')
    var username = $(this).attr('data-username')
    var nama_user = $(this).attr('data-nmuser')
    var level = $(this).attr('data-level')

    $('#edit_id_user').val(id_user)
    $('#edit_username').val(username)
    $('#edit_nama_user').val(nama_user)
    $('#edit_level').val(level)
  })
</script>

<!-- Modal Reset Password -->
<div class="modal fade" id="reset_userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form method="POST" action="page/setting/reset.php">
        <input type="hidden" name="rst_id_user" id="reset_id_user">
          <div class="form-row">
            <div class="form-group col-5">
              <label for="">Nama User :</label>
              <input type="text" class="form-control" name="rst_namauser" id="reset_nama_user" readonly="">
            </div>
            <div class="form-group col-4">
              <label for="">Username :</label>
              <input type="text" class="form-control" name="rst_username" id="reset_username" readonly="">
            </div>
            <div class="form-group col-3">
              <label for="">Level :</label>
              <input type="text" class="form-control" name="rst_level" id="reset_level" readonly="">
            </div>
          </div>
          <div class="form-row">
              <div class="form-group col-12">
                <label for="">RESET PASSWORD</label><br>
                  mengembalikan akses login ke pengaturan default <br>
                  <font color="blue"><b>Username & Password :</b></font> <br>
                  NIP (<font color="red">*Sesuai NIP masing-masing user</font>)
              </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary" name="reset">Reset</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.reset').click(function(){
    $('#reset_userModal').modal();
    var id_user = $(this).attr('data-iduser')
    var username = $(this).attr('data-username')
    var nama_user = $(this).attr('data-nmuser')
    var level = $(this).attr('data-level')

    $('#reset_id_user').val(id_user)
    $('#reset_username').val(username)
    $('#reset_nama_user').val(nama_user)
    $('#reset_level').val(level)
  })
</script>
