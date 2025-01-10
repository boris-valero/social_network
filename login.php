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

                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement)
                    {
                        $emailAVerifier = $_POST['email'];
                        $passwdAVerifier = $_POST['motdepasse'];
                        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                        $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
                        $passwdAVerifier = md5($passwdAVerifier);
                        $lInstructionSql = "SELECT * FROM users WHERE email='$emailAVerifier' AND password='$passwdAVerifier'";
                        $res = $mysqli->query($lInstructionSql);
                        if ( ! $res)
                        {
                            echo "Erreur SQL : " . $mysqli->error;
                        } else
                        {
                            $user = $res->fetch_assoc();
                            if ( ! $user)
                            {
                                echo "La connexion a échouée. ";
                            } else
                            {
                                echo "Connexion réussie : " . $user['alias'];
                                $_SESSION['connected_id'] = $user['id'];
                            }
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