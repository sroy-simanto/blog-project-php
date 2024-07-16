
<?php
$title= 'category';
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
                        <h1 class="h3 mb-0 text-gray-800">Category</h1>
                        <a href="categoryCreate.php" class="d-none d-sm-inline-block btn btn-sm btn-success fw-bold shadow-sm"><i class='bx bx-plus' ></i>Add New Category</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
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
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php 
                                            $sql = "SELECT * FROM category";
                                            $stmt = $conn->query($sql);
                                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            
                                            if($categories !=null){
                                                foreach($categories as $key=> $category){?>
                                                <tr>
                                                    <td><?php echo $key+1; ?></td>
                                                    <td><?php echo $category->name; ?></td>
                                                    <td><?php echo $category->slug; ?></td>                                             
                                                    <td>
                                                        <a href="categoryEdit.php?id=<?php echo $category->id; ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="categoryDelete.php?id=<?php echo $category->id; ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i> Delete</a>
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