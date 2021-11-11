<?php 
session_start();
include "../../asset/inc/config.php";

if (isset($_POST['reset'])) {
  $id_user = $_POST['rst_id_user'];
  $nama_user = $_POST['rst_namauser'];

  $query = "SELECT * FROM tb_baak WHERE nama_pegawai ='$nama_user'";
  $result = mysqli_query($koneksi, $query);
  while($data = mysqli_fetch_assoc($result)){
    $nip = $data['nip'];
  
  $hash = password_hash($nip, PASSWORD_DEFAULT);

  $query = "UPDATE tb_user SET username='$nip',password='$hash' WHERE id_user='$id_user'";
  $result = mysqli_query($koneksi, $query);
  if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {
        echo "<script>alert(' Akun berhasil direset!');
        window.location='../../index.php?page=user'</script>";
      }
  }
}
 ?>