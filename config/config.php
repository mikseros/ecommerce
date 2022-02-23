<?php
/* Database credentials. */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'comm');
 
/* Attempt to connect to MySQL database */
try{
    /* If your port number is 3306, please remove ';port=3308'
       If your port number is different than 3306 or 3308, then change the number of port below */
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";port=3308;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>