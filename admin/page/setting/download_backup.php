<?php
session_start();
$error = ""; 
if (isset($_POST['backup'])) {

define("DB_USER", $_SESSION['db_username']);
define("DB_PASSWORD", $_SESSION['db_password']);
define("DB_NAME", $_SESSION['db_name']);
define("DB_HOST", $_SESSION['db_host']);
define("BACKUP_DIR", 'backup_db/'); // Comment this line to use same script's directory ('.')
define("TABLES", '*'); // Full backup
//define("TABLES", 'table1, table2, table3'); // Partial backup
define("CHARSET", 'utf8');
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails
define("BATCH_SIZE", 1000); // Batch size when selecting rows from database in order to not exhaust system memory
                            // Also number of rows per INSERT statement in backup file

class Backup_Database {

    var $host;
    var $username;
    var $passwd;
    var $dbName;
    var $charset;
    var $conn;
    var $backupDir;
    var $backupFile;
    var $gzipBackupFile;
    var $output;
    var $disableForeignKeyChecks;
    var $batchSize;

    public function __construct($host, $username, $passwd, $dbName, $charset = 'utf8') {
        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = BACKUP_DIR ? BACKUP_DIR : '.';
        $this->backupFile              = $this->dbName.'.sql';
        $this->gzipBackupFile          = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
        $this->batchSize               = defined('BATCH_SIZE') ? BATCH_SIZE : 1000; // default 1000 rows
        $this->output                  = '';
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
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $conn;
    }

    public function backupTables($tables = '*') {
        try {
            /**
             * Tables to export
             */
            if($tables == '*') {
                $tables = array();
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
            }
            $sql = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbName."`;\n\n";
            $sql .= 'USE `'.$this->dbName."`;\n\n";
            /**
             * Disable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 0;\n\n";
            }
            /**
             * Iterate tables
             */
            foreach($tables as $table) {
                // $this->obfPrint("Backing up `".$table."` table...".str_repeat('.', 50-strlen($table)), 0, 0);
                /**
                 * CREATE TABLE
                 */
                $sql .= 'DROP TABLE IF EXISTS `'.$table.'`;';
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `'.$table.'`'));
                $sql .= "\n\n".$row[1].";\n\n";
                /**
                 * INSERT INTO
                 */
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `'.$table.'`'));
                $numRows = $row[0];
                // Split table in batches in order to not exhaust system memory 
                $numBatches = intval($numRows / $this->batchSize) + 1; // Number of while-loop calls to perform
                for ($b = 1; $b <= $numBatches; $b++) {
 
                    $query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($b * $this->batchSize - $this->batchSize) . ',' . $this->batchSize;
                    $result = mysqli_query($this->conn, $query);
                    $realBatchSize = mysqli_num_rows ($result); // Last batch size can be different from $this->batchSize
                    $numFields = mysqli_num_fields($result);
                    if ($realBatchSize !== 0) {
                        for ($i = 0; $i < $numFields; $i ++) {
                        while ($row = mysqli_fetch_row($result)) {
                            $sql .= "INSERT INTO $table VALUES(";
                            for ($j = 0; $j < $numFields; $j ++) {
                                $row[$j] = $row[$j];
                                
                                if (isset($row[$j])) {
                                    $sql .= '"' . $row[$j] . '"';
                                } else {
                                    $sql .= '""';
                                }
                                if ($j < ($numFields - 1)) {
                                    $sql .= ',';
                                }
                            }
                            $sql .= ");\n";
                        }
                    }
 
                        $this->saveFile($sql);
                        $sql = '';
                    }
                }

                $sql.="\n\n";
                // $this->obfPrint('OK');
            }
            /**
             * Re-enable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 1;\n";
            }
            $this->saveFile($sql);
            if ($this->gzipBackupFile) {
                $this->gzipBackupFile();
            } else {
                $this->obfPrint('Backup file succesfully saved to ' . $this->backupDir.'/'.$this->backupFile, 1, 1);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        return true;
    }
    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql) {
        if (!$sql) return false;
        try {
            if (!file_exists($this->backupDir)) {
                mkdir($this->backupDir, 0777, true);
            }
            file_put_contents($this->backupDir.'/'.$this->backupFile, $sql, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        return true;
    }

    protected function gzipBackupFile($level = 9) {
        if (!$this->gzipBackupFile) {
            return true;
        }
        $source = $this->backupDir . '/' . $this->backupFile;
        $dest =  $source . '.gz';
        // $this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);
        $mode = 'wb' . $level;
        if ($fpOut = gzopen($dest, $mode)) {
            if ($fpIn = fopen($source,'rb')) {
                while (!feof($fpIn)) {
                    gzwrite($fpOut, fread($fpIn, 1024 * 256));
                }
                fclose($fpIn);
            } else {
                return false;
            }
            gzclose($fpOut);
            if(!unlink($source)) {
                return false;
            }
        } else {
            return false;
        }
 
        // $this->obfPrint('OK');
        return $dest;
    }
    /**
     * Prints message forcing output buffer flush
     *
     */
    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }
        // if ($msg != 'OK' and $msg != 'KO') {
        //     $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        // }
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
        // Save output for later use
        $this->output .= str_replace('<br />', '\n', $output);
        echo $output;
        if (php_sapi_name() != "cli") {
            if( ob_get_level() > 0 ) {
                ob_flush();
            }
        }
        $this->output .= " ";
        flush();
    }
    /**
     * Returns full execution output
     *
     */
    public function getOutput() {
        return $this->output;
    }
}
/**
 * Instantiate Backup_Database and perform backup
 */
// Report all errors
error_reporting(E_ALL);
// Set script max execution time
set_time_limit(900); // 15 minutes
if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}
$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, CHARSET);
$result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
// $backupDatabase->obfPrint('Backup result: ' . $result, 1);
// Use $output variable for further processing, for example to send it by email
$output = $backupDatabase->getOutput();
if (php_sapi_name() != "cli") {
    echo '</div>';
}

