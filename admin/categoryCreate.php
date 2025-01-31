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
                        <a href="category.php"
                            class="d-none d-sm-inline-block btn btn-sm btn-danger fw-bold shadow-sm"><i
                                class='bx bx-arrow-back'></i> Back to List</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
                        </div>
                        <div class="card-body">

                            <?php
                                                                
                                $errors = [];
                                $data   = [];
                            
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $category_name     = $_POST['category_name'];
                                $category_slug     = $_POST['category_slug']??"";



                                if (empty($category_name)) {
                                    $error['categoryName'] = "Category name is required";
                                } else {
                                    $data['categoryName'] =  $category_name;
                                }

                                if (empty($category_slug)) {
                                    $error['categorySlug'] = "Category slug is required";
                                } else {
                                    $data['categorySlug'] =  $category_slug;
                                }

                                if (empty($error['categoryName']) || empty($error['categorySlug'])) {


                                    try {


                                        $sql = "INSERT INTO category(name,slug)VALUES(:name,:slug)";

                                        if ($stmp = $conn->prepare($sql)) {

                                            $stmp->bindParam(':name', $data['categoryName'], PDO::PARAM_STR);
                                            $stmp->bindParam(':slug', $data['categorySlug'], PDO::PARAM_STR);

                                            if ($stmp->execute()) {

                                                $_SESSION['success'] = 'Category insert successfully';
                                                // header('location:category.php');
                                                echo '<script>window.location.href = "category.php";</script>';
                                              
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        die('Could insert category' . $sql . $e->getMessage());
                                    }
                                }
                            }
                            ?>

                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id="category_name">
                                    <span class="form-text text-danger">
                                        <?php echo  $error['categoryName'] ?? ''; ?>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Category Slug</label>
                                    <input type="text" name="category_slug" class="form-control" id="slug">
                                    <span class="form-text text-danger">
                                        <?php echo  $error['categorySlug'] ?? ''; ?>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary fw-bold "><i
                                            class="fa fa-edit"></i> Create</button>
                                </div>
                            </form>
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
    <script>
    $('#category_name').on('keyup', function() {

        $("#slug").val('')
        var category = $(this).val();

        category = slugify(category);

        $("#slug").val(category)
    });

    function slugify(text) {
        return text.toLowerCase()
            .replace(text, text)
            .replace(/^-+|-+$/g, '')
            .replace(/\s/g, '-')
            .replace(/\-\-+/g, '-');
    }
    </script>

</body>

</html>