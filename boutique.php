<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Breaking Glass - Boutique</title>
        <link rel="stylesheet" href="/styles/styles.css">
    </head>
    <body>
        <?php
            require_once __DIR__ .'/includes/header.php';
        ?>
        
        <main class="shop-page">
            <section class="shop-intro" aria-labelledby="shop-title">
                <p class="eyebrow">La collection Breaking Glass</p>
                <h1 id="shop-title">Bienvenue dans la boutique de Breaking Glass</h1>
                <p class="shop-lead">Découvrez nos verres à boire cassés à des prix imbattables.</p>
            </section>

            <section class="product-grid" aria-label="Collection de produits">
                <article class="product-card product-card--amber" data-collection="amber">
                    <div class="product-art">
                        <img class="collection-photo" src="images/Ambre_eclate.jpg" alt="Verre ambré éclaté">
                    </div>
                    <div class="product-info">
                        <p class="product-category">Les Tchin-Tchin Tragiques</p>
                        <h2>Le Grand Éclat</h2>
                        <p>Un tumbler ambré qui a connu une soirée mouvementée.</p>
                        <a class="product-link" href="commande.php?collection=amber">Voir la boutique</a>
                    </div>
                </article>

                <article class="product-card product-card--smoke" data-collection="smoke">
                    <div class="product-art">
                        <img class="collection-photo" src="images/Halo_brise.jpg" alt="Verre fumé cassé">
                    </div>
                    <div class="product-info">
                        <p class="product-category">Les Culbutes Fumées</p>
                        <h2>Le Culbuto</h2>
                        <p>Un verre fumé aux transparences douces, tombé avec panache.</p>
                        <a class="product-link" href="commande.php?collection=smoke">Voir la boutique</a>
                    </div>
                </article>

                <article class="product-card product-card--clay" data-collection="clay">
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
        <?php
            require_once __DIR__ .'/includes/footer.php';
        ?>

    </body>
</html>
