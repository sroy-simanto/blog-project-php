<?php

  include("layout/head.php");
?> 



  <body>

    <!-- ***** Preloader Start ***** -->
      <!-- <div id="preloader">
          <div class="jumper">
              <div></div>
              <div></div>
              <div></div>
          </div>
      </div>   -->
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
                <h2 class="text-white">Search: <?php echo $search ??""; ?></h2>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    

    <!-- get category id by category slug -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $search = inputValidate($_GET['q']);

        $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts INNER JOIN category ON posts.category_id=category.id INNER JOIN admin ON posts.admin_id=admin.id WHERE posts.status='active' AND title LIKE :search OR description LIKE :search ORDER BY 
        posts.id DESC";

        $bindings = [
            ':search' => '%' . $search . '%',
        ];

        $statement = $conn->prepare($sql);

        $statement->execute($bindings);

        $posts = $statement->fetchAll(PDO::FETCH_OBJ);
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
                                                    <h4><?php echo $post->title ?></h4>
                                                </a>
                                                <ul class="post-info">
                                                    <li><a href="#"><?php echo $post->Author ?></a></li>
                                                    <li><a href="#"><?php
                                                                    $dateCreate = date_create($post->created_at);
                                                                    echo $dateCreate->format('M d, Y');
                                                                    ?></a></li>
                                                </ul>
                                                <!-- descriptnon -->
                                                <?php echo html_entity_decode(str_limit($post->description, 250)) ?>

                                                <div class="post-options">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <ul class="post-tags">
                                                                <li><i class="fa fa-tags"></i></li>
                                                                <?php
                                                                $sql = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_id=:postId";
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->bindParam(':postId', $post->id, PDO::PARAM_INT);
                                                                $stmt->execute();
                                                                $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                                if ($tags) {
                                                                    foreach ($tags as $key => $tag) { ?>
                                                                        <li><a class="btn btn-light" href="#"><?php echo $tag->name; ?></a>,</li>
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
                                <ul class="page-numbers">
                                    <li><a href="#">1</a></li>
                                    <li class="active"><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php
                    include "layout/sidebar.php";
                    ?>
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