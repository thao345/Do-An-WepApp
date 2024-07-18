<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $idnd = $_POST['edit_id'];
    $sql = "SELECT * FROM `nguoidung` WHERE id_nguoidung ='$idnd'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $idnd = $_GET['edit_id'];
    $sql = "SELECT * FROM `nguoidung` WHERE id_nguoidung ='$idnd'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}



?>

<!-- Content Wrapper -->
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
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

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

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa người dùng</h1>

            <form class="needs-validation" novalidate action="them_nguoidung.php" method="POST">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Mã Người dùng</label>
                                            <input type="text" class="form-control" name="id_nguoidung"
                                                id="validationCustom01" placeholder="Mã nhân sự" value="<?php echo $idnd; ?>" required readonly>
                                            
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tên đăng nhập</label>
                                            <input type="text" class="form-control" name="tendangnhap" id="validationCustom02"
                                                placeholder="Tên nhân sự" value="<?php echo $items['tendangnhap']; ?>" required>
                                            <div class="invalid-feedback">
                                                Nhập tên đăng nhập.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Admin</label>
                                            <select name="isadmin" class="form-control" id="validationCustom02" required>
                                                <option value="true">True</option>
                                                <option value="false">False</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Admin.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Mật khẩu</label>
                                            <input type="text" class="form-control" name="matkhau"
                                                id="validationCustom02" placeholder="Mật khẩu" value="<?php echo $items['matkhau']; ?>" required>
                                            <div class="invalid-feedback">
                                                Mật khẩu.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Trạng thái</label>
                                            <select name="trangthai" class="form-control" id="validationCustom02" required>
                                                <option value="true">Hoạt động</option>
                                                <option value="false">Không còn hoạt động</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Trạng thái.
                                            </div>
                                        </div>


                                        
                            


                    </div>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_ngoidung.php" class="btn btn-secondary mr-3">Trở lại </a>
                    <button type="submit" name="luubtn" class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>