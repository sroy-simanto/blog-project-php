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

    <!-- Header start -->
    <?php
      include("layout/header.php");
    ?> 

    <!-- Header end -->
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h4>Post Details</h4>
                <h2 class="text-white"><?php echo $post->title ??""; ?></h2>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <!-- Banner Ends Here -->

    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">

                <div class="col-lg-12">
                  <!-- single post details -->
                    <?php 
                         if (isset($_GET['slug']) && !empty($_GET['slug'])) {
                            $slug = trim($_GET['slug']);
                            $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                            INNER JOIN category ON posts.category_id=category.id
                            INNER JOIN admin ON posts.admin_id= admin.id                            
                            WHERE posts.slug=:postSlug";
                            $stmp = $conn->prepare($sql);
                            $stmp->bindParam(':postSlug', $slug, PDO::PARAM_STR);
                            $stmp->execute();
                            $post = $stmp->fetch(PDO::FETCH_OBJ);                          
                         }                         
                         ?>
                      <div class="blog-post">
                        <div class="blog-thumb">
                          <img src="admin/<?php echo $post->image ?>" alt="">
                        </div>
                        <div class="down-content">
                          <span><?php echo $post->CategoryName ?></span>
                          <a href="post-details.php">
                            <h4><?php echo $post->title ?></h4></a>
                          <ul class="post-info">
                            <li><a href="#"><?php echo $post->Author ?></a></li>
                            <li><a href="#"><?php $dateCreate = date_create($post->created_at);
                              echo $dateCreate->format('M d, Y'); ?></a></li>
                          </ul>
                            <!-- descriptnon -->
                            <?php echo html_entity_decode($post->description) ?>

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
	
	
    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="all-blog-posts">
            <div class="sidebar-heading">
              <h2>Related Posts</h2>
            </div>
              <div class="row">
                <div class="col-lg-3">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="assets/images/blog-thumb-06.jpg" alt="">
                    </div>
                    <div class="down-content p-3">
                      <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                      <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="assets/images/blog-thumb-06.jpg" alt="">
                    </div>
                    <div class="down-content p-3">
                      <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                      <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="assets/images/blog-thumb-06.jpg" alt="">
                    </div>
                    <div class="down-content p-3">
                      <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                      <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="assets/images/blog-thumb-06.jpg" alt="">
                    </div>
                    <div class="down-content p-3">
                      <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                      <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                    </div>
                  </div>
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