include_once("../../asset/inc/config.php");

    $query = "SELECT * FROM tb_user";
    $hasil  = mysqli_query($koneksi, $query);
      while($data = mysqli_fetch_assoc($hasil)){
      $filename    = $data['username'];
      // OUTPUT
      $back_dir_siswa ="../../asset/images/siswa/";
      $back_dir_baak ="../../asset/images/baak/";
      $back_dir_db    ="backup_db/";

      if(extension_loaded('zip')) {   //memeriksa ekstensi zip
          if(isset($filename)) {   //memeriksa file yang dipilih
               $zip = new ZipArchive(); // Load zip library  
               $zip_name = "Backup_".date('d-m-Y').".zip";  // nama Zip  
               if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE) {   //Membuka file zip untuk memuat file
                    $error .= "* Maaf Download ZIP gagal"; 
               } 
                // query siswa
                $query  = "SELECT * FROM tb_siswa ORDER BY id_siswa DESC";
                $hasil  = mysqli_query($koneksi, $query);
                  while($data = mysqli_fetch_assoc($hasil)){
                    $foto_siswa= $data['foto'];
                  if ($foto_siswa != "") {
                   foreach(array($foto_siswa) as $file){  
                      $zip->addFile($back_dir_siswa.$file);
                    }
                  }
                }
                // query baak
                $query  = "SELECT * FROM tb_baak ORDER BY id_pegawai DESC";
                $hasil  = mysqli_query($koneksi, $query);
                  while($data = mysqli_fetch_assoc($hasil)){
                    $foto_baak= $data['foto'];
                  if ($foto_baak != "") {
                   foreach(array($foto_baak) as $file){  
                      $zip->addFile($back_dir_baak.$file);
                    }
                  }
                }

                    $database_name = $_SESSION['db_name'].".sql.gz";
                    foreach(array($database_name) as $file){  
                    $zip->addFile($back_dir_db.$file);
                    }
          }

        $zip->close(); 
         if (file_exists($zip_name)) {
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename='.basename($zip_name));
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: private');
          header('Pragma: private');
          header('Content-Length: ' . filesize($zip_name));
          ob_clean();
          flush();
          readfile($zip_name);
          unlink($zip_name);
          unlink('backup_db/'.$_SESSION['db_name'].'.sql.gz');
          exit;
        } 
      }
    } 
  }

?>