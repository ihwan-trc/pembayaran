<h1 class="h5 mb-4 text-gray-800">RESET SYSTEM</h1>
<div class="card shadow mb-4">
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="backup-tab" data-toggle="tab" href="#backup" role="tab" aria-controls="backup" aria-selected="true">BACKUP</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="backup" role="tabpanel" aria-labelledby="backup-tab">
        <div class="my-4">
          <p>- Mengembalikan pengaturan sistem ke pengaturan awal (default)<br/>
            - Semua data yang telah diinput akan terhapus<br/>
            - Username = admin<br/>
            - Password = admin<br/>
            <font style="color: red; font-style: italic;">Pastikan anda sudah backup terlebih dahulu sebelum melakukan reset! </font></p>
           <form method="post" action="index.php?page=proses_reset">
            <button type="submit" class="btn tbn-sm btn-danger" name="reset" onclick="return confirm('Yakin Untuk Reset?')"><i class="fas fa fa-undo fa-sm fa-fw mr-2 text-gray-400"></i>Reset</button>
           </form>
        </div>
      </div>
    </div>
  </div>
</div>