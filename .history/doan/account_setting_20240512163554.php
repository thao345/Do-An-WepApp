<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

$tendangnhap = $_SESSION['tendangnhap'];

?>

<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form> -->

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <button id="fullscreenButton">
                    <i class="fas fa-expand"></i>
                </button>
                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>



                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $tendangnhap; ?></span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div>
        <div class="container-fluid p-0">

<h1 class="h3 mb-3">Settings</h1>

<div class="row">
    <div class="col-md-3 col-xl-2">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Profile Settings</h5>
            </div>

            <div class="list-group list-group-flush" role="tablist">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list"
                    href="#account" role="tab">
                    Account
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password"
                    role="tab">
                    Password
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Privacy and safety
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Email notifications
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Web notifications
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Widgets
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Your data
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#" role="tab">
                    Delete account
                </a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="password" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Password</h5>

                <form>
                    <div class="mb-3">
                        <label class="form-label" for="inputPasswordCurrent">Current password</label>
                        <input type="password" class="form-control" id="inputPasswordCurrent">
                        <small><a href="#">Forgot your password?</a></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputPasswordNew">New password</label>
                        <input type="password" class="form-control" id="inputPasswordNew">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputPasswordNew2">Verify password</label>
                        <input type="password" class="form-control" id="inputPasswordNew2">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>

            </div>
        </div>


    </div>
</div>
</div>
        </div>

        <!-- End of Main Content -->





        <?php
        include ('includes/footer.php');
        include ('includes/scripts.php');
        ?>