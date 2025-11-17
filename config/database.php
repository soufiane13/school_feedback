<?php

$host = '127.0.0.1'; 
$db_name = 'school_feedback';
$username = 'root';
$password = ''; 
$charset = 'utf8mb4';

// Options de PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                 
];


$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

try {
    // Crée l'objet de connexion PDO
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // En cas d'échec de connexion, affiche l'erreur
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

