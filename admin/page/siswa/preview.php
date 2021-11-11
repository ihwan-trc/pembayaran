<?php 
  if (isset($_POST['preview'])) {
  $kelas_post = $_POST['kelas'];
  $jurusan_post = $_POST['jurusan'];
?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <table>
      <tr>
        <td><b>Kelas</b></td>
        <td><b>: <?= $kelas_post; ?></b></td>
      </tr>
      <tr>
        <td><b>Jurusan</b></td>
        <td><b>: <?= $jurusan_post; ?></b></td>
      </tr>
      <tr>
        <td><form method='post' class='d-sm-inline-block form-inline' action="index.php?page=siswa">
              <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
              <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
              <button class="btn btn-sm btn-danger" type="submit" name="search"><i class="fas fa-backward"></i> Back
              </button>
            </form>
        </td>
        <td><form method='post' class='d-sm-inline-block form-inline' action="page/siswa/print.php" target="blank">
              <input type="hidden" name="kelas" value="<?= $kelas_post; ?>">
              <input type="hidden" name="jurusan" value="<?= $jurusan_post; ?>">
              <button class="btn btn-sm btn-primary" type="submit" name="print"><i class="fas fa-print"></i> Print
              </button>
            </form>
        </td>
      </tr>
    </table>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class='table table-bordered'>
        <thead>
          <tr>
            <th colspan='5' class='text-center'>Preview Data</th>
          </tr>
          <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>NAMA SISWA</th>
            <th>KELAS</th>
            <th>JURUSAN</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $no = 1;
          $query = "SELECT * FROM tb_siswa WHERE kelas='$kelas_post' AND jurusan='$jurusan_post' ORDER BY id_siswa ASC";
          $result = mysqli_query($koneksi, $query);
          while ($data=mysqli_fetch_assoc($result)) {           
        ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nis']; ?></td>
            <td><?= $data['nama_siswa']; ?></td>
            <td><?= $data['kelas']; ?></td>
            <td><?= $data['jurusan']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php } ?>