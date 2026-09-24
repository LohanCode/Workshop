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

$cart = $_SESSION['panier'] ?? [];
if (!is_array($cart)) {
    $cart = [];
}
$cart = array_filter($cart, static fn ($quantity): bool => (int) $quantity > 0);
$_SESSION['panier'] = $cart;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (string) ($_POST['produit_id'] ?? '');
    $action = (string) ($_POST['action'] ?? '');
    if ($productId !== '' && isset($cart[$productId])) {
        if ($action === 'supprimer') {
            unset($cart[$productId]);
        } elseif ($action === 'mettre_a_jour') {
            $quantity = filter_var($_POST['quantite'] ?? 0, FILTER_VALIDATE_INT);
            if ($quantity === false || $quantity < 1) {
                unset($cart[$productId]);
            } else {
                $cart[$productId] = min($quantity, 99);
            }
        }
        $_SESSION['panier'] = $cart;
    }
    header('Location: panier.php');
    exit;
}

$items = [];
$totalCentimes = 0;
if ($cart !== []) {
    $placeholders = implode(', ', array_fill(0, count($cart), '?'));
    $query = $pdo->prepare(
        "SELECT id, nom, description, prix_centimes, image
         FROM public.produits
         WHERE disponible = true AND id IN ($placeholders)
         ORDER BY id"
    );
    $query->execute(array_keys($cart));
    foreach ($query->fetchAll() as $product) {
        $quantity = (int) ($cart[(string) $product['id']] ?? 0);
        if ($quantity < 1) {
            continue;
        }
        $product['quantite'] = $quantity;
        $product['sous_total'] = (int) $product['prix_centimes'] * $quantity;
        $totalCentimes += $product['sous_total'];
        $items[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Breaking Glass</title>
    <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<main class="cart-page">
    <p class="eyebrow">La sélection est faite</p>
    <h1>Votre panier</h1>
    <?php if ($items === []): ?>
        <p class="cart-empty">Votre panier est vide. Les verres qui ont vécu vous attendent.</p>
        <a class="primary-link" href="boutique.php">Découvrir le catalogue</a>
    <?php else: ?>
        <div class="cart-list">
            <?php foreach ($items as $item): ?>
                <article class="cart-item">
                    <img src="images/<?= htmlspecialchars((string) $item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="">
                    <div class="cart-item-info">
                        <h2><?= htmlspecialchars((string) $item['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p><?= number_format((int) $item['prix_centimes'] / 100, 2, ',', ' ') ?> € l'unité</p>
                        <form method="post" class="cart-actions">
                            <input type="hidden" name="produit_id" value="<?= htmlspecialchars((string) $item['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="action" value="mettre_a_jour">
                            <label>Quantité <input type="number" name="quantite" min="1" max="99" value="<?= $item['quantite'] ?>"></label>
                            <button type="submit">Mettre à jour</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="produit_id" value="<?= htmlspecialchars((string) $item['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="action" value="supprimer">
                            <button type="submit" class="text-button">Supprimer</button>
                        </form>
                    </div>
                    <strong><?= number_format($item['sous_total'] / 100, 2, ',', ' ') ?> €</strong>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="cart-total"><span>Total</span><strong><?= number_format($totalCentimes / 100, 2, ',', ' ') ?> €</strong></div>
        <a class="primary-link" href="paiement.php">Passer au paiement</a>
    <?php endif; ?>
</main>
</body>
</html>
