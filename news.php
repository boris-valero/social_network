<?php $pageTitle = "Mes actualités"; include 'header.php'; ?>
<?php
require_once 'config.php';
require_once 'database.php';

$db = new Database();
?>
<div id="wrapper">
    <aside>
        <img src="user.jpg" alt="Portrait de l'utilisateur"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez les derniers messages de
                tous les utilisateurs du site.</p>
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
        $lesInformations = $db->query($laQuestionEnSql);
        if (!$lesInformations) {
            echo "<article>";
            echo("Échec de la requête : " . $db->error);
            echo("<p>Indice: Vérifiez la requête SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
            echo "</article>";
            exit();
        }
        while ($post = $lesInformations->fetch_assoc()) {
            ?>                
            <article>
                <h3>
                    <time datetime='<?php echo htmlspecialchars($post['created']); ?>'>
                        <?php echo htmlspecialchars($post['created']); ?>
                    </time>
                </h3>
                <address>par <?php echo htmlspecialchars($post['author_name']); ?></address>
                <div>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>                                            
                <footer>
                    <small><?php echo intval($post['like_number']); ?> J'aime</small>
                    <a href="#"><?php echo htmlspecialchars($post['taglist']); ?></a>
                </footer>
            </article>
        <?php 
        } 
        ?>
    </main>
</div>
<?php include 'footer.php'; ?>