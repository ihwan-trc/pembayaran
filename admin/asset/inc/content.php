<?php

$page = $_GET["page"];
$action = $_GET["action"];

if ($page == "dashboard") {
    include "dashboard.php";
  }
  
  elseif ($page == "import_jenis_tagihan_umum") {
    include "page/import/import_jenis_tagihan_umum.php";
  }
  elseif ($page == "import_jenis_tagihan_siswa") {
    include "page/import/import_jenis_tagihan_siswa.php";
  }
  // ===========================================
  elseif ($page == "import_pembayaran") {
    include "page/import/import_pembayaran_umum.php";
  }
  elseif ($page == "import_pembayaran_umum") {
    include "page/import/import_pembayaran_umum.php";
  }
  elseif ($page == "import_pembayaran_siswa") {
    include "page/import/import_pembayaran_siswa.php";
  }
  elseif ($page == "import_tunggakan_umum") {
    include "page/import/import_tunggakan_umum.php";
  }
  elseif ($page == "import_tunggakan_siswa") {
    include "page/import/import_tunggakan_siswa.php";
  }
  elseif ($page == "import_tunggakan") {
    include "page/import/import_tunggakan_umum.php";
  }
  elseif ($page == "proses_import_pembayaran_umum") {
    include "page/import/proses_import_pembayaran.php";
  }
  elseif ($page == "proses_import_pembayaran_siswa") {
    include "page/import/proses_import_pembayaran.php";
  }
  elseif ($page == "proses_import_tunggakan") {
    include "page/import/proses_import_tunggakan.php";
  }

  elseif ($page == "siswa") {
      include "page/siswa/siswa.php";
  }elseif ($page == "kelas") {
      include "page/kelas/kelas.php";
  }elseif ($page == "jurusan") {
      include "page/kelas/kelas.php";
  }elseif ($page == "import_siswa") {
    include "page/siswa/import.php";
  }elseif ($page == "siswa_print") {
    include "page/siswa/preview.php";
  }
// __________________END SISWA_______

  elseif ($page == "baak") {
    include "page/baak/baak.php";
  }elseif ($page == "import_baak") {
    include "page/baak/import.php";
  }
  // __________________END BAAK_______

  elseif ($page == "jenis_tagihan") {
    include "page/jenis_tagihan/jenis_tagihan.php";
  }elseif ($page == "detail") {
    include "page/tagihan/detail.php";
  }elseif ($page == "rincian_tagihan") {
    include "page/tagihan/rincian.php";
  }elseif ($page == "tagihan") {
    include "page/tagihan/proses_tagihan.php";
  }elseif ($page == "jenis_tagihan_siswa") {
    include "page/jenis_tagihan_siswa/jenis_tagihan_siswa.php";
  }elseif ($page == "rincian_preview") {
    include "page/tagihan/preview_rincian.php";
  }

  elseif ($page == "bayar") {
    include "page/tagihan/bayar.php";
  }
  // __________________END TAGIHAN_______

  elseif ($page == "pembayaran") {
      include "page/laporan/pembayaran.php";
  }elseif ($page == "rincian_pembayaran") {
      include "page/laporan/rincian_pembayaran.php";   
  }elseif ($page == "pembayaran_preview") {
    include "page/laporan/pembayaran_preview.php";
  }elseif ($page == "rincian_pembayaran_preview") {
    include "page/laporan/rincian_pembayaran_preview.php";
  }

  elseif ($page == "tunggakan") {
      include "page/laporan/tunggakan.php";
  }elseif ($page == "rincian_tunggakan") {
      include "page/laporan/rincian_tunggakan.php";
  }elseif ($page == "tunggakan_preview") {
    include "page/laporan/tunggakan_preview.php";
  }elseif ($page == "rincian_tunggakan_preview") {
    include "page/laporan/rincian_tunggakan_preview.php";
  }
  // __________________END LAPORAN_______


  elseif ($page == "ganti_pass") {
    include "page/setting/ganti_pass.php";
  }
  // __________________END GANTI PASSWORD_______


  elseif ($page == "backup") {
    include "page/setting/backup.php";
  }
  elseif ($page == "restore") {
    include "page/setting/restore.php";
  }
  // __________________END GANTI BACKUP - RESTORE_______


  
  elseif ($page == "user") {
    include "page/setting/user.php";
  }
  // __________________END USER_______

  elseif ($page == "info") {
    include "page/setting/info.php";
  }
  // __________________END USER_______


  
  elseif ($page == "reset_default") {
    include "page/setting/reset_default.php";
  }
  elseif ($page == "proses_reset") {
    include "page/setting/proses_reset.php";
  }
  // __________________END RESET DEFAULT_______
  elseif ($page == "petunjuk") {
    include "petunjuk.php";
  }