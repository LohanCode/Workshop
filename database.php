<?php

declare(strict_types=1);

require_once __DIR__ .'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$requiredEnvironmentVariables = [
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASSWORD',
];

foreach ($requiredEnvironmentVariables as $variable) {
    if (getenv($variable) === false && ($_ENV[$variable] ?? '') === '') {
        throw new RuntimeException(
            'La variable d’environnement ' . $variable . ' est manquante.'
        );
    }
}

if (!extension_loaded('pdo_pgsql')) {
    throw new RuntimeException(
        'L’extension PHP pdo_pgsql est nécessaire pour se connecter à PostgreSQL.'
    );
}

$pdo = new PDO(
    "pgsql:host=" . (getenv('DB_HOST') ?: $_ENV['DB_HOST']) .
    ";port=" . (getenv('DB_PORT') ?: $_ENV['DB_PORT']) .
    ";dbname=" . (getenv('DB_NAME') ?: $_ENV['DB_NAME']),
    getenv('DB_USER') ?: $_ENV['DB_USER'],
    getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);