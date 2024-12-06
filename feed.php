<?php
$pageTitle = "Mon flux";
include 'header.php';
require_once 'config.php';
require_once 'Database.php';

$userId = intval($_GET['user_id']);
$db = new Database();

$laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
$lesInformations = $db->query($laQuestionEnSql);
$user = $lesInformations->fetch_assoc();
?>
<aside>
    <img src="user.jpg" alt="Portrait de l'utilisateur" />
    <section>
        <h3>Présentation</h3>
        <p>Sur cette page vous trouverez tous les message des utilisateurs
            auxquel est abonné l'utilisateur <?php echo htmlspecialchars($user['alias']); ?>
            (n° <?php echo $userId ?>)
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
    $lesInformations = $mysqli->query($laQuestionEnSql);
    if (!$lesInformations) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
    while ($post = $lesInformations->fetch_assoc()) {
        ?>
        <article>
            <h3>
                <time><?php echo htmlspecialchars($post['created']); ?></time>
            </h3>
            <address><?php echo htmlspecialchars($post['author_name']); ?></address>
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
<?php include 'footer.php'; ?>