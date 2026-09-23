<?php

declare(strict_types=1);

require_once __DIR__ .'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$pdo = new PDO(
    "pgsql:host=" . $_ENV['DB_HOST'] .
    ";port=" . $_ENV['DB_PORT'] .
    ";dbname=" . $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);