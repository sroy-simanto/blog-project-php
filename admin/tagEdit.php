
<?php
$title= 'tag';
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
                        <h1 class="h3 mb-0 text-gray-800">Tag</h1>
                        <a href="tag.php" class="d-none d-sm-inline-block btn btn-sm btn-danger fw-bold shadow-sm"><i class='bx bx-arrow-back'></i> Back to List</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Tag</h6>
                        </div>
                        <div class="card-body">
                            
                        <?php
                            
                            
                            $errors = [];
                            $data   = [];

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $tag_name     = $_POST['tag_name'];
                                $tag_slug     = $_POST['tag_slug'];
                                $tagId        = $_POST["tagId"];



                                if (empty($tag_name)) {
                                    $error['tagName'] = "Tag name is required";
                                } else {
                                    $data['tagName'] =  $tag_name;
                                }

                                if (empty($tag_slug)) {
                                    $error['tagSlug'] = "Tag slug is required";
                                } else {
                                    $data['tagSlug'] =  $tag_slug;
                                }

                                if (empty($error['tagName']) || empty($error['tagSlug'])) {


                                    try {


                                        $sql ="UPDATE tag SET name=:name,slug=:slug WHERE id=:id";

                                        if ($stmp = $conn->prepare($sql)) {

                                            $stmp->bindParam(':name', $data['tagName'], PDO::PARAM_STR);
                                            $stmp->bindParam(':slug', $data['tagSlug'], PDO::PARAM_STR);
                                            $stmp->bindParam(':id',$tagId ,PDO::PARAM_INT);

                                            if ($stmp->execute()) {

                                                $_SESSION['success'] = 'Tag update successfully';
                                                // header('location:tag.php');
                                                echo '<script>window.location.href = "tag.php";</script>';
                                              
                                            }
                                        }
										} catch (PDOException $e) {
                                        die('Could update tag' . $sql . $e->getMessage());
										}
                                }
                            }

                            
                            /* get url  id */
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                                $id = trim($_GET['id']);
                                $sql ="SELECT * FROM tag WHERE id=:id";
                                $stmp = $conn->prepare($sql);
                                $stmp->bindParam(':id',$id,PDO::PARAM_INT);
                                $stmp->execute();
                                $row = $stmp->fetch(PDO::FETCH_OBJ);
                            
                            }
                            ?>
                           
                           <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="tag_name">Tag Name</label>
                                <input type="text" name="tag_name" value="<?php echo $row->name??''; ?>" class="form-control" id="tag_name">
                                <small id="emailHelp" class="form-text text-danger">
                                    <?php echo  $error['tagName'] ?? ''; ?>
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="slug">Tag Slug</label>
                                <input type="text" name="tag_slug" value="<?php echo $row->slug??''; ?>" class="form-control" id="slug">
                                <small id="emailHelp" class="form-text text-danger">
                                    <?php echo  $error['tagSlug'] ?? ''; ?>
                                </small>
                            </div>
                            <input type="hidden" name="tagId" value="<?php echo $row->id??''; ?>">
                            <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary fw-bold "><i class="fa fa-edit"></i> Create</button>
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
                $('#tag_name').on('keyup', function() {

                    $("#slug").val('')
                    var tag = $(this).val();

                    tag = slugify(tag);

                    $("#slug").val(tag)
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