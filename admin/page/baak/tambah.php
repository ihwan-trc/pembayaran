<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['tambah']))
{
    $foto = $_FILES['foto']['name'];
    $nip = $_POST['nip'];
    $nama_pegawai = $_POST['nama'];
    // $kelas = 'X';
    $jabatan = $_POST['jabatan'];

// include database connection file
include_once("../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($foto != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $foto); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_foto_tmp = $_FILES['foto']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoExt = substr($foto, strrpos($foto, '.')); 
    $fotoExt = str_replace('.','',$fotoExt); // Extension
    $foto = preg_replace("/\.[^.\s]{3,4}$/", "", $foto); 
    $nama_foto_baru = "foto_".$nip.'.'.$acak.'.'.$fotoExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_foto_tmp, '../../asset/images/baak/'.$nama_foto_baru); //memindah file ke folder file/rpd
    }
  }
  

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_baak(nip,nama_pegawai,jabatan,foto) VALUES('$nip','$nama_pegawai','$jabatan','$nama_foto_baru')");

        // Show message when user added
        header("Location:../../index.php?page=baak");

}
?>