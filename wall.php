<?php $pageTitle = "Mon mur"; include 'header.php'; ?> 
        <div id="wrapper">
            <?php
            $userId =intval($_GET['user_id']);
            ?>
            <?php
            $mysqli = new mysqli("localhost", "root", "Jvale2lppsc", "socialnetwork");
            ?>
            <aside>
                <?php
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisateur"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisateur : <?php echo htmlspecialchars($user['alias']); ?>
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
                <?php
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                while ($post = $lesInformations->fetch_assoc())
                {
                    ?>                
                    <article>
                        <h3>
                        <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo $post['author_name'] ?></address>
                        <div>
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
