<?php

    // Check If form submitted, insert form data into users table.
    if(isset($_POST['tambah'])) {
        $nama_user = $_POST['nama_user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $level = $_POST['level'];

        // include database connection file
        include_once("../../asset/inc/config.php");

        // Insert barang data into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_user(username,password,level,nama_user) VALUES('$username','$hash','$level','$nama_user')");

        // Show message when user added
        header("Location:../../index.php?page=user");
    }
    ?>