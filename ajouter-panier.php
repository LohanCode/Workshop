<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}
require_once __DIR__ . '/database.php';

$productId = (string) ($_POST['produit_id'] ?? '');
$quantity = filter_var($_POST['quantite'] ?? 1, FILTER_VALIDATE_INT);
$collection = trim((string) ($_POST['collection'] ?? ''));
$redirect = 'commande.php' . ($collection !== '' ? '?collection=' . rawurlencode($collection) : '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $productId === '' || $quantity === false || $quantity < 1) {
    header('Location: ' . $redirect);
    exit;
}
$query = $pdo->prepare('SELECT id FROM public.produits WHERE id = :id AND disponible = true LIMIT 1');
$query->execute(['id' => $productId]);
if ($query->fetchColumn() === false) {
    header('Location: ' . $redirect);
    exit;
}
if (!isset($_SESSION['panier']) || !is_array($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}
$current = (int) ($_SESSION['panier'][$productId] ?? 0);
$_SESSION['panier'][$productId] = min($current + $quantity, 99);
header('Location: panier.php');
exit;
