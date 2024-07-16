<?php
  include("layout/head.php");
?>  



  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header start -->
    <?php
      include("layout/header.php");
    ?> 

    <!-- Header end -->
    

    <!-- Page Content -->
    <!-- Banner/Slider Starts Here -->
        <?php
          include("slider.php")
        ?>
    <!-- Banner/Slider Ends Here -->



    <section class="blog-posts">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">

              <?php
                $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                INNER JOIN category ON posts.category_id=category.id
                INNER JOIN admin ON posts.admin_id= admin.id      
                WHERE posts.status='active'                       
                ORDER BY posts.id DESC LIMIT 3";
                $stmp = $conn->query($sql);
                $stmp->execute();
                $posts = $stmp->fetchAll(PDO::FETCH_OBJ);
                if ($posts != null) {
                  foreach ($posts as $post) { ?>

                <div class="col-lg-12">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="admin/<?php echo $post-> image ?>" alt="">
                    </div>
                    <div class="down-content">
                      <span><?php echo $post->CategoryName ?></span>
                      <a href="post-details.php?slug=<?php echo $post->slug ?>">
                        <h4><?php echo $post->title ?></h4></a>
                      <ul class="post-info">
                        <li><a href="#"><?php echo $post->Author ?></a></li>
                        <li><a href="#"><?php echo $post->created_at ?></a></li>
                      </ul>
                      <!-- description -->
                       <?php echo html_entity_decode (str_limit($post->description,450)); ?> 
                      <div class="post-options">
                        <div class="row">
                          <div class="col-12">
                            <ul class="post-tags">

                            <li><i class="fa fa-tags mt-5"></i></li>
                                <?php
                                $sql = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_id=:postId";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':postId', $post->id, PDO::PARAM_INT);
                                $stmt->execute();
                                $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                if ($tags) {
                                  foreach ($tags as $key => $tag) { ?>
                                    <li><a class="btn btn-light" href="#"><?php echo $tag->name; ?></a></li>
                                <?php
                                  }
                                }
                                ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
             <?php
              }
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
              <!-- sidebr start -->
                  <?php
                      include("layout/sidebar.php")
                  ?>
              <!-- sidebr end -->
          </div>
        </div>
      </div>
    </section>

    <!-- footer section start -->
        <?php
            include("layout/footer.php");
        ?>
    <!-- footer section end -->
   
  </body>
</html>