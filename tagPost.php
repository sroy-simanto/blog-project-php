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

     <!-- ******* Header start ******* -->
          <?php
            include("layout/header.php");
          ?> 

    <!-- ******* Header end ******* -->

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                
                <h3 class="text-white">Tag: <?php echo $tag->name??""; ?></h3>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    

    <!-- get category id by category slug -->
    <?php
        if (isset($_GET['slug'])) {

            $tagSlug = $_GET['slug'];
            $sql = "SELECT * FROM tag WHERE slug=:slug";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':slug', $tagSlug, PDO::PARAM_STR);
            $stmt->execute();
            $tag = $stmt->fetch(PDO::FETCH_OBJ);
        }

        ?>




    <!-- Banner Ends Here -->
    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">


              <?php


                $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                INNER JOIN category ON posts.category_id=category.id 
                INNER JOIN admin ON posts.admin_id=admin.id 
                INNER JOIN post_tag ON posts.id = post_tag.post_id 
                WHERE post_tag.tag_id=:tagId AND posts.status='active'                                               
                ORDER BY posts.id DESC LIMIT 4";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam('tagId', $tag->id, PDO::PARAM_INT);
                $stmt->execute();
                $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
                if ($posts != null) {
                  foreach ($posts as $post) { ?>

                    <div class="col-lg-6">
                      <div class="blog-post">
                        <div class="blog-thumb">
                          <img src="admin/<?php echo $post->image ?>" alt="">
                        </div>
                        <div class="down-content">
                          <span><?php echo $post->CategoryName ?></span>
                          <a href="post-details.php?slug=<?php echo $post->slug ?>">
                            <h4><?php echo $post->title ?></h4></a>
                          <ul class="post-info">
                            <li><a href="#"><?php echo $post->Author ?></a></li>
                            <li><a href="#"><?php $dateCreate = date_create($post->created_at);
                              echo $dateCreate->format('M d, Y'); ?></a></li>
                          </ul>
                            <!-- descriptnon -->
                            <?php echo html_entity_decode(str_limit($post->description, 150)) ?>

                          <div class="post-options">
                            <div class="row">
                              <div class="col-lg-12">
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
                                      <li><a class="btn btn-light" href="#"><?php echo $tag->name; ?></a> </li>
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

                
                

                <div class="col-lg-12">
                 
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="sidebar">
              <div class="row">
                <div class="col-lg-12">
                  <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="#">
                      <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                    <!-- sidebr start -->
                    <?php
                        include("layout/sidebar.php")
                    ?>
                  <!-- sidebr end -->
                </div>

              </div>
            </div>
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