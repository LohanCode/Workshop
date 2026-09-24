<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isAuthenticated = isset($_SESSION['utilisateur']);
?>

<header>
    <nav aria-label="Primary navigation">
        <a class="site-logo" href="index.php" aria-label="Accueil Breaking Glass">
            <img src="images/logo_bk_glass.png" alt="Breaking Glass">
            <span class="site-name">Breaking Glass</span>
        </a>
        <button class="menu-btn" id="menuBtn" type="button" aria-expanded="false" aria-controls="navMenu" aria-label="Open navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-menu" id="navMenu">
            <?php if ($isAuthenticated): ?>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <li><a href="panier.php">Panier</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>
            <li><a href="actualites.php">Actualités</a></li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="about.php">A propos</a></li>
        </ul>
    </nav>
</header>
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