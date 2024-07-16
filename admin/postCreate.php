
<?php
$title= 'post';

include ("../admin/layout/head.php");
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
                        <a href="post.php" class="d-none d-sm-inline-block btn btn-sm btn-danger fw-bold shadow-sm"><i class='bx bx-arrow-back'></i> Back to List</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Post</h6>
                        </div>
                        <div class="card-body">
                            
                        <?php
                                                                
                                $errors = [];
                                $data   = [];
                            
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $title       = inputValidate($_POST['title']);
                                $slug        = str_slug(inputValidate($_POST['slug']));
                                $description = $_POST['description'];
                                $category    = $_POST['category'] ?? '';
                                $tags        = $_POST['tags'] ?? '';
                                $status      = $_POST['status'] ?? '';

                                $fileName    = $_FILES['image']['name'];
                                $fileTmp     = $_FILES['image']['tmp_name'];
                                $fileSize    = $_FILES['image']['size'];



                                if (empty($title)) {
                                    $error['title'] = 'Post title is required';
                                } else {
                                    $data['title'] = $title;
                                }
                                if (empty($slug)) {
                                    $error['slug'] = 'Post slug is required';
                                } else {
                                    $data['slug'] = $slug;
                                }
                                if (empty($description)) {
                                    $error['description'] = 'Post description is required';
                                } else {
                                    $data['description'] = $description;
                                }
                                if (empty($category)) {
                                    $error['category'] = 'Category is required';
                                } else {
                                    $data['category'] = $category;
                                }
        
                                if (is_array_empty($tags)) {
                                    $data['tags'] = $tags;
                                } else {
                                    $error['tags'] = 'Tag is required';
                                }
        
                                if (empty($status)) {
                                    $error['status'] = 'Status is required';
                                } else {
                                    $data['status'] = $status;
                                }
        
                                $ext           = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                $allowItem     = array('jpg', 'jpeg', 'png', 'webp');
                                $uniqueImgName = uniqid() . time() . '.' . $ext;
                                $upload_Image  = 'uploads/post/' . $uniqueImgName;
        
                                if (empty($fileName)) {
                                    $error['image'] = "Post image is required";
                                } elseif ($fileSize > 1048576) {
                                    /* max photo size 1mb */
                                    $error['image'] = "Image size less then 1mb required";
                                } else {
                                    if (!in_array($ext, $allowItem)) {
                                        $error['image'] = "Only jpg, jpeg, webp & png allow";
                                    } else {
                                        $data['image'] = $upload_Image;
                                    }
                                }
        
        
                                if (
                                    empty($error['title']) &&
                                    empty($error['slug']) &&
                                    empty($error['description']) &&
                                    empty($error['category']) &&
                                    empty($error['tag']) &&
                                    empty($error['image']) &&
                                    empty($error['status'])
                                ) 
                                {
                                    try {
        
        
                                        $sql = "INSERT INTO posts(category_id, admin_id, title, slug, description, image, status, created_at)VALUES(:category_id, :admin_id, :title, :slug, :description, :image, :status, :created_at)";
        
                                        if ($stmt = $conn->prepare($sql)) {
        
                                            $currentTime = date('Y-m-d H:i:s');
        
                                            $stmt->bindParam(':category_id', $data['category'], PDO::PARAM_INT);
                                            $stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
                                            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
                                            $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
                                            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
                                            $stmt->bindParam(':image', $upload_Image, PDO::PARAM_STR);
                                            $stmt->bindParam(':status',$status, PDO::PARAM_STR);
                                            $stmt->bindParam(':created_at', $currentTime, PDO::PARAM_STR);
                                            $stmt->execute();
        
                                            $lastId = $conn->lastInsertId();
        
                                            /* insert post tags */
                                            if ($data['tags']) {
                                                foreach ($tags as $key => $tag) {
                                                    $sql = "INSERT INTO post_tag(post_id,tag_id)VALUES(:post_id,:tag_id)";
                                                    if ($stmt = $conn->prepare($sql)) {
                                                        $stmt->bindParam(':post_id', $lastId, PDO::PARAM_INT);
                                                        $stmt->bindParam(':tag_id', $tags[$key], PDO::PARAM_INT);
                                                        $stmt->execute();
                                                    }
                                                }
                                            }
        
                                            if ($lastId) {
        
                                                if ($fileName != null) {
                                                    move_uploaded_file($fileTmp, $upload_Image);
                                                }
                                                $_SESSION['success'] = 'Post insert successfully';
        
                                                echo '<script>window.location.href = "post.php";</script>';
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        die('Could insert tag' . $sql . $e->getMessage());
                                    }
                                }
                            }
                            ?>
                           
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="title" class="fw-bold">Post Title</label>
                                            <input type="text" name="title" class="form-control" id="tag_name" value="<?php echo $data['title'] ?? '' ?>">
                                            <span class="form-text text-danger">
                                                <?php echo  $error['title'] ?? ''; ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="slug" class="fw-bold">Slug</label>
                                            <input type="text" name="slug" class="form-control" id="slug" value="<?php echo $data['slug'] ?? '' ?>">
                                            <span class="form-text text-danger">
                                                <?php echo  $error['slug'] ?? ''; ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="tags" class="fw-bold" >Select Post Tags </label>
                                                <select name="tags[]" id="tags" class="form-control" multiple>
                                                        <?php
                                                        $sql = "SELECT * FROM tag";
                                                        $stmt = $conn->query($sql);
                                                        $tags = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                        if ($tags != null) {
                                                            foreach ($tags as $key => $tag) { ?>
                                                                <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                                                        <?php
                                                            }
                                                        }  ?>
                                                </select>
                                            
                                            <span class="form-text text-danger">
                                               <?php echo  $error['tags'] ?? ''; ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="fw-bold" >Post Description </label>
                                            <textarea name="description" id="description" class="form-control"><?php echo $data['description'] ?? '' ?></textarea>
                                            <span class="form-text text-danger">
                                               <?php echo  $error['description'] ?? ''; ?>
                                            </span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                                <label for="slug" class="fw-bold" >Post Image</label>
                                                <input type="file" name="image" class="form-control" data-default-file="<?php echo $data['image'] ?? '' ?>" id="image">
                                                <span class="form-text text-danger">
                                                    <?php echo  $error['image'] ?? ''; ?>
                                                </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="category" class="fw-bold" >Select Post Category </label>
                                            <select name="category" id="category" class="form-control">
                                                <option disabled selected value="">Select Category ▼ </option>
                                                    <?php
                                                    $sql = "SELECT * FROM category";
                                                    $stmt = $conn->query($sql);
                                                    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                    if ($categories != null) {
                                                        foreach ($categories as $key => $category) { ?>
                                                            <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                                                    <?php
                                                        }
                                                    }  ?>
                                            </select>
                                            <span class="form-text text-danger">
                                               <?php echo  $error['category'] ?? ''; ?>
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Post Status</label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="published" name="status" value="active" class="custom-control-input">
                                                    <label class="custom-control-label" for="published">Published</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="draft" name="status" value="inactive" class="custom-control-input">
                                                    <label class="custom-control-label" for="draft">Draft</label>
                                                </div>

                                                <small id="image" class="form-text text-danger">
                                                    <?php echo  $error['status'] ?? ''; ?>
                                                </small>
                                        </div>

                                    </div>

                                </div> <!--row end-->

                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary px-4 py-2 fw-bold "><i class="fa fa-edit"></i> Create</button>
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
        <!-- include Summernote js link -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <!-- include Dropify js link -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Select2 js link -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


     <!-- Page level custom scripts -->
     <script>
            
          
                $(document).ready(function() {

                    // include Summernote js calling
                    $('#description').summernote({
                        height: 180
                    });


                    // Select2 js calling
                    $('#tags').select2();


                });


            // include Dropify js calling
                $('#image').dropify({
                    height:190
                });
            
            //  Slug js calling
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