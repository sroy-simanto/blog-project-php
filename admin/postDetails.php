
<?php
$title= 'post';
include('../admin/layout/head.php')

?>



<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        
        <?php
        include('../admin/layout/sidebar.php')
        ?>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                    <?php
                        include("../admin/layout/topbar.php")
                    ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Post</h1>
                        <a href="post.php" class="d-none d-sm-inline-block btn btn-sm btn-danger fw-bold shadow-sm"><i class='bx bx-arrow-back'></i> Back to List</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Show Post Details</h6>
                        </div>
                        <div class="card-body">

                        <?php 
                         if (isset($_GET['id']) && !empty($_GET['id'])) {

                            $id = trim($_GET['id']);

                            $sql = "SELECT posts.*,category.name as CategoryName,admin.name as Author FROM posts 
                            INNER JOIN category ON posts.category_id=category.id
                            INNER JOIN admin ON posts.admin_id= admin.id                            
                            WHERE posts.id=:id";
                            $stmp = $conn->prepare($sql);
                            $stmp->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmp->execute();
                            $row = $stmp->fetch(PDO::FETCH_OBJ);                          
                         }                         
                         ?>
                         <div class="container">
                               <div class="row d-flex justify-content-center">
                                    <div class="col-lg-11 bg-light">

                                        <div class="mx-4">
                                            
                                            <div class="pt-3 my-3">
                                            <h3 class="text-danger fw-bold"><?php echo $row->title ?></h3>
                                            </div>

                                            <div class="text-center">
                                            <img src="<?php echo $row->image ?>" alt="" >
                                            <p class="pb-3 mt-0">Author:<?php echo $row->Author ?> &nbsp; Date:<?php echo $row->created_at ?></p> 
                                           
                                            </div>

                                            
                                            <div class="fs-5 text-dark">
                                                <?php echo $row->description ?>
                                            </div>   
                                            
                                            <div class="pb-4">
                                                <?php 
                                                
                                                $sql = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_id=:postId";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bindParam(':postId', $row->id, PDO::PARAM_INT);
                                                $stmt->execute();
                                                $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                if ($tags) {
                                                    foreach ($tags as $key => $tag) { ?>
                                                        <span class="fs-5 btn btn-info "><?php echo $tag->name; ?></span>
                                                <?php
                                                    }
                                                }
                                                
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                               </div>
                         </div>
                            

                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
        include("../admin/layout/footer.php")
    ?>
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

     <!-- Page level custom scripts -->

</body>

</html>