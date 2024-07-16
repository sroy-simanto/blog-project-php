
<?php
$title= 'post';
include('../admin/layout/head.php');
include ("../admin/helper/Helper.php");

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
                        <a href="postCreate.php" class="d-none d-sm-inline-block btn btn-sm btn-success fw-bold shadow-sm"> +Add New Post</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
                        </div>
                        <div class="card-body">

                        <?php
                        if (isset($_SESSION['success'])) { ?>                           
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong>  <?php echo $_SESSION['success']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        <?php  
                          }
                          unset($_SESSION['success']);
                        ?>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody> 
                                        <?php
                                            $sql = "SELECT posts.id,posts.title,posts.status,posts.created_at,category.name as CategoryName,admin.name as Author FROM posts 
                                            INNER JOIN category ON posts.category_id=category.id
                                            INNER JOIN admin ON posts.admin_id=admin.id
                                            ORDER BY posts.id DESC";

                                            $stmt = $conn->query($sql);
                                            $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            if ($posts) {
                                                foreach ($posts as $key => $post) { ?>
                                                    <tr>
                                                        <td><?php echo $key + 1; ?></td>
                                                        <td><?php echo str_limit($post->title, 150); ?></td>
                                                        <td><?php echo $post->Author; ?></td>
                                                        <td><?php echo $post->CategoryName; ?></td>
                                                        <td><?php echo $post->created_at; ?></td>
                                                        <td>
                                                            <?php if ($post->status == 'active') { ?>
                                                                <span class="badge badge-success">Published</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-danger">Draft</span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td width="15%">
                                                            <a href="postDetails.php?id=<?php echo $post->id ?>" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="postEdit.php?id=<?php echo $post->id ?>" class="btn btn-success  btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="postDelete.php?id=<?php echo $post->id ?>" onclick="return confirm('Are you sure to delete this post?')" class="btn btn-danger  btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                            <?php
                                                }
                                            }

                                            ?>
                                        
                                    </tbody>
                                </table>
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

   
</body>

</html>