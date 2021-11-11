<?php 
session_start();
include "../../asset/inc/config.php";

if (isset($_POST['submit'])) {
  $id_user = $_SESSION['id_user'];
  $username = $_POST['username'];
  $pass_lama = $_POST['pass_lama'];
  $pass_baru = $_POST['pass_baru'];
  $konfirmasi = $_POST['konfirmasi'];
  $hash = password_hash($pass_baru, PASSWORD_DEFAULT);

  $query = "SELECT * FROM tb_user WHERE id_user='$id_user'";
  $result = mysqli_query($koneksi, $query);
  while($data = mysqli_fetch_assoc($result)){
    $hasil = $data["password"];
    $verf= password_verify($pass_lama, $hasil);
    if ($verf == true) {
      mysqli_query($koneksi,"UPDATE tb_user SET username='$username', password='$hash' WHERE id_user='$id_user'");
      echo "<script>
          alert('berhasil')</script>";
    }else{
      echo "<script>
          alert('gagal')</script>";
    }
  }
}
 ?>

<div class="row">
  <div class="col-4 offset-4">
    <div class="card">
      <div class="card-header">
        Ganti Password
      </div>
      <?php
        $user =$_SESSION['id_user'];
        $query = "SELECT * FROM tb_user WHERE id_user='$user'";
        $result = mysqli_query($koneksi, $query);
        while($data = mysqli_fetch_assoc($result)){
          $uname = $data['username'];
        }
       ?>
      <div class="card-body">
        <form action="" method="post">
        <div class="form-group">
          <label for="pass_lama">Username</label>
          <input type="text" name="username" class="form-control" value=<?= $uname; ?>>
        </div>
        <div class="form-group">
          <label for="pass_lama">Password Lama</label>
          <input type="password" name="pass_lama" class="form-control">
        </div>
        <div class="form-group">
          <label for="pass_baru">Password Baru</label>
          <input type="password" name="pass_baru" class="form-control">
        </div>
        <div class="form-group">
          <label for="konfirmasi">Konfrimasi Password</label>
          <input type="password" name="konfirmasi" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>