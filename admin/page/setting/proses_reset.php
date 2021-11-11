<?php 
session_start();
 ?>

<style type="text/css">
    #bungkustext
{   width:100%; margin: auto; padding: 10px 20px;
    text-align:left;background-Color:gray; color:#ffffff; font-size:24px; 
}
</style>
<script type="text/javascript">
    var kedipan = 500; 
    var dumet = setInterval(function () {
    var ele = document.getElementById('textkedip');
    ele.style.visibility = (ele.style.visibility == 'hidden' ? '' : 'hidden');
    }, kedipan);
</script>


<div id="bungkustext">
  <div id="textkedip">Silahkan tunggu, Proses Reset sedang berjalan . . .</div>
</div>

<div class="card shadow mb-4">

  <div class="card-body">
<!-- EXTRACT ZIP -->
<?php 
 // Replace Database-------

define("DB_USER", $_SESSION['db_username']);
define("DB_PASSWORD", $_SESSION['db_password']);
define("DB_NAME", $_SESSION['db_name']);
define("DB_HOST", $_SESSION['db_host']);
define("BACKUP_DIR", 'asset/db_default');
define("BACKUP_FILE", 'jyinsmwo_pembayaran.sql.gz');
define("CHARSET", 'utf8');
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails

class Restore_Database {
    var $host;
    var $username;
    var $passwd;
    var $dbName;
    var $charset;
    var $conn;
    var $disableForeignKeyChecks;

    function __construct($host, $username, $passwd, $dbName, $charset = 'utf8') {
        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = defined('BACKUP_DIR') ? BACKUP_DIR : '.';
        $this->backupFile              = defined('BACKUP_FILE') ? BACKUP_FILE : null;
    }

    function __destructor() {

        if ($this->disableForeignKeyChecks === true) {
            mysqli_query($this->conn, 'SET foreign_key_checks = 1');
        }
    }
    protected function initializeDatabase() {
        try {
            $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
            if (mysqli_connect_errno()) {
                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                die();
            }
            if (!mysqli_set_charset($conn, $this->charset)) {
                mysqli_query($conn, 'SET NAMES '.$this->charset);
            }

            if ($this->disableForeignKeyChecks === true) {
                mysqli_query($conn, 'SET foreign_key_checks = 0');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $conn;
    }

    public function restoreDb() {
        try {
            $sql = '';
            $multiLineComment = false;
            $backupDir = $this->backupDir;
            $backupFile = $this->backupFile;
            /**
             * Gunzip file if gzipped
             */
            $backupFileIsGzipped = substr($backupFile, -3, 3) == '.gz' ? true : false;
            if ($backupFileIsGzipped) {
                if (!$backupFile = $this->gunzipBackupFile()) {
                    throw new Exception("ERROR: couldn't gunzip backup file " . $backupDir . '/' . $backupFile);
                }
            }

            $handle = fopen($backupDir . '/' . $backupFile, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $line = ltrim(rtrim($line));
                    if (strlen($line) > 1) { // avoid blank lines
                        $lineIsComment = false;
                        if (preg_match('/^\/\*/', $line)) {
                            $multiLineComment = true;
                            $lineIsComment = true;
                        }
                        if ($multiLineComment or preg_match('/^\/\//', $line)) {
                            $lineIsComment = true;
                        }
                        if (!$lineIsComment) {
                            $sql .= $line;
                            if (preg_match('/;$/', $line)) {
                                // execute query
                                if(mysqli_query($this->conn, $sql)) {
                                    if (preg_match('/^CREATE TABLE `([^`]+)`/i', $sql, $tableName)) {
                                        $this->obfPrint("Table succesfully created: `" . $tableName[1] . "`");
                                    }
                                    $sql = '';
                                } else {
                                    throw new Exception("ERROR: SQL execution error: " . mysqli_error($this->conn));
                                }
                            }
                        } else if (preg_match('/\*\/$/', $line)) {
                            $multiLineComment = false;
                        }
                    }
                }
                fclose($handle);
            } else {
                throw new Exception("ERROR: couldn't open backup file " . $backupDir . '/' . $backupFile);
            } 
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        if ($backupFileIsGzipped) {
            unlink($backupDir . '/' . $backupFile);
        }
        return true;
    }

    protected function gunzipBackupFile() {
        // Raising this value may increase performance
        $bufferSize = 4096; // read 4kb at a time
        $error = false;
        $source = $this->backupDir . '/' . $this->backupFile;
        $dest = $this->backupDir . '/' . date("Ymd_His", time()) . '_' . substr($this->backupFile, 0, -3);
        $this->obfPrint('Gunzipping backup file ' . $source . '... ', 1, 1);
        // Remove $dest file if exists
        if (file_exists($dest)) {
            if (!unlink($dest)) {
                return false;
            }
        }
 
        // Open gzipped and destination files in binary mode
        if (!$srcFile = gzopen($this->backupDir . '/' . $this->backupFile, 'rb')) {
            return false;
        }
        if (!$dstFile = fopen($dest, 'wb')) {
            return false;
        }
        while (!gzeof($srcFile)) {
            // Read buffer-size bytes
            // Both fwrite and gzread are binary-safe
            if(!fwrite($dstFile, gzread($srcFile, $bufferSize))) {
                return false;
            }
        }
        fclose($dstFile);
        gzclose($srcFile);
        // Return backup filename excluding backup directory
        return str_replace($this->backupDir . '/', '', $dest);
    }

    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }
        $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        $output = '';
        if (php_sapi_name() != "cli") {
            $lineBreak = "<br />";
        } else {
            $lineBreak = "\n";
        }
        if ($lineBreaksBefore > 0) {
            for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                $output .= $lineBreak;
            }                
        }
        $output .= $msg;
        if ($lineBreaksAfter > 0) {
            for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                $output .= $lineBreak;
            }                
        }
        if (php_sapi_name() == "cli") {
            $output .= "\n";
        }
        echo $output;
        if (php_sapi_name() != "cli") {
            ob_flush();
        }
        flush();
    }
}

// Report all errors
error_reporting(E_ALL);
// Set script max execution time
set_time_limit(900); // 15 minutes
if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}
$restoreDatabase = new Restore_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$result = $restoreDatabase->restoreDb(BACKUP_DIR, BACKUP_FILE) ? 'OK' : 'Failed';
$restoreDatabase->obfPrint("Restoration result: ".$result, 1);
if (php_sapi_name() != "cli") {
    echo '</div>';
}

// .................................Hapus File yang ada di directory...........................

    $files =glob('../assets/images/siswa/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../assets/images/baak/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }

?>
<script type="text/javascript">
  alert("Reset berhasil! Kembali ke pengaturan awal! username : admin | password : admin");
  window.location = "index.php?page=dashboard";
</script> 
  </div>
</div>