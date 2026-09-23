<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="styles.css">
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
    </body> 
</html>