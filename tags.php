<?php $pageTitle = "Les mots-clés"; include 'header.php'; ?> 
        <div id="wrapper">
            <?php
            $tagId = intval($_GET['tag_id']);
            ?>
            <?php
            $mysqli = new mysqli("localhost", "root", "Jvale2lppsc", "socialnetwork");
            ?>
            <aside>
                <?php
                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisateur"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le mot-clé <?php echo htmlspecialchars($tag['label']) ?>
                        (n° <?php echo $tagId ?>)
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
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE filter.tag_id = '$tagId' 
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
                            <?php 
                            $tags = explode(',', $post['taglist']);
                            foreach ($tags as $tag) {
                                echo '<a href="#">' . htmlspecialchars($tag) . '</a> ';
                            }
                            ?>
                        </footer>
                    </article>
                <?php 
                } 
                ?>
            </main>
<?php include 'footer.php'; ?>