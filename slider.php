<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">

        <?php

          $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                INNER JOIN category ON posts.category_id=category.id
                INNER JOIN admin ON posts.admin_id= admin.id      
                WHERE posts.status='active'                       
                ORDER BY posts.id DESC LIMIT 6";
                $stmp = $conn->query($sql);
                $stmp->execute();
                $posts = $stmp->fetchAll(PDO::FETCH_OBJ);
                if ($posts != null) {
                  foreach ($posts as $post) { ?>
                    <div class="item">
                      <img src="admin/<?php echo $post->image ?>" alt="">
                      <div class="item-content">
                        <div class="main-content">
                          <div class="meta-category">
                            <span><?php echo $post->CategoryName ?></span>
                          </div>
                          <a href="post-details.php?slug=<?php echo $post->slug ?>">
                            <h4><?php echo $post->title ?></h4>
                          </a>
                          <ul class="post-info">
                            <li><a href="#"><?php echo $post->Author ?></a></li>
                            <li><a href="#">
                                <?php
                                $dateCreate = date_create($post->created_at);
                                echo $dateCreate->format('M d, Y');
                                ?>
                              </a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                <?php    }
                }

                ?>
          
        </div>          
    </div>
</div>