<?php 
include_once("../../asset/inc/config.php");

if (isset($_POST['edit'])) {
	$id_siswa = $_POST['id_siswa'];
	$nis = $_POST['nis'];
  $nama_siswa = $_POST['nama_siswa'];
  $kelas = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];
  $foto = $_FILES['foto']['name'];

  //cek dulu jika ada file jalankan coding ini
  if($foto != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $foto); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_foto_tmp = $_FILES['foto']['tmp_name'];   
    $acak = rand(000, 999);
    $fotoExt = substr($foto, strrpos($foto, '.')); 
    $fotoExt = str_replace('.','',$fotoExt); // Extension
    $foto = preg_replace("/\.[^.\s]{3,4}$/", "", $foto);  
    $nama_foto_baru = "foto_".$nis.'.'.$acak.'.'.$fotoExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_foto_tmp, '../../asset/images/siswa/'.$nama_foto_baru)){
      // Query untuk menampilkan data foto berdasarkan id_siswa yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_siswa='".$id_siswa."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("../../asset/images/siswa/".$data['foto'])) // Jika file ada
        unlink("../../asset/images/siswa/".$data['foto']); // Hapus file sebelumnya yang ada di folder foto

      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_siswa SET foto='$nama_foto_baru' WHERE id_siswa='$id_siswa'");
        
      }
    }
  }
  $result = mysqli_query($koneksi, "UPDATE tb_siswa SET nis='$nis',nama_siswa='$nama_siswa',kelas='$kelas',jurusan='$jurusan' WHERE id_siswa='$id_siswa'");

        header("Location:../../index.php?page=siswa");
}
 ?>