<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id_donhang = $_POST['edit_id_donhang'];
    $id_cpvt = $_POST['edit_id'];

    // data ĐƠn hàng
    $sqlDonHang = "SELECT donhang.id_donhang, donhang.ngaydongcontainer,donhang.id_nhomhanghoa,donhang.ngaytao,donhang.booking,donhang.thuthutuc,donhang.thukhac,donhang.sokg, nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh,dieuhanh.id_xe,
    xe.bienso,tuyenvantai.ten as tentuyenvantai,hanghoa.ten as tenhanghoa,phieudonhienlieu.thanhtien,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
    INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa 
    INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
    LEFT JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
     WHERE donhang.id_donhang  ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data cpvt
    $sqlCPVT = "SELECT * FROM `chiphivantai` WHERE id_cpvt ='$id_cpvt'";

    $stmt2 = $conn->prepare($sqlCPVT);
    $query2 = $stmt2->execute();
    $resultCPVT = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultCPVT[] = $row;
    }

    // lấy ra số tiền 1 kg khi bấm sửa
    $totalPriceKg = $resultCPVT[0]['tongchiphi'] - $resultCPVT[0]['tienthuexengoai'] - $resultCPVT[0]['luongchunhat'] -
        $resultCPVT[0]['luongchuyen'] - $resultCPVT[0]['tienanca'] - $resultCPVT[0]['phicauduong']
        - $resultDH[0]['tiencuocvo'] - $resultDH[0]['tienhaiquan'] - $resultDH[0]['tiennangha'] - $resultDH[0]['tienkhac']
        - $resultDH[0]['thanhtien'];

} else {
    // phần này để doubleclick vào row trong table
    $id_donhang = $_GET['donhang_id'];
    $id_cpvt = $_GET['edit_id'];

    // data ĐƠn hàng
    $sqlDonHang = "SELECT donhang.id_donhang, donhang.ngaydongcontainer,donhang.id_nhomhanghoa,donhang.ngaytao,donhang.booking,donhang.thuthutuc,donhang.thukhac,donhang.sokg, nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh,dieuhanh.id_xe,
    xe.bienso,tuyenvantai.ten as tentuyenvantai,hanghoa.ten as tenhanghoa,phieudonhienlieu.thanhtien,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
    INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa 
    INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
    LEFT JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
     WHERE donhang.id_donhang  ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data cpvt
    $sqlCPVT = "SELECT * FROM `chiphivantai` WHERE id_cpvt ='$id_cpvt'";

    $stmt2 = $conn->prepare($sqlCPVT);
    $query2 = $stmt2->execute();
    $resultCPVT = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultCPVT[] = $row;
    }

    // lấy ra số tiền 1 kg khi bấm sửa
    $totalPriceKg = $resultCPVT[0]['tongchiphi'] - $resultCPVT[0]['tienthuexengoai'] - $resultCPVT[0]['luongchunhat'] -
        $resultCPVT[0]['luongchuyen'] - $resultCPVT[0]['tienanca'] - $resultCPVT[0]['phicauduong']
        - $resultDH[0]['tiencuocvo'] - $resultDH[0]['tienhaiquan'] - $resultDH[0]['tiennangha'] - $resultDH[0]['tienkhac']
        - $resultDH[0]['thanhtien'];

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa chi phí vận tải</h1>

            <form class="needs-validation" novalidate action="them_chiphivantai.php" method="POST"
                enctype="multipart/form-data">
                <div class="form-row">
                    <?php foreach ($resultDH as $items): ?>
                        <?php foreach ($resultCPVT as $itemsCPVT): ?>
                            <!-- thông tin đơn hàng của cpvt -->
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3 shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleCPVT" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExampleCPVT">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Thông tin đơn hàng</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleCPVT">
                                        <div class="card-body">
                                            <div class="form-row">

                                                <div class="col-md-3 mb-3">
                                                    <label for="id_donhang_cpvt">Mã đơn hàng :</label>
                                                    <input type="text" class="form-control" name="id_donhang_cpvt"
                                                        id="id_donhang_cpvt" placeholder="mã đơn hàng"
                                                        value="<?php echo $items['id_donhang']; ?>" readonly>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Ngày vận chuyển :</label>
                                                    <input disabled type="date" class="form-control" id="ngaydongcontainer_cpvt"
                                                        value="<?php echo $items['ngaydongcontainer']; ?>">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Ngày lập :</label>
                                                    <input disabled type="date" class="form-control" id="ngaytao_cpvt"
                                                        value="<?php echo $items['ngaytao']; ?>">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Booking :</label>
                                                    <input type="text" class="form-control" id="booking_cpvt"
                                                        placeholder="booking" value="<?php echo $items['booking']; ?>" readonly>
                                                </div>

                                                <div class="col-md-8 mb-3">
                                                    <label for="">Khách hàng :</label>
                                                    <input type="text" class="form-control" id="khachhang_cpvt"
                                                        placeholder="khachhang" value="<?php echo $items['tenkh']; ?>" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Hàng hóa :</label>
                                                    <input type="text" class="form-control" id="hanghoa_cpvt"
                                                        placeholder="Hàng hóa..." value="<?php echo $items['tenhanghoa']; ?>"
                                                        readonly>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <label for="">Nhóm hàng hóa :</label>
                                                    <input type="text" value="<?php echo $items['id_nhomhanghoa']; ?>"
                                                        class="form-control" id="nhomhanghoa_cpvt" placeholder="nhomhanghoa"
                                                        readonly>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Tuyến vận tải :</label>
                                                    <input type="text" class="form-control" id="tvt_cpvt" placeholder="tvt"
                                                        value="<?php echo $items['tentuyenvantai']; ?>" readonly>
                                                </div>


                                                <div class="col-md-3 mb-3">
                                                    <label for="bienso">Biển số :</label>
                                                    <input class="form-control" id="bienso_cpvt" placeholder="Biển số..."
                                                        value="<?php echo $items['bienso']; ?>" readonly></input>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="thuthutuc">Thu thủ tục :</label>
                                                    <div class="input-group mb-2 d-flex ">
                                                        <input type="text" class="form-control" id="thuthutuc_cpvt_display"
                                                            placeholder="Thu thủ tục..."
                                                            value="<?php echo $items['thuthutuc']; ?>" readonly>
                                                        <input type="hidden" name="thuthutuc_cpvt" id="thuthutuc_cpvt"
                                                            value="<?php echo $items['thuthutuc']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#thuthutuc_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#thuthutuc_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#thuthutuc_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#thuthutuc_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="thukhac">Thu khác :</label>
                                                    <div class="input-group mb-2 d-flex ">
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $items['thukhac']; ?>" id="thukhac_cpvt_display"
                                                            placeholder="Thu khác..." readonly>
                                                        <input type="hidden" name="thukhac_cpvt" id="thukhac_cpvt"
                                                            value="<?php echo $items['thukhac']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#thukhac_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#thukhac_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#thukhac_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#thukhac_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card chi phí vận tải -->
                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-info  mb-3  shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleCPVT1" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExampleCPVT1">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Chi phí vận tải</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleCPVT1">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <!-- chi phí đơn hàng -->
                                                <div class="col-md-12 mb-3">
                                                    <input type="hidden" readonly class="form-control" name="id_edit"
                                                        id="validationCustom01" placeholder="Mã cpvt"
                                                        value="<?php echo $itemsCPVT['id_cpvt']; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="phi1kg">Phí cân nặng / 1kg :</label>
                                                    <div class="input-group mb-2 d-flex">
                                                        <input class="form-control" id="phi1kg" placeholder="Phí cân nặng..."
                                                            value="<?php echo $totalPriceKg / $resultDH[0]['sokg']; ?>"></input>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                đ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">x</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Trọng lượng :</label>
                                                    <div class="input-group mb-2 d-flex">
                                                        <input type="text" class="form-control" id="cannang_cpvt_display"
                                                            placeholder="Phí cân nặng..." value="<?php echo $items['sokg']; ?>"
                                                            readonly>
                                                        <input type="hidden" name="cannang_cpvt" id="cannang_cpvt"
                                                            value="<?php echo $items['sokg']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                Kg</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">=</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#cannang_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#cannang_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#cannang_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#cannang_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tongphicannang">Phí cân nặng :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">

                                                        <input type="text" class="form-control" id="tongphicannang_cpvt_display"
                                                            placeholder="Phí cân nặng..." value="" readonly>
                                                        <input type="hidden" name="tongphicannang_cpvt" id="tongphicannang_cpvt"
                                                            value="<?php echo $totalPriceKg; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tongphicannang_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tongphicannang_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }

                                                        $('#phi1kg').on('input', function () {
                                                            var phi1kgValue = parseFloat($(this).val());

                                                            var cannangValue = parseFloat($('#cannang_cpvt').val());

                                                            var tongphicannangValue = phi1kgValue * cannangValue;

                                                            // Cập nhật giá trị mới cho "Phí cân nặng"
                                                            $('#tongphicannang_cpvt_display').val(tongphicannangValue);

                                                            var displayValue = $('#tongphicannang_cpvt_display').val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tongphicannang_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $('#tongphicannang_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $('#tongphicannang_cpvt_display').val('');
                                                            }


                                                        });
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="nhienlieu">Phí nhiên liệu :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="nhienlieu_cpvt_display"
                                                            placeholder="Phí nhiên liệu..."
                                                            value="<?php echo $items['thanhtien']; ?>" readonly>
                                                        <input type="hidden" name="nhienlieu_cpvt" id="nhienlieu_cpvt"
                                                            value="<?php echo $items['thanhtien']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#nhienlieu_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#nhienlieu_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#nhienlieu_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#nhienlieu_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <!-- start phí tạm ứng -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="tiencuocvo">Tiền cước vỏ :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="tiencuocvo_cpvt_display"
                                                            placeholder="Tiền cước vỏ..."
                                                            value="<?php echo $items['tiencuocvo']; ?>" readonly>
                                                        <input type="hidden" name="tiencuocvo_cpvt" id="tiencuocvo_cpvt"
                                                            value="<?php echo $items['tiencuocvo']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tiencuocvo_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tiencuocvo_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tiencuocvo_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tiencuocvo_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienhaiquan">Tiền hải quan :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="tienhaiquan_cpvt_display"
                                                            placeholder="Tiền hải quan..."
                                                            value="<?php echo $items['tienhaiquan']; ?>" readonly>
                                                        <input type="hidden" name="tienhaiquan_cpvt" id="tienhaiquan_cpvt"
                                                            value="<?php echo $items['tienhaiquan']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienhaiquan_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienhaiquan_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienhaiquan_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienhaiquan_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tiennangha">Tiền nâng hạ :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="tiennangha_cpvt_display"
                                                            placeholder="Tiền nâng hạ..."
                                                            value="<?php echo $items['tiennangha']; ?>" readonly>
                                                        <input type="hidden" name="tiennangha_cpvt" id="tiennangha_cpvt"
                                                            value="<?php echo $items['tiennangha']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tiennangha_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tiennangha_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tiennangha_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tiennangha_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienkhac">Tiền khác :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="tienkhac_cpvt_display"
                                                            placeholder="Tiền khác..." value="<?php echo $items['tienkhac']; ?>"
                                                            readonly>
                                                        <input type="hidden" name="tienkhac_cpvt" id="tienkhac_cpvt"
                                                            value="<?php echo $items['tienkhac']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienkhac_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienkhac_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienkhac_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienkhac_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <!--end  phí tạm ứng -->


                                                <!-- chi phí vt -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="phicauduong_cpvt">Phí cầu đường :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="phicauduong_cpvt_display"
                                                            placeholder="Phí cầu đường..."
                                                            value="<?php echo $itemsCPVT['phicauduong']; ?>">
                                                        <input type="hidden" name="phicauduong_cpvt" id="phicauduong_cpvt"
                                                            value="<?php echo $itemsCPVT['phicauduong']; ?>">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#phicauduong_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#phicauduong_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#phicauduong_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#phicauduong_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienanca_cpvt">Tiền ăn ca :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="tienanca_cpvt_display"
                                                            placeholder="Tiền ăn ca..."
                                                            value="<?php echo $itemsCPVT['tienanca']; ?>">
                                                        <input type="hidden" name="tienanca_cpvt" id="tienanca_cpvt"
                                                            value="<?php echo $itemsCPVT['tienanca']; ?>">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienanca_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienanca_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienanca_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienanca_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>


                                                <div class="col-md-3 mb-3">
                                                    <label for="luongchuyen_cpvt">Lương chuyến :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">

                                                        <input type="text" class="form-control" id="luongchuyen_cpvt_display"
                                                            placeholder="Lương chuyến..."
                                                            value="<?php echo $itemsCPVT['luongchuyen']; ?>">
                                                        <input type="hidden" name="luongchuyen_cpvt" id="luongchuyen_cpvt"
                                                            value="<?php echo $itemsCPVT['luongchuyen']; ?>">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#luongchuyen_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#luongchuyen_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#luongchuyen_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#luongchuyen_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="luongchunhat_cpvt">Lương chủ nhật :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control" id="luongchunhat_cpvt_display"
                                                            placeholder="Lương chủ nhật..."
                                                            value="<?php echo $itemsCPVT['luongchunhat']; ?>">
                                                        <input type="hidden" name="luongchunhat_cpvt" id="luongchunhat_cpvt"
                                                            value="<?php echo $itemsCPVT['luongchunhat']; ?>">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">+</div>
                                                    </div>
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#luongchunhat_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#luongchunhat_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#luongchunhat_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#luongchunhat_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienthuexengoai_cpvt">Tiền thuê xe ngoài
                                                        :</label>
                                                    <div class="input-group mb-2 d-flex calculation-input">
                                                        <input type="text" class="form-control"
                                                            id="tienthuexengoai_cpvt_display"
                                                            placeholder="Tiền thuê xe ngoài..."
                                                            value="<?php echo $itemsCPVT['tienthuexengoai']; ?>">
                                                        <input type="hidden" name="tienthuexengoai_cpvt"
                                                            id="tienthuexengoai_cpvt"
                                                            value="<?php echo $itemsCPVT['tienthuexengoai']; ?>">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>
                                                        <div class="ml-2  dautinhtoan">=</div>
                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienthuexengoai_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienthuexengoai_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienthuexengoai_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienthuexengoai_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>


                                                <div class="col-md-3 mb-3">
                                                    <label for="tongchiphi_cpvt">Tổng giá cước :</label>
                                                    <div class="input-group mb-2 ">
                                                        <input type="text" class="form-control" id="tongchiphi_cpvt_display"
                                                            placeholder="Tổng giá cước..."
                                                            value="<?php echo $itemsCPVT['tongchiphi']; ?>" readonly>
                                                        <input type="hidden" name="tongchiphi_cpvt" id="tongchiphi_cpvt"
                                                            value="<?php echo $itemsCPVT['tongchiphi']; ?>" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                VNĐ</div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                      
                                                        $('#tongchiphi_cpvt_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tongchiphi_cpvt').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tongchiphi_cpvt').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tongchiphi_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>


                                                <div class="col-md-12 mb-3">
                                                    <label for="ghichu_cpvt">Ghi chú :</label>
                                                    <textarea class="form-control" name="ghichu_cpvt" id="ghichu_cpvt"
                                                        placeholder="Nhập ghi chú..."
                                                        rows="3"><?php echo $itemsCPVT['ghichu']; ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>

                                </script>
                            </div>
                            <!-- end card chi phí vận tải -->


                        <?php endforeach ?>

                        <!-- end card tạm ứng -->
                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_chiphivantai.php" class="btn btn-secondary mr-3">Trở lại </a>
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

        $(document).ready(function () {

            function calculateTotalCost() {
                var tongphicannang = parseFloat($("#tongphicannang_cpvt").val()) || 0;
                var nhienlieu = parseFloat($("#nhienlieu_cpvt").val()) || 0;
                // var thuthutuc = parseFloat($("#thuthutuc_cpvt").val()) || 0;
                // var thukhac = parseFloat($("#thukhac_cpvt").val()) || 0;
                var phicauduong = parseFloat($("#phicauduong_cpvt").val()) || 0;
                var tienanca = parseFloat($("#tienanca_cpvt").val()) || 0;
                var luongchuyen = parseFloat($("#luongchuyen_cpvt").val()) || 0;
                var luongchunhat = parseFloat($("#luongchunhat_cpvt").val()) || 0;
                var tienthuexengoai = parseFloat($("#tienthuexengoai_cpvt").val()) || 0;
                var tiencuocvo = parseFloat($("#tiencuocvo_cpvt").val()) || 0;
                var tienhaiquan = parseFloat($("#tienhaiquan_cpvt").val()) || 0;
                var tiennangha = parseFloat($("#tiennangha_cpvt").val()) || 0;
                var tienkhac = parseFloat($("#tienkhac_cpvt").val()) || 0;

                var totalCost = tongphicannang + nhienlieu + phicauduong + tienanca + luongchuyen + luongchunhat + tienthuexengoai + tiencuocvo + tienhaiquan + tiennangha + tienkhac;

                $("#tongchiphi_cpvt").val(totalCost);
                $("#tongchiphi_cpvt_display").val(new Intl.NumberFormat('vi-VN').format(totalCost));
            }

            calculateTotalCost();

            $("#tiencuocvo_cpvt,#tienhaiquan_cpvt,#tiennangha_cpvt,#tienkhac_cpvt,#phi1kg,#tongphicannang_cpvt, #nhienlieu_cpvt").on("change", calculateTotalCost);
            $("#phi1kg,#phicauduong_cpvt_display, #tienanca_cpvt_display, #luongchuyen_cpvt_display,#luongchunhat_cpvt_display,#tienthuexengoai_cpvt_display").on("input", calculateTotalCost);
        });
    </script>

    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>