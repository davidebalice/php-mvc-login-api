<?php
$config = include 'config/config.php';

$servername = $config['db_host'];
$dbname = $config['db_name'];
$username = $config['db_user'];
$password = $config['db_password'];
$tablePrefix = $config['table_prefix'];

try {
    $conn = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    define('TABLE_PREFIX', $tablePrefix);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

return $conn;