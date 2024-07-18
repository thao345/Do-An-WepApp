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
        <div > 
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: ".$tendangnhap; ?></span>
            <br>
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: ".$thoigiandangnhap; ?></span>
        </div>
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
                <?php
                include 'includes/userInformation.php';
                ?>
            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    <h5 class="card-title mb-0">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <form action="account/save_change_profile.php" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="inputUsername">Tên đăng nhập</label>
                                    <input type="text" class="form-control" id="inputUsername" name = "inputUsername" value = "<?php echo $tendangnhap; ?>"
                                        placeholder="Tên đăng nhập" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputName">Họ tên</label>
                                    <input type="text" class="form-control" id="inputName" placeholder="Họ tên"
                                    value = "<?php echo $tendangnhap; ?>" readonly>
                                </div>
                               
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="text-center">
                                    <img alt="Charles Hall" src="img/illustration-businessman_53876-5856.avif"
                                        class="rounded-circle img-responsive mt-2" width="100" height="100" />
                                    <div class="mt-2">
                                        <span class="btn btn-primary"><i class="fas fa-upload"></i> Tải ảnh lên</span>
                                    </div>
                                    <small>Chọn ảnh đại diện mới (nên sử dụng ảnh có kích thước 200 x 200px)</small>
                                </div>
                            </div> -->
                        </div>

                        <button type="submit" name = "changeProfileBtn" class="btn btn-primary">Lưu các thay đổi</button>
                    </form>

                </div>
            </div>
            <br>
            <br>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mật khẩu</h5>

                    <form action="account/save_change_setting.php" method = "POST">
                        <div class="mb-3">
                            <label class="form-label" for="inputPasswordCurrent">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" name ="currentPas" id="inputPasswordCurrent" required>
                            <!-- <small><a href="#">Forgot your password?</a></small> -->
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputPasswordNew">Mật khẩu mới</label>
                            <input type="password" class="form-control"  name ="newPas" id="inputPasswordNew" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputPasswordNew2">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" name ="newPas2" id="inputPasswordNew2" required> 
                        </div>
                        <button type="submit" name ="changePasBtn" class="btn btn-primary">Đổi mật khẩu</button>
                    </form>

                </div>
            </div>
            
           
        </div>
           
        

    </div>
    <!-- End of Main Content -->

    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>