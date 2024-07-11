<?php
$host = 'localhost';
$db = 'finance_system';
$user = 'root';  // sesuaikan dengan user database Anda
$pass = '';      // sesuaikan dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>
