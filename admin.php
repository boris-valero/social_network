<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Administration</title> 
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

        <?php
        $mysqli = new mysqli("localhost", "root", "Jvale2lppsc", "socialnetwork");
        if ($mysqli->connect_errno)
        {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            exit();
        }
        ?>
        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>
                <?php
$laQuestionEnSql = "
    SELECT tags.id, tags.label, COUNT(posts_tags.post_id) as message_count
    FROM tags
    LEFT JOIN posts_tags ON tags.id = posts_tags.tag_id
    GROUP BY tags.id
    LIMIT 50";
$lesInformations = $mysqli->query($laQuestionEnSql);
if ( ! $lesInformations)
{
    echo("Échec de la requete : " . $mysqli->error);
    exit();
} 

while ($tag = $lesInformations->fetch_assoc()) {
    ?>
    <article>
        <h3>#<?php echo htmlspecialchars($tag['label']); ?></h3>
        <p>Numéro d'id du tag : <?php echo htmlspecialchars($tag['id']); ?></p>
        <br>
        <p>Nombre de messages : <?php echo htmlspecialchars($tag['message_count']); ?></p>
        <nav>
            <a href="tags.php?tag_id=<?php echo htmlspecialchars($tag['id']); ?>">Messages</a>
        </nav>
    </article>
    <?php
}
                ?>
            </aside>
            <main>
    <h2>Utilisateurs</h2>
    <?php
    $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    if ( ! $lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
        exit();
    }

    while ($user = $lesInformations->fetch_assoc())
    {
        ?>
        <article>
            <h3>Nom d'utilisateur : <?php echo htmlspecialchars($user['alias']); ?></h3>
            <p>Numéro d'id de l'utilisateur : <?php echo htmlspecialchars($user['id']); ?></p>
            <br>
            <p>Adresse email : <?php echo htmlspecialchars($user['email']); ?></p>
                      
            <nav>
                <a href="wall.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Mur</a>
                | <a href="feed.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Flux</a>
                | <a href="settings.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Paramètres</a>
                | <a href="followers.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Suiveurs</a>
                | <a href="subscriptions.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Abonnements</a>
            </nav>
        </article>
        <?php
    }
    ?>
</main>
        </div>
    </body>
</html>
