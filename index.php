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
            <center>
                <h4>
                    Bienvenue dans le site de Breaking Glass, une entreprise spécialisée dans la vente de verre cassée à des prix cassés !
                </h4>
            </center>
            <div class="sponso">
                    <img class="photofl" src="/images/flvvvfr.png" alt="franck" class="fl">
                    <img class="photocar" src="/images/carglass.png" alt="Carglass" class="car">
            </div>
        </main>

        <script>
            const menuBtn = document.getElementById('menuBtn');
            const navMenu = document.getElementById('navMenu');

            const closeMenu = () => {
                navMenu.classList.remove('active');
                menuBtn.setAttribute('aria-expanded', 'false');
                menuBtn.setAttribute('aria-label', 'Open navigation menu');
            };

            menuBtn.addEventListener('click', () => {
                const isOpen = navMenu.classList.toggle('active');
                menuBtn.setAttribute('aria-expanded', String(isOpen));
                menuBtn.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
            });

            document.addEventListener('click', (event) => {
                if (!event.target.closest('nav')) {
                    closeMenu();
                }
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