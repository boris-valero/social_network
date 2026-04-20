<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Inscription</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=5">Mur</a>
                <a href="feed.php?user_id=5">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=5">Paramètres</a></li>
                    <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                </ul>
            </nav>
        </header>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>
                    <?php
                    require_once 'config.php';

                    $enCoursDeTraitement = isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['motpasse']);
                    $error_message = '';
                    $success_message = '';
                    
                    if ($enCoursDeTraitement)
                    {
                        $new_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                        $new_alias = trim($_POST['pseudo']);
                        $new_passwd = $_POST['motpasse'];
                        
                        // Validation
                        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                            $error_message = "Email invalide.";
                        } else if (strlen($new_alias) < 3 || strlen($new_alias) > 50) {
                            $error_message = "Le pseudo doit contenir entre 3 et 50 caractères.";
                        } else if (strlen($new_passwd) < 8) {
                            $error_message = "Le mot de passe doit contenir au moins 8 caractères.";
                        } else {
                            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            if ($mysqli->connect_errno) {
                                $error_message = "Erreur de connexion à la base de données.";
                            } else {
                                // Vérifier si l'email existe déjà
                                $stmt_check = $mysqli->prepare("SELECT id FROM users WHERE email=?");
                                $stmt_check->bind_param("s", $new_email);
                                $stmt_check->execute();
                                $stmt_check->store_result();
                                
                                if ($stmt_check->num_rows > 0) {
                                    $error_message = "Cet email est déjà utilisé.";
                                } else {
                                    // Hacher le mot de passe avec bcrypt
                                    $hashed_passwd = password_hash($new_passwd, PASSWORD_BCRYPT);
                                    
                                    // Prepared statement pour l'insertion
                                    $stmt = $mysqli->prepare("INSERT INTO users (email, password, alias) VALUES (?, ?, ?)");
                                    if ($stmt) {
                                        $stmt->bind_param("sss", $new_email, $hashed_passwd, $new_alias);
                                        if ($stmt->execute()) {
                                            $success_message = "Votre inscription est un succès : " . htmlspecialchars($new_alias) . " <a href='login.php'>Connectez-vous.</a>";
                                        } else {
                                            $error_message = "L'inscription a échouée : " . $stmt->error;
                                        }
                                        $stmt->close();
                                    } else {
                                        $error_message = "Erreur préparation requête : " . $mysqli->error;
                                    }
                                }
                                $stmt_check->close();
                                $mysqli->close();
                            }
                        }
                        
                        if ($error_message) {
                            echo "<p style='color: red;'>" . htmlspecialchars($error_message) . "</p>";
                        }
                        if ($success_message) {
                            echo "<p style='color: green;'>" . $success_message . "</p>";
                        }
                    }
                    ?>                     
                    <form action="registration.php" method="post">
                        <input type='hidden' name='form_submitted' value='1'>
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text' name='pseudo'></dd>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email' name='email'></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password' name='motpasse'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>