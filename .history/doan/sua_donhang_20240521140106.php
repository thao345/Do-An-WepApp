<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id_donhang = $_POST['edit_id'];
    $sql = "SELECT *,nhansu.id_auto_increment,DATE(donhang.ngaytao) as ngaytao FROM `donhang` INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment WHERE id_donhang ='$id_donhang'";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }


} else {
    // phần này để doubleclick vào row trong table
    $id_donhang = $_GET['edit_id'];
    $sql = "SELECT *,nhansu.id_auto_increment,DATE(donhang.ngaytao) as ngaytao FROM `donhang` INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment WHERE id_donhang ='$id_donhang'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}


$sqlNhanSu = "SELECT * FROM nhansu";
$stmt1 = $conn->prepare($sqlNhanSu);
$query = $stmt1->execute();
$resultNS = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNS[] = $row;
}

$sqlKH = "SELECT * FROM khachhang";
$stmt2 = $conn->prepare($sqlKH);
$query = $stmt2->execute();
$resultKH = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}

$sqlHangTau = "SELECT * FROM `hangtau` ORDER BY `hangtau`.`id_hangtau` DESC";
$stmt3 = $conn->prepare($sqlHangTau);
$query = $stmt3->execute();
$resultHangTau = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultHangTau[] = $row;
}

$sqlNHH = "SELECT * FROM `nhomhanghoa` ORDER BY `nhomhanghoa`.`id_nhomhanghoa` DESC";
$stmt4 = $conn->prepare($sqlNHH);
$query = $stmt4->execute();
$resultNHH = array();
while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    $resultNHH[] = $row;
}

$sqlTVT = "SELECT * FROM `tuyenvantai` ORDER BY `tuyenvantai`.`id_tuyenvantai` DESC";
$stmt5 = $conn->prepare($sqlTVT);
$query = $stmt5->execute();
$resultTVT = array();
while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
    $resultTVT[] = $row;
}

