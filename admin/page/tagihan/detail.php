<?php
include "../../asset/inc/config.php";
if (isset($_POST['hapus'])) {
    $id_pembayaran_hapus = $_POST['id_pembayaran_hapus'];
    // $id_tagihan_siswa_hapus = $_POST['id_tagihan_siswa_hapus'];
    $kelas_back = $_POST['kelas_back'];
    $jurusan_back = $_POST['jurusan_back'];


    $query1 = mysqli_query($koneksi,"DELETE FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran_hapus' ");
  //   if ($id_tagihan_siswa_hapus !== NULL) {
  //     $query2 = mysqli_query($koneksi,"DELETE FROM tb_tagihan_siswa WHERE id_tagihan_siswa='$id_tagihan_siswa_hapus' ");
  // }
    ?>
    <form action="../../index.php?page=tagihan" method="post" enctype="multipart/form-data" name="myform">
        <input type="hidden" name="kelas_back" value="<?=$kelas_back;?>">
        <input type="hidden" name="jurusan_back" value="<?=$jurusan_back;?>">
        <input type="hidden" name="back">
        <script type="text/javascript">
            document.myform.submit();
        </script>
    </form>
<?php
}
?>