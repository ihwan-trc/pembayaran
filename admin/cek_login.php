<?php 
session_start();

// menghubungkan php dengan koneksi database
include 'asset/inc/config.php';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST['login'])) {
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * from tb_user WHERE username='$username'";
  $result = mysqli_query($koneksi, $query);
  while($data = mysqli_fetch_assoc($result)){
  	$usernamedata = $data['username'];
  	$hasil = $data["password"];
 	$verf= password_verify($password, $hasil);
 	$_SESSION['id_user']	= $data['id_user'];
	$_SESSION['username']	= $data['username'];
	$_SESSION['nama_user']	= $data['nama_user'];
	$_SESSION['level']		= $data['level'];
  }
  	// var_dump($usernamedata);
  	if ($usernamedata == NULL) {
  		 echo "<script>
	 			alert('Login Failed. Username & password tidak sesuai...!');
	 			document.location='logout.php';
	 		</script>";
  	}
  	if ($verf == true) {
  		header("location:index.php?page=dashboard");
  	}else{
       echo "<script>
	 			alert('Login Failed. Username & password tidak sesuai...!');
	 			document.location='logout.php';
	 		</script>";
     }
}

?>