<?php $pageTitle = "Mes abonnés"; include 'header.php'; ?> 
<?php
require_once 'config.php';
require_once 'database.php';

$db = new Database();
$userId = intval($_GET['user_id']);
?>
<aside>
    <img src="user.jpg" alt="Portrait de l'utilisateur"/>
    <section>
        <h3>Présentation</h3>
        <p>Sur cette page vous trouverez la liste des personnes qui
            suivent les messages de l'utilisateur
            n° <?php echo $userId ?></p>
    </section>
</aside>
<main class='contacts'>
    <?php
    $laQuestionEnSql = "
        SELECT users.*
        FROM followers
        LEFT JOIN users ON users.id=followers.following_user_id
        WHERE followers.followed_user_id='$userId'
        GROUP BY users.id
        ";
    $lesInformations = $db->query($laQuestionEnSql);
    if (!$lesInformations) {
        echo "Échec de la requête : " . $db->error;
        exit();
    }
    while ($abonne = $lesInformations->fetch_assoc()) {
        ?>                
        <article>
            <img src="user.jpg" alt="blason"/>
            <h3><a href="wall.php?user_id=<?php echo intval($abonne['id']); ?>"><?php echo htmlspecialchars($abonne['alias']); ?></a></h3>
            <p>id:<?php echo intval($abonne['id']); ?></p>                    
        </article>
    <?php 
    } 
    ?>
</main>
<?php include 'footer.php'; ?>