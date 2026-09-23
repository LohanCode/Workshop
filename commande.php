<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Collection - Breaking Glass</title>
        <link rel="stylesheet" href="/styles/styles.css">
    </head>
    <body>
        <?php
            require_once __DIR__ .'/includes/header.php';
        ?>
        <main class="gallery-page">
            <a class="back-link" href="boutique.html">← Retour aux collections</a>
            <section class="gallery-intro" aria-labelledby="gallery-title">
                <p class="eyebrow" id="galleryCollection">Collection Breaking Glass</p>
                <h1 id="galleryTitle">Les verres qui ont vécu</h1>
                <p id="galleryDescription">Une sélection de verres à boire cassés, chacun avec son histoire et sa personnalité.</p>
            </section>

            <div class="gallery-notice">
                <strong>Boutique en préparation</strong>
                <span>Les prix sont indicatifs pour le moment. Le paiement sera bientôt disponible.</span>
            </div>

            <div class="catalog-filters" role="group" aria-label="Filtrer les verres">
                <button class="catalog-filter is-active" type="button" data-filter="all" aria-pressed="true">Tous les verres</button>
                <button class="catalog-filter" type="button" data-filter="cocktail" aria-pressed="false">Cocktails</button>
                <button class="catalog-filter" type="button" data-filter="vin" aria-pressed="false">Vin &amp; coupes</button>
                <button class="catalog-filter" type="button" data-filter="shot" aria-pressed="false">Shots &amp; tumblers</button>
                <button class="catalog-filter" type="button" data-filter="original" aria-pressed="false">Formes originales</button>
            </div>

            <section class="catalog-grid" id="catalogGrid" aria-label="Verres disponibles"></section>
        </main>

        <script>
            const collections = {
                amber: {
                    collection: 'Les Tchin-Tchin Tragiques',
                    description: 'Des teintes chaleureuses pour les verres qui ont trinqué un peu trop fort.',
                    className: 'product-card--amber',
                    products: [
                        ['Le Verre est dans le Fruit', 'Une coupe fruitée qui a pris le concept de salade de fruits un peu trop au sérieux.', '39 €', 'Ambre_eclate.jpg', 'cocktail'],
                        ['Whisky Business', 'Il a rencontré la table. La table a gagné. Le caractère est resté.', '42 €', 'Cognac_le_choc.jpg', 'shot'],
                        ['La Faille du Siècle', 'Une coupe historique, fissurée juste à temps pour entrer dans les livres.', '46 €', 'Coupe_rubis_brisee.jpg', 'vin'],
                        ['Cristal Clear… ou presque', 'Transparent sur ses défauts, mystérieux sur les circonstances.', '31 €', 'Fragment_rose.jpg', 'original'],
                        ['Rosé, mais Fêlé', 'Il voit la vie en rose, même quand ses bords voient double.', '38 €', 'Rubis_mais_roussi.jpg', 'vin'],
                        ['La Coupe est Pleine', 'Pleine de charme, de souvenirs et d’une fissure franchement ambitieuse.', '35 €', 'Eclat_classique.jpg', 'vin'],
                        ['Gla-Gla le Verre', 'Petit format, grande fraîcheur, très peu de stabilité sur la banquise.', '24 €', 'Petit_shot_eclate.jpg', 'shot'],
                        ['Le Nordique en Panique', 'Un verre froid dans le style, mais très émotif à l’atterrissage.', '37 €', 'Verre_laiton_fendu.jpg', 'original'],
                        ['Le Cercle des Verres Disparus', 'Une verrine qui a quitté le buffet pour une carrière de sculpture.', '29 €', 'Verrine_eclatee.jpg', 'original'],
                        ['La Verrine qui a Craqué', 'Elle voulait devenir une œuvre d’art. Elle a commencé par se fissurer.', '44 €', 'Verre_cocktail_fracas.jpg', 'cocktail'],
                        ['Flûte Alors !', 'Une flûte qui pétillait avant de prendre un virage dramatique.', '43 €', 'Verre_cocktail_martini.jpg', 'cocktail'],
                        ['Le Tumbler de Travers', 'Le vin est droit, le verre a choisi une autre trajectoire.', '36 €', 'verre_vin_casse.png', 'vin'],
                        ['Le Verre qui Perd la Tête', 'Un whisky servi avec une légère perte de contrôle, mais beaucoup de panache.', '41 €', 'verre_whisky_casse.png', 'shot'],
                        ['Calice, c’est Cassé', 'Une allure royale et une relation compliquée avec la gravité.', '28 €', 'verre_eau_casse.png', 'vin'],
                        ['Ambre Alert', 'Un éclat doré qui déclenche l’alarme dès qu’on le pose trop près du bord.', '40 €', 'Brise_cristal.jpg', 'original']
                    ]
                },
                smoke: {
                    collection: 'Les Culbutes Fumées',
                    description: 'Des verres fumés aux transparences douces, tombés avec beaucoup de panache.',
                    className: 'product-card--smoke',
                    products: [
                        ['Le Gobelet à Bout', 'Un gobelet qui a atteint le bout de sa patience, mais pas celui de la soirée.', '34 €', 'Bambou_boum.jpg', 'original'],
                        ['Tourne-Verre', 'Il tourne, il tourne, et personne ne sait pourquoi il est encore debout.', '37 €', 'Choc_givre.jpg', 'original'],
                        ['Tulipe, mais Pas Trop', 'Une forme florale qui a décidé de pousser légèrement de travers.', '39 €', 'Fumé_sans_feu.jpg', 'vin'],
                        ['Dark Verre', 'Froid aux bords, chaud au cœur, et légèrement susceptible.', '35 €', 'Givre_ebreche.jpg', 'original'],
                        ['Basalte de Combat', 'Il a gagné contre la gravité, mais le combat a laissé quelques traces.', '41 €', 'Halo_brise.jpg', 'original'],
                        ['Le Verre qui Vient de la Mer', 'Il rêvait de plage et a rencontré le carrelage avec beaucoup d’écume.', '45 €', 'Highball_high_fissure.jpg', 'original'],
                        ['Opaline, mais Pas Solide', 'Une longue histoire, une longue paille et une fracture très assumée.', '43 €', 'Longdrink_fracture.jpg', 'cocktail'],
                        ['Longdrink, Longue Fissure', 'Des perles dans le décor, des fissures dans le CV.', '40 €', 'Perles_et_fractures.jpg', 'cocktail'],
                        ['Le Verre sur un Fil', 'Il a voyagé dans le temps et est revenu légèrement cabossé.', '36 €', 'Retour_vers_le_verre.jpg', 'original'],
                        ['Facette, mais Fatigué', 'Le temps passe, les facettes restent, mais l’apéro demeure ponctuel.', '38 €', 'Sablier_fendu.jpg', 'original'],
                        ['Doré qui a Dérapé', 'Il brillait de mille feux avant de faire connaissance avec le sol.', '26 €', 'Shot_dans_le_pied.jpg', 'shot'],
                        ['Givré du Bord', 'Droit dans ses idées, incliné dans la réalité, frais dans les deux cas.', '40 €', 'Tumbler_oblique.jpg', 'shot'],
                        ['Cocktail, mais Catastrophe', 'Le cocktail est chic, le verre raconte une autre version de la soirée.', '33 €', 'Verre_canne_eclate.jpg', 'cocktail'],
                        ['Retour vers le Verre', 'Il rêvait de plage et a rencontré le carrelage avant de remonter le temps.', '35 €', 'Verre_marin_brise.jpg', 'original'],
                        ['Carrément Fendu', 'Minimaliste, froid et légèrement plus fragile qu’un Viking.', '42 €', 'Ébréché_nordique.jpg', 'original']
                    ]
                },
                clay: {
                    collection: 'Les Santé Brisées',
                    description: 'Des verres bruts et courageux, marqués par leurs irrégularités.',
                    className: 'product-card--clay',
                    products: [
                        ['Martini, mais Pas Très Net', 'Un basalte qui se prend pour un cocktail chic et refuse de rester discret.', '39 €', 'Basalte_ebreche.jpg', 'cocktail'],
                        ['Cognac le Choc', 'Une allure royale et une relation compliquée avec la gravité.', '44 €', 'Calice_brise.jpg', 'shot'],
                        ['Shot dans le Pied', 'Le nom explique la chute. Le verre refuse de commenter.', '35 €', 'Carrement_fendu.jpg', 'shot'],
                        ['Bambou, Boum !', 'Une allure zen, une fin explosive, une vraie philosophie de vie.', '42 €', 'Coupe_fendu.jpg', 'original'],
                        ['Perles et Fractures', 'Des perles dans le décor, des fissures dans le CV.', '46 €', 'Coupe_martini_casse.jpg', 'cocktail'],
                        ['Highball, High Fissure', 'Il vise les sommets, même quand il penche dangereusement.', '40 €', 'Cristallin_mais_pas_impeccable.jpg', 'cocktail'],
                        ['Fumé sans Feu', 'Aucune alarme incendie, juste un verre qui a beaucoup de vécu.', '43 €', 'Faille_royale.jpg', 'original'],
                        ['Cristallin, mais Pas Impeccable', 'Transparent sur ses défauts, opaque sur les circonstances.', '27 €', 'Gobelet_faille.jpg', 'original'],
                        ['Rubis, mais Roussi', 'Rouge, chic et légèrement passé par le service des urgences.', '32 €', 'Tuplique_cassee.jpg', 'vin'],
                        ['Le Verre qui en a Trop Vu', 'Il ne parlera pas de la soirée. Il n’en a pas besoin.', '37 €', 'Verre_cubique_fendu.jpg', 'original'],
                        ['La Fissure Fantôme', 'Il tourne, il tourne, et personne ne sait pourquoi il est encore debout.', '41 €', 'Verre_helice.jpg', 'original'],
                        ['Le Dernier des Can(n)és', 'Une petite perle de verrerie avec un gros dossier de maladresses.', '34 €', 'Verre_perle_fendu.jpg', 'original'],
                        ['Le Rescapé du Buffet', 'Il ne parlera pas de la soirée. Il n’en a pas besoin.', '39 €', 'Verre_qui_en_a_trop_vu.jpg', 'original'],
                        ['Le Verre de Rechange', 'Une pièce signée par la gravité, en édition très, très limitée.', '48 €', 'Verre_signature_fracture.jpg', 'original']
                    ]
                }
            };

            const selectedCollection = collections[new URLSearchParams(window.location.search).get('collection')] || collections.amber;
            document.getElementById('galleryCollection').textContent = selectedCollection.collection;
            document.getElementById('galleryDescription').textContent = selectedCollection.description;

            const catalogGrid = document.getElementById('catalogGrid');
            selectedCollection.products.forEach(([title, description, price, image], index) => {
                const card = document.createElement('article');
                card.className = `catalog-card ${selectedCollection.className}`;
                card.innerHTML = `
                    <div class="product-art product-art--variant-${index + 1}">
                        <img class="catalog-photo" src="images/${image}" alt="Photo de ${title}">
                    </div>
                    <div class="catalog-info">
                        <p class="product-category">${selectedCollection.collection}</p>
                        <h2>${title}</h2>
                        <p>${description}</p>
                        <div class="catalog-footer">
                            <strong>${price}</strong>
                            <button type="button" disabled>Bientôt disponible</button>
                        </div>
                    </div>
                `;
                card.dataset.filter = selectedCollection.products[index][4];
                catalogGrid.appendChild(card);
            });

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
                        card.classList.toggle('is-hidden', selectedFilter !== 'all' && card.dataset.filter !== selectedFilter);
                    });
                });
            });

            const menuBtn = document.getElementById('menuBtn');
            const navMenu = document.getElementById('navMenu');
            const closeMenu = () => {
                navMenu.classList.remove('active');
                menuBtn.setAttribute('aria-expanded', 'false');
                menuBtn.setAttribute('aria-label', 'Ouvrir le menu');
            };

            menuBtn.addEventListener('click', () => {
                const isOpen = navMenu.classList.toggle('active');
                menuBtn.setAttribute('aria-expanded', String(isOpen));
                menuBtn.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
            });

            document.addEventListener('click', (event) => {
                if (!event.target.closest('nav')) closeMenu();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeMenu();
                    menuBtn.focus();
                }
            });
        </script>
    </body>
</html>
