<!DOCTYPE html>
<html lang="en">
    <?php
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        require_once __DIR__ . '/database.php';

        $errorMessage = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
                $errorMessage = 'Renseigne une adresse email valide et ton mot de passe.';
            } else {
                try {
                    $query = $pdo->prepare(
                        'SELECT id, prenom, nom, mail, tel, password
                         FROM "Utilisateur"
                         WHERE mail = :mail
                         LIMIT 1'
                    );
                    $query->execute(['mail' => $email]);
                    $user = $query->fetch();

                    $passwordHash = (string) ($user['password'] ?? '');
                    $passwordUsesModernHash = $user !== false && password_verify($password, $passwordHash);
                    $passwordUsesLegacyHash = $user !== false
                        && hash_equals($passwordHash, hash('sha256', $password));
                    $passwordIsValid = $passwordUsesModernHash || $passwordUsesLegacyHash;

                    if (!$passwordIsValid) {
                        $errorMessage = 'Email ou mot de passe incorrect.';
                    } else {
                        if ($passwordUsesLegacyHash) {
                            $upgradeQuery = $pdo->prepare(
                                'UPDATE "Utilisateur"
                                 SET password = :password
                                 WHERE id = :id'
                            );
                            $upgradeQuery->execute([
                                'password' => password_hash($password, PASSWORD_DEFAULT),
                                'id' => $user['id'],
                            ]);
                        }

                        session_regenerate_id(true);
                        unset($user['password']);
                        $_SESSION['utilisateur'] = $user;
                        header('Location: index.php');
                        exit;
                    }
                } catch (PDOException $exception) {
                    error_log($exception->getMessage());
                    $errorMessage = 'La connexion à la base de données est momentanément indisponible.';
                }
            }
        }
    ?>
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

        <center><main class="login-container">
        <div class="login-box">
                <h1>Connexion</h1>
                <p class="subtitle">
                Connectez-vous à votre compte
                </p>
                <?php if ($errorMessage !== null): ?>
                    <p class="form-error" role="alert"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
                <form method="post" action="connexion.php">
                    <div class="input-group">
                        <label for="email">Adresse email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="exemple@email.com"
                            required
                        >
                    </div>
                    <div class="input-group"> 
                        <label for="password">Mot de passe</label> 
                        <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Votre mot de passe"
                        required
                        > 
                    </div> 
                    <button type="submit"> Se connecter </button> 
                </form>
            </div>
        </main></center>
    </body> 
</html>