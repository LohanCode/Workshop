<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

$collectionKey = $_GET['collection'] ?? null;
$collections = [
    'amber' => [
        'name' => 'Les Tchin-Tchin Tragiques',
        'description' => 'Des teintes chaleureuses pour les verres qui ont trinqué un peu trop fort.',
        'className' => 'product-card--amber',
    ],
    'smoke' => [
        'name' => 'Les Culbutes Fumées',
        'description' => 'Des verres fumés aux transparences douces, tombés avec beaucoup de panache.',
        'className' => 'product-card--smoke',
    ],
    'clay' => [
        'name' => 'Les Santé Brisées',
        'description' => 'Des verres bruts et courageux, marqués par leurs irrégularités.',
        'className' => 'product-card--clay',
    ],
];

$selectedCollection = $collections[$collectionKey] ?? null;

$sql = '
    select id, nom, description, prix_centimes, image, collection, categorie
    from public.produits
    where disponible = true
';
$params = [];

if ($selectedCollection !== null) {
    $sql .= ' and collection = :collection';
    $params['collection'] = $collectionKey;
}

$sql .= ' order by id';

$statement = $pdo->prepare($sql);
$statement->execute($params);
$products = $statement->fetchAll();

$collectionName = $selectedCollection['name'] ?? 'Tous les verres';
$collectionDescription = $selectedCollection['description']
    ?? 'Découvrez toutes les collections de verres qui ont vécu.';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Collection - Breaking Glass</title>
        <link rel="stylesheet" href="/styles/styles.css">
    </head>
    <body>
        <?php require_once __DIR__ . '/includes/header.php'; ?>

        <main class="gallery-page">
            <a class="back-link" href="boutique.php">← Retour aux collections</a>
            <section class="gallery-intro" aria-labelledby="gallery-title">
                <p class="eyebrow" id="galleryCollection">
                    <?= htmlspecialchars($collectionName, ENT_QUOTES, 'UTF-8') ?>
                </p>
                <h1 id="galleryTitle">Les verres qui ont vécu</h1>
                <p id="galleryDescription">
                    <?= htmlspecialchars($collectionDescription, ENT_QUOTES, 'UTF-8') ?>
                </p>
            </section>

            <div class="gallery-notice">
                <strong>Les verres sont prêts à partir</strong>
                <span>Ajoutez vos préférés au panier, puis découvrez notre paiement de démonstration.</span>
            </div>

            <div class="catalog-filters" role="group" aria-label="Filtrer les verres">
                <button class="catalog-filter is-active" type="button" data-filter="all" aria-pressed="true">Tous les verres</button>
                <button class="catalog-filter" type="button" data-filter="cocktail" aria-pressed="false">Cocktails</button>
                <button class="catalog-filter" type="button" data-filter="vin" aria-pressed="false">Vin &amp; coupes</button>
                <button class="catalog-filter" type="button" data-filter="shot" aria-pressed="false">Shots &amp; tumblers</button>
                <button class="catalog-filter" type="button" data-filter="original" aria-pressed="false">Formes originales</button>
            </div>

            <section class="catalog-grid" id="catalogGrid" aria-label="Verres disponibles">
                <?php foreach ($products as $index => $product): ?>
                    <?php
                    $className = $selectedCollection['className']
                        ?? ($collections[$product['collection']]['className'] ?? '');
                    ?>
                    <article
                        class="catalog-card <?= htmlspecialchars($className, ENT_QUOTES, 'UTF-8') ?>"
                        data-filter="<?= htmlspecialchars($product['categorie'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <div class="product-art product-art--variant-<?= ($index % 15) + 1 ?>">
                            <img
                                class="catalog-photo"
                                src="images/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="Photo de <?= htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8') ?>"
                            >
                        </div>
                        <div class="catalog-info">
                            <p class="product-category">
                                <?= htmlspecialchars($collections[$product['collection']]['name'] ?? $product['collection'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <h2><?= htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                            <p><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="catalog-footer">
                                <strong><?= number_format((int) $product['prix_centimes'] / 100, 2, ',', ' ') ?> €</strong>
                                <form method="post" action="ajouter-panier.php">
                                    <input type="hidden" name="produit_id" value="<?= htmlspecialchars((string) $product['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="collection" value="<?= htmlspecialchars((string) ($collectionKey ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </main>
        <?php require_once __DIR__ . '/includes/footer.php'; ?>
        <script>
            const catalogFilters = document.querySelectorAll('.catalog-filter');
            const catalogCards = document.querySelectorAll('.catalog-card');

            catalogFilters.forEach((button) => {
                button.addEventListener('click', () => {
                    const selectedFilter = button.dataset.filter;

                    catalogFilters.forEach((filterButton) => {
                        const isSelected = filterButton === button;
                        filterButton.classList.toggle('is-active', isSelected);
                        filterButton.setAttribute('aria-pressed', String(isSelected));
                    });

                    catalogCards.forEach((card) => {
                        card.classList.toggle(
                            'is-hidden',
                            selectedFilter !== 'all' && card.dataset.filter !== selectedFilter
                        );
                    });
                });
            });
        </script>
    </body>
</html>
