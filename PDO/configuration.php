<?php

$host = 'localhost';
$dbname = 'super_bowl';
$port = 3307;
$user = 'root';
$pass = '';

// Chaine de connexion
$dsn = "mariadb:host=$host;dbname=$dbname;port=$port;charset=utf8";

// Mode d'erreur
$err_mode = [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION];

//Connexion vers la BDD
try {
$conn = new PDO($dsn, $user, $pass, $err_mode);
} catch (PDOException $e) {
die('Erreur de connexion !: ' . $e->getMessage());
}


?>