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
                        <div class="text-content text-center">
                            <h2>Login Form</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Banner Ends Here -->
    <?php

    $errors = [];
    $data   = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
        $email      = inputValidate($_POST['email']);
        $password   = inputValidate($_POST['password']);

        if (empty($email)) {
            $error['email'] = "Email is required";
        } else {

            $data['email'] = filter_var($email, FILTER_SANITIZE_EMAIL);

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Invalid email format";
            }
        }

        if (empty($password)) {
            $error['password'] = "Password is required";
        } else {            
            $data['password'] =  $password;            
        }


        if (empty($error['email']) && empty($error['password'])) {

            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row != null) {

                if (password_verify($data['password'], $row->password)) {

                    $_SESSION['name']       = $row->name;
                    $_SESSION['user_id']    = $row->id;
                    $_SESSION['is_loggend'] = true;
                    header("location:index.php");
                } else {
                    $error['password'] = "Password does not match!";
                }
            } else {
                $error['email'] = "Email not found!";
            }
        }
    }
    ?>

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo  $data['email']??''?>" id="email" aria-describedby="emailHelp">
                                    <span class="text-danger"><?php echo  $error['email'] ?? '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                    <span class="text-danger"><?php echo  $error['password'] ?? '' ?></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
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