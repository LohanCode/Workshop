<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="/styles/styles.css">
    </head>
    <body>
        <?php
            require_once __DIR__ .'/includes/header.php';
        ?>

        <main class="login-container">
        <div class="login-box">
                <h1>Connexion</h1>
                <p class="subtitle">
                Connectez-vous à votre compte
                </p>
                <form>
                    <div class="input-group">
                        <label for="email">Adresse email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="exemple@email.com"
                        >
                    </div>
                    <div class="input-group"> 
                        <label for="password">Mot de passe</label> 
                        <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Votre mot de passe" 
                        > 
                    </div> 
                    <button type="submit"> Se connecter </button> 
                </form>
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