

                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                    <!-- Sidebar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-laugh-wink"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
                    </a>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item <?php echo isset($title) && $title =='dashboard'?'active':''?>">
                        <a class="nav-link" href="dashboard.php"> <i class="fas fa-fw fa-tachometer-alt fs-6"></i> <span class="fs-6">Dashboard</span></a>
                    </li>

                    <!-- Nav Item - Category -->
                    <li class="nav-item <?php echo isset($title) && $title =='category'?'active':''?>">
                        <a class="active nav-link" href="category.php"> <i class='bx bxs-category fs-6'></i> <span class="fs-6">Category</span></a>
                    </li>

                    <!-- Nav Item - Tag -->
                    <li class="nav-item <?php echo isset($title) && $title =='tag'?'active':''?>">
                        <a class="nav-link" href="tag.php"> <i class='bx bxs-purchase-tag-alt fs-6' ></i> <span class="fs-6">Tag</span></a>
                    </li>
                    <!-- Nav Item - Post -->
                    <li class="nav-item <?php echo isset($title) && $title =='post'?'active':''?>">
                        <a class="nav-link" href="post.php"> <span class="material-symbols-outlined fs-6"> post</span> <span class="fs-6">Post</span></a>
                    </li>

                    <!-- Nav Item - Admin -->
                    <li class="nav-item <?php echo isset($title) && $title =='admin'?'active':''?>">
                        <a class="nav-link" href="#"> <i class='bx bxs-user fs-6'></i> <span class="fs-6">Admin</span></a>
                    </li>








                    <!-- Nav Item - Tables -->
                    <li class="nav-item">
                        <a class="nav-link" href="tables.html">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Tables</span></a>
                    </li>

                    </ul>


