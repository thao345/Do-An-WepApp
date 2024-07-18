<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) { 
    $id_donhang = $_POST['edit_id_donhang'];
    $id_nhomhanghoa = $_POST['edit_id_nhh'];
    $id_thauphu = $_POST['edit_id_tp'];
    $id_dieuhanh = $_POST['edit_id'];


    // data ĐƠn hàng
    $sqlDonHang = "SELECT *,  nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh 
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
     WHERE id_donhang ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data điều hành
    $sqlDieuHanh = "SELECT dieuhanh.id_dieuhanh,dieuhanh.id_donhang,dieuhanh.tinhtrangdonhang,dieuhanh.sodonkethop,dieuhanh.id_thauphu,
    thauphu.ten as tenthauphu ,thauphu.masothue,dieuhanh.id_xe,xe.bienso,dieuhanh.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai,
    dieuhanh.ghichu
    FROM dieuhanh 
    INNER JOIN donhang ON donhang.id_donhang = dieuhanh.id_donhang
    INNER JOIN thauphu ON thauphu.id_thauphu = dieuhanh.id_thauphu
    INNER JOIN xe ON xe.id_xe = dieuhanh.id_xe
    INNER JOIN taixe ON taixe.id_taixe = dieuhanh.id_taixe
    
    WHERE id_dieuhanh ='$id_dieuhanh'";

    $stmt2 = $conn->prepare($sqlDieuHanh);
    $query2 = $stmt2->execute();
    $resultDieuHanh = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultDieuHanh[] = $row;
    }


} else {
    // phần này để doubleclick vào row trong table
    $id_donhang = $_GET['donhang_id'];
    $id_dieuhanh = $_GET['edit_id'];

    $id_nhomhanghoa = $_GET['edit_id_nhh'];
    $id_thauphu = $_GET['edit_id_tp'];

    // data ĐƠn hàng
    $sqlDonHang = "SELECT *,  nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh 
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
     WHERE id_donhang ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data điều hành
    $sqlTU = "SELECT dieuhanh.id_dieuhanh,dieuhanh.id_donhang,dieuhanh.tinhtrangdonhang,dieuhanh.sodonkethop,dieuhanh.id_thauphu,
    thauphu.ten as tenthauphu ,thauphu.masothue,dieuhanh.id_xe,xe.bienso,dieuhanh.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai,
    dieuhanh.ghichu
    FROM dieuhanh 
    INNER JOIN donhang ON donhang.id_donhang = dieuhanh.id_donhang
    INNER JOIN thauphu ON thauphu.id_thauphu = dieuhanh.id_thauphu
    INNER JOIN xe ON xe.id_xe = dieuhanh.id_xe
    INNER JOIN taixe ON taixe.id_taixe = dieuhanh.id_taixe
    
    WHERE id_dieuhanh ='$id_dieuhanh'";

    $stmt2 = $conn->prepare($sqlTU);
    $query2 = $stmt2->execute();
    $resultDieuHanh = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultDieuHanh[] = $row;
    }
}


$sqlMaTP = "SELECT id_thauphu, thauphu.ten as tentp FROM thauphu INNER JOIN nhomhanghoa ON nhomhanghoa.id_nhomhanghoa
= thauphu.id_nhomhanghoa WHERE thauphu.id_nhomhanghoa ='$id_nhomhanghoa'";
$stmt1 = $conn->prepare($sqlMaTP);
$query = $stmt1->execute();
$resultThauPhu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultThauPhu[] = $row;
}

$sqlMaXe = "SELECT xe.id_xe,xe.bienso
FROM xe 
INNER JOIN thauphu ON thauphu.id_thauphu = xe.id_thauphu 
WHERE xe.trangthaixe = 'OK'  and xe.id_thauphu ='$id_thauphu'";
$stmt2 = $conn->prepare($sqlMaXe);
$query = $stmt2->execute();
$resultXe = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultXe[] = $row;
}

