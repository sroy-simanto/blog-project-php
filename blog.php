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
                <h4>Recent Posts</h4>
                <h2>Our Recent Blog Entries</h2>
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


              <?php

                $per_page  = 2;
                $sql = "SELECT count(*) FROM posts";

                $stmt = $conn->query($sql);
                $total_records = $stmt->fetchColumn();

                $total_pages = ceil($total_records / $per_page);

                $currentPage = 1;

                $page_decrement = null;
                $page_increment = null;

                if (isset($_GET['page'])) {
                  $page = $_GET['page'];
                  $currentPage = $page;
                  /*for previous & next*/
                  $page_decrement = $page - 1;
                  $page_increment = $page + 1;
                } else {
                  $page = 1;
                }

                $starting_page = ($page - 1) * $per_page;
                


                $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                INNER JOIN category ON posts.category_id=category.id
                INNER JOIN admin ON posts.admin_id= admin.id      
                WHERE posts.status='active'                       
                ORDER BY posts.id DESC LIMIT $starting_page,$per_page";
                $stmp = $conn->query($sql);
                $stmp->execute();
                $posts = $stmp->fetchAll(PDO::FETCH_OBJ);
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
                  
                    <ul class="page-numbers">

                      <!-- decrement -->
                      <?php
                      if ($page_decrement < 1) { ?>
                        <li class="">
                          <a class="" href="javascript:void(0)" disabled><i class="fa fa-angle-double-left"></i></a>
                        </li>
                      <?php    } else { ?>
                        <li class="">
                          <a class="" href="<?php echo '?page=' . $page_decrement; ?>"><i class="fa fa-angle-double-left"></i></a>
                        </li>
                      <?php      }
                      ?>

                      <!-- main pagination start -->
                      <?php
                      for ($i = 1; $i <=  $total_pages; $i++) {
                        $activePage = '';
                        if ($currentPage == $i) {
                          $activePage = 'active';
                        }
                      ?>
                        <li class="<?php echo  $activePage; ?>"><a href="<?php echo "?page=" . $i; ?>"><?php echo $i; ?></a></li>
                      <?php    }
                      ?>
                      <!-- end -->

                      <!-- increment -->
                      <?php
                      if ($page_increment > $total_pages) { ?>
                        <li class="">
                          <a class="disabled" href="javascript:void(0)"><i class="fa fa-angle-double-right"></i></a>
                        </li>
                      <?php    } else { ?>
                        <li class="">
                          <a class="" href="<?php echo '?page=' . $page_increment ?>"><i class="fa fa-angle-double-right"></i></a>
                        </li>
                      <?php      }
                      ?>

                      </ul>


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