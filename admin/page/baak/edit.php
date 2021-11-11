<?php 
include_once("../../asset/inc/config.php");

if (isset($_POST['update'])) {
	$id_pegawai = $_POST['id_pegawai'];
	$nip = $_POST['nip'];
  $nama_pegawai = $_POST['nama_pegawai'];
  $jabatan = $_POST['jabatan'];
  $foto = $_FILES['foto']['name'];

  //cek dulu jika ada file jalankan coding ini
  if($foto != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $foto); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_foto_tmp = $_FILES['foto']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoExt = substr($foto, strrpos($foto, '.')); 
    $fotoExt = str_replace('.','',$fotoExt); // Extension
    $foto = preg_replace("/\.[^.\s]{3,4}$/", "", $foto);  
    $nama_foto_baru = "foto_".$nip.'.'.$acak.'.'.$fotoExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_foto_tmp, '../../asset/images/baak/'.$nama_foto_baru)){
      // Query untuk menampilkan data foto berdasarkan id_pegawai yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_baak WHERE id_pegawai='".$id_pegawai."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("../../asset/images/baak/".$data['foto'])) // Jika file ada
        unlink("../../asset/images/baak/".$data['foto']); // Hapus file sebelumnya yang ada di folder foto

      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_baak SET foto='$nama_foto_baru' WHERE id_pegawai='$id_pegawai'");
        
      }
    }
  }
  $result = mysqli_query($koneksi, "UPDATE tb_baak SET nip='$nip',nama_pegawai='$nama_pegawai',jabatan='$jabatan' WHERE id_pegawai='$id_pegawai'");

        header("Location:../../index.php?page=baak");
}
 ?>