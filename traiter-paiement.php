<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['simulation_confirmee'])) {
    header('Location: paiement.php');
    exit;
}
require_once __DIR__ . '/database.php';

$address = trim((string) ($_POST['adresse_livraison'] ?? ''));
$phone = preg_replace('/[\s.-]+/', '', (string) ($_POST['telephone_livraison'] ?? ''));

if ($address === '' || mb_strlen($address) > 255 || $phone === null || !preg_match('/^0[1-9][0-9]{8}$/', $phone)) {
    $_SESSION['erreur_paiement'] =
        'Renseignez une adresse valide et un numéro de téléphone français à 10 chiffres.';
    header('Location: paiement.php');
    exit;
}

$cart = $_SESSION['panier'] ?? [];
if (!is_array($cart) || $cart === []) {
    header('Location: panier.php');
    exit;
}

try {
    $sessionUser = $_SESSION['utilisateur'];
    $userQuery = $pdo->prepare(
        'SELECT id
         FROM "Utilisateur"
         WHERE id = :id
         AND mail = :mail
         LIMIT 1'
    );
    $userQuery->execute([
        'id' => $sessionUser['id'] ?? null,
        'mail' => $sessionUser['mail'] ?? null,
    ]);

    if ($userQuery->fetchColumn() === false) {
        unset($_SESSION['utilisateur']);
        $_SESSION['erreur_paiement'] =
            'Votre compte n’est plus disponible. Veuillez vous reconnecter.';
        header('Location: connexion.php');
        exit;
    }

    $pdo->beginTransaction();
    $ids = array_keys($cart);
    $placeholders = implode(', ', array_fill(0, count($ids), '?'));
    $productsQuery = $pdo->prepare(
        "SELECT id, nom, prix_centimes FROM public.produits WHERE disponible = true AND id IN ($placeholders) FOR UPDATE"
    );
    $productsQuery->execute($ids);
    $products = [];
    foreach ($productsQuery->fetchAll() as $product) {
        $products[(string) $product['id']] = $product;
    }
    if (count($products) !== count($ids)) {
        throw new RuntimeException('Un produit du panier n’est plus disponible.');
    }
    $total = 0;
    foreach ($ids as $id) {
        $quantity = filter_var($cart[$id], FILTER_VALIDATE_INT);
        if ($quantity === false || $quantity < 1 || $quantity > 99) {
            throw new RuntimeException('Quantité invalide.');
        }
        $total += (int) $products[(string) $id]['prix_centimes'] * $quantity;
    }
    $order = $pdo->prepare(
        'INSERT INTO commandes
         (utilisateur_id, total_centimes, statut, reference, adresse_livraison, telephone_livraison)
         VALUES (:utilisateur_id, :total, :statut, :reference, :adresse, :telephone)
         RETURNING id'
    );
    $order->execute([
        'utilisateur_id' => $_SESSION['utilisateur']['id'],
        'total' => $total,
        'statut' => 'paye_simule',
        'reference' => 'BG-' . strtoupper(bin2hex(random_bytes(5))),
        'adresse' => $address,
        'telephone' => $phone,
    ]);
    $orderId = $order->fetchColumn();
    $line = $pdo->prepare(
        'INSERT INTO lignes_commande
         (commande_id, produit_id, nom_produit, quantite, prix_unitaire_centimes, total_centimes)
         VALUES (:commande_id, :produit_id, :nom, :quantite, :prix, :total)'
    );
    foreach ($ids as $id) {
        $line->execute([
            'commande_id' => $orderId,
            'produit_id' => $id,
            'nom' => $products[(string) $id]['nom'],
            'quantite' => (int) $cart[$id],
            'prix' => (int) $products[(string) $id]['prix_centimes'],
            'total' => (int) $products[(string) $id]['prix_centimes'] * (int) $cart[$id],
        ]);
    }
    $pdo->commit();
    $_SESSION['panier'] = [];
    $_SESSION['derniere_commande'] = ['id' => $orderId, 'total_centimes' => $total];
    header('Location: confirmation-commande.php');
    exit;
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log($exception->getMessage());
    $_SESSION['erreur_paiement'] = 'La commande n’a pas pu être enregistrée. Vérifiez votre panier et réessayez.';
    header('Location: paiement.php');
    exit;
}
