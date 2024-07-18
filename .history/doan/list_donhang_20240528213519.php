<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');

//get page number
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

//total row to display
$total_records_per_page = 10;
//get the page offset for LIMIT query
$offset = ($page_no - 1) * $total_records_per_page;
// echo $offset;
//get previous page
$previous_page = $page_no - 1;
//get next page
$next_page = $page_no + 1;

//get total count of records
$sqlCount = "SELECT COUNT(*) as total_rows FROM donhang";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// dữ liệu đơn hàng
$sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua,chitietdonhangtamung.id_ctdhtu,dieuhanh.id_dieuhanh,dieuhanh.id_thauphu,dieuhanh.tinhtrangdonhang
FROM donhang 
INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
LEFT JOIN chitietdonhangtamung ON donhang.id_donhang = chitietdonhangtamung.id_donhang
LEFT JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang


WHERE  1 AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY donhang.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
// $sql ="CALL GetDonHang($offset,$total_records_per_page)";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}



$sqlNhanSu = "SELECT * FROM `nhansu` ORDER BY `nhansu`.`id_nhansu` DESC";
$stmt1 = $conn->prepare($sqlNhanSu);
$query = $stmt1->execute();
$resultNhanSu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNhanSu[] = $row;
}

$sqlThauPhu = "SELECT * FROM `thauphu` ORDER BY `thauphu`.`id_thauphu` DESC";
$stmtTP = $conn->prepare($sqlThauPhu);
$query = $stmtTP->execute();
$resultThauPhu = array();
while ($row = $stmtTP->fetch(PDO::FETCH_ASSOC)) {
    $resultThauPhu[] = $row;
}


$sqlKH = "SELECT * FROM `khachhang` ORDER BY `khachhang`.`id_khachhang` DESC";
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

$sqlSoLuong = "SELECT
SUM(CASE WHEN donhang.id_nhomhanghoa = 'FCL' THEN 1 ELSE 0 END) AS total_FCL,
SUM(CASE WHEN donhang.id_nhomhanghoa = 'LCL' THEN 1 ELSE 0 END) AS total_LCL,
SUM(CASE WHEN donhang.id_nhomhanghoa IN ('FCL', 'LCL') THEN 1 ELSE 0 END) AS total_both
FROM
donhang
WHERE
1 AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
    AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')";
$stmt6 = $conn->prepare($sqlSoLuong);
$query = $stmt6->execute();
$resultSoLuong = array();
while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
    $resultSoLuong[] = $row;
}

if (isset($_GET['filter'])) {
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';
    $trangthai = isset($_GET['trangthai']) ? $_GET['trangthai'] : '';

    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
    donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
    hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
    donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
    donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
    donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua,chitietdonhangtamung.id_ctdhtu,dieuhanh.id_dieuhanh,dieuhanh.id_thauphu,dieuhanh.tinhtrangdonhang
    FROM donhang 
    INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    LEFT JOIN chitietdonhangtamung ON donhang.id_donhang = chitietdonhangtamung.id_donhang
    LEFT JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang
    
    
    WHERE 1 ";

    $sqlSoLuong = "SELECT
        SUM(CASE WHEN donhang.id_nhomhanghoa = 'FCL' THEN 1 ELSE 0 END) AS total_FCL,
        SUM(CASE WHEN donhang.id_nhomhanghoa = 'LCL' THEN 1 ELSE 0 END) AS total_LCL,
        SUM(CASE WHEN donhang.id_nhomhanghoa IN ('FCL', 'LCL') THEN 1 ELSE 0 END) AS total_both
        FROM
        donhang
        WHERE
        1 ";

    if (!empty($trangthai)) {
        // Thêm điều kiện trạng thái
        $sql .= " AND donhang.trangthai = '$trangthai'";
        $sqlSoLuong .= " AND donhang.trangthai = '$trangthai'";
    }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND donhang.ngaytao >= :from_date";
        $sqlSoLuong .= " AND donhang.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND donhang.ngaytao <= :to_date";
        $sqlSoLuong .= " AND donhang.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY donhang.ngaytao DESC LIMIT $offset, $total_records_per_page";

    $stmt = $conn->prepare($sql);
    $stmt1 = $conn->prepare($sqlSoLuong);



    if (!empty($from_date)) {
        $stmt->bindParam(':from_date', $from_date);
        $stmt1->bindParam(':from_date', $from_date);
    }

    if (!empty($to_date)) {
        $stmt->bindParam(':to_date', $to_date);
        $stmt1->bindParam(':to_date', $to_date);
    }

    $stmt->execute();
    $stmt1->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $resultSoLuong = $stmt1->fetchAll(PDO::FETCH_ASSOC);

}




