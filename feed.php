<?php $pageTitle = "Mon flux"; include 'header.php'; ?>
<?php
require_once 'config.php';
require_once 'database.php';

$db = new Database();
$userId = intval($_GET['user_id']);
?>
<div id="wrapper">
    <aside>
        <?php
        $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
        $lesInformations = $db->query($laQuestionEnSql);
        if (!$lesInformations) {
            echo("Échec de la requête : " . $db->error);
            exit();
        }
        $user = $lesInformations->fetch_assoc();
        ?>
        <img src="user.jpg" alt="Portrait de l'utilisateur"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez tous les messages des utilisateurs
                auxquels est abonné l'utilisateur <?php echo htmlspecialchars($user['alias']); ?>
                (n° <?php echo $userId ?>)
            </p>
        </section>
    </aside>
    <main>
        <?php
        $laQuestionEnSql = "
            SELECT posts.content,
            posts.created,
            posts.user_id,
            users.alias as author_name,  
            count(likes.id) as like_number,  
            GROUP_CONCAT(DISTINCT tags.label ORDER BY tags.label) AS taglist,
            GROUP_CONCAT(DISTINCT tags.id ORDER BY tags.label) AS tag_ids
            FROM followers 
            JOIN users ON users.id=followers.followed_user_id
            JOIN posts ON posts.user_id=users.id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE followers.following_user_id='$userId' 
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";
        $lesInformations = $db->query($laQuestionEnSql);
        if (!$lesInformations) {
            echo("Échec de la requête : " . $db->error);
            exit();
        }
        while ($post = $lesInformations->fetch_assoc()) {
            ?>                
            <article>
                <h3>
                    <time><?php echo htmlspecialchars($post['created']); ?></time>
                </h3>
                <address>
                    <a href="wall.php?user_id=<?php echo intval($post['user_id']); ?>"><?php echo htmlspecialchars($post['author_name']); ?></a>
                </address>
                <div>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>                                            
                <footer>
                    <small><?php echo intval($post['like_number']); ?> J'aime</small>
                    <small style="float: right;">
                        <?php
                        $tags = explode(',', $post['taglist']);
                        $tag_ids = explode(',', $post['tag_ids']);
                        foreach ($tags as $index => $tag) {
                            $tag_id = intval($tag_ids[$index]);
                            echo '<a href="tag.php?id=' . $tag_id . '">' . htmlspecialchars($tag) . '</a> ';
                        }
                        ?>
                    </small>
                </footer>
            </article>
        <?php 
        } 
        ?>
    </main>
</div>
<?php include 'footer.php'; ?>