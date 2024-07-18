<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php'); 

if (isset($_POST['suabtn'])) {
    $id_donhang = $_POST['edit_id_donhang'];
    $id_ctdhtu = $_POST['edit_id'];

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

    // data tạm ứng
    $sqlTU = "SELECT chitietdonhangtamung.id_ctdhtu,chitietdonhangtamung.id_donhang,DATE(chitietdonhangtamung.ngaytamung) as ngaytamung,
    chitietdonhangtamung.id_nhansu as idnhansutamung,nhansu.ten as tennhansutamung,chitietdonhangtamung.tiencuocvo,
    chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ngaythanhtoan,
    chitietdonhangtamung.giothanhtoan,chitietdonhangtamung.ghichu,chitietdonhangtamung.anh1,donhang.booking,
    DATE(donhang.ngaytao) as ngaytaodonhang,donhang.loaihang,donhang.id_nhomhanghoa,nhomhanghoa.ten as tennhomhanghoa,
    donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.sokg,donhang.id_khachhang,khachhang.ten as tenkhachhang,donhang.id_tuyenvantai,
    tuyenvantai.ten as tentuyenvantai,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(chitietdonhangtamung.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(chitietdonhangtamung.ngaysua) as ngaysua
    FROM chitietdonhangtamung 
    INNER JOIN nguoidung ON chitietdonhangtamung.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON chitietdonhangtamung.id_nguoisua = nguoidung2.id_nguoidung
    
    INNER JOIN donhang ON donhang.id_donhang = chitietdonhangtamung.id_donhang
    INNER JOIN nhansu ON nhansu.id_auto_increment = chitietdonhangtamung.id_nhansu
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    
    WHERE id_ctdhtu ='$id_ctdhtu'";

    $stmt2 = $conn->prepare($sqlTU);
    $query2 = $stmt2->execute();
    $resultTU = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultTU[] = $row;
    }


} else {
    // phần này để doubleclick vào row trong table
    $id_donhang = $_GET['donhang_id'];
    $id_ctdhtu = $_GET['edit_id'];

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

    // data tạm ứng
    $sqlTU = "SELECT chitietdonhangtamung.id_ctdhtu,chitietdonhangtamung.id_donhang,DATE(chitietdonhangtamung.ngaytamung) as ngaytamung,
    chitietdonhangtamung.id_nhansu as idnhansutamung,nhansu.ten as tennhansutamung,chitietdonhangtamung.tiencuocvo,
    chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ngaythanhtoan,
    chitietdonhangtamung.giothanhtoan,chitietdonhangtamung.ghichu,chitietdonhangtamung.anh1,donhang.booking,
    DATE(donhang.ngaytao) as ngaytaodonhang,donhang.loaihang,donhang.id_nhomhanghoa,nhomhanghoa.ten as tennhomhanghoa,
    donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.sokg,donhang.id_khachhang,khachhang.ten as tenkhachhang,donhang.id_tuyenvantai,
    tuyenvantai.ten as tentuyenvantai,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(chitietdonhangtamung.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(chitietdonhangtamung.ngaysua) as ngaysua
    FROM chitietdonhangtamung 
    INNER JOIN nguoidung ON chitietdonhangtamung.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON chitietdonhangtamung.id_nguoisua = nguoidung2.id_nguoidung
    
    INNER JOIN donhang ON donhang.id_donhang = chitietdonhangtamung.id_donhang
    INNER JOIN nhansu ON nhansu.id_auto_increment = chitietdonhangtamung.id_nhansu
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    
    WHERE id_ctdhtu ='$id_ctdhtu'";

    $stmt2 = $conn->prepare($sqlTU);
    $query2 = $stmt2->execute();
    $resultTU = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultTU[] = $row;
    }
}


