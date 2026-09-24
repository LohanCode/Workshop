<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}
$order = $_SESSION['derniere_commande'] ?? null;
if (!is_array($order)) {
    header('Location: boutique.php');
    exit;
}
unset($_SESSION['derniere_commande']);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Commande confirmée - Breaking Glass</title><link rel="stylesheet" href="/styles/styles.css"></head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<main class="confirmation-page">
    <p class="eyebrow">C'est validé</p><h1>Merci pour votre commande !</h1>
    <p>Votre paiement simulé a bien été enregistré. Commande n°<?= htmlspecialchars((string) $order['id'], ENT_QUOTES, 'UTF-8') ?>.</p>
    <p class="confirmation-total">Total : <strong><?= number_format((int) $order['total_centimes'] / 100, 2, ',', ' ') ?> €</strong></p>
    <a class="primary-link" href="boutique.php">Retour à la boutique</a>
</main>
</body>
</html>