?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div class="background-wave"></div>

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách đơn hàng</h1>

            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_trangthai"
                            id="filter_trangthai" value="1" <?php echo isset($_GET['filter_trangthai']) && $_GET['filter_trangthai'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Trạng thái</span>
                            </div>
                            <select disabled class="form-control mr-5" name="trangthai" id="exampleFormControlSelect1"
                                aria-describedby="basic-addon3">
                                <option value="">Chọn trạng thái</option>
                                <option value="Hủy" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] == 'Hủy' ? 'selected' : '') : ''; ?>>Hủy</option>
                                <option value="Hoàn thành" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] == 'Hoàn thành' ? 'selected' : '') : ''; ?>>Hoàn thành</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_date" id="filter_date"
                            value="1" <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Từ ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="from_date"
                                aria-describedby="basic-addon1"
                                value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group ml-3">
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2">Đến ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="to_date"
                                aria-describedby="basic-addon2"
                                value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="list_donhang.php" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
            <script>
                const form = document.getElementById('filterForm');
                const filterTrangthai = document.getElementById('filter_trangthai');
                const trangthaiSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    trangthaiSelect.disabled = !filterTrangthai.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filterTrangthai.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (filterTrangthai.checked && trangthaiSelect.disabled) {
                            e.preventDefault();
                        }

                        if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                            e.preventDefault();
                        }
                    });
                }
            </script>
            <div class="d-flex mt-3 mb-3 float-right">
                <div class="card border-left-primary shadow h-100 mr-4">
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 0px;">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary ">
                                    Cont: <?php echo $resultSoLuong[0]['total_FCL']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-left-info shadow h-100 mr-4">
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 0px;">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-info ">
                                    Truck: <?php echo $resultSoLuong[0]['total_LCL']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-left-secondary shadow h-100 mr-5">
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 0px;">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-secondary ">
                                    Tổng cộng: <?php echo $resultSoLuong[0]['total_both']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm đơn hàng</button>
                <form class="form-inline mr-3 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control border-1 small search-input" placeholder="Tìm kiếm..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- modal thêm đơn hàg -->
            <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                đơn hàng </h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body ">
                            <form class="needs-validation" novalidate action="them_donhang.php" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-3  mb-3">
                                        <label for="select_sales">Sales* :</label>
                                        <select name="select_sales" class="" id="select_sales" required>
                                            <option value="">--Chọn sales--</option>
                                            <?php foreach ($resultNhanSu as $items1): ?>
                                                <option value="<?php echo $items1['id_auto_increment']; ?>">
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
                                        <label for="select_KH">Khách hàng* :</label>
                                        <select name="select_KH" class="" id="select_KH" required>
                                            <option value="">--Chọn khách hàng--</option>
                                            <?php foreach ($resultKH as $items2): ?>
                                                <option value="<?php echo $items2['id_khachhang']; ?>">
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
                                        <label for="masothue">Mã số thuế* :</label>
                                        <input type="text" class="form-control" name="masothue" id="masothue"
                                            placeholder="Mã số thuế" value="" required readonly>
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
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Booking* :</label>
                                        <input type="text" class="form-control" name="booking" id="validationCustom02"
                                            placeholder="Nhập booking..." value="" required>
                                        <div class="invalid-feedback">
                                            Nhập booking.
                                        </div>
                                    </div>

                                    <div class="col-md-3  mb-3">
                                        <label for="select_loaihang">Loại hàng* :</label>
                                        <select name="select_loaihang" class="" id="select_loaihang" required>
                                            <option value="">--Chọn loại hàng--</option>
                                            <option value="1">Nhập</option>
                                            <option value="2">Xuất</option>
                                            <option value="3">Nội địa</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn loại hàng.
                                        </div>
                                    </div>


                                    <div class="col-md-5  mb-3">
                                        <label for="validationCustom01">Lines/FWD :</label>
                                        <select name="select_hangtau" class="" id="select_hangtau">
                                            <option value="">--Chọn hãng tàu--</option>
                                            <?php foreach ($resultHangTau as $items3): ?>
                                                <option value="<?php echo $items3['id_hangtau']; ?>">
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
                                        <label for="select_NHH">Nhóm hàng hóa* :</label>
                                        <select name="select_NHH" class="" id="select_NHH" required>
                                            <option value="">--Chọn nhóm hàng--</option>
                                            <?php foreach ($resultNHH as $items4): ?>
                                                <option value="<?php echo $items4['id_nhomhanghoa']; ?>">
                                                    <?php echo $items4['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhóm hàng hóa.
                                        </div>
                                    </div>

                                    <div class="col-md-3  mb-3">
                                        <label for="select_HH">Hàng hóa* :</label>
                                        <select name="select_HH" class="" id="select_HH" required>
                                            <option value="">--Chọn hàng hóa--</option>
                                            <?php foreach ($resultHH as $items5): ?>
                                                <option value="<?php echo $items5['id_hanghoa']; ?>">
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
                                        selectHH.disable();

                                        // Sử dụng Ajax để cập nhật giá trị của select_HH
                                        $("#select_NHH").on("change", function () {
                                            var nhomHangHoaId = $(this).val();
                                            // console.log(nhomHangHoaId);

                                            if (nhomHangHoaId) {
                                                $.ajax({
                                                    url: "ajax/get_hanghoa_loaixe.php", // Đường dẫn tới file xử lý Ajax
                                                    method: "POST",
                                                    data: {
                                                        nhomHangHoaId: nhomHangHoaId
                                                    },
                                                    dataType: 'json',
                                                    success: function (response) {
                                                        // console.log(response);
                                                        // Cập nhật giá trị và options của select_HH
                                                        selectHH.clear();
                                                        selectHH.clearOptions();
                                                        // Lặp qua mảng response và thêm các tùy chọn mới vào select_HH
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
                                        <label for="soluong">Số lượng* :</label>
                                        <input type="number" min="1" class="form-control" name="soluong" id="soluong"
                                            placeholder="Nhập số lượng" value="1">

                                        <div class="invalid-feedback">
                                            Nhập số lượng.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="sokg_display">Số kg* :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="sokg_display"
                                                id="sokg_display" placeholder="Nhập số kg..." value="" required>
                                            <input type="hidden" name="sokg" id="sokg" value="" required>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    Kg</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Sai dữ liệu kg.
                                            </div>
                                        </div>
                                    </div>

                                    <!--  chỉ cho nhập số và định dạng -->
                                    <script>
                                        $(document).ready(function () {
                                            $('#sokg_display').on('input', function (e) {
                                                var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                var realValue = parseInt(displayValue, 10) || 0;
                                                $('#sokg').val(realValue); // Thiết lập giá trị của trường ẩn

                                                if (displayValue.length > 0) {
                                                    $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                } else {
                                                    $(this).val('');
                                                }
                                                if (realValue > 40000) {
                                                    $(this).addClass('is-invalid'); // Thêm lớp 'is-invalid' để hiển thị thông báo lỗi
                                                } else {
                                                    $(this).removeClass('is-invalid'); // Xóa lớp 'is-invalid' nếu giá trị hợp lệ
                                                }
                                            });

                                            // Định dạng giá trị ban đầu
                                            var hiddenValue = $('#sokg').val();
                                            if (hiddenValue.length > 0) {
                                                $('#sokg_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                            }
                                        });
                                    </script>


                                    <div class="col-md-6  mb-3">
                                        <label for="select_TVT">Tuyến vận tải* :</label>
                                        <select name="select_TVT" class="" id="select_TVT" required>
                                            <option value="">--Chọn tuyến vận tải--</option>
                                            <?php foreach ($resultTVT as $items6): ?>
                                                <option value="<?php echo $items6['id_tuyenvantai']; ?>">
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
                                        <label for="culy">Cự ly* :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="culy" id="culy"
                                                placeholder="Cự ly" value="" readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    Km
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập cự ly.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="dautieuthu">Dầu tiêu thụ* :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="dautieuthu" id="dautieuthu"
                                                placeholder="Dầu tiêu thụ" value="" readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
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


                                    <div class="col-md-3 mb-3 ngaydongcontainer">
                                        <label for="ngaydongcontainer ">Ngày đóng container* :</label>
                                        <input type="date" class="form-control" name="ngaydongcontainer"
                                            id="ngaydongcontainer" placeholder="Chọn ngày đóng container" value=""
                                            required>
                                        <div class="invalid-feedback">
                                            Ngày đóng container.
                                        </div>
                                    </div>


                                    <div class="col-md-3 mb-3">
                                        <label for="giodongcontainer">Giờ đóng container :</label>
                                        <input type="time" class="form-control" name="giodongcontainer"
                                            id="giodongcontainer" placeholder="Chọn giờ đóng container" value="">

                                        <div class="invalid-feedback">
                                            Chọn giờ đóng container.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 ngaycatmang">
                                        <label for="ngaycatmang">Ngày cắt máng :</label>
                                        <input type="date" class="form-control" name="ngaycatmang" id="ngaycatmang"
                                            placeholder="Chọn ngày cắt máng" value="">
                                        <div class="invalid-feedback">
                                            Ngày cắt máng.
                                        </div>
                                    </div>
                                    <!--  check lỗi ngày cắt máng nhỏ hơn ngày đóng cont -->
                                    <script>
                                        $(document).ready(function () {
                                            // Lắng nghe sự kiện thay đổi ngày đóng container và ngày cắt máng
                                            $('#ngaydongcontainer, #ngaycatmang').on('change', function () {
                                                var ngayDongContainer = new Date($('#ngaydongcontainer').val());
                                                var ngayCatMang = new Date($('#ngaycatmang').val());

                                                if (ngayDongContainer > ngayCatMang) {
                                                    // Ngày đóng container lớn hơn ngày cắt máng, hiển thị thông báo lỗi
                                                    $(this).closest('.ngaycatmang').find('.invalid-feedback').text('Ngày cắt máng phải lớn hơn hoặc bằng ngày đóng cont.');
                                                    $(this).closest('.ngaydongcontainer').find('.invalid-feedback').text('Ngày cắt máng phải lớn hơn hoặc bằng ngày đóng cont.');
                                                    $(this).addClass('is-invalid');
                                                } else {
                                                    // Ngày đóng container hợp lệ, xóa thông báo lỗi
                                                    $(this).closest('.ngaycatmang').find('.invalid-feedback').text('');
                                                    $(this).closest('.ngaydongcontainer').find('.invalid-feedback').text('');
                                                    $(this).removeClass('is-invalid');
                                                }
                                            });
                                        });
                                    </script>


                                    <div class="col-md-3 mb-3">
                                        <label for="giocatmang">Giờ cắt máng :</label>
                                        <input type="time" class="form-control" name="giocatmang" id="giocatmang"
                                            placeholder="Chọn giờ cắt máng" value="">

                                        <div class="invalid-feedback">
                                            Chọn giờ cắt máng.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nguoigiaonhan">Người giao nhận* :</label>
                                        <input type="text" class="form-control" name="nguoigiaonhan" id="nguoigiaonhan"
                                            placeholder="Nhập người giao nhận" value="" required>

                                        <div class="invalid-feedback">
                                            Nhập người giao nhận.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="dienthoai">Số điện thoại :</label>
                                        <input type="text" class="form-control" name="dienthoai" id="dienthoai"
                                            placeholder="Nhập SĐT" value="">

                                        <div class="invalid-feedback">
                                            Nhập SĐT.
                                        </div>
                                    </div>
                                    <!-- chỉ nhập số -->
                                    <script>
                                        $(document).ready(function () {
                                            // Lắng nghe sự kiện nhập vào trường input
                                            $('#dienthoai').on('input', function () {
                                                var inputValue = $(this).val();
                                                var numericValue = inputValue.replace(/[^\d]/g, ''); // Loại bỏ tất cả các ký tự không phải số

                                                // Cập nhật giá trị của trường input
                                                $(this).val(numericValue);
                                            });
                                        });
                                    </script>

                                    <div class="col-md-0 mb-3">
                                        <input type="hidden" class="form-control" name="giacuoc" id="giacuoc"
                                            placeholder="Giá cước" value="" readonly>

                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="thuthutuc">Thu thủ tục :</label>
                                        <div class="input-group mb-2">

                                            <input type="text" class="form-control" id="thuthutuc_display"
                                                placeholder="Nhập thu thủ tục..." value="">
                                            <input type="hidden" name="thuthutuc" id="thuthutuc" value="">

                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập thu thủ tục.
                                            </div>
                                        </div>

                                    </div>
                                    <!--  chỉ cho nhập số và định dạng -->
                                    <script>
                                        $(document).ready(function () {
                                            $('#thuthutuc_display').on('input', function (e) {
                                                var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                var realValue = parseInt(displayValue, 10) || 0;
                                                $('#thuthutuc').val(realValue); // Thiết lập giá trị của trường ẩn

                                                if (displayValue.length > 0) {
                                                    $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                } else {
                                                    $(this).val('');
                                                }
                                            });

                                            // Định dạng giá trị ban đầu
                                            var hiddenValue = $('#thuthutuc').val();
                                            if (hiddenValue.length > 0) {
                                                $('#thuthutuc_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                            }
                                        });
                                    </script>

                                    <div class="col-md-4 mb-3">
                                        <label for="thukhac">Thu khác :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="thukhac_display"
                                                placeholder="Nhập thu khác..." value="">
                                            <input type="hidden" name="thukhac" id="thukhac" value="">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập thu khác
                                            </div>
                                        </div>

                                    </div>
                                    <!--  chỉ cho nhập số và định dạng -->
                                    <script>
                                        $(document).ready(function () {
                                            $('#thukhac_display').on('input', function (e) {
                                                var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                var realValue = parseInt(displayValue, 10) || 0;
                                                $('#thukhac').val(realValue); // Thiết lập giá trị của trường ẩn

                                                if (displayValue.length > 0) {
                                                    $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                } else {
                                                    $(this).val('');
                                                }
                                            });

                                            // Định dạng giá trị ban đầu
                                            var hiddenValue = $('#thukhac').val();
                                            if (hiddenValue.length > 0) {
                                                $('#thukhac_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                            }
                                        });
                                    </script>

                                    <div class="col-md-3 mb-3">
                                        <label for="hanthanhtoan">Hạn thanh toán* :</label>
                                        <input type="date" class="form-control" name="hanthanhtoan" id="hanthanhtoan"
                                            placeholder="Chọn hạn thanh toán" value="" required>

                                        <div class="invalid-feedback">
                                            Chọn hạn thanh toán.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="ghichu">Ghi chú :</label>
                                        <textarea class="form-control" name="ghichu" id="ghichu"
                                            placeholder="Nhập ghi chú..." rows="3"></textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="customFile">Ảnh 1 :</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="anh1" id="customFile"
                                                onchange="hienThiTenFile()">
                                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            Chọn file ảnh
                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label for="customFile1">Ảnh 2 :</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="anh2" id="customFile1"
                                                onchange="hienThiTenFile1()">
                                            <label class="custom-file-label anh2" for="customFile1">Chọn ảnh</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            Chọn file ảnh
                                        </div>
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
                                        <input class="form-check-input checkbox-to" type="hidden" name="trangthai"
                                            id="customCheckbox" value="1">
                                        <!-- <label class="mr-2" for="customCheckbox">Hủy</label> -->
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var checkbox = document.getElementById("customCheckbox");
                                        checkbox.value = "Hoàn thành";
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Trở
                                lại</button>
                            <button type="submit" name="thembtn" class="btn btn-primary">Thêm</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end  modal thêm đơn hàg-->
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                    <thead style=" white-space: nowrap;" class="thead-dark">
                        <tr data-id="<?php echo $items['id_donhang']; ?>"
                            data-ngaytao="<?php echo $items['ngaytao']; ?>">
                            <th>STT</th>
                            <th class="hidden-column">Mã id_ctdhtu</th>
                            <th>Mã đơn hàng </th>
                            <th>Sales</th>
                            <th>Mã khách hàng</th>
                            <th>Mã số thuế</th>
                            <th>Số booking</th>
                            <th>Loại hàng</th>
                            <th>Lines/FWD</th>
                            <th>Mã nhóm hàng</th>
                            <th>Loại xe(Tên hàng hóa)</th>
                            <th>Số lượng</th>
                            <th>Số kg</th>
                            <th>Trạng thái</th>
                            <th>Ngày đóng cont</th>
                            <th>Giờ đóng cont</th>
                            <th>Tên tuyến vận tải</th>
                            <th>Cự ly(Km)</th>
                            <th>Ngày cắt máng</th>
                            <th>Giờ cắt máng</th>
                            <th>Người giao nhận</th>
                            <th>Số điện thoại</th>
                            <th class="hidden-column">Tổng giá cước(VNĐ)</th>
                            <th>Thu thủ tục(VNĐ)</th>
                            <th>Thu khác(VNĐ)</th>
                            <th>Hạn thanh toán</th>
                            <th>Ghi chú</th>
                            <th>Ảnh 1</th>
                            <th>Ảnh 2</th>

                            <th>Ngày tạo</th>
                            <th>Người tạo</th>
                            <th>Ngày sửa</th>
                            <th>Người sửa</th>
                            <th colspan="4" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody style=" white-space: nowrap;">
                        <?php $count = 1;
                        $hasData = false; // Biến kiểm tra dữ liệu
                        
                        foreach ($result as $items):
                            $hasData = true; // Đánh dấu có dữ liệu  
                            if ($items['tinhtrangdonhang'] == 'Kết hợp') {
                                $classMauRow = 'bg-gradient-warning text-white';
                            } elseif ($items['tinhtrangdonhang'] == 'Đơn') {
                                $classMauRow = '';
                            } else {
                                $classMauRow = ''; // Nếu không có điều kiện nào khớp, không gán lớp CSS
                            }
                            ?>

                            <tr data-id="<?php echo $items['id_donhang']; ?>"
                                data-ngaytao="<?php echo $items['ngaytao']; ?>" class="<?php echo $classMauRow; ?>">
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                <td class="hidden-column">
                                    <?php echo $items['id_ctdhtu']; ?>
                                </td>
                                <td>
                                    <?php echo $items['id_donhang']; ?>
                                </td>
                                <td>
                                    <?php echo $items['tensales']; ?>
                                </td>
                                <td>
                                    <?php echo $items['id_khachhang']; ?>
                                </td>
                                <td>
                                    <?php echo $items['masothue']; ?>
                                </td>
                                <td>
                                    <?php echo $items['booking']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($items['loaihang'] == 1) {
                                        echo "Nhập";
                                    } elseif ($items['loaihang'] == 2) {
                                        echo "Xuất";
                                    } elseif ($items['loaihang'] == 3) {
                                        echo "Nội địa";
                                    } else {
                                        echo "Không xác định";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php echo $items['id_hangtau']; ?>
                                </td>
                                <td>
                                    <?php echo $items['id_nhomhanghoa']; ?>
                                </td>
                                <td>
                                    <?php echo $items['tenhanghoa']; ?>
                                </td>
                                <td>
                                    <?php echo $items['soluong']; ?>
                                </td>
                                <td>
                                    <?php
                                    $sokg = $items['sokg'];
                                    $formatted_sokg = number_format($sokg, 0, ',', '.');
                                    echo $formatted_sokg;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $trangthai = $items['trangthai'];
                                    if ($trangthai == 'Hủy') {
                                        echo '<i class="fas fa-times text-danger"></i>';
                                    } else if ($trangthai == 'Hoàn thành') {
                                        echo '<i class="fas fa-check text-success"></i>';
                                    } else {
                                        echo $trangthai;
                                    }
                                    ?>
                                </td>
                                <td>

                                    <?php echo date('d-m-Y', strtotime($items['ngaydongcontainer'])); ?>
                                </td>

                                <td>
                                    <?php echo $items['giodongcontainer'] !== NULL && $items['giodongcontainer'] !== '00:00:00' ? $items['giodongcontainer'] : ''; ?>
                                </td>

                                <td>
                                    <?php echo $items['tentuyenvantai']; ?>
                                </td>
                                <td>

                                    <?php
                                    $culy = $items['culy'];
                                    $formatted_culy = number_format($culy, 0, ',', '.');
                                    echo $formatted_culy;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($items['ngaycatmang'] !== NULL) {
                                        echo date('d-m-Y', strtotime($items['ngaycatmang']));
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $items['giocatmang'] !== NULL && $items['giocatmang'] !== '00:00:00' ? $items['giocatmang'] : ''; ?>
                                </td>
                                <td>
                                    <?php echo $items['nguoigiaonhan']; ?>
                                </td>
                                <td>
                                    <?php echo $items['dienthoai']; ?>
                                </td>

                                <td class="hidden-column">
                                    <?php
                                    $giacuoc = $items['giacuoc'];
                                    $formatted_giacuoc = number_format($giacuoc, 0, ',', '.');
                                    echo $formatted_giacuoc;
                                    ?>

                                </td>
                                <td>

                                    <?php
                                    $thuthutuc = $items['thuthutuc'];
                                    $formatted_thuthutuc = number_format($thuthutuc, 0, ',', '.');
                                    echo $formatted_thuthutuc;
                                    ?>
                                </td>
                                <td>

                                    <?php
                                    $thukhac = $items['thukhac'];
                                    $formatted_thukhac = number_format($thukhac, 0, ',', '.');
                                    echo $formatted_thukhac;
                                    ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y', strtotime($items['hanthanhtoan'])); ?>
                                </td>
                                <td>
                                    <?php echo $items['ghichu']; ?>
                                </td>

                                <td>
                                    <a href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                        <img style="width: 100px;" src="img/<?php echo $items['anh1']; ?>">
                                    </a>
                                </td>
                                <td>
                                    <a href="img/<?php echo $items['anh2']; ?>" target="_blank">
                                        <img style="width: 100px;" src="img/<?php echo $items['anh2']; ?>">
                                    </a>
                                </td>

                                <td>

                                    <?php echo date('d-m-Y', strtotime($items['ngaytao'])); ?>
                                </td>
                                <td>
                                    <?php echo $items['nguoitao']; ?>
                                </td>
                                <td>

                                    <?php
                                    if ($items['ngaysua'] !== NULL) {
                                        echo date('d-m-Y', strtotime($items['ngaysua']));
                                    } else {
                                        echo "";
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?php echo $items['nguoisua']; ?>
                                </td>

                                <?php
                                $ngaytao = $items['ngaytao']; // 'Y-m-d'
                                $ngayhientai = date('Y-m-d'); // Lấy ngày hiện tại dưới định dạng 'Y-m-d'
                            
                                $ngaytao_timestamp = strtotime($ngaytao);
                                $ngayhientai_timestamp = strtotime($ngayhientai);

                                $ngaytao_day = date('d', $ngaytao_timestamp);
                                $ngaytao_month = date('m', $ngaytao_timestamp);
                                $ngaytao_year = date('Y', $ngaytao_timestamp);

                                $ngayhientai_day = date('d', $ngayhientai_timestamp);
                                $ngayhientai_month = date('m', $ngayhientai_timestamp);
                                $ngayhientai_year = date('Y', $ngayhientai_timestamp);

                                if ($ngaytao_year < $ngayhientai_year || ($ngaytao_year == $ngayhientai_year && $ngaytao_month < $ngayhientai_month)) {

                                    $disableSua = 'disabled';
                                    $disableXoa = 'disabled';
                                } else {

                                    $disableSua = '';
                                    $disableXoa = '';
                                }
                                ?>

                                <?php
                                // Kiểm tra trạng thái của đơn hàng
                                $statusSql = "SELECT trangthai FROM donhang WHERE id_donhang = :id_donhang";
                                $statusStmt = $conn->prepare($statusSql);
                                $statusStmt->bindParam(':id_donhang', $items['id_donhang']);
                                $statusStmt->execute();
                                if ($statusStmt->rowCount() > 0) {
                                    $statusResult = $statusStmt->fetch(PDO::FETCH_ASSOC);
                                    $trangthai = $statusResult['trangthai'];


                                    if ($trangthai == 'Hủy') {
                                        $disableHuy = 'disabled';

                                    } else if ($trangthai == 'Hoàn thành') {
                                        $disableHuy = '';

                                    } else {
                                        $disableHuy = 'disabled';

                                    }
                                }
                                // Kiểm tra dữ liệu trong bảng dieuhanh cho id_donhang
                                $sql = "SELECT * FROM dieuhanh WHERE id_donhang = :id_donhang";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':id_donhang', $items['id_donhang']);
                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    // Nếu có dữ liệu thì sửa dieuhanh
                                    ?>
                                    <td>
                                        <form action="sua_dieuhanh.php" method="POST">
                                            <input type="hidden" name="edit_id_tp" value="<?php echo $items['id_thauphu']; ?>">
                                            <input type="hidden" name="edit_id_nhh"
                                                value="<?php echo $items['id_nhomhanghoa']; ?>">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_dieuhanh']; ?>">
                                            <input type="hidden" name="edit_id_donhang"
                                                value="<?php echo $items['id_donhang']; ?>">
                                            <button name="suabtn" class="btn btn-dieuhanh btn-block btn-icon-split ">
                                                <span class="icon ">
                                                    <i class="fa-solid fa-truck fa-sm fa-fw "></i>
                                                </span>
                                                <span class="text">Sửa điều hành</span>
                                            </button>
                                        </form>
                                    </td>
                                    <?php
                                } else {
                                    // Nếu không có dữ liệu thì thêm đh
                                    ?>
                                    <td>
                                        <button type="button" class="btn btn-dieuhanh btn-block btn-icon-split dieuhanh"
                                            data-toggle="modal" data-target="#modalDieuHanh" data-whatever="@mdo"
                                            data-id-donhang="<?php echo $items['id_donhang']; ?>" <?php echo $disableXoa; ?>
                                            <?php echo $disableHuy; ?>>
                                            <span class="icon ">
                                                <i class="fa-solid fa-truck fa-sm fa-fw "></i>
                                            </span>
                                            <span class="text">Thêm điều hành</span>
                                        </button>
                                    </td>
                                    <?php
                                }

                                // Kiểm tra dữ liệu trong bảng chitietdonhangtamung cho id_donhang
                                $sql = "SELECT * FROM chitietdonhangtamung WHERE id_donhang = :id_donhang";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':id_donhang', $items['id_donhang']);
                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    // Nếu có dữ liệu thì sửa tạm ứng
                                    ?>
                                    <td>
                                        <form action="sua_tamung.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_ctdhtu']; ?>">
                                            <input type="hidden" name="edit_id_donhang"
                                                value="<?php echo $items['id_donhang']; ?>">


                                            <button name="suabtn" class="btn btn-info btn-block btn-icon-split " <?php echo $disableXoa; ?>         <?php echo $disableHuy; ?>>
                                                <span class="icon ">
                                                    <i class="fa-solid fa-dollar-sign fa-sm fa-fw "></i>
                                                </span>
                                                <span class="text">Sửa tạm
                                                    ứng</span>
                                            </button>
                                        </form>
                                    </td>
                                    <?php
                                } else {
                                    // Nếu không có dữ liệu thì thêm tạm ứng
                                    ?>
                                    <td>


                                        <button type="button" class="btn btn-info btn-block btn-icon-split tamung"
                                            data-toggle="modal" data-target="#modalTamUng" data-whatever="@mdo"
                                            data-id-donhang="<?php echo $items['id_donhang']; ?>" <?php echo $disableXoa; ?>
                                            <?php echo $disableHuy; ?>>
                                            <span class="icon ">
                                                <i class="fa-solid fa-dollar-sign fa-sm fa-fw "></i>
                                            </span>
                                            <span class="text">Thêm tạm
                                                ứng</span>
                                        </button>
                                    </td>
                                    <?php
                                }
                                ?>

                </div>
                <td>
                    <form action="sua_donhang.php" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $items['id_donhang']; ?>">
                        <button name="suabtn" class="btn   btn-edit  btn-block" <?php echo $disableSua; ?>><i
                                class="fas fa-edit"></i></button>
                    </form>
                </td>

                <td>
                    <!-- Thêm modal dialog -->
                    <div class="modal" id="deleteModal<?php echo $items['id_donhang']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xác nhận xóa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn có chắc chắn muốn xóa đơn hàng có mã:
                                        <strong>
                                            <?php echo $items['id_donhang']; ?>
                                        </strong>?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <form action="them_donhang.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $items['id_donhang']; ?>">
                                        <button name="xoabtn" class="btn btn-danger" type="submit">Xoá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Nút "Xóa" -->
                    <button class="btn  btn-delete  btn-block" data-toggle="modal"
                        data-target="#deleteModal<?php echo $items['id_donhang']; ?>" <?php echo $disableXoa; ?>><i
                            class="fas fa-trash"></i> </button>
                </td>

                </tr>

            <?php endforeach ?>
            <?php if (!$hasData): ?>
                <tr>
                    <td colspan="100" class="text-center">Không tìm thấy dữ liệu phù hợp!</td>
                </tr>
            <?php endif; ?>

            </tbody>
            </table>



        </div>

        <div class="mt-4 d-flex justify-content-between">

            <div class="p-10 mb-3">
                <strong>Page
                    <?= $page_no; ?> of
                    <?= $total_no_of_pages; ?>
                </strong>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>
                            Previous
                        </a>
                    </li>

                    <?php
                    $start_page = max(1, $page_no - 2);
                    $end_page = min($start_page + 4, $total_no_of_pages);

                    for ($counter = $start_page; $counter <= $end_page; $counter++) {
                        ?>
                        <li class="page-item <?php echo ($page_no == $counter) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page_no=<?= $counter; ?>">
                                <?= $counter; ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                    <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>



    <!-- modal thêm tạm ứng -->
    <div class="modal fade" id="modalTamUng" tabindex="-1" aria-labelledby="modalTamUngLabel" aria-hidden="true">
        <!-- modal-sm  modal-xl  modal-lg  -->
        <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header header-crud ">
                    <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="modalTamUngLabel">Thêm
                        tạm ứng</h1>

                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate action="them_tamung.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3 shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleTamUng" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="collapseCardExampleTamUng">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Thông tin đơn hàng</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleTamUng">
                                        <div class="card-body">
                                            <div class="form-row">

                                                <div class="col-md-3 mb-3">
                                                    <label for="id_donhang_tamung">Mã đơn hàng :</label>
                                                    <input type="text" class="form-control" name="id_donhang_tamung"
                                                        id="id_donhang_tamung" placeholder="mã đơn hàng" value=""
                                                        readonly>
                                                </div>

                                                <div class="col-md-5 mb-3">
                                                    <label for="">Sales :</label>
                                                    <input type="text" class="form-control" id="sales_tamung"
                                                        placeholder="Sales" value="" readonly>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Ngày lập :</label>
                                                    <input disabled type="date" class="form-control" id="ngaytao_tamung"
                                                        value="">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Booking :</label>
                                                    <input type="text" class="form-control" id="booking_tamung"
                                                        placeholder="booking" value="" readonly>
                                                </div>

                                                <div class="col-md-8 mb-3">
                                                    <label for="">Khách hàng :</label>
                                                    <input type="text" class="form-control" id="khachhang_tamung"
                                                        placeholder="khachhang" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Loại hàng :</label>
                                                    <input type="text" class="form-control" id="loaihang_tamung"
                                                        placeholder="loaihang" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Nhóm hàng hóa :</label>
                                                    <input type="text" class="form-control" id="nhomhanghoa_tamung"
                                                        placeholder="nhomhanghoa" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Tuyến vận tải :</label>
                                                    <input type="text" class="form-control" id="tvt_tamung"
                                                        placeholder="tvt" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Trọng lượng :</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" id="trongluong_tamung"
                                                            placeholder="trongluong" value="" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                Kg</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label for="ghichu">Ghi chú :</label>
                                                    <textarea class="form-control" id="ghichu_tamung"
                                                        placeholder="Ghi chú..." rows="3" disabled></textarea>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card tạm ứng -->
                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-info mb-3 shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleTamUng1" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="collapseCardExampleTamUng1">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Tạm ứng</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleTamUng1">
                                        <div class="card-body">
                                            <div class="form-row">

                                                <div class="col-md-3  mb-3">
                                                    <label for="select_sales_tamung">Cán bộ tạm ứng :</label>
                                                    <select name="select_sales_tamung" class="" id="select_sales_tamung"
                                                        required>
                                                        <option value="">--Chọn nhân sự--</option>
                                                        <?php foreach ($resultNhanSu as $itemsCBTU): ?>
                                                            <option value="<?php echo $itemsCBTU['id_auto_increment']; ?>">
                                                                <?php echo $itemsCBTU['ten']; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Chọn nhân sự.
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
                                                    <input type="date" class="form-control" name="ngaytamung"
                                                        id="ngaytamung" placeholder="Chọn ngày tạm ứng" value=""
                                                        required>
                                                    <div class="invalid-feedback">
                                                        Ngày tạm ứng.
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="ngaythanhtoan_tamung">Ngày thanh toán :</label>
                                                    <input type="date" class="form-control" name="ngaythanhtoan_tamung"
                                                        id="ngaythanhtoan_tamung" placeholder="Chọn ngày thanh toán"
                                                        value="">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="giothanhtoan_tamung">Giờ thanh toán :</label>
                                                    <input type="time" class="form-control" name="giothanhtoan_tamung"
                                                        id="giothanhtoan_tamung" placeholder="Chọn giờ thanh toán"
                                                        value="">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tiencuocvo_tamung">Tiền cước vỏ :</label>
                                                    <input type="text" class="form-control"
                                                        id="tiencuocvo_tamung_display"
                                                        placeholder="Nhập tiền cước vỏ..." value="">
                                                    <input type="hidden" name="tiencuocvo_tamung" id="tiencuocvo_tamung"
                                                        value="">
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tiencuocvo_tamung_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tiencuocvo_tamung').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tiencuocvo_tamung').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tiencuocvo_tamung_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienhaiquan_tamung">Tiền hải quan :</label>
                                                    <input type="text" class="form-control"
                                                        id="tienhaiquan_tamung_display"
                                                        placeholder="Nhập tiền hải quan..." value="">
                                                    <input type="hidden" name="tienhaiquan_tamung"
                                                        id="tienhaiquan_tamung" value="">
                                                </div>
                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienhaiquan_tamung_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienhaiquan_tamung').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienhaiquan_tamung').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienhaiquan_tamung_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>


                                                <div class="col-md-3 mb-3">
                                                    <label for="tiennangha_tamung">Tiền nâng hạ :</label>
                                                    <input type="text" class="form-control"
                                                        id="tiennangha_tamung_display"
                                                        placeholder="Nhập tiền nâng hạ..." value="">
                                                    <input type="hidden" name="tiennangha_tamung" id="tiennangha_tamung"
                                                        value="">
                                                </div>

                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tiennangha_tamung_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tiennangha_tamung').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tiennangha_tamung').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tiennangha_tamung_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tienkhac_tamung">Tiền khác :</label>
                                                    <input type="text" class="form-control" id="tienkhac_tamung_display"
                                                        placeholder="Nhập tiền khác..." value="">
                                                    <input type="hidden" name="tienkhac_tamung" id="tienkhac_tamung"
                                                        value="">
                                                </div>


                                                <!--  chỉ cho nhập số và định dạng -->
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#tienkhac_tamung_display').on('input', function (e) {
                                                            var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                                            var realValue = parseInt(displayValue, 10) || 0;
                                                            $('#tienkhac_tamung').val(realValue); // Thiết lập giá trị của trường ẩn

                                                            if (displayValue.length > 0) {
                                                                $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                                            } else {
                                                                $(this).val('');
                                                            }
                                                        });

                                                        // Định dạng giá trị ban đầu
                                                        var hiddenValue = $('#tienkhac_tamung').val();
                                                        if (hiddenValue.length > 0) {
                                                            $('#tienkhac_tamung_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                                        }
                                                    });
                                                </script>

                                                <div class="col-md-12 mb-3">
                                                    <label for="customFile_tamung">Ảnh thanh toán :</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="anh1_tamung"
                                                            id="customFile_tamung" onchange="hienThiTenFileTamUng()">
                                                        <label class="custom-file-label tamung-lbl"
                                                            for="customFile_tamung">Chọn ảnh</label>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Chọn file ảnh
                                                    </div>
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
                                                    <textarea class="form-control" name="ghichu_tamung"
                                                        id="ghichu_tamung" placeholder="Nhập ghi chú..."
                                                        rows="3"></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card tạm ứng -->
                        </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Trở
                        lại</button>
                    <button type="submit" name="thembtn" class="btn btn-primary">Thêm</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- end thêm tạm ứng -->

    <!-- modal thêm điều hành -->
    <div class="modal fade" id="modalDieuHanh" tabindex="-1" aria-labelledby="modalDieuHanhLabel" aria-hidden="true">
        <!-- modal-sm  modal-xl  modal-lg  -->
        <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header header-crud ">
                    <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="modalDieuHanhLabel">Thêm
                        điều hành</h1>

                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate action="them_dieuhanh.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3 shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleDieuHanh" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="collapseCardExampleDieuHanh">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Thông tin đơn hàng</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleDieuHanh">
                                        <div class="card-body">
                                            <div class="form-row">

                                                <div class="col-md-3 mb-3">
                                                    <label for="id_donhang_dieuhanh">Mã đơn hàng :</label>
                                                    <input type="text" class="form-control" name="id_donhang_dieuhanh"
                                                        id="id_donhang_dieuhanh" placeholder="mã đơn hàng" value=""
                                                        readonly>
                                                </div>

                                                <div class="col-md-5 mb-3">
                                                    <label for="">Sales :</label>
                                                    <input type="text" class="form-control" id="sales_dieuhanh"
                                                        placeholder="Sales" value="" readonly>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Ngày lập :</label>
                                                    <input disabled type="date" class="form-control"
                                                        id="ngaytao_dieuhanh" value="">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="">Booking :</label>
                                                    <input type="text" class="form-control" id="booking_dieuhanh"
                                                        placeholder="booking" value="" readonly>
                                                </div>

                                                <div class="col-md-8 mb-3">
                                                    <label for="">Khách hàng :</label>
                                                    <input type="text" class="form-control" id="khachhang_dieuhanh"
                                                        placeholder="khachhang" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Loại hàng :</label>
                                                    <input type="text" class="form-control" id="loaihang_dieuhanh"
                                                        placeholder="loaihang" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Nhóm hàng hóa :</label>
                                                    <input type="text" class="form-control" id="nhomhanghoa_dieuhanh"
                                                        placeholder="nhomhanghoa" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Tuyến vận tải :</label>
                                                    <input type="text" class="form-control" id="tvt_dieuhanh"
                                                        placeholder="tvt" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="">Trọng lượng :</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" id="trongluong_dieuhanh"
                                                            placeholder="trongluong" value="" readonly>
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                Kg</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label for="ghichu">Ghi chú :</label>
                                                    <textarea class="form-control" id="ghichu_dieuhanh"
                                                        placeholder="Ghi chú..." rows="3" disabled></textarea>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card điều hành -->
                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-dieuhanh  mb-3 shadow mb-4">

                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExampleDieuHanh1" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="collapseCardExampleDieuHanh1">
                                        <h6 class="m-0 font-weight-bold " style="color: white;"> Điều hành</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExampleDieuHanh1">
                                        <div class="card-body">
                                            <div class="form-row">

                                                <div class="col-md-2  mb-3">
                                                    <label for="select_thauphu_dh">Mã chủ xe :</label>
                                                    <select name="select_thauphu_dh" class="" id="select_thauphu_dh"
                                                        required>
                                                        <option value="">--Chọn thầu phụ--</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Chọn thầu phụ.
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="tenthauphu_dh">Tên chủ xe :</label>
                                                    <input type="text" class="form-control" name="tenthauphu_dh"
                                                        id="tenthauphu_dh" placeholder="Tên chủ xe..." value=""
                                                        readonly>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="masothue_dh">Mã số thuế :</label>
                                                    <input type="text" class="form-control" name="masothue_dh"
                                                        id="masothue_dh" placeholder="Mã số thuế..." value="" readonly>
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
                                                    <label for="select_bienso_dh">Biển số :</label>
                                                    <select name="select_bienso_dh" class="" id="select_bienso_dh"
                                                        required>
                                                        <option value="">--Chọn biển số--</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Chọn biển số.
                                                    </div>
                                                </div>

                                                <div class="col-md-4  mb-3">
                                                    <label for="select_taixe_dh">Tài xế :</label>
                                                    <select name="select_taixe_dh" class="" id="select_taixe_dh"
                                                        required>
                                                        <option value="">--Chọn tài xế--</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Chọn tài xế.
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="sodienthoai_dh">Số điện thoại :</label>
                                                    <input type="text" class="form-control" name="sodienthoai_dh"
                                                        id="sodienthoai_dh" placeholder="Số điện thoại..." value=""
                                                        readonly>
                                                </div>

                                                <div class="col-md-3  mb-3">
                                                    <label for="select_tinhtrangdonhang_dh">Tình trạng :</label>
                                                    <select name="select_tinhtrangdonhang_dh" class=""
                                                        id="select_tinhtrangdonhang_dh" required>
                                                        <option value="">--Chọn tình trạng--</option>
                                                        <option value="Đơn">Đơn</option>
                                                        <option value="Kết hợp">Kết hợp</option>

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
                                                        id="sodonkethop_dh" placeholder="Nhập số đơn" value="0"
                                                        disabled>
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
                                                        placeholder="Nhập ghi chú..." rows="3"></textarea>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- end card điều hành -->
                        </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Trở
                        lại</button>
                    <button type="submit" name="thembtn" class="btn btn-primary">Thêm</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- end modal thêm điều hành -->

    <!-- ajax lấy data đơn hàng bên tạm ứng và điều hành-->
    <script>
        $(document).ready(function () {
            // Lắng nghe sự kiện click vào nút "Tạm ứng"
            $('.tamung').click(function () {
                var idDonhang = $(this).data('id-donhang'); // Lấy giá trị id_donhang từ thuộc tính data

                // Gửi dữ liệu đến server bằng Ajax
                $.ajax({
                    url: 'ajax/get_donhang_tamung_dieuhanh.php',
                    type: 'POST',
                    dataType: "json",
                    data: { id_donhang: idDonhang },
                    success: function (response) {

                        //  console.log(response);

                        $('#id_donhang_tamung').val(response.id_donhang);
                        $('#sales_tamung').val(response.tensales);
                        $('#ngaytao_tamung').val(response.ngaytao);
                        $('#booking_tamung').val(response.booking);
                        $('#khachhang_tamung').val(response.tenkh);
                        $('#loaihang_tamung').val(response.loaihang);
                        $('#nhomhanghoa_tamung').val(response.id_nhomhanghoa);
                        $('#tvt_tamung').val(response.id_tuyenvantai);
                        $('#trongluong_tamung').val(response.sokg);
                        $('#ghichu_tamung').val(response.ghichu);
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi (nếu có)
                        console.log(error);
                    }
                });
            });
            // Khởi tạo TomSelect
            var selectThauphu = new TomSelect("#select_thauphu_dh", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "desc"
                }
            });


            // Lắng nghe sự kiện click vào nút "điều hành"
            $('.dieuhanh').click(function () {
                var idDonhang = $(this).data('id-donhang'); // Lấy giá trị id_donhang từ thuộc tính data

                // Gửi dữ liệu đến server bằng Ajax
                $.ajax({
                    url: 'ajax/get_donhang_tamung_dieuhanh.php',
                    type: 'POST',
                    dataType: "json",
                    data: { id_donhang: idDonhang },
                    success: function (response) {
                        // console.log(response);
                        $('#id_donhang_dieuhanh').val(response.id_donhang);
                        $('#sales_dieuhanh').val(response.tensales);
                        $('#ngaytao_dieuhanh').val(response.ngaytao);
                        $('#booking_dieuhanh').val(response.booking);
                        $('#khachhang_dieuhanh').val(response.tenkh);
                        $('#loaihang_dieuhanh').val(response.loaihang);
                        $('#nhomhanghoa_dieuhanh').val(response.id_nhomhanghoa);
                        $('#tvt_dieuhanh').val(response.id_tuyenvantai);
                        $('#trongluong_dieuhanh').val(response.sokg);
                        $('#ghichu_dieuhanh').val(response.ghichu);

                        //lấy nhomhanghoa_dieuhanh
                        var nhomHangHoaId = response.id_nhomhanghoa;
                        // console.log(nhomHangHoaId);
                        // Lấy dữ liệu cho select_thauphu_dh qua nhomhanghoa_dieuhanh
                        if (nhomHangHoaId) {
                            $.ajax({
                                url: 'ajax/get_idthauphu_Byid_nhomhh.php',
                                type: 'POST',
                                data: {
                                    nhomhanghoa: nhomHangHoaId
                                },
                                dataType: "json",
                                success: function (response) {
                                    // console.log(response);
                                    // Xóa tất cả các tùy chọn hiện có
                                    selectThauphu.clearOptions();
                                    // Thêm các tùy chọn từ dữ liệu lấy được
                                    $.each(response, function (index, item) {
                                        selectThauphu.addOption({
                                            value: item.id_thauphu,
                                            text: item.id_thauphu
                                        });
                                    });
                                    // selectThauphu.refreshOptions();

                                }
                            });
                        } else {
                            selectThauphu.clearOptions();
                        }
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi (nếu có)
                        console.log(error);
                    }
                });
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
                selectBienSo.refreshOptions();
                selectTaiXe.refreshOptions();

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
                        $('#sodienthoai_dh').val(response.sodienthoai);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>

    <!-- Modal thông báo ko cho sửa -->
    <div class="modal fade" id="disableEditModal" tabindex="-1" role="dialog" aria-labelledby="disableEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disableEditModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Không được phép sửa
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <?php
    include ('includes/footer.php');
    // include ('includes/scripts.php');
    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    $('tr[data-id]').on('dblclick', function () {
        // Lấy ID của mục được dbclick
        var id = $(this).data('id');
        // Lấy ngày tạo của mục đc dbclick
        var ngaytao = $(this).data('ngaytao'); // Giả sử ngày tạo có thuộc tính data-ngaytao
        // console.log(ngaytao); //2024-03-06
        // Lấy ngày hiện tại
        var ngaytaoDate = new Date(ngaytao); // Wed Mar 06 2024 07:00:00 GMT+0700 (Giờ Đông Dương)
        var ngaytaoYear = ngaytaoDate.getFullYear(); // 2024
        var ngaytaoMonth = ngaytaoDate.getMonth() + 1; //3 
        // console.log(ngaytaoDate);


        // Chuyển đổi ngày tạo thành đối tượng Date
        var currentDate = new Date(); // Tue Apr 09 2024 20:54:36 GMT+0700 (Giờ Đông Dương)
        var currentYear = currentDate.getFullYear(); //2024
        var currentMonth = currentDate.getMonth() + 1; // 4
        // console.log(currentMonth);
        if (ngaytaoYear < currentYear || (ngaytaoYear === currentYear && ngaytaoMonth < currentMonth)) {
            $('#disableEditModal').modal('show');
        } else {
            // Ngược lại, chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_donhang.php?edit_id=' + id;
        }
    });

    // tìm kiếm change text search
    $(document).ready(function () {
        $('.search-input').on('input', function () {
            var searchText = $(this).val().toLowerCase();
            $('#myTable tbody tr').each(function () {
                var rowData = $(this).text().toLowerCase();
                if (rowData.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });


</script>


<?php
// include ('includes/footer.php');
include ('includes/scripts.php');
?>