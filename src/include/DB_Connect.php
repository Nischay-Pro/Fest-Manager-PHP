<?php
class DB_Connect {
 
    // constructor
    function __construct() {
         
    }
 
    // destructor
    function __destruct() {
        // $this->close();
    }
 
    // Connecting to database
    public function connect() {
        require_once 'DB_Config.php';
        // connecting to mysql

        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
     
 
        // return database handler
        return $con;
    }
 
    // Closing database connection
    public function close() {
        mysql_close();
    }
 
}
 
?>