<?php $pageTitle = "Mes abonnés";
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
            <p>Sur cette page vous trouverez la liste des personnes dont
                l'utilisateur n°
                <?php echo intval($_GET['user_id']) ?>
                suit les messages
            </p>

        </section>
    </aside>
    <main class='contacts'>
        <?php
        $userId = intval($_GET['user_id']);
        $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        if (!$lesInformations) {
            echo "Échec de la requête : " . $mysqli->error;
        }
        while ($abonne = $lesInformations->fetch_assoc()) {
            ?>
            <article>
                <img src="user.jpg" alt="blason" />
                <h3><?php echo htmlspecialchars($abonne['alias']); ?></h3>
                <p>id:<?php echo intval($abonne['id']); ?></p>
            </article>
        <?php
        }
        ?>
    </main>
    <?php include 'footer.php'; ?>