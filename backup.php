<?php
$page = 'Home';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';


date_default_timezone_set('Asia/Manila');
$d = date("Y-m-d");
$t = date("h:i:s A");
if ($_SESSION['userType'] != 1) {
    if (!isset($_SESSION['fullname'])) {
        header("Location: index.php");
    } else {
        header("Location: home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/client.js"></script>
</head>

<body>

    <?php
    include_once 'assets/includes/navigation.php';
    include_once 'assets/includes/side_navigation.php';
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Backup And Restore</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Backup And Restore</li>
                    <li class="breadcrumb-item active">Backup</li>
                </ol>
            </nav>
        </div>
        <a href="backupAndRestore.php" type="button" class="btn btn-primary mb-2"><i class='bx bx-arrow-back'></i>Back</a>
        <section class="section dashboard">
            <div class="row">
                <?php
                /**
                 * This file contains the Backup_Database class wich performs
                 * a partial or complete backup of any given MySQL database
                 * @author Daniel López Azaña <daniloaz@gmail.com>
                 * @version 1.0
                 */
                /**
                 * Define database parameters here
                 */
                define("DB_USER", 'root');
                define("DB_PASSWORD", '');
                define("DB_NAME", 'aitech_payment');
                define("DB_HOST", 'localhost');
                define("BACKUP_DIR", 'backup'); // Comment this line to use same script's directory ('.')
                define("TABLES", '*'); // Full backup
                //define("TABLES", 'table1 table2 table3'); // Partial backup
                define("CHARSET", 'utf8');
                define("GZIP_BACKUP_FILE", true);  // Set to false if you want plain SQL backup files (not gzipped)
                /**
                 * The Backup_Database class
                 */
                class Backup_Database
                {
                    /**
                     * Host where the database is located
                     */
                    var $host;
                    /**
                     * Username used to connect to database
                     */
                    var $username;
                    /**
                     * Password used to connect to database
                     */
                    var $passwd;
                    /**
                     * Database to backup
                     */
                    var $dbName;
                    /**
                     * Database charset
                     */
                    var $charset;
                    /**
                     * Database connection
                     */
                    var $conn;
                    /**
                     * Backup directory where backup files are stored 
                     */
                    var $backupDir;
                    /**
                     * Output backup file
                     */
                    var $backupFile;
                    /**
                     * Use gzip compression on backup file
                     */
                    var $gzipBackupFile;
                    /**
                     * Constructor initializes database
                     */
                    public function __construct($host, $username, $passwd, $dbName, $charset = 'utf8')
                    {
                        $this->host            = $host;
                        $this->username        = $username;
                        $this->passwd          = $passwd;
                        $this->dbName          = $dbName;
                        $this->charset         = $charset;
                        $this->conn            = $this->initializeDatabase();
                        $this->backupDir       = BACKUP_DIR ? BACKUP_DIR : '.';
                        $this->backupFile      = 'backup-' . $this->dbName . '-' . date("F_j_Y_g-i_a", time()) . '.sql';
                        $this->gzipBackupFile  = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
                    }
                    protected function initializeDatabase()
                    {
                        try {
                            $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
                            if (mysqli_connect_errno()) {
                                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                                die();
                            }
                            if (!mysqli_set_charset($conn, $this->charset)) {
                                mysqli_query($conn, 'SET NAMES ' . $this->charset);
                            }
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                            die();
                        }
                        return $conn;
                    }

                    /**
                     * Backup the whole database or just some tables
                     * Use '*' for whole database or 'table1 table2 table3...'
                     * @param string $tables
                     */
                    public function backupTables($tables = '*')
                    {
                        try {
                            /**
                             * Tables to export
                             */
                            if ($tables == '*') {
                                $tables = array();
                                $result = mysqli_query($this->conn, 'SHOW TABLES');
                                while ($row = mysqli_fetch_row($result)) {
                                    $tables[] = $row[0];
                                }
                            } else {
                                $tables = is_array($tables) ? $tables : explode(',', $tables);
                            }
                            $sql = 'CREATE DATABASE IF NOT EXISTS `' . $this->dbName . "`;\n\n";
                            $sql .= 'USE ' . $this->dbName . ";\n\n";
                            /**
                             * Iterate tables
                             */
                            $this->obfPrint("Preparing tables to backup...");
                            foreach ($tables as $table) {
                                $this->obfPrint("Backing up `" . $table . "` table..." . str_repeat('.', 50 - strlen($table)), 0, 0);
                                /**
                                 * CREATE TABLE
                                 */
                                $sql .= 'DROP TABLE IF EXISTS `' . $table . '`;';
                                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `' . $table . '`'));
                                $sql .= "\n\n" . $row[1] . ";\n\n";
                                /**
                                 * INSERT INTO
                                 */
                                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `' . $table . '`'));
                                $numRows = $row[0];
                                // Split table in batches in order to not exhaust system memory 
                                $batchSize = 1000; // Number of rows per batch
                                $numBatches = intval($numRows / $batchSize) + 1; // Number of while-loop calls to perform
                                for ($b = 1; $b <= $numBatches; $b++) {

                                    $query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($b * $batchSize - $batchSize) . ',' . $batchSize;
                                    $result = mysqli_query($this->conn, $query);
                                    $numFields = mysqli_num_fields($result);
                                    for ($i = 0; $i < $numFields; $i++) {
                                        $rowCount = 0;
                                        while ($row = mysqli_fetch_row($result)) {
                                            $sql .= 'INSERT INTO `' . $table . '` VALUES(';
                                            for ($j = 0; $j < $numFields; $j++) {
                                                if (isset($row[$j])) {
                                                    $row[$j] = addslashes($row[$j]);
                                                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                                                    $sql .= '"' . $row[$j] . '"';
                                                } else {
                                                    $sql .= 'NULL';
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
                                $sql .= "\n\n\n";
                                $this->obfPrint(" OK");
                            }
                            if ($this->gzipBackupFile) {
                                $this->gzipBackupFile();
                            } else {
                                $this->obfPrint('Backup file succesfully saved to ' . $this->backupDir . '/' . $this->backupFile, 1, 1);
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
                    protected function saveFile(&$sql)
                    {
                        if (!$sql) return false;
                        try {
                            if (!file_exists($this->backupDir)) {
                                mkdir($this->backupDir, 0777, true);
                            }
                            file_put_contents($this->backupDir . '/' . $this->backupFile, $sql, FILE_APPEND | LOCK_EX);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                            return false;
                        }
                        return true;
                    }
                    /*
                             * Gzip backup file
                             *
                             * @param integer $level GZIP compression level (default: 9)
                             * @return string New filename (with .gz appended) if success, or false if operation fails
                             */
                    protected function gzipBackupFile($level = 9)
                    {
                        if (!$this->gzipBackupFile) {
                            return true;
                        }
                        $source = $this->backupDir . '/' . $this->backupFile;
                        $dest =  $source . '.gz';
                        $this->obfPrint('Compressing backup file to ' . $dest . '... ', 1, 0);
                        $mode = 'wb' . $level;
                        if ($fpOut = gzopen($dest, $mode)) {
                            if ($fpIn = fopen($source, 'rb')) {
                                while (!feof($fpIn)) {
                                    gzwrite($fpOut, fread($fpIn, 1024 * 256));
                                }
                                fclose($fpIn);
                            } else {
                                return false;
                            }
                            gzclose($fpOut);
                            if (!unlink($source)) {
                                return false;
                            }
                        } else {
                            return false;
                        }

                        $this->obfPrint('OK');
                        return $dest;
                    }
                    /**
                     * Prints message forcing output buffer flush
                     *
                     */
                    public function obfPrint($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1)
                    {
                        if (!$msg) {
                            return false;
                        }
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
                        echo $output;
                        if (php_sapi_name() != "cli") {
                            ob_flush();
                        }
                        flush();
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

                $backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? '<b>DB Backup successfully created!</b>' : '<b>DB Backup unsuccessful!</b>';
                $backupDatabase->obfPrint('<b>Backup result: </b>' . $result, 1);
                if (php_sapi_name() != "cli") {
                    echo '</div>';
                }

                if (strcmp($result, '<b>DB Backup successfully created!</b>') == 0) {
                    $pdo = new PDO('mysql:host=localhost;dbname=aitech_payment', 'root', '');
                    //echo'Connection Successful!';

                    $action = 'Backup the database named backup-' . DB_NAME . '-' . date("Ymd_His", time()) . '.sql.gz';
                    $type = 1;
                    $insertLog = $pdo->prepare("INSERT INTO logs(user_id, user_email, action, type) values(:id, :user, :action, :type)");

                    $insertLog->bindParam(':id', $_SESSION['myid']);
                    $insertLog->bindParam(':user', $_SESSION['userEmail']);
                    $insertLog->bindParam(':action', $action);
                    $insertLog->bindParam(':type', $type);
                    $insertLog->execute();
                }
                ?>
            </div>
        </section>
    </main>

    <?php
    include_once 'assets/includes/footer.php';
    require_once 'assets/includes/script.php';
    ?>
</body>

</html>