<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id = $_POST['edit_id'];
    $sql = "SELECT * FROM `xe` WHERE id_xe ='$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM `xe` WHERE id_xe ='$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}


$sqlNhomXe = "SELECT * FROM nhomxe ";
$stmt1 = $conn->prepare($sqlNhomXe);
$query = $stmt1->execute();
$resultNhomXe = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNhomXe[] = $row;
}

$sqlNhienlieu = "SELECT * FROM nhienlieu ";
$stmt1 = $conn->prepare($sqlNhienlieu);
$query = $stmt1->execute();
$resultNhienlieu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNL[] = $row;
}

$sqlNhomHang = "SELECT * FROM nhomhanghoa";
$stmt1 = $conn->prepare($sqlNhomHang);
$query = $stmt1->execute();
$resultNhomHang = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNH[] = $row;
}


$sqlThauPhu = "SELECT * FROM thauphu";
$stmt1 = $conn->prepare($sqlThauPhu);
$query = $stmt1->execute();
$resultThauPhu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTP[] = $row;
}

?>

<!-- Content Wrapper -->
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
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Activity Log
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
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa xe</h1>

            <form class="needs-validation" novalidate action="them_xe.php" method="POST">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                    <div class="col-md-8 mb-3">
                            <label for="validationCustom01">id xe</label>
                            <input type="text" class="form-control" name="bienso" id="validationCustom01"
                                placeholder="Nhập id xe" value="<?php echo $items['id_xe'] ?>" required>
                            <div class="invalid-feedback">
                                Nhập id xe.
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="validationCustom01">Biển số xe</label>
                            <input type="text" class="form-control" name="bienso" id="validationCustom01"
                                placeholder="Nhập biển số xe" value="<?php echo $items['bienso'] ?>" required>
                            <div class="invalid-feedback">
                                Nhập biển số xe.
                            </div>
                        </div>
                        <!-- Biển xe chưa bắt lỗi định dạng -->
                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Trạng thái xe</label>
                            <select name="select_TrangThai" class="" id="select_TrangThai" required>
                                <option value="">--Trạng thái xe--</option>
                                <?php
                                $options = array("OK", "Đang sửa");
                                foreach ($options as $selectTrangThai): ?>
                                    <option value="<?php echo $selectTrangThai; ?>" <?php echo ($selectTrangThai == $items['trangthaixe']) ? 'selected' : ''; ?>>
                                        <?php echo $selectTrangThai; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Trạng thái xe.
                            </div>
                        </div>
                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Nhóm xe</label>
                            <select name="select_NX" class="" id="select_NX" required>
                                <option value="">--Chọn nhóm xe--</option>
                                <?php foreach ($resultNhomXe as $itemsNhomXe): ?>
                                    <option value="<?php echo $itemsNhomXe['id_nhomxe']; ?>" <?php echo ($itemsNhomXe['id_nhomxe'] == $items['id_nhomxe']) ? 'selected' : ''; ?>>
                                        <?php echo $itemsNhomXe['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn nhóm xe.
                            </div>
                        </div>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Nhiên liệu</label>
                            <select name="select_NL" class="" id="select_NL" required>
                                <option value="">--Chọn nhiên liệu--</option>
                                <?php foreach ($resultNL as $itemsNL): ?>
                                    <option value="<?php echo $itemsNL['id_nhienlieu']; ?>" <?php echo ($itemsNL['id_nhienlieu'] == $items['id_nhienlieu']) ? 'selected' : ''; ?>>
                                        <?php echo $itemsNL['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn nhiên liệu.
                            </div>
                        </div>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Nhóm hàng</label>
                            <select name="select_NH" class="" id="select_NH" required>
                                <option value="">--Chọn nhóm hàng--</option>
                                <?php foreach ($resultNH as $itemsNH): ?>
                                    <option value="<?php echo $itemsNH['id_nhomhanghoa']; ?>" <?php echo ($itemsNH['id_nhomhanghoa'] == $items['id_nhomhang']) ? 'selected' : ''; ?>>
                                        <?php echo $itemsNH['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn nhóm hàng.
                            </div>
                        </div>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Thầu phụ</label>
                            <select name="select_TP" class="" id="select_TP" required>
                                <option value="">--Chọn thầu phụ--</option>
                                <?php foreach ($resultTP as $itemsTP): ?>
                                    <option value="<?php echo $itemsTP['id_thauphu']; ?>" <?php echo ($itemsTP['id_thauphu'] == $items['id_thauphu']) ? 'selected' : ''; ?>>
                                        <?php echo $itemsTP['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn thầu phụ.
                            </div>
                        </div>



                    </div>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_xe.php" class="btn btn-secondary mr-3">Trở lại </a>
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