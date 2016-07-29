<?php



/*
 * DB Config local
 */
define('DBHOST', "localhost");
define('DBNAME', "aa_marketport");
define('DBUSER', "root");
define('DBPASS', "");

ob_start();
session_start();

class Connection {

    var $hostname, $username, $password, $database;

    function __construct() {
        $this->hostname = DBHOST; //Database host.
        $this->username = DBUSER; //Database username.
        $this->password = DBPASS; //Database password.
        $this->database = DBNAME; //Database.local
        $this->dbConnection();
    }

    public function dbConnection() {
        $connection = mysql_connect($this->hostname, $this->username, $this->password) or die('Cannot make a connection');
        if ($connection) {
            $selectDB = mysql_select_db($this->database) or die('Cannot select database');
        }
    }

}

$connect = new Connection();
date_default_timezone_set('Asia/Kolkata');
$homeurl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
extract($_REQUEST);
