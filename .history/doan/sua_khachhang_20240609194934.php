<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php'); 

if (isset($_POST['suabtn'])) {
    $idtt = $_POST['edit_id'];
    $sql = "SELECT * FROM `khachhang` WHERE id_khachhang ='$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $idtt = $_GET['edit_id'];
    $sql = "SELECT * FROM `khachhang` WHERE id_khachhang ='$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}


$sqltuyenvantai = "SELECT * FROM tuyenvantai";
$stmt1 = $conn->prepare($sqltuyenvantai);
$query = $stmt1->execute();
$resulttuyenvantai = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTVT[] = $row;
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa khách hàng</h1>

            <form class="needs-validation" novalidate action="them_khachhang.php" method="POST">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã khách hàng</label>
                                        <input type="text" class="form-control" name="id_khachhang"
                                            id="validationCustom01" placeholder="Mã khách hàng" value="<?php echo $items['id_khachhang']; ?> " required readonly>
                                        <div class="invalid-feedback">
                                            Nhập mã khách hàng.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên khách hàng</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên khách hàng" value=" <?php echo $items['ten']; ?>" required>
                                        <div class="invalid-feedback">
                                            Nhập tên khách hàng.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Địa chỉ</label>
                                        <input type="text" class="form-control" name="diachi"
                                            id="validationCustom01" placeholder="Địa chỉ" value="<?php echo $items['diachi']; ?>"  required>
                                        <div class="invalid-feedback">
                                            Nhập địa chỉ.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số điện thoại</label>
                                        <input type="text" class="form-control" name="sodienthoai"
                                            id="validationCustom01" placeholder="Số điện thoại" value="<?php echo $items['sodienthoai']; ?>" >
                                        <div class="invalid-feedback">
                                            Nhập Số điện thoại.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            id="validationCustom01" placeholder="Email" value="<?php echo $items['email']; ?>"  >
                                        <div class="invalid-feedback">
                                            Nhập Email.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã số thuế</label>
                                        <input type="text" class="form-control" name="masothue"
                                            id="validationCustom01" placeholder="Mã số thuế" value="<?php echo $items['masothue']; ?>"  required>
                                        <div class="invalid-feedback">
                                            Nhập mã số thuế.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Tên ngân hàng</label>
                                        <input type="text" class="form-control" name="tennganhang"
                                            id="validationCustom01" placeholder="Tên ngân hàng" value="<?php echo $items['tennganhang']; ?>"  >
                                        <div class="invalid-feedback">
                                            Nhập Tên ngân hàng.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số tài khoản</label>
                                        <input type="text" class="form-control" name="stk"
                                            id="validationCustom01" placeholder="Số tài khoản" value="<?php echo $items['stk']; ?>"  >
                                        <div class="invalid-feedback">
                                            Nhập số tài khoản.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Người đại diện</label>
                                        <input type="text" class="form-control" name="nguoidaidien"
                                            id="validationCustom01" placeholder="Người đại diện" value="<?php echo $items['nguoidaidien']; ?>"  required>
                                        <div class="invalid-feedback">
                                            Nhập tên người đại diện.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số điện thoại giao nhận</label>
                                        <input type="text" class="form-control" name="sđtgiaonhan"
                                            id="validationCustom01" placeholder="Số điện thoại giao nhận" value="<?php echo $items['sđtgiaonhan']; ?>"  >
                                        <div class="invalid-feedback">
                                            Nhập số điện thoại giao nhận.
                                        </div>
                                    </div>

                                    <div class="col-md-8  mb-3">
                                        <label for="validationCustom01">Tên tuyến vận tải</label>
                                        <select name="id_tuyenvantai" class="" id="id_tuyenvantai" required>
                                            <option value="">--Chọn tuyến vận tải--</option>
                                            <?php foreach ($resultTVT as $itemsTVT): ?>
                                                <option value="<?php echo $itemsTVT['id_tuyenvantai']; ?>" <?php echo ($itemsTVT['id_tuyenvantai'] == $items['id_tuyenvantai']) ? 'selected' : ''; ?> required>
                                                    <?php echo $itemsTVT['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn tuyến vận tải.
                                        </div>
                                    </div>
                                    <!-- select search -->
                                    <script>
                                        new TomSelect("#id_tuyenvantai", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>
                                    
                                    
                                </div>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_khachhang.php" class="btn btn-secondary mr-3">Trở lại </a>
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