<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

$featuredProductsQuery = $pdo->query(
    'select id, nom, description, prix_centimes, image, collection
     from (
         select distinct on (collection)
             id, nom, description, prix_centimes, image, collection
         from public.produits
         where disponible = true
         order by collection, id desc
     ) as featured
     order by id desc'
);
$featuredProducts = $featuredProductsQuery->fetchAll();

$collectionNames = [
    'amber' => 'Les Tchin-Tchin Tragiques',
    'smoke' => 'Les Culbutes Fumées',
    'clay' => 'Les Santé Brisées',
];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Breaking Glass</title>
        <link rel="stylesheet" href="/styles/styles.css">
    </head>
    <body>
        <?php
            require_once __DIR__ .'/includes/header.php'; 
        ?>

        <main>
            <section class="welcome-hero" aria-labelledby="welcome-title">
                <h2>
                    Bienvenue sur le site de Breaking Glass !<br>
                    Découvrez nos verres à boire cassés à des prix CASSÉS.<br>
                    <a href="boutique.php">Accéder à la boutique</a>
                </h2>
            </section>
            <h1 class="marketing-heading">Notre nouvelle collection</h1>
            <main class="shop-page">
            <section class="shop-intro" aria-labelledby="shop-title">
            <article class="product-card product-card--clay product-card--survivant" data-collection="clay">
                    <div class="product-art">
                        <img class="collection-photo" src="images/Basalte_ebreche.jpg" alt="Verre brut ébréché">
                    </div>
                    <div class="product-info">
                        <p class="product-category">Les Santé Brisées</p>
                        <h2>Le Survivant</h2>
                        <p>Un verre brut marqué par ses irrégularités et son grand courage.</p>
                        <a class="product-link" href="commande.php?collection=clay">Voir la boutique</a>
                    </div>
                </article>
                </section>
                </main>
                <section class="benefits-strip" aria-labelledby="benefits-title">
                    <h1 class="marketing-heading" id="benefits-title">DES PRODUITS PENSÉS POUR VOUS</h1>
                    <p class="benefits-intro">Chez Breaking Glass, nous croyons que chaque verre a une histoire à raconter</p>
                    <div class="benefits-list">
                        <p>⭐ Livraison rapide</p>
                        <p>🔒 Paiement sécurisé</p>
                        <p>↩ Retours faciles</p>
                        <p>📦 Expédition France</p>
                    </div>
                </section>

               <center> <h1 class="marketing-heading">NOS PRODUITS DU MOMENT</h1>
                <section class="featured-products" aria-label="Nos produits du moment">
                    <?php foreach ($featuredProducts as $product): ?>
                        <article class="catalog-card featured-product-card">
                            <div class="product-art">
                                <img
                                    class="catalog-photo"
                                    src="images/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Photo de <?= htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8') ?>"
                                >
                            </div>
                            <div class="catalog-info">
                                <p class="product-category">
                                    <?= htmlspecialchars($collectionNames[$product['collection']] ?? $product['collection'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                                <h2><?= htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                                <p><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?></p>
                                <div class="catalog-footer">
                                    <strong><?= number_format((int) $product['prix_centimes'] / 100, 2, ',', ' ') ?> €</strong>
                                    <form method="post" action="ajouter-panier.php">
                                        <input
                                            type="hidden"
                                            name="produit_id"
                                            value="<?= (int) $product['id'] ?>"
                                        >
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit">Ajouter au panier</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section> </center>
                <section class="benefits-strip" aria-labelledby="why-choose-title">
                    <h1 class="marketing-heading" id="why-choose-title">POURQUOI NOUS CHOISIR ?</h1>
                    <div class="benefits-list">
                        <p>Qualité</p>
                        <p>Prix</p>
                        <p>Livraison</p>
                    </div>
                </section>
        </main>

        <?php
            require_once __DIR__ .'/includes/footer.php';
        ?>
    </body>
</html>