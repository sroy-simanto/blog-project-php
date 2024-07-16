<div class="sidebar">
              <div class="row">
                <div class="col-lg-12">
                  <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="search.php">
                      <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                 
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                      <h2>Categories</h2>
                    </div>
                    <div class="content">
                      <ul>
                      <?php
                            $sql = "SELECT * FROM category";
                            $stmt = $conn->query($sql);
                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                            
                            if($categories !=null){
                                foreach($categories as $key=> $category){?>

                                 <li><a class="btn" style="background-color: #f1f5f9;" href="categoryPost.php?slug=<?php echo $category->slug?>"> <?php echo $category->name;?></a></li>
                          <?php
                              }
                            }
                          ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item tags">
                    <div class="sidebar-heading">
                      <h2>Tag Clouds</h2>
                    </div>
                    <div class="content">
                      <ul>
                      <?php
                            $sql = "SELECT * FROM tag ORDER BY RAND() LIMIT 30";
                            $stmt = $conn->query($sql);
                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                            
                            if($tags !=null){
                                foreach($tags as $key=> $tag){?>

                                 <li><a href="tagPost.php?slug=<?php echo $tag->slug?>"> <?php echo $tag->name;?></a></li>
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