<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $idns = $_POST['edit_id'];
    $sql = "SELECT * FROM `nhansu` WHERE id_nhansu ='$idns'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $idns = $_GET['edit_id'];
    $sql = "SELECT * FROM `nhansu` WHERE id_nhansu ='$idns'";
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa nhân sự</h1>

            <form class="needs-validation" novalidate action="them_nhan_su.php" method="POST">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                                <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Mã nhân sự</label>
                                            <input type="text" class="form-control" name="id_nhansu"
                                                id="validationCustom01" placeholder="Mã nhân sự" value="<?php echo $idns; ?>" required readonly>
                                            <div class="invalid-feedback">
                                                Nhập mã nhân sự.
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Tên nhân sự</label>
                                            <input type="text" class="form-control" name="ten" id="validationCustom02"
                                                placeholder="Tên nhân sự" value="<?php echo $items['ten']; ?>" required>
                                            <div class="invalid-feedback">
                                                Nhập tên nhân sự.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Tên phòng ban</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Tên phòng ban" value="<?php echo $items['tenphongban']; ?>" required>
                                            <div class="invalid-feedback">
                                                Nhập tên phòng ban.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Chức vụ</label>
                                            <input type="text" class="form-control" name="chucvu"
                                                id="validationCustom02" placeholder="Chức vụ" value="<?php echo $items['chucvu']; ?>" required>
                                            <div class="invalid-feedback">
                                                Chức vụ.
                                            </div>
                                        </div>
                                        



                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom02">Nguyên quán</label>
                                            <input type="text" class="form-control" name="nguyenquan"
                                                id="validationCustom02" placeholder="Nguyên quán" value="<?php echo $items['nguyenquan']; ?>" required>
                                            <div class="invalid-feedback">
                                                Nguyên quán.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom02">Địa chỉ thường trú</label>
                                            <input type="text" class="form-control" name="diachithuongtru"
                                                id="validationCustom02" placeholder="Địa chỉ thường trú" value="<?php echo $items['diachithuongtru']; ?>" required>
                                            <div class="invalid-feedback">
                                                Địa chỉ thường trú.
                                            </div>
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Ngày sinh</label>
                                            <input type="date" class="form-control" name="ngaysinh"
                                                id="validationCustom02" placeholder="Ngày sinh" value="<?php echo $items['ngaysinh']; ?>" required>
                                            <div class="invalid-feedback">
                                                Ngày sinh.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Căn cước công dân</label>
                                            <input type="text" class="form-control" name="cmnd"
                                                id="validationCustom02" placeholder="Căn cước công dân" value="<?php echo $items['cmnd']; ?>" required>
                                            <div class="invalid-feedback">
                                                Căn cước công dân.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Số điện thoại</label>
                                            <input type="text" class="form-control" name="sđt"
                                                id="validationCustom02" placeholder="Số điện thoại" value="<?php echo $items['sđt']; ?>" required>
                                            <div class="invalid-feedback">
                                            Số điện thoại.
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Tên ngân hàng</label>
                                            <input type="text" class="form-control" name="nganhang"
                                                id="validationCustom02" placeholder="Tên ngân hàng" value="<?php echo $items['tennganhang']; ?>" required>
                                            <div class="invalid-feedback">
                                                Tên ngân hàng.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Số tài khoản</label>
                                            <input type="text" class="form-control" name="stk"
                                                id="validationCustom02" placeholder="Số tài khoản" value="<?php echo $items['stk']; ?>" required>
                                            <div class="invalid-feedback">
                                                Số tài khoản.
                                            </div>
                                        </div>
                            


                    </div>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_nhan_su.php" class="btn btn-secondary mr-3">Trở lại </a>
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