$sqlNhanSu = "SELECT * FROM nhansu";
$stmt1 = $conn->prepare($sqlNhanSu);
$query = $stmt1->execute();
$resultNS = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNS[] = $row;
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa tạm ứng</h1>

            <form class="needs-validation" novalidate action="them_tamung.php" method="POST"
                enctype="multipart/form-data">
                <div class="form-row">
                    <?php foreach ($resultDH as $items): ?>
                        <?php foreach ($resultTU as $itemsTU): ?>
                            <!-- thông tin đơn hàng tạm ứng -->
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3">
                                    <div class="card-header">
                                        Thông tin đơn hàng
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="id_donhang_tamung">Mã đơn hàng :</label>
                                                <input type="text" class="form-control" name="id_donhang_tamung"
                                                    id="id_donhang_tamung" placeholder="mã đơn hàng"
                                                    value="<?php echo $items['id_donhang']; ?>" readonly>
                                            </div>

                                            <div class="col-md-5 mb-3">
                                                <label for="">Sales :</label>
                                                <input type="text" class="form-control" id="sales_tamung" placeholder="Sales"
                                                    value="<?php echo $items['tensales']; ?>" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Ngày lập :</label>
                                                <input disabled type="date" class="form-control" id="ngaytao_tamung"
                                                    value="<?php echo $items['ngaytao']; ?>">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Booking :</label>
                                                <input type="text" class="form-control" id="booking_tamung"
                                                    placeholder="booking" value="<?php echo $items['booking']; ?>" readonly>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label for="">Khách hàng :</label>
                                                <input type="text" class="form-control" id="khachhang_tamung"
                                                    placeholder="khachhang" value="<?php echo $items['tenkh']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Loại hàng :</label>
                                                <input type="text" class="form-control" id="loaihang_tamung"
                                                    placeholder="loaihang"
                                                    value="<?php echo ($items['loaihang'] == 1) ? 'Nhập' : (($items['loaihang'] == 2) ? 'Xuất' : (($items['loaihang'] == 3) ? 'Nội địa' : '')); ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Nhóm hàng hóa :</label>
                                                <input type="text" class="form-control" id="nhomhanghoa_tamung"
                                                    placeholder="nhomhanghoa" value="<?php echo $items['id_nhomhanghoa']; ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Tuyến vận tải :</label>
                                                <input type="text" class="form-control" id="tvt_tamung" placeholder="tvt"
                                                    value="<?php echo $items['id_tuyenvantai']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Trọng lượng :</label>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="trongluong_tamung"
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
                                                <textarea class="form-control" id="ghichu_tamung" placeholder="Ghi chú..."
                                                    rows="3" disabled value="<?php echo $items['ghichu']; ?>"></textarea>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- card tạm ứng --> 

                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-info mb-3">
                                    <div class="card-header">
                                        Tạm ứng
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <input type="hidden" readonly class="form-control" name="id_edit" id="validationCustom01"
                                                    placeholder="Mã tạm ứng" value="<?php echo $itemsTU['id_ctdhtu']; ?>" required>
                                            </div>
                                            <div class="col-md-3  mb-3">
                                                <label for="select_sales_tamung">Cán bộ tạm ứng</label>
                                                <select name="select_sales_tamung" class="" id="select_sales_tamung" required>
                                                    <option value="">--Chọn nhân sự--</option>
                                                    <?php foreach ($resultNS as $items1): ?>
                                                        <option value="<?php echo $items1['id_auto_increment']; ?>" <?php echo ($items1['id_auto_increment'] == $itemsTU['idnhansutamung']) ? 'selected' : ''; ?>>
                                                            <?php echo $items1['ten']; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Chọn cán bộ.
                                                </div>
                                            </div>
                                            <script>
                                                new TomSelect("#select_sales_tamung", {
                                                    create: false,
                                                    sortField: {
                                                        field: "text",
                                                        direction: "desc"
                                                    }
                                                });

                                            </script>

                                            <div class="col-md-3 mb-3">
                                                <label for="ngaytamung">Ngày tạm ứng* :</label>
                                                <input type="date" class="form-control" name="ngaytamung" id="ngaytamung"
                                                    placeholder="Chọn ngày tạm ứng" value="<?php echo $itemsTU['ngaytamung']; ?>" required>
                                                <div class="invalid-feedback">
                                                    Ngày tạm ứng.
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="ngaythanhtoan_tamung">Ngày thanh toán :</label>
                                                <input type="date" class="form-control" name="ngaythanhtoan_tamung"
                                                    id="ngaythanhtoan_tamung" placeholder="Chọn ngày thanh toán" value="<?php echo $itemsTU['ngaythanhtoan']; ?>">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="giothanhtoan_tamung">Giờ thanh toán :</label>
                                                <input type="time" class="form-control" name="giothanhtoan_tamung"
                                                    id="giothanhtoan_tamung" placeholder="Chọn giờ thanh toán" value="<?php echo $itemsTU['giothanhtoan']; ?>">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tiencuocvo_tamung">Tiền cước vỏ :</label>
                                                <input type="text" class="form-control" name="tiencuocvo_tamung"
                                                    id="tiencuocvo_tamung" placeholder="Nhập tiền cước vỏ..." value="<?php echo $itemsTU['tiencuocvo']; ?>">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienhaiquan_tamung">Tiền hải quan :</label>
                                                <input type="text" class="form-control" name="tienhaiquan_tamung"
                                                    id="tienhaiquan_tamung" placeholder="Nhập tiền hải quan..." value="<?php echo $itemsTU['tienhaiquan']; ?>">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tiennangha_tamung">Tiền nâng hạ :</label>
                                                <input type="text" class="form-control" name="tiennangha_tamung"
                                                    id="tiennangha_tamung" placeholder="Nhập tiền nâng hạ..." value="<?php echo $itemsTU['tiennangha']; ?>">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienkhac_tamung">Tiền khác :</label>
                                                <input type="text" class="form-control" name="tienkhac_tamung"
                                                    id="tienkhac_tamung" placeholder="Nhập tiền khác..." value="<?php echo $itemsTU['tienkhac']; ?>">
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label for="customFile_tamung">Ảnh thanh toán :</label>
                                                <div class="custom-file">
                                                    <?php
                                                    if (!empty($itemsTU['anh1'])) {
                                                        echo '<input type="file" class="custom-file-input" name="anh1_tamung"  id="customFile_tamung"  onchange="hienThiTenFileTamUng()" value="' . $itemsTU['anh1'] . '">';
                                                        echo '<label class="custom-file-label tamung-lbl" for="customFile_tamung">' . $itemsTU['anh1'] . '</label>';
                                                    } else {
                                                        echo '<input type="file" class="custom-file-input" name="anh1_tamung" id="customFile_tamung"  onchange="hienThiTenFileTamUng()">';
                                                        echo '<span class="custom-file-label tamung-lbl" id="customFileLabel">Chọn ảnh</span>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Chọn file ảnh
                                                </div>
                                                <a class="mt-3" width="100px" href="img/<?php echo $itemsTU['anh1']; ?>" target="_blank">
                                                    <img class="mt-3" width="100px" src="img/<?php echo $itemsTU['anh1']; ?>">
                                                </a>
                                            </div>

                                            <!-- hiện tên ảnh -->
                                            <script>
                                                function hienThiTenFileTamUng() {
                                                    var input_tamung = document.getElementById('customFile_tamung');
                                                    var label_tamung = document.querySelector('.tamung-lbl');
                                                    label_tamung.textContent = input_tamung.files[0].name;
                                                }
                                            </script>



                                            <div class="col-md-12 mb-3">
                                                <label for="ghichu_tamung">Ghi chú :</label>
                                                <textarea class="form-control" name="ghichu_tamung" id="ghichu_tamung"
                                                    placeholder="Nhập ghi chú..." rows="3" > <?php echo $itemsTU['ghichu']; ?></textarea>
                                                    
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <!-- end card tạm ứng -->
                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_tamung.php" class="btn btn-secondary mr-3">Trở lại </a>
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