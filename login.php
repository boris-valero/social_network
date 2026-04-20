<?php
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Connexion</title> 
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
                    <h2>Connexion</h2>
                    <?php
                    require_once 'config.php';

                    $enCoursDeTraitement = isset($_POST['email']) && isset($_POST['motdepasse']);
                    $error_message = '';
                    
                    if ($enCoursDeTraitement)
                    {
                        $emailAVerifier = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                        $passwdAVerifier = $_POST['motdepasse'];
                        
                        // Validation email
                        if (!filter_var($emailAVerifier, FILTER_VALIDATE_EMAIL)) {
                            $error_message = "Email invalide.";
                        } else {
                            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            if ($mysqli->connect_errno) {
                                $error_message = "Erreur de connexion à la base de données.";
                            } else {
                                // Prepared statement pour éviter l'injection SQL
                                $stmt = $mysqli->prepare("SELECT id, alias, password FROM users WHERE email=?");
                                if ($stmt) {
                                    $stmt->bind_param("s", $emailAVerifier);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $user = $res->fetch_assoc();
                                    
                                    if ($user && password_verify($passwdAVerifier, $user['password'])) {
                                        echo "Connexion réussie : " . htmlspecialchars($user['alias']);
                                        $_SESSION['connected_id'] = $user['id'];
                                    } else {
                                        $error_message = "La connexion a échouée.";
                                    }
                                    $stmt->close();
                                } else {
                                    $error_message = "Erreur préparation requête : " . $mysqli->error;
                                }
                                $mysqli->close();
                            }
                        }
                        
                        if ($error_message) {
                            echo "<p style='color: red;'>" . htmlspecialchars($error_message) . "</p>";
                        }
                    }
                    ?>                     
                    <form action="login.php" method="post">
                        <input type='hidden' name='form_submitted' value='1'>
                        <dl>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email' name='email'></dd>
                            <dt><label for='motdepasse'>Mot de passe</label></dt>
                            <dd><input type='password' name='motdepasse'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>