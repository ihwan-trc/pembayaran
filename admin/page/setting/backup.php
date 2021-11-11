<h1 class="h5 mb-4 text-gray-800">BACKUP & RESTORE DATABASE</h1>
<div class="card shadow mb-4">
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="backup-tab" data-toggle="tab" href="#backup" role="tab" aria-controls="backup" aria-selected="true">BACKUP</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="restore-tab" data-toggle="tab" href="#restore" role="tab" aria-controls="restore" aria-selected="false">RESTORE</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="backup" role="tabpanel" aria-labelledby="backup-tab">
        <div class="my-4">
          <p><b>Backup</b> semua data yang ada didalam database.</p>
           <form class="" method="post" action="page/setting/download_backup.php">
            <button type="submit" class="btn tbn-sm btn-info" name="backup">Backup</button>
           </form>
        </div>
      </div>
      <div class="tab-panel fade" id="restore" role="tabpanel" aria-labelledby="restore-tab">
        <div class="my-4">
          <p><b>Restore</b> semua data yang ada didalam database.</p>
          <p>File Backup Database (*.zip)</p>
          <form method="POST" action="index.php?page=restore" enctype="multipart/form-data" >
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="db" name="file_zip" required="" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
            <button type="submit" class="btn tbn-sm btn-success" name="restore">Restore</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
var uploadField = document.getElementById("db");
uploadField.onchange = function() {
  var inputFile = document.getElementById('db');
  var pathFile = inputFile.value;
  var ekstensiOk = /(\.zip)$/i;
  if(!ekstensiOk.exec(pathFile)){
      alert('Silahkan upload file yang memiliki ekstensi .zip');
      inputFile.value = '';
      return false;
  }
};
</script>