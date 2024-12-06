<?php $pageTitle = "Mes actualités";
include 'header.php'; ?>
<?php
require_once 'config.php';
require_once 'database.php';

$db = new Database();
?>
<div id="wrapper">
    <aside>
        <img src="user.jpg" alt="Portrait de l'utilisateur" />
        <section>
            <h3>Présentation</h3>
            <p>
                Sur cette page vous trouverez les derniers messages de tous les utilisateur du site.
            </p>
        </section>
    </aside>
    <main>
        <?php
        $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        if (!$lesInformations) {
            echo "<article>";
            echo ("Échec de la requete : " . $mysqli->error);
            echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
            exit();
        }
        while ($post = $lesInformations->fetch_assoc()) {
            ?>
            <article>
                <h3>
                    <time><?php echo $post['created'] ?></time>
                </h3>
                <address><?php echo $post['author_name'] ?></address>
                <div>
                    <p><?php echo $post['content'] ?></p>
                </div>
                <footer>
                    <small><?php echo $post['like_number'] ?></small>
                    <a href=""><?php echo $post['taglist'] ?></a>,
                </footer>
            </article>
            <?php
        }
        ?>
    </main>
    <?php include 'footer.php'; ?>