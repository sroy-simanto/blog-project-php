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
                            <h2>Registration Form</h2>
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

        $name       = inputValidate($_POST['name']);
        $email      = inputValidate($_POST['email']);
        $password   = inputValidate($_POST['password']);



        if (empty($name)) {
            $error['name'] = "Name is required";
        } else {
            $data['name'] =  $name;
        }

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
            if (strlen($password) < 6) {
                $error['password'] = "Password at least 6 digit";
            } else {
                $data['password'] =  password_hash($password,PASSWORD_DEFAULT);
            }
        }


        if (empty($error['name']) && empty($error['email']) && empty($error['password'])) {

           

            try {


                $sql = "INSERT INTO users(name,email,password)VALUES(:name,:email,:password)";

                if ($stmp = $conn->prepare($sql)) {

                    $stmp->bindParam(':name', $data['name'], PDO::PARAM_STR);
                    $stmp->bindParam(':email', $data['email'], PDO::PARAM_STR);
                    $stmp->bindParam(':password', $data['password'], PDO::PARAM_STR);

                    if ($stmp->execute()) {

                        $_SESSION['success'] = 'Registration successfully complete';
                        // header('location:category.php');
                        echo '<script>window.location.href = "login.php";</script>';
                    }
                }
            } catch (PDOException $e) {
                die('Registration failed' . $sql . $e->getMessage());
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
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo  $data['name']??''?>" id="name" aria-describedby="nameHelp">
                                    <span class="text-danger"><?php echo  $error['name'] ?? '' ?></span>
                                </div>
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
                                <p>You have already regisger? Please <a href="login.php">login here</a></p>
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