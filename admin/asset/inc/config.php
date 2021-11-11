<?php
$DB_host = "localhost";
$DB_name = "db_pembayaran";
$DB_username = "root";
$DB_password = "";

// $DB_host = "localhost:3306";
// $DB_name = "jyinsmwo_pembayaran";
// $DB_username = "jyinsmwo_pembayaran";
// $DB_password = "smkmu_pembayaran";

$_SESSION['db_host'] = $DB_host;
$_SESSION['db_name'] = $DB_name;
$_SESSION['db_username'] = $DB_username;
$_SESSION['db_password'] = $DB_password;

$koneksi = mysqli_connect($DB_host, $DB_username, $DB_password, $DB_name); 
if (mysqli_connect_errno())
	{
		echo "Koneksi Gagal".mysqli_connect_error();
	}
?>