$sqlTaixe = "SELECT taixe.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai 
FROM taixe 
INNER JOIN thauphu ON thauphu.id_thauphu = taixe.id_thauphu
WHERE taixe.id_thauphu  ='$id_thauphu'";
$stmt3 = $conn->prepare($sqlTaixe);
$query = $stmt3->execute();
$resultTaiXe = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultTaiXe[] = $row;
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
                <?php
                include 'includes/userInformation.php';
                ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa điều hành</h1>

            <form class="needs-validation" novalidate action="them_dieuhanh.php" method="POST"
                enctype="multipart/form-data">
                <div class="form-row">
                    <?php foreach ($resultDH as $items): ?>
                        <?php foreach ($resultDieuHanh as $itemsDieuHanh): ?>
                            <!-- thông tin đơn hàng điều hành -->
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3">
                                    <div class="card-header">
                                        Thông tin đơn hàng
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="id_donhang_dieuhanh">Mã đơn hàng :</label>
                                                <input type="text" class="form-control" name="id_donhang_dieuhanh"
                                                    id="id_donhang_dieuhanh" placeholder="mã đơn hàng"
                                                    value="<?php echo $items['id_donhang']; ?>" readonly>
                                            </div>

                                            <div class="col-md-5 mb-3">
                                                <label for="">Sales :</label>
                                                <input type="text" class="form-control" id="sales_dieuhanh" placeholder="Sales"
                                                    value="<?php echo $items['tensales']; ?>" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Ngày lập :</label>
                                                <input disabled type="date" class="form-control" id="ngaytao_dieuhanh"
                                                    value="<?php echo $items['ngaytao']; ?>">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Booking :</label>
                                                <input type="text" class="form-control" id="booking_dieuhanh"
                                                    placeholder="booking" value="<?php echo $items['booking']; ?>" readonly>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label for="">Khách hàng :</label>
                                                <input type="text" class="form-control" id="khachhang_dieuhanh"
                                                    placeholder="khachhang" value="<?php echo $items['tenkh']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Loại hàng :</label>
                                                <input type="text" class="form-control" id="loaihang_dieuhanh"
                                                    placeholder="loaihang"
                                                    value="<?php echo ($items['loaihang'] == 1) ? 'Nhập' : (($items['loaihang'] == 2) ? 'Xuất' : (($items['loaihang'] == 3) ? 'Nội địa' : '')); ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Nhóm hàng hóa :</label>
                                                <input type="text" class="form-control" id="nhomhanghoa_dieuhanh"
                                                    placeholder="nhomhanghoa" value="<?php echo $items['id_nhomhanghoa']; ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Tuyến vận tải :</label>
                                                <input type="text" class="form-control" id="tvt_dieuhanh" placeholder="tvt"
                                                    value="<?php echo $items['id_tuyenvantai']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Trọng lượng :</label>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="trongluong_dieuhanh"
                                                        placeholder="trongluong" value="<?php echo $items['sokg']; ?>" readonly>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            Kg</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label for="ghichu">Ghi chú :</label>
                                                <textarea class="form-control" id="ghichu_dieuhanh" placeholder="Ghi chú..."
                                                    rows="3" disabled value="<?php echo $items['ghichu']; ?>"></textarea>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- card điều hành -->

                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-dieuhanh  mb-3">
                                    <div class="card-header">
                                        Điều hành 
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">

                                            <div class="col-md-12 mb-3">
                                                <input type="hidden" readonly class="form-control" name="id_edit" id="validationCustom01"
                                                    placeholder="Mã đh" value="<?php echo $itemsDieuHanh['id_dieuhanh']; ?>" required>
                                            </div>
                                   
                                            <div class="col-md-2  mb-3">
                                                <label for="select_thauphu_dh">(1) Mã chủ xe :</label>
                                                <select name="select_thauphu_dh" class="" id="select_thauphu_dh" required>
                                                    <option value="">--Chọn thầu phụ--</option>
                                                    <?php foreach ($resultThauPhu as $itemTP): ?>
                                                        <option value="<?php echo $itemTP['id_thauphu']; ?>" <?php echo ($itemTP['id_thauphu'] == $itemsDieuHanh['id_thauphu']) ? 'selected' : ''; ?>>
                                                            <?php echo $itemTP['id_thauphu']; ?>
                                                        </option>
                                                    <?php endforeach ?>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Chọn thầu phụ.
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tenthauphu_dh">Tên chủ xe :</label>
                                                <input type="text" class="form-control" name="tenthauphu_dh" id="tenthauphu_dh"
                                                    placeholder="Tên chủ xe..." value=" <?php echo $itemsDieuHanh['tenthauphu']; ?>" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="masothue_dh">Mã số thuế :</label>
                                                <input type="text" class="form-control" name="masothue_dh" id="masothue_dh"
                                                    placeholder="Mã số thuế..." value="<?php echo $itemsDieuHanh['masothue']; ?>" readonly>
                                            </div>
                                            <script>
                                                $('#select_thauphu_dh').change(function () {
                                                    var selectedThauphuId = $(this).val();
                                                    // console.log(selectedThauphuId)
                                                    $.ajax({
                                                        url: 'ajax/get4_thauphuById.php',
                                                        type: 'POST',
                                                        data: {
                                                            thauphuId: selectedThauphuId
                                                        },
                                                        dataType: 'json',
                                                        success: function (response) {
                                                            // console.log(response);
                                                            $('#tenthauphu_dh').val(response.tenthauphu);
                                                            $('#masothue_dh').val(response.masothue);

                                                        },
                                                        error: function (xhr, status, error) {
                                                            console.log(error);
                                                        }
                                                    });
                                                });
                                            </script>

                                            <div class="col-md-4  mb-3">
                                                <label for="select_bienso_dh">(2) Biển số :</label>
                                                <select name="select_bienso_dh" class="" id="select_bienso_dh" required>
                                                    <option value="">--Chọn biển số--</option> 
                                                    <?php foreach ($resultXe as $itemXe): ?>
                                                        <option value="<?php echo $itemXe['id_xe']; ?>" <?php echo ($itemXe['id_xe'] == $itemsDieuHanh['id_xe']) ? 'selected' : ''; ?>>
                                                            <?php echo $itemXe['bienso']; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Chọn biển số.
                                                </div>
                                            </div>

                                            <div class="col-md-4  mb-3">
                                                <label for="select_taixe_dh">(3) Tài xế :</label>
                                                <select name="select_taixe_dh" class="" id="select_taixe_dh" required>
                                                    <option value="">--Chọn tài xế--</option>
                                                    <?php foreach ($resultTaiXe as $itemTX): ?>
                                                        <option value="<?php echo $itemTX['id_taixe']; ?>" <?php echo ($itemTX['id_taixe'] == $itemsDieuHanh['id_taixe']) ? 'selected' : ''; ?>>
                                                            <?php echo $itemTX['tentaixe']; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Chọn tài xế.
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-4 mb-3">
                                                <label for="sodienthoai_dh">Số điện thoại :</label>
                                                <input type="text" class="form-control" name="sodienthoai_dh"
                                                    id="sodienthoai_dh" placeholder="Số điện thoại..." value=" <?php echo $itemsDieuHanh['sodienthoai']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3  mb-3">
                                                <label for="select_tinhtrangdonhang_dh">Tình trạng :</label>
                                                <select name="select_tinhtrangdonhang_dh" class=""
                                                    id="select_tinhtrangdonhang_dh" required>
                                                    <option value="">--Chọn tình trạng--</option>
                                                    <option value="Đơn" <?php if ($itemsDieuHanh['tinhtrangdonhang'] == 'Đơn') echo 'selected'; ?>>Đơn</option>
                                                    <option value="Kết hợp" <?php if ($itemsDieuHanh['tinhtrangdonhang'] == 'Kết hợp') echo 'selected'; ?>>Kết hợp</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Chọn tình trạng.
                                                </div>
                                            </div>

                                            <script>
                                                new TomSelect("#select_tinhtrangdonhang_dh", {
                                                    create: false,
                                                    sortField: {
                                                        field: "text",
                                                        direction: "desc"
                                                    }
                                                });

                                            </script>

                                            <div class="col-md-3 mb-3">
                                                <label for="sodonkethop_dh">Số đơn kết hợp :</label>
                                                <input type="number" class="form-control" name="sodonkethop_dh"
                                                    id="sodonkethop_dh" placeholder="Nhập số đơn" value="<?php echo $itemsDieuHanh['sodonkethop']; ?>" 
                                                    <?php if ($itemsDieuHanh['sodonkethop'] < 1 || is_null($itemsDieuHanh['sodonkethop'])) echo 'disabled'; ?>>
                                            </div>
                                            
                                            <script>
                                                $('#select_tinhtrangdonhang_dh').change(function () {
                                                    var selectedValue = $(this).val();
                                                    if (selectedValue === 'Kết hợp') {
                                                        $('#sodonkethop_dh').prop('disabled', false).val(1);
                                                    } else {
                                                        $('#sodonkethop_dh').prop('disabled', true).val(0);
                                                    }
                                                });
                                            </script>

                                            <div class="col-md-12 mb-3">
                                                <label for="ghichu_dh">Ghi chú :</label>
                                                <textarea class="form-control" name="ghichu_dh" id="ghichu_dh"
                                                    placeholder="Nhập ghi chú..." rows="3"><?php echo $itemsDieuHanh['ghichu']; ?></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <!-- end card điều hành -->
                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_dieuhanh.php" class="btn btn-secondary mr-3">Trở lại </a>
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

    <!-- ajax lấy data đơn hàng bên điều hành-->
    <script>
        $(document).ready(function () {
           
            // Khởi tạo TomSelect
            var selectThauphu = new TomSelect("#select_thauphu_dh", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "desc"
                }
            });

            
            var selectTaiXe = new TomSelect("#select_taixe_dh", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "desc"
                }
            });
            var selectBienSo = new TomSelect("#select_bienso_dh", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "desc"
                }
            });
            // lắng nghe thay đổi thầu phụ
            $('#select_thauphu_dh').change(function () {
                var selectedThauphuId = $('#select_thauphu_dh').val();
                selectBienSo.clear(); // xóa data cũ 
                selectTaiXe.clear();
                // console.log(selectedThauphuId);

                //lấy biển xe
                $.ajax({
                    url: 'ajax/get_xe_byIdThauPhu.php',
                    type: 'POST',
                    data: {
                        thauphuId: selectedThauphuId
                    },
                    dataType: 'json',
                    success: function (response) {
                        // console.log(response);

                        selectBienSo.clearOptions();
                    if (response.length > 0) {
                        $.each(response, function (index, item) {
                            selectBienSo.addOption({
                                value: item.id_xe,
                                text: item.bienso
                            });
                        });
                        selectBienSo.refreshOptions();

                    }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });

                //lấy tài xế
                $.ajax({
                    url: 'ajax/get_taixe_byIdThauPhu.php',
                    type: 'POST',
                    data: {
                        thauphuId: selectedThauphuId
                    },
                    dataType: 'json',
                    success: function (responseTaiXe) {
                        // console.log(responseTaiXe);

                        selectTaiXe.clearOptions();
                    if (responseTaiXe.length > 0) {
                        $.each(responseTaiXe, function (index, item) {
                            selectTaiXe.addOption({
                                value: item.id_taixe,
                                text: item.tentaixe
                            });
                        });
                        selectTaiXe.refreshOptions();

                    }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            // lắng nghe thay đổi tài xế để lấy sdt
            $('#select_taixe_dh').change(function () {
                var selectedTaiXeId = $('#select_taixe_dh').val();
                // console.log(selectedTaiXeId);
                $.ajax({
                    url: 'ajax/get_sdt_byIdTaiXe.php',
                    type: 'POST',
                    data: {
                        taixeId: selectedTaiXeId
                    },
                    dataType: 'json',
                    success: function (response) {
                        // console.log(response);

                        // vì lúc thay đổi mã tp chưa có id tài xế lên bị lỗi k nhận đc id_taixe
                        $('#sodienthoai_dh').val(response.sodienthoai);
                       
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>

    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>