<?php
declare(strict_types=1);

$host = 'localhost'; //host name
$db   = "week2"; //database name
$user = 'root'; //username
$password = ""; //password

//Points to the database
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

//Try to cnnect to the database, catch any errors
try {
    $pdo = new PDO ($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connected to the $db database successfully!</p>";
}
catch (PDOException $e) {
    echo "<p>Connection to the database failed: " . $e->getMessage() . "</p>";
}