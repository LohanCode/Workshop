<?php

require_once __DIR__ .'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try{
    $pdo = new PDO(
        "pgsql:host=" . $_ENV['DB_HOST'] .
        ";port=" . $_ENV['DB_PORT'] .
        ";dbname=" . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion à la base de données réussie !";
} catch(PDOException $e){
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}