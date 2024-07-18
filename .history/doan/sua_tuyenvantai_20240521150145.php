<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id = $_POST['edit_id'];
    $sql = "SELECT * FROM `tuyenvantai` WHERE id_tuyenvantai ='$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM `tuyenvantai` WHERE id_tuyenvantai ='$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
}

$sqlTinhThanh = "SELECT id_tinhthanh, ten FROM `tinhthanh` ";
$stmt1 = $conn->prepare($sqlTinhThanh);
$query = $stmt1->execute();
$resultTinhThanh = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTinhThanh[] = $row;
}

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: " . $tendangnhap; ?></span>
                <br>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: " . $thoigiandangnhap; ?></span>
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa tuyến vận tải</h1>

            <form class="needs-validation" novalidate action="them_tuyenvantai.php" method="POST">
                <?php foreach ($result as $items): ?>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Mã tuyến vận tải</label>
                            <input type="text" class="form-control" name="id_tuyenvantai" id="validationCustom01"
                                placeholder="Mã tuyến vận tải" value="<?php echo $id; ?>" required readonly>
                            <div class="invalid-feedback">
                                Nhập mã tuyến vận tải.
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="validationCustom02">Tên tuyến vận tải</label>
                            <input type="text" class="form-control" name="ten" id="validationCustom02"
                                placeholder="Tên tuyến vận tải" value="<?php echo $items['ten']; ?>" required>
                            <div class="invalid-feedback">
                                Nhập tên tuyến vận tải.
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="hidden" readonly class="form-control" name="id_tinhthanhdau_edit"
                                id="validationCustom01" placeholder="Mã tỉnh thành đầu"
                                value="<?php echo $items['id_tinhthanhdau']; ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="hidden" readonly class="form-control" name="id_tinhthanhcuoi_edit"
                                id="validationCustom01" placeholder="Mã tỉnh thành cuối"
                                value="<?php echo $items['id_tinhthanhcuoi']; ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Điểm đầu</label>
                            <input type="text" class="form-control" name="diemdau" id="validationCustom02"
                                placeholder="Điểm đầu" value="<?php echo $items['diemdau']; ?>" required>
                            <div class="invalid-feedback">
                                Điểm đầu.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Tỉnh thành đầu</label>
                            <select class="form-control" name="id_tinhthanhdau" id="validationCustom02" required>
                                <option value="">--Chọn tỉnh thành đầu--</option>
                                <?php foreach ($resultTinhThanh as $items1): ?>
                                    <option value="<?php echo $items1['id_tinhthanh']; ?>" <?php echo ($items1['id_tinhthanh'] == $items['id_tinhthanhdau']) ? 'selected' : ''; ?>>
                                        <?php echo $items1['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                                <!-- Phần tử option sẽ được thêm bằng JavaScript từ dữ liệu JSON -->
                            </select>
                            <div class="invalid-feedback">
                                Chọn tỉnh thành đầu.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Điểm cuối</label>
                            <input type="text" class="form-control" name="diemdau" id="validationCustom02"
                                placeholder="Điểm cuối" value="<?php echo $items['diemdau']; ?>" required>
                            <div class="invalid-feedback">
                                Điểm cuối.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Tỉnh thành cuối</label>
                            <select class="form-control" name="id_tinhthanhcuoi" id="validationCustom02" required>
                                <option value="">--Chọn tỉnh thành cuối--</option>
                                <?php foreach ($resultTinhThanh as $items1): ?>
                                    <option value="<?php echo $items1['id_tinhthanh']; ?>" <?php echo ($items1['id_tinhthanh'] == $items['id_tinhthanhcuoi']) ? 'selected' : ''; ?>>
                                        <?php echo $items1['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                                <!-- Phần tử option sẽ được thêm bằng JavaScript từ dữ liệu JSON -->
                            </select>
                            <div class="invalid-feedback">
                                Chọn tỉnh thành cuối.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="validationSLNL">Cự ly</label>

                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="validationSLNL" placeholder="Cự ly" required
                                    value="<?php echo $items['culy']; ?>" name="culy">
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        km</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập cự ly
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="validationSLNL">Dầu ước tính</label>

                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="dau_tieuthu" placeholder="Lượng dầu tiêu thụ"
                                    value="<?php echo $items['dautieuthu']; ?>" required name="dau_tieuthu" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        lít</div>
                                </div>
                                <div class="invalid-feedback">
                                    Lượng dầu tiêu thụ
                                </div>
                            </div>
                        </div>

                        <script>
                            var inputCuly = document.getElementById('validationSLNL');
                            var inputDauTieuThu = document.getElementById('dau_tieuthu');
                            inputCuly.addEventListener('input', function () {
                                var culy = parseFloat(inputCuly.value);
                                var dauTieuThu = culy / 8;
                                inputDauTieuThu.value = dauTieuThu.toFixed(2);
                            });

                        </script>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Ghi chú</label>
                            <input type="text" class="form-control" name="ghichu" id="validationCustom02"
                                placeholder="Ghi chú" value="">
                            <div class="invalid-feedback">
                                Ghi chú.
                            </div>
                        </div>



                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_tuyen_van_tai.php" class="btn btn-secondary mr-3">Trở lại </a>
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