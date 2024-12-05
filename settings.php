<?php $pageTitle = "Mes paramètres"; include 'header.php'; ?>
        <div id="wrapper" class='profile'>


            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisateur"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les informations de l'utilisateur
                        n° <?php echo intval($_GET['user_id']) ?></p>

                </section>
            </aside>
            <main>
                <?php

                $userId = intval($_GET['user_id']);

                $mysqli = new mysqli("localhost", "root", "Jvale2lppsc", "socialnetwork");

                $laQuestionEnSql = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                $user = $lesInformations->fetch_assoc();
                ?>                
                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt> : <dd><?php echo htmlspecialchars($user['alias']); ?></dd>
                        <dt>Email</dt> : <dd><?php echo htmlspecialchars($user['email']); ?></dd>
                        <dt>Nombre de message</dt> : <dd><?php echo intval($user['totalpost']); ?></dd>
                        <dt>Nombre de "J'aime" donnés </dt> : <dd><?php echo intval($user['totalgiven']); ?></dd>
                        <dt>Nombre de "J'aime" reçus</dt> : <dd><?php echo intval($user['totalrecieved']); ?></dd>
                     </dl>
                </article>
            </main>
<?php include 'footer.php'; ?>
