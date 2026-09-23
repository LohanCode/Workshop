<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

function authenticateWithSupabase(string $email, string $password): array
{
    $supabaseUrl = rtrim((string) ($_ENV['SUPABASE_URL'] ?? ''), '/');
    $anonKey = (string) ($_ENV['SUPABASE_ANON_KEY'] ?? '');

    if ($supabaseUrl === '' || $anonKey === '') {
        throw new RuntimeException('La configuration Supabase est incomplète.');
    }

    $payload = json_encode([
        'email' => $email,
        'password' => $password,
    ], JSON_THROW_ON_ERROR);

    $curl = curl_init($supabaseUrl . '/auth/v1/token?grant_type=password');

    if ($curl === false) {
        throw new RuntimeException('Impossible d’initialiser la connexion Supabase.');
    }

    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'apikey: ' . $anonKey,
            'Content-Type: application/json',
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
    ]);

    $response = curl_exec($curl);
    $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    if ($response === false) {
        throw new RuntimeException('Supabase est inaccessible : ' . $curlError);
    }

    $decodedResponse = json_decode($response, true);

    if (!is_array($decodedResponse)) {
        throw new RuntimeException('Réponse Supabase invalide.');
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        throw new RuntimeException('Email ou mot de passe incorrect.');
    }

    if (empty($decodedResponse['access_token']) || empty($decodedResponse['user'])) {
        throw new RuntimeException('Supabase n’a pas retourné une session valide.');
    }

    return $decodedResponse;
}
