<?php 
$host = "localhost"; //hostname
$db = "Mitchell200636138"; //database name
$user = "Mitchell200636138"; //username
$password = "PdnkSpwQdZ"; //password

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
?>