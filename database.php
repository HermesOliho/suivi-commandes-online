<?php
$host = 'host=localhost';
// $host = 'unix_socket=/run/mysqld/mysqld.sock';
$dbname = 'suivi_commandes';
$username = 'root';
$password = 'Herom';

try {
    $pdo = new PDO("mysql:{$host};dbname={$dbname};charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
