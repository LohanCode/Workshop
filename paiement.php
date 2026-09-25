<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}
$cart = $_SESSION['panier'] ?? [];
if (!is_array($cart) || $cart === []) {
    header('Location: panier.php');
    exit;
}

$paymentError = $_SESSION['erreur_paiement'] ?? null;
unset($_SESSION['erreur_paiement']);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Paiement - Breaking Glass</title><link rel="stylesheet" href="/styles/styles.css"></head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<main class="form-page">
    <p class="eyebrow">Dernière étape</p><h1>Paiement de démonstration</h1>
    <p class="form-intro">Aucune donnée bancaire n'est demandée : cette commande est entièrement simulée.</p>
    <?php if (is_string($paymentError)): ?>
        <p class="form-error" role="alert"><?= htmlspecialchars($paymentError, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" action="traiter-paiement.php" class="demo-payment-form">
        <label for="nom">Nom pour la commande</label>
        <input id="nom" name="nom" type="text" autocomplete="name" required>
        <label for="email">Email de confirmation</label>
        <input id="email" name="email" type="email" autocomplete="email" required>
        <label for="adresse_livraison">Adresse de livraison</label>
        <textarea id="adresse_livraison" name="adresse_livraison" rows="3" autocomplete="street-address" required></textarea>
        <label for="telephone_livraison">Téléphone</label>
        <input
            id="telephone_livraison"
            name="telephone_livraison"
            type="tel"
            inputmode="numeric"
            autocomplete="tel"
            pattern="0[1-9][0-9]{8}"
            minlength="10"
            maxlength="10"
            placeholder="0612345678"
            required
        >
        <label class="checkbox-label"><input type="checkbox" name="simulation_confirmee" value="1" required> Je confirme le paiement fictif de cette commande.</label>
        <button type="submit">Confirmer la commande</button>
    </form>
</main>
</body>
</html>