$sqlHH = "SELECT * FROM `hanghoa`";
$stmt6 = $conn->prepare($sqlHH);
$query = $stmt6->execute();
$resultHH = array();
while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
    $resultHH[] = $row;
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa đơn hàng</h1>

            <form class="needs-validation" novalidate action="them_donhang.php" method="POST"
                enctype="multipart/form-data">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" readonly class="form-control" name="id_edit" id="validationCustom01"
                                placeholder="Mã đơn hàng" value="<?php echo $items['id_donhang']; ?>" required>
                        </div>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Sales</label>
                            <select name="select_sales" class="" id="select_sales" required>
                                <option value="">--Chọn sales--</option>
                                <?php foreach ($resultNS as $items1): ?>
                                    <option value="<?php echo $items1['id_auto_increment']; ?>" <?php echo ($items1['id_auto_increment'] == $items['id_auto_increment']) ? 'selected' : ''; ?>>
                                        <?php echo $items1['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn sales.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_sales", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-6  mb-3">
                            <label for="validationCustom01">Khách hàng</label>
                            <select name="select_KH" class="" id="select_KH" required>
                                <option value="">--Chọn khách hàng--</option>
                                <?php foreach ($resultKH as $items2): ?>
                                    <option value="<?php echo $items2['id_khachhang']; ?>" <?php echo ($items2['id_khachhang'] == $items['id_khachhang']) ? 'selected' : ''; ?>>
                                        <?php echo $items2['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn khách hàng.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_KH", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-3 mb-3">
                            <label for="masothue">Mã số thuế</label>
                            <input type="text" class="form-control" name="masothue" id="masothue" placeholder="Mã số thuế"
                                value="<?php echo $items['masothue']; ?>" required readonly>
                            <div class="invalid-feedback">
                                Nhập mã số thuế.
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $("#select_KH").change(function () {
                                    var idKhachHang = $(this).val();
                                    $.ajax({
                                        url: "ajax/get4_khachhangById.php",
                                        method: "POST",
                                        data: {
                                            idKhachHang: idKhachHang
                                        },
                                        dataType: "json",
                                        success: function (response) {

                                            $("#masothue").val(response.masothue);
                                        }
                                    });
                                });
                            });
                        </script>
                        <div class="col-md-2 mb-3">
                            <label for="ngaytao">Ngày tạo đơn</label>
                            <input type="date" class="form-control" name="ngaytao" id="ngaytao" placeholder="Ngày tạo đơn"
                                value="<?php echo $items['ngaytao']; ?>" readonly>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">Booking</label>
                            <input type="text" class="form-control" name="booking" id="validationCustom02"
                                placeholder="Nhập booking..." value="<?php echo $items['booking']; ?>" required>
                            <div class="invalid-feedback">
                                Nhập booking.
                            </div>
                        </div>

                        <div class="col-md-2  mb-3">
                            <label for="validationCustom01">Loại hàng</label>
                            <select name="select_loaihang" class="" id="select_loaihang" required>
                                <option value="">--Chọn loại hàng--</option>
                                <option value="1" <?php echo ($items['loaihang']) == '1' ? 'selected' : ''; ?>>Nhập</option>
                                <option value="2" <?php echo ($items['loaihang']) == '2' ? 'selected' : ''; ?>>Xuất</option>
                                <option value="3" <?php echo ($items['loaihang']) == '3' ? 'selected' : ''; ?>>Nội địa
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Chọn loại hàng.
                            </div>
                        </div>



                        <div class="col-md-5  mb-3">
                            <label for="validationCustom01">Lines/FWD</label>
                            <select name="select_hangtau" class="" id="select_hangtau">
                                <option value="">--Chọn hãng tàu--</option>
                                <?php foreach ($resultHangTau as $items3): ?>
                                    <option value="<?php echo $items3['id_hangtau']; ?>" <?php echo ($items3['id_hangtau'] == $items['id_hangtau']) ? 'selected' : ''; ?>>
                                        <?php echo $items3['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn hãng tàu.
                            </div>
                        </div>

                        <script>
                            var selectLoaiHang = new TomSelect("#select_loaihang", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "asc"
                                }
                            });

                            var selectHangTau = new TomSelect("#select_hangtau", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });
                            selectHangTau.disable(); // Vô hiệu hóa select_hangtau ban đầu

                            selectLoaiHang.on("change", function () {
                                var selectedValue = this.getValue();
                                if (selectedValue === '2') {
                                    selectHangTau.enable();
                                    selectHangTau.refreshOptions();
                                } else {
                                    selectHangTau.disable();
                                }
                            });
                        </script>


                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Nhóm hàng hóa</label>
                            <select name="select_NHH" class="" id="select_NHH" required>
                                <option value="">--Chọn nhóm hàng--</option>
                                <?php foreach ($resultNHH as $items4): ?>
                                    <option value="<?php echo $items4['id_nhomhanghoa']; ?>" <?php echo ($items4['id_nhomhanghoa'] == $items['id_nhomhanghoa']) ? 'selected' : ''; ?>>
                                        <?php echo $items4['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn nhóm hàng hóa.
                            </div>
                        </div>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Hàng hóa</label>
                            <select name="select_HH" class="" id="select_HH" required>
                                <option value="">--Chọn hàng hóa--</option>
                                <?php foreach ($resultHH as $items5): ?>
                                    <option value="<?php echo $items5['id_hanghoa']; ?>" <?php echo ($items5['id_hanghoa'] == $items['id_hanghoa']) ? 'selected' : ''; ?>>
                                        <?php echo $items5['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn hàng hóa.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_NHH", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                            var selectHH = new TomSelect("#select_HH", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });
                            // selectHH.disable();

                            // Gọi hàm AJAX sau khi trang đã được tải // vì nếu k thêm cái này thì ajax sẽ gọi luôn all data của hàng hóa
                            $(document).ready(function () {
                                var nhomHangHoaId = $("#select_NHH").val();

                                if (nhomHangHoaId) {
                                    $.ajax({
                                        url: "ajax/get_hanghoa_loaixe.php",
                                        method: "POST",
                                        data: {
                                            nhomHangHoaId: nhomHangHoaId
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                            // selectHH.clear();
                                            selectHH.clearOptions();

                                            $.each(response, function (index, item) {
                                                selectHH.addOption({
                                                    value: item.id_hanghoa,
                                                    text: item.ten
                                                });
                                            });

                                            selectHH.enable();
                                            // selectHH.refreshOptions();
                                        }
                                    });
                                } else {
                                    selectHH.clearOptions();
                                }
                            });

                            // Xử lý sự kiện change của select_NHH
                            $("#select_NHH").on("change", function () {
                                var nhomHangHoaId = $("#select_NHH").val();

                                if (nhomHangHoaId) {
                                    $.ajax({
                                        url: "ajax/get_hanghoa_loaixe.php",
                                        method: "POST",
                                        data: {
                                            nhomHangHoaId: nhomHangHoaId
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                            selectHH.clear();
                                            selectHH.clearOptions();

                                            $.each(response, function (index, item) {
                                                selectHH.addOption({
                                                    value: item.id_hanghoa,
                                                    text: item.ten
                                                });
                                            });

                                            selectHH.enable();
                                            selectHH.refreshOptions();
                                        }
                                    });
                                } else {
                                    selectHH.clearOptions();
                                }
                            });

                        </script>

                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">Số lượng</label>
                            <input type="number" class="form-control" name="soluong" id="soluong"
                                placeholder="Nhập số lượng" value="<?php echo $items['soluong']; ?>" required>

                            <div class="invalid-feedback">
                                Nhập số lượng.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">Số kg</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="sokg" id="sokg" placeholder="Nhập số kg..."
                                    value="<?php echo $items['sokg']; ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        Kg</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập số kg.
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6  mb-3">
                            <label for="validationCustom01">Tuyến vận tải</label>
                            <select name="select_TVT" class="" id="select_TVT" required>
                                <option value="">--Chọn tuyến vận tải--</option>
                                <?php foreach ($resultTVT as $items6): ?>
                                    <option value="<?php echo $items6['id_tuyenvantai']; ?>" <?php echo ($items6['id_tuyenvantai'] == $items['id_tuyenvantai']) ? 'selected' : ''; ?>>
                                        <?php echo $items6['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn tuyến vận tải.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_TVT", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-3 mb-3">
                            <label for="culy">Cự ly</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="culy" id="culy" placeholder="Cự ly"
                                    value="<?php echo $items['culy']; ?>" required readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        Km
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập cự ly.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="dautieuthu">Dầu tiêu thụ</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="dautieuthu" id="dautieuthu"
                                    placeholder="Dầu tiêu thụ" value="<?php echo $items['dautieuthu']; ?>" required
                                    readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        lít
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập dầu tiêu thụ
                                </div>
                            </div>

                        </div>

                        <script>
                            $(document).ready(function () {
                                $("#select_TVT").change(function () {
                                    var idTuyen = $(this).val();
                                    $.ajax({
                                        url: "ajax/get_culy_dautieuthu.php",
                                        method: "POST",
                                        data: {
                                            idTuyen: idTuyen
                                        },
                                        dataType: "json",
                                        success: function (response) {
                                            $("#culy").val(response.culy);
                                            $("#dautieuthu").val(response.dautieuthu);
                                        }
                                    });
                                });
                            });
                        </script>


                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">Ngày đóng container</label>
                            <input type="date" class="form-control" name="ngaydongcontainer" id="validationCustom02"
                                placeholder="Chọn ngày đóng container" value="<?php echo $items['ngaydongcontainer']; ?>"
                                required>
                            <div class="invalid-feedback">
                                Ngày đóng container.
                            </div>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">Giờ đóng container</label>
                            <input type="time" class="form-control" name="giodongcontainer" id="giodongcontainer"
                                placeholder="Chọn giờ đóng container" value="<?php echo $items['giodongcontainer']; ?>">

                            <div class="invalid-feedback">
                                Chọn giờ đóng container.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="ngaycatmang">Ngày cắt máng</label>
                            <input type="date" class="form-control" name="ngaycatmang" id="ngaycatmang"
                                placeholder="Chọn ngày cắt máng" value="<?php echo $items['ngaycatmang']; ?>">
                            <div class="invalid-feedback">
                                Ngày cắt máng.
                            </div>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="giocatmang">Giờ cắt máng</label>
                            <input type="time" class="form-control" name="giocatmang" id="giocatmang"
                                placeholder="Chọn giờ cắt máng" value="<?php echo $items['giocatmang']; ?>">

                            <div class="invalid-feedback">
                                Chọn giờ cắt máng.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nguoigiaonhan">Người giao nhận</label>
                            <input type="text" class="form-control" name="nguoigiaonhan" id="nguoigiaonhan"
                                placeholder="Nhập người giao nhận" value="<?php echo $items['nguoigiaonhan']; ?>" required>

                            <div class="invalid-feedback">
                                Nhập người giao nhận.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="dienthoai">Số điện thoại</label>
                            <input type="text" class="form-control" name="dienthoai" id="dienthoai" placeholder="Nhập SĐT"
                                value="<?php echo $items['dienthoai']; ?>">

                            <div class="invalid-feedback">
                                Nhập SĐT.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="giacuoc">Giá cước</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="giacuoc" id="giacuoc" placeholder="Giá cước"
                                    value="<?php echo $items['giacuoc']; ?>" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    giá cước.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="thuthutuc">Thu thủ tục</label>
                            <div class="input-group mb-2">

                                <input type="text" class="form-control" name="thuthutuc" id="thuthutuc"
                                    placeholder="Nhập thu thủ tục..." value="<?php echo $items['thuthutuc']; ?>">
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập thu thủ tục.
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="thukhac">Thu khác</label>
                            <div class="input-group mb-2">

                                <input type="text" class="form-control" name="thukhac" id="thukhac"
                                    placeholder="Nhập thu khác..." value="<?php echo $items['thukhac']; ?>">
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập thu khác
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="hanthanhtoan">Hạn thanh toán</label>
                            <input type="date" class="form-control" name="hanthanhtoan" id="hanthanhtoan"
                                placeholder="Chọn hạn thanh toán" value="<?php echo $items['hanthanhtoan']; ?>" required>

                            <div class="invalid-feedback">
                                Chọn hạn thanh toán.
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="ghichu">Ghi chú</label>
                            <textarea class="form-control" name="ghichu" id="ghichu" placeholder="Nhập ghi chú..."
                                rows="3"><?php echo $items['ghichu']; ?></textarea>
                            <div class="invalid-feedback">
                                Nhập ghi chú.
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="customFile">Ảnh 1</label>

                            <div class="custom-file">
                                <?php
                                if (!empty($items['anh1'])) {
                                    echo '<input type="file" class="custom-file-input" name="anh1"  id="customFile"  onchange="hienThiTenFile()" value="' . $items['anh1'] . '">';
                                    echo '<label class="custom-file-label" for="customFile">' . $items['anh1'] . '</label>';
                                } else {
                                    echo '<input type="file" class="custom-file-input" name="anh1" id="customFile"  onchange="hienThiTenFile()">';
                                    echo '<span class="custom-file-label" id="customFileLabel">Chọn ảnh</span>';
                                }
                                ?>
                            </div>
                            <div class="invalid-feedback">
                                Chọn file ảnh
                            </div>
                            <a class="mt-3" width="100px" href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                <img class="mt-3" width="100px" src="img/<?php echo $items['anh1']; ?>">
                            </a>
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="customFile1">Ảnh 2</label>
                            <div class="custom-file">
                                <?php
                                if (!empty($items['anh2'])) {
                                    echo '<input type="file" class="custom-file-input" name="anh2"  id="customFile1"  onchange="hienThiTenFile1()" value="' . $items['anh2'] . '">';
                                    echo '<label class="custom-file-label anh2" for="customFile1">' . $items['anh2'] . '</label>';
                                } else {
                                    echo '<input type="file" class="custom-file-input" name="anh2" id="customFile1"  onchange="hienThiTenFile1()">';
                                    echo '<span class="custom-file-label anh2" id="customFileLabel">Chọn ảnh</span>';
                                }
                                ?>
                            </div>
                            <div class="invalid-feedback">
                                Chọn file ảnh
                            </div>
                            <a class="mt-3" width="100px" href="img/<?php echo $items['anh2']; ?>" target="_blank">
                                <img class="mt-3" width="100px" src="img/<?php echo $items['anh2']; ?>">
                            </a>
                        </div>


                    </div>
                    <!-- hiện tên ảnh -->
                    <script>
                        function hienThiTenFile() {
                            var input = document.getElementById('customFile');
                            var label = document.querySelector('.custom-file-label');
                            label.textContent = input.files[0].name;
                        }

                        function hienThiTenFile1() {
                            var input1 = document.getElementById('customFile1');
                            var label1 = document.querySelector('.anh2');
                            label1.textContent = input1.files[0].name;
                        }
                    </script>


                    <div class="col-md-12 mb-3 ">
                        <div class="form-group float-right">
                            <input class="form-check-input checkbox-to" type="checkbox" name="trangthai" id="customCheckbox"
                                onchange="toggleValue(this);" <?php echo ($items['trangthai'] == 'Hủy') ? 'checked' : ''; ?>>
                            <label class="mr-2" for="customCheckbox">Hủy</label>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var checkbox = document.getElementById("customCheckbox");
                            // checkbox.value = "Hoàn thành";
                        });
                        function toggleValue(checkbox) {
                            if (checkbox.checked) {
                                checkbox.value = "Hủy";
                            } else {
                                checkbox.value = "Hoàn thành";
                            }
                        }
                    </script>
            </div>
        <?php endforeach ?>
        <div class="modal-footer">
            <a href="list_donhang.php" class="btn btn-secondary mr-3">Trở lại </a>
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
// include ('includes/footer.php');
include ('includes/scripts.php');
?>