<?php 
include "../../asset/inc/config.php";
$query = mysqli_query($koneksi,"SELECT * FROM tb_info");
    while ($data = mysqli_fetch_assoc($query)) {
      $nama = $data['nama'];
      $alamat = $data['alamat'];
      $kode_pos = $data['kode_pos'];
      $telp = $data['telp'];
      $icon = $data['icon'];
      $logo = $data['logo'];
    }
    if (isset($_POST['print'])) { ?>
<link rel="shortcut icon" href="../../asset/img/<?= $icon ?>" type="image/x-icon">
<!DOCTYPE html>
<html>
<head>
    <title>DATA SISWA</title>
    <style type="text/css">
        table {
            border-style: double;
            border-width: 3px;
            border-color: white;
        }
        table tr .text2 {
            text-align: right;
            font-size: 13px;
        }
        table tr .text {
            text-align: center;
            font-size: 13px;
        }
        table tr td {
            font-size: 13px;
        }

.border {
    border-collapse: collapse;
    border: 1px solid black;
}
#halaman{
    width: 640;
    border: 1px solid; 
    padding-top: 10px; 
    padding-left: 20px; 
    padding-right: 20px; 
    padding-bottom: 20px;
        }


    </style>
</head>
<body>
    <center>
      <div id=halaman>
        <table width="625">
            <tr>
                <td><img src="../../asset/img/<?= $logo ?>" width="80" height="80"></td>
                <td>
                <center>
                    <font size="4"><b><?= $nama ?></b></font><br>
                    <font size="2">Bidang Keahlian : Multimedia - Teknik Kendaraan Ringan Otomotif</font><br>
                    <font size="2"><?= $alamat?> <?= $kode_pos ?></font>
                    <font size="2">Telp : <?= $telp ?> <br><font color="blue">https://www.smkmu.sch.id/</font></font>
                </center>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
        </table>
        <h4>DATA BAAK</h4>


  <table class="border" width="625">
    <thead>
      <tr bgcolor="#e6e4df">
        <th class="border">NO</th>
        <th class="border">NIP</th>
        <th class="border">NAMA PEGAWAI</th>
        <th class="border">JABATAN</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $no = 1; 
        $query = "SELECT * FROM tb_baak ORDER BY id_pegawai ASC";
        $result = mysqli_query($koneksi, $query);
        while ($data=mysqli_fetch_assoc($result)) {
        ?>
      <tr>
        <td class="border" align="center"><?=$no; ?></td>
        <td class="border"><?= $data['nip']; ?></td>
        <td class="border"><?= $data['nama_pegawai']; ?></td>
        <td class="border"><?=$data['jabatan'];?></td>
      </tr>
      <?php $no++; } ?>
    </tbody>
  </table>
  <br>
   <table width="625">
       <tr>
           <td>
            <?php 
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('d/m/Y h:i');
           ?>
            Cetak : <?= $tanggal; ?>
           </td>
       </tr>
   </table>
  </div>
</center>
</body>
</html>
<script type="text/javascript">
  window.print();
</script>
<?php } ?>