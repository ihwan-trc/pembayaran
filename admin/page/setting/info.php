<?php 
  $query = mysqli_query($koneksi,"SELECT * FROM tb_info");
  $row = mysqli_num_rows($query);
  if ($row != NULL) {
    $tambah = "";
  }else{
    $tambah = "
    <a href='#' class='btn btn-sm btn-primary' data-toggle='modal' data-target='#add_userModal'><i class='fas fa-plus'></i> Tambah</a>";
  }
 ?>

<h1 class="h5 mb-4 text-gray-800">DATA SEKOLAH</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <?= $tambah ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">Nama Sekolah</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">Kode Pos</th>
            <th class="text-center">Telp</th>
            <th class="text-center">Info 1</th>
            <th class="text-center">Info 2</th>
            <th class="text-center">Icon</th>
            <th class="text-center">Logo</th>
            <th class="text-center">Banner</th>
            <th class="text-center">Banner Admin</th>
            <th width="18%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "asset/inc/config.php";

            $query = "SELECT * FROM tb_info";
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
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['alamat']; ?></td>
            <td><?php echo $data['kode_pos']; ?></td>
            <td><?php echo $data['telp']; ?></td>
            <td><?php echo $data['info1']; ?></td>
            <td><?php echo $data['info2']; ?></td>
            <td class="text-center"><?php echo $data['icon']; ?></td>
            <td class="text-center"><?php echo $data['logo']; ?></td>
            <td class="text-center"><?php echo $data['banner']; ?></td>
            <td class="text-center"><?php echo $data['banner_admin']; ?></td>
            <td class="text-center">
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_userModal"
              data-id="<?php echo $data['id']; ?>"
              data-nama="<?php echo $data['nama']; ?>"
              data-alamat="<?php echo $data['alamat']; ?>"
              data-kode_pos="<?php echo $data['kode_pos']; ?>"
              data-telp="<?php echo $data['telp']; ?>"
              data-info1="<?php echo $data['info1']; ?>"
              data-info2="<?php echo $data['info2']; ?>"
              data-icon="<?php echo $data['icon']; ?>"
              data-logo="<?php echo $data['logo']; ?>"
              data-banner="<?php echo $data['banner']; ?>"
              data-banner_admin="<?php echo $data['banner_admin']; ?>"
              data-level="<?php echo $data['level']; ?>"><i class="fas fa-edit"></i> edit</a>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
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
        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="nama">Nama Sekolah</label>
            <input type="text" class="form-control" name="nama" id="nama">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat"></textarea>
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label for="kode_pos">Kode Pos</label>
              <input type="text" class="form-control" name="kode_pos" id="kode_pos">
            </div>
            <div class="form-group col-6">
              <label for="telp">Telp</label>
              <input type="text" class="form-control" name="telp" id="telp">
            </div>
          </div>
          <div class="form-group">
            <label for="info1">Info 1</label>
            <input type="text" class="form-control" name="info1" id="info1">
          </div>
          <div class="form-group">
            <label for="info2">Info 2</label>
            <textarea class="form-control" name="info2" id="info2"></textarea>
          </div>
          <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" class="form-control" name="icon" id="icon">
          </div>
          <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" class="form-control" name="logo" id="logo">
          </div>
          <div class="form-group">
            <label for="banner">Banner</label>
            <input type="file" class="form-control" name="banner" id="banner">
          </div>
          <div class="form-group">
            <label for="banner_admin">Banner Admin</label>
            <input type="file" class="form-control" name="banner_admin" id="banner_admin">
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
    var id = $(this).attr('data-id')
    var nama = $(this).attr('data-nama')
    var alamat = $(this).attr('data-alamat')
    var kode_pos = $(this).attr('data-kode_pos')
    var telp = $(this).attr('data-telp')
    var info1 = $(this).attr('data-info1')
    var info2 = $(this).attr('data-info2')
    var icon = $(this).attr('data-icon')
    var logo = $(this).attr('data-logo')
    var banner = $(this).attr('data-banner')
    var banner_admin = $(this).attr('data-banner_admin')

    $('#id').val(id)
    $('#nama').val(nama)
    $('#alamat').val(alamat)
    $('#kode_pos').val(kode_pos)
    $('#telp').val(telp)
    $('#info1').val(info1)
    $('#info2').val(info2)
    $('#icon').val(icon)
    $('#logo').val(logo)
    $('#banner').val(banner)
    $('#banner_admin').val(banner_admin)
  })
</script>


<?php 
  if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $kode_pos = $_POST['kode_pos'];
  $telp = $_POST['telp'];
  $info1 = $_POST['info1'];
  $info2 = $_POST['info2'];
  $icon = $_FILES['icon']['name'];
  $logo = $_FILES['logo']['name'];
  $banner = $_FILES['banner']['name'];
  $banner_admin = $_FILES['banner_admin']['name'];

$icon_up = $icon;
$logo_up = $logo;
$banner_up = $banner;
$banner_admin_up = $banner_admin;

  // var_dump($icon);
  // var_dump($logo);
  // var_dump($banner);
  // var_dump($banner_admin);
// // 0000
//   if ($icon =="") {
//     if ($logo == "") {
//       if ($banner =="") {
//         if ($banner_admin =="") {
//           $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }
// // 1234
//   if ($icon !="") {
//     if ($logo != "") {
//       if ($banner !="") {
//         if ($banner_admin !="") {
//           $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',icon='$icon_up',logo='$logo_up',banner='$banner_up',banner_admin='$banner_admin_up',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }
// // 1000
//   if ($icon !="") {
//     if ($logo == "") {
//       if ($banner =="") {
//         if ($banner_admin =="") {
//           $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',icon='$icon_up',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }
// // 2000
//   if ($icon =="") {
//     if ($logo != "") {
//       if ($banner =="") {
//         if ($banner_admin =="") {
//           $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',logo='$logo_up',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }

// // 3000
//   if ($icon =="") {
//     if ($logo == "") {
//       if ($banner !="") {
//         if ($banner_admin =="") {
//           $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',banner='$banner_up',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }

//   if ($icon =="") {
//     if ($logo == "") {
//       if ($banner =="") {
//         if ($banner_admin !="") {
//          $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',banner_admin='$banner_admin_up',info1='$info1',info2='$info2' WHERE id='$id'";
//           $result = mysqli_query($koneksi, $query);
//         }
//       }
//     }
//   }





  $query = "UPDATE tb_info SET nama='$nama', alamat='$alamat',kode_pos='$kode_pos',telp='$telp',icon='$icon',logo='$logo',banner='$banner',banner_admin='$banner_admin',info1='$info1',info2='$info2' WHERE id='$id'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../index.php?page=info");
      }
}
 ?>
