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
$sqlCount = "SELECT COUNT(*) AS total_rows
FROM (
    SELECT donhang.id_donhang, chiphivantai.id_cpvt, chiphivantai.tongchiphi, donhang.id_khachhang, donhang.id_nhomhanghoa,
    donhang.id_tuyenvantai, tuyenvantai.ten AS tentuyenvantai, donhang.id_hanghoa, hanghoa.ten AS tenhanghoa, donhang.sokg, 
    dieuhanh.id_thauphu, thauphu.ten AS tenchuxe, dieuhanh.id_xe, xe.bienso, dieuhanh.id_taixe, taixe.ten AS tentaixe, 
    dieuhanh.tinhtrangdonhang, donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh, nguoidung.tendangnhap AS nguoitao, 
    nguoidung.id_nguoidung, DATE(chiphivantai.ngaytao) AS ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung AS id_nguoidung_sua, 
    DATE(chiphivantai.ngaysua) AS ngaysua
    FROM donhang
    LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    LEFT JOIN nguoidung ON chiphivantai.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON chiphivantai.id_nguoisua = nguoidung2.id_nguoidung
    LEFT JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    LEFT JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    LEFT JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
    LEFT JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
    INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
    WHERE 1
) AS subquery";

$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// chỉ lấy ra các đơn hàng đã được điều hành để lập chi phí vt // innner join
$sql = "SELECT donhang.id_donhang, chiphivantai.id_cpvt, chiphivantai.tongchiphi, donhang.id_khachhang, donhang.id_nhomhanghoa,
donhang.id_tuyenvantai, tuyenvantai.ten AS tentuyenvantai, donhang.id_hanghoa, hanghoa.ten AS tenhanghoa, donhang.sokg, 
dieuhanh.id_thauphu, thauphu.ten AS tenchuxe, dieuhanh.id_xe, xe.bienso, dieuhanh.id_taixe, taixe.ten AS tentaixe, 
dieuhanh.tinhtrangdonhang, donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh, nguoidung.tendangnhap AS nguoitao, 
nguoidung.id_nguoidung, DATE(chiphivantai.ngaytao) AS ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, 
DATE(chiphivantai.ngaysua) AS ngaysua
FROM donhang
LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
LEFT JOIN nguoidung ON chiphivantai.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON chiphivantai.id_nguoisua = nguoidung2.id_nguoidung
LEFT JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
LEFT JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
LEFT JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
LEFT JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
LEFT JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
WHERE 1 AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
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



$sqlKH = "SELECT * FROM `khachhang` ORDER BY `khachhang`.`id_khachhang` DESC";
$stmt1 = $conn->prepare($sqlKH);
$query = $stmt1->execute();
$resultKH = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}


if (isset($_GET['filter'])) {
    $id_khachhang = '';

    if (isset($_GET['filter_khachhang']) && $_GET['filter_khachhang'] == '1') {
        // Kiểm tra xem checkbox "Cán bộ tạm ứng" được chọn hay không
        if (isset($_GET['khachhang'])) {
            $id_khachhang = $_GET['khachhang'];
        }
    }

    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';


    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT donhang.id_donhang, chiphivantai.id_cpvt, chiphivantai.tongchiphi, donhang.id_khachhang, donhang.id_nhomhanghoa,
    donhang.id_tuyenvantai, tuyenvantai.ten AS tentuyenvantai, donhang.id_hanghoa, hanghoa.ten AS tenhanghoa, donhang.sokg, 
    dieuhanh.id_thauphu, thauphu.ten AS tenchuxe, dieuhanh.id_xe, xe.bienso, dieuhanh.id_taixe, taixe.ten AS tentaixe, 
    dieuhanh.tinhtrangdonhang, donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh, nguoidung.tendangnhap AS nguoitao, 
    nguoidung.id_nguoidung, DATE(chiphivantai.ngaytao) AS ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, 
    DATE(chiphivantai.ngaysua) AS ngaysua
    FROM donhang
    LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    LEFT JOIN nguoidung ON chiphivantai.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON chiphivantai.id_nguoisua = nguoidung2.id_nguoidung
    LEFT JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    LEFT JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    LEFT JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe
    LEFT JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
    INNER JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
    WHERE 1 ";

    if (!empty($id_khachhang)) {
        // Thêm điều kiện tìm kiếm theo id_nhansu
        $sql .= " AND donhang.id_khachhang = :id_khachhang";
    }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND chiphivantai.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND chiphivantai.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY chiphivantai.ngaytao DESC LIMIT $offset, $total_records_per_page";

    $stmt = $conn->prepare($sql);

    if (!empty($id_khachhang)) {
        $stmt->bindParam(':id_khachhang', $id_khachhang);
    }

    if (!empty($from_date)) {
        $stmt->bindParam(':from_date', $from_date);
    }

    if (!empty($to_date)) {
        $stmt->bindParam(':to_date', $to_date);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách chi phí vận tải</h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_khachhang"
                            id="filter_khachhang" value="1" <?php echo isset($_GET['filter_khachhang']) && $_GET['filter_khachhang'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Khách hàng</span>
                            </div>
                            <select disabled class="form-control mr-5" name="khachhang" id="exampleFormControlSelect1">
                                <option value="">--Chọn khách hàng--</option>

                                <?php foreach ($resultKH as $itemsKH): ?>
                                    <option value="<?php echo $itemsKH['id_khachhang']; ?>" <?php echo isset($_GET['khachhang']) && $_GET['khachhang'] == $itemsKH['id_khachhang'] ? 'selected' : ''; ?>>
                                        <?php echo $itemsKH['id_khachhang']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_date" id="filter_date"
                            value="1" <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Từ ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="from_date"
                                value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group ml-3">
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Đến ngày</span>
                            </div>
                            <input disabled type="date" class="form-control" name="to_date"
                                value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Lọc</button>
                        <a href="list_chiphivantai.php" class="btn btn-danger">Làm mới</a>
                    </div>
                </form>
            </div>
            <!-- // phần này để khi chọn checkbox rồi khi filter reload trang sẽ ko bị mất checkbox đã checked -->
            <script>
                const form = document.getElementById('filterForm');
                const filterkhachhang = document.getElementById('filter_khachhang');
                const khachhangSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    khachhangSelect.disabled = !filterkhachhang.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filterkhachhang.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (filterkhachhang.checked && khachhangSelect.disabled) {
                            e.preventDefault();
                        }

                        if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                            e.preventDefault();
                        }
                    });
                }
            </script>
            <!-- search input -->
            <div class="d-flex mt-3 mb-3 float-right">

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

            <div class="card-body">
                <div class="table-responsive">

                    <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;" class="thead-dark">
                            <tr>
                                <th>STT</th>
                                <th>Mã cpvt</th>
                                <th>Mã đơn hàng</th>
                                <th>Giá cước (VNĐ)</th>
                                <th>Mã khách hàng</th>
                                <th>Mã nhóm hàng </th>
                                <th>Tuyến vận tải</th>
                                <th>Mã hàng hóa</th>
                                <th>Trọng lượng (Kg)</th>
                                <th>Ghi chú(Đơn hàng)</th>
                                <th>Mã chủ xe</th>
                                <th>Tên chủ xe</th>
                                <th>Biển số</th>
                                <th>Tên tài xế</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Ghi chú(Điều hành)</th>

                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th>Ngày sửa</th>
                                <th>Người sửa</th>
                                <th colspan="3" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu     
                                // Kiểm tra giá trị và gán tên lớp CSS tương ứng
                                if ($items['tinhtrangdonhang'] == 'Kết hợp') {
                                    $classMauRow = 'bg-gradient-warning text-white';
                                } elseif ($items['tinhtrangdonhang'] == 'Đơn') {
                                    $classMauRow = '';
                                } else {
                                    $classMauRow = ''; // Nếu không có điều kiện nào khớp, không gán lớp CSS
                                } ?>

                                <tr data-id="<?php echo $items['id_cpvt']; ?>"
                                    data-ngaytao="<?php echo $items['ngaytao']; ?>"
                                    data-id-donhang="<?php echo $items['id_donhang']; ?>"
                                    class="<?php echo $classMauRow; ?>">

                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_cpvt']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tongchiphi = $items['tongchiphi'];
                                        $formatted_tongchiphi = number_format($tongchiphi, 0, ',', '.');
                                        echo $formatted_tongchiphi;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_khachhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_nhomhanghoa']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tentuyenvantai']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_hanghoa']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $sokg = $items['sokg'];
                                        $formatted_sokg = number_format($sokg, 0, ',', '.');
                                        echo $formatted_sokg;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichudonhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_thauphu']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tenchuxe']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tentaixe']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tinhtrangdonhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichudieuhanh']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($items['ngaytao'] !== NULL) {
                                            echo date('d-m-Y', strtotime($items['ngaytao']));
                                        } else {
                                            echo "";
                                        }
                                        ?>

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
                                    <!-- điều kiện enabled/disabled nút -->
                                    <?php
                                    $ngaytao = $items['ngaytao']; // 'Y-m-d'
                                    $ngayhientai = date('Y-m-d'); // Lấy ngày hiện tại dưới định dạng 'Y-m-d'
                                    $disableSua = '';
                                    $disableXoa = '';
                                    $disableThem = '';


                                    $ngaytao_timestamp = strtotime($ngaytao);
                                    $ngayhientai_timestamp = strtotime($ngayhientai);

                                    $ngaytao_day = date('d', $ngaytao_timestamp);
                                    $ngaytao_month = date('m', $ngaytao_timestamp);
                                    $ngaytao_year = date('Y', $ngaytao_timestamp);

                                    $ngayhientai_day = date('d', $ngayhientai_timestamp);
                                    $ngayhientai_month = date('m', $ngayhientai_timestamp);
                                    $ngayhientai_year = date('Y', $ngayhientai_timestamp);


                                    // có dữ liệu của  ip_cpvt thì mới ktra ngày tạo của cpvt 
                                    if ($items['id_cpvt'] !== null && $items['id_cpvt'] !== '') {

                                        if ($ngaytao_year < $ngayhientai_year || ($ngaytao_year == $ngayhientai_year && $ngaytao_month < $ngayhientai_month)) {

                                            $disableSua = 'disabled';
                                            $disableXoa = 'disabled';
                                        } else {
                                            $disableSua = '';
                                            $disableXoa = '';
                                        }

                                    } else {
                                        $disableThem = '';
                                        $disableXoa = 'disabled'; // k có id_cpvt  thì k thể xóa
                                    }
                                    ?>

                                    <?php if ($items['id_cpvt'] === null || $items['id_cpvt'] === '') { ?>
                                        <td>
                                            <button type="button" class="btn  btn-add chiphivantai btn-block"
                                                data-toggle="modal" data-target="#modalCPVT" data-whatever="@mdo"
                                                data-id-donhang="<?php echo $items['id_donhang']; ?>" <?php echo $disableThem; ?>> <i class="fas fa-plus-square"></i> Thêm </button>
                                        </td>
                                        <?php
                                    } else { ?>
                                        <td>
                                            <form action="sua_chiphivantai.php" method="POST">
                                                <input type="hidden" name="edit_id" value="<?php echo $items['id_cpvt']; ?>">
                                                <input type="hidden" name="edit_id_donhang"
                                                    value="<?php echo $items['id_donhang']; ?>">
                                                <button name="suabtn" class="btn   btn-edit  btn-block" <?php echo $disableSua; ?>> <i class="fas fa-edit"></i></button>
                                            </form>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    <td>
                                        <form action="hoadon.php" method="POST" target="_blank">
                                            <input type="hidden" name="id_cpvt" value="<?php echo $items['id_cpvt']; ?>">
                                            <input type="hidden" name="id_donhang"
                                                value="<?php echo $items['id_donhang']; ?>">
                                            <button name="printbtn" class="btn  btn-print  btn-block"><i
                                                    class="fas fa-print"></i></button>
                                        </form>
                                    </td>
                                    <!-- Kiểm tra và k cho  print -->
                                    <script>
                                        window.addEventListener('DOMContentLoaded', function () {
                                            var printButtons = document.getElementsByClassName('btn-print');

                                            for (var i = 0; i < printButtons.length; i++) {
                                                var id_cpvt = printButtons[i].form.elements['id_cpvt'].value;

                                                if (id_cpvt === '' || id_cpvt === undefined) {
                                                    printButtons[i].addEventListener('click', function (event) {
                                                        event.preventDefault();
                                                        $('#printModal').modal('show');
                                                    });
                                                }
                                            }
                                        });
                                    </script>

                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_cpvt']; ?>" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Xác nhận xóa</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn có chắc chắn muốn xóa chi phí vt có mã:
                                                            <strong>
                                                                <?php echo $items['id_cpvt']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_chiphivantai.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_cpvt']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn  btn-delete  btn-block" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_cpvt']; ?>" <?php echo $disableXoa; ?>> <i class="fas fa-trash"></i> </button>
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

            <!-- modal thêm chi phí vận tải -->
            <div class="modal fade" id="modalCPVT" tabindex="-1" aria-labelledby="modalCPVTLabel" aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="modalCPVTLabel">Thêm
                                chi phí vận tải</h1>

                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_chiphivantai.php" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-row">
                                    <!-- thông tin đơn hàng của cpvt -->
                                    <div class="col-sm-12">
                                        <div class="card text-white bg-secondary mb-3 shadow mb-4">
                                            <!-- Card Header - Accordion -->
                                            <a href="#collapseCardExampleCPVT" class="d-block card-header py-3"
                                                data-toggle="collapse" role="button" aria-expanded="true"
                                                aria-controls="collapseCardExampleCPVT">
                                                <h6 class="m-0 font-weight-bold " style="color: white;"> Thông tin đơn
                                                    hàng</h6>
                                            </a>
                                            <!-- Card Content - Collapse -->
                                            <div class="collapse show" id="collapseCardExampleCPVT">
                                                <div class="card-body">
                                                    <div class="form-row">

                                                        <div class="col-md-3 mb-3">
                                                            <label for="id_donhang_cpvt">Mã đơn hàng :</label>
                                                            <input type="text" class="form-control"
                                                                name="id_donhang_cpvt" id="id_donhang_cpvt"
                                                                placeholder="mã đơn hàng" value="" readonly>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Ngày vận chuyển :</label>
                                                            <input disabled type="date" class="form-control"
                                                                id="ngaydongcontainer_cpvt" value="">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Ngày lập :</label>
                                                            <input disabled type="date" class="form-control"
                                                                id="ngaytao_cpvt" value="">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Booking :</label>
                                                            <input type="text" class="form-control" id="booking_cpvt"
                                                                placeholder="booking" value="" readonly>
                                                        </div>

                                                        <div class="col-md-8 mb-3">
                                                            <label for="">Khách hàng :</label>
                                                            <input type="text" class="form-control" id="khachhang_cpvt"
                                                                placeholder="khachhang" value="" readonly>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="">Hàng hóa :</label>
                                                            <input type="text" class="form-control" id="hanghoa_cpvt"
                                                                placeholder="Hàng hóa..." value="" readonly>
                                                        </div>

                                                        <div class="col-md-2 mb-3">
                                                            <label for="">Nhóm hàng hóa :</label>
                                                            <input type="text" class="form-control"
                                                                id="nhomhanghoa_cpvt" placeholder="nhomhanghoa" value=""
                                                                readonly>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Tuyến vận tải :</label>
                                                            <input type="text" class="form-control" id="tvt_cpvt"
                                                                placeholder="tvt" value="" readonly>
                                                        </div>


                                                        <div class="col-md-3 mb-3">
                                                            <label for="bienso">Biển số :</label>
                                                            <input class="form-control" id="bienso_cpvt"
                                                                placeholder="Biển số..." rows="3" readonly></input>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="thuthutuc">Thu thủ tục :</label>
                                                            <div class="input-group mb-2 d-flex ">
                                                                <input type="text" class="form-control"
                                                                    id="thuthutuc_cpvt_display"
                                                                    placeholder="Thu thủ tục..." value="" readonly>
                                                                <input type="hidden" name="thuthutuc_cpvt"
                                                                    id="thuthutuc_cpvt" value="" readonly>

                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="thukhac">Thu khác :</label>
                                                            <div class="input-group mb-2 d-flex ">
                                                                <input type="text" class="form-control"
                                                                    id="thukhac_cpvt_display" placeholder="Thu khác..."
                                                                    value="" readonly>
                                                                <input type="hidden" name="thukhac_cpvt"
                                                                    id="thukhac_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- card chi phí vận tải -->
                                    <div class="col-sm-12 mt-2">
                                        <div class="card text-white bg-info  mb-3 shadow mb-4">
                                            <!-- Card Header - Accordion -->
                                            <a href="#collapseCardExampleCPVT1" class="d-block card-header py-3"
                                                data-toggle="collapse" role="button" aria-expanded="true"
                                                aria-controls="collapseCardExampleCPVT1">
                                                <h6 class="m-0 font-weight-bold " style="color: white;"> Chi phí vận tải
                                                </h6>
                                            </a>
                                            <!-- Card Content - Collapse -->
                                            <div class="collapse show" id="collapseCardExampleCPVT1">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <!-- chi phí đơn hàng -->
                                                        <div class="col-md-3 mb-3">
                                                            <label for="phi1kg">Phí cân nặng / 1kg :</label>
                                                            <div class="input-group mb-2 d-flex">
                                                                <input class="form-control" id="phi1kg"
                                                                    placeholder="Phí cân nặng..." value="500"></input>
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
                                                                <input type="text" class="form-control"
                                                                    id="cannang_cpvt_display"
                                                                    placeholder="Phí cân nặng..." value="" readonly>
                                                                <input type="hidden" name="cannang_cpvt"
                                                                    id="cannang_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        Kg</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">=</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="tongphicannang">Phí cân nặng :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tongphicannang_cpvt_display"
                                                                    placeholder="Phí cân nặng..." value="" readonly>
                                                                <input type="hidden" name="tongphicannang_cpvt"
                                                                    id="tongphicannang_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>
                                                        <script>

                                                        </script>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="nhienlieu">Phí nhiên liệu :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="nhienlieu_cpvt_display"
                                                                    placeholder="Phí nhiên liệu..." value="" readonly>
                                                                <input type="hidden" name="nhienlieu_cpvt"
                                                                    id="nhienlieu_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>

                                                        <!-- start phí tạm ứng -->
                                                        <div class="col-md-3 mb-3">
                                                            <label for="tiencuocvo">Tiền cước vỏ :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tiencuocvo_cpvt_display"
                                                                    placeholder="Tiền cước vỏ..." value="" readonly>
                                                                <input type="hidden" name="tiencuocvo_cpvt"
                                                                    id="tiencuocvo_cpvt" value="" readonly>

                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="tienhaiquan">Tiền hải quan :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tienhaiquan_cpvt_display"
                                                                    placeholder="Tiền hải quan..." value="" readonly>
                                                                <input type="hidden" name="tienhaiquan_cpvt"
                                                                    id="tienhaiquan_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="tiennangha">Tiền nâng hạ :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tiennangha_cpvt_display"
                                                                    placeholder="Tiền nâng hạ..." value="" readonly>
                                                                <input type="hidden" name="tiennangha_cpvt"
                                                                    id="tiennangha_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="tienkhac">Tiền khác :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tienkhac_cpvt_display"
                                                                    placeholder="Tiền khác..." value="" readonly>
                                                                <input type="hidden" name="tienkhac_cpvt"
                                                                    id="tienkhac_cpvt" value="" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>
                                                                <div class="ml-2  dautinhtoan">+</div>
                                                            </div>
                                                        </div>

                                                        <!--end  phí tạm ứng -->



                                                        <!-- chi phí vt -->
                                                        <div class="col-md-3 mb-3">
                                                            <label for="phicauduong_cpvt">Phí cầu đường :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="phicauduong_cpvt_display"
                                                                    placeholder="Phí cầu đường..." value="0">
                                                                <input type="hidden" name="phicauduong_cpvt"
                                                                    id="phicauduong_cpvt" value="0">

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
                                                                <input type="text" class="form-control"
                                                                    id="tienanca_cpvt_display"
                                                                    placeholder="Tiền ăn ca..." value="0">
                                                                <input type="hidden" name="tienanca_cpvt"
                                                                    id="tienanca_cpvt" value="0">
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

                                                                <input type="text" class="form-control"
                                                                    id="luongchuyen_cpvt_display"
                                                                    placeholder="Lương chuyến..." value="0">
                                                                <input type="hidden" name="luongchuyen_cpvt"
                                                                    id="luongchuyen_cpvt" value="0">
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
                                                                <input type="text" class="form-control"
                                                                    id="luongchunhat_cpvt_display"
                                                                    placeholder="Lương chủ nhật..." value="0">
                                                                <input type="hidden" name="luongchunhat_cpvt"
                                                                    id="luongchunhat_cpvt" value="0">
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
                                                            <label for="tienthuexengoai_cpvt">Tiền thua xe ngoài
                                                                :</label>
                                                            <div class="input-group mb-2 d-flex calculation-input">
                                                                <input type="text" class="form-control"
                                                                    id="tienthuexengoai_cpvt_display"
                                                                    placeholder="Tiền thua xe ngoài..." value="0">
                                                                <input type="hidden" name="tienthuexengoai_cpvt"
                                                                    id="tienthuexengoai_cpvt" value="0">
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
                                                                <input type="text" class="form-control"
                                                                    id="tongchiphi_cpvt_display"
                                                                    placeholder="Tổng giá cước..." value="0" readonly>
                                                                <input type="hidden" name="tongchiphi_cpvt"
                                                                    id="tongchiphi_cpvt" value="0" readonly>
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                                        VNĐ</div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <label for="ghichu_cpvt">Ghi chú :</label>
                                                            <textarea class="form-control" name="ghichu_cpvt"
                                                                id="ghichu_cpvt" placeholder="Nhập ghi chú..."
                                                                rows="3"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>

                                        </script>
                                    </div>
                                    <!-- end card chi phí vận tải -->
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
            <!-- end modal thêm chi phí vận tải -->

            <!-- Modal thông báo ko cho sửa -->
            <div class="modal fade" id="disableEditModal" tabindex="-1" role="dialog"
                aria-labelledby="disableEditModalLabel" aria-hidden="true">
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

            <!-- Modal thông báo không thể print-->
            <div id="printModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="printModalLabel">Thông báo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Chưa thêm chi phí vận tải, không thể in.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->
        <?php
        include ('includes/footer.php');
        // include ('includes/scripts.php');
        ?>

    </div>
    <!-- End of Main Content -->
    <script>
        //  lấy data đơn hàng khi click nút thêm chi phí vận tải
        $('.chiphivantai').click(function () {
            var idDonhang = $(this).data('id-donhang'); // Lấy giá trị id_donhang từ thuộc tính data
            // console.log(idDonhang);
            // Gửi dữ liệu đến server bằng Ajax
            $.ajax({
                url: 'ajax/get_donhang_chiphivantai.php',
                type: 'POST',
                dataType: "json",
                data: { id_donhang: idDonhang },
                success: function (response) {
                    // console.log(response);


                    $('#id_donhang_cpvt').val(response.id_donhang);
                    $('#ngaydongcontainer_cpvt').val(response.ngaydongcontainer);
                    $('#ngaytao_cpvt').val(response.ngaytao);
                    $('#booking_cpvt').val(response.booking);
                    $('#khachhang_cpvt').val(response.tenkh);
                    $('#hanghoa_cpvt').val(response.tenhanghoa);
                    $('#nhomhanghoa_cpvt').val(response.id_nhomhanghoa);
                    $('#tvt_cpvt').val(response.tentuyenvantai);
                    $('#bienso_cpvt').val(response.bienso);

                    $('#nhienlieu_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.thanhtiendau));
                    $('#nhienlieu_cpvt').val(response.thanhtiendau);

                    $('#thuthutuc_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.thuthutuc));
                    $('#thuthutuc_cpvt').val(response.thuthutuc);

                    $('#thukhac_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.thukhac));
                    $('#thukhac_cpvt').val(response.thukhac);

                    $('#cannang_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.sokg));
                    $('#cannang_cpvt').val(response.sokg);
                    $(document).ready(function () {
                        // Định nghĩa hàm để cập nhật giá trị "Phí cân nặng"
                        function updateTongPhiCanNang() {
                            var phi1kgValue = parseFloat($('#phi1kg').val());
                            var cannangValue = parseFloat(response.sokg);
                            var tongphicannangValue = phi1kgValue * cannangValue;

                            // Cập nhật giá trị mới cho "Phí cân nặng"
                            $('#tongphicannang_cpvt').val(tongphicannangValue);
                            $('#tongphicannang_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(tongphicannangValue));
                        }
                        // Gọi hàm khi trang được tải
                        updateTongPhiCanNang();
                        // Gọi hàm khi sự kiện "input" xảy ra trên phần tử "#phi1kg"
                        $('#phi1kg').on('input', function () {
                            updateTongPhiCanNang();
                        });
                    });

                    $('#tongphicannang_cpvt').val(response.thanhtiensokg);

                    $('#tiencuocvo_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.tiencuocvo));
                    $('#tiencuocvo_cpvt').val(response.tiencuocvo);

                    $('#tienhaiquan_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.tienhaiquan));
                    $('#tienhaiquan_cpvt').val(response.tienhaiquan);

                    $('#tiennangha_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.tiennangha));
                    $('#tiennangha_cpvt').val(response.tiennangha);

                    $('#tienkhac_cpvt_display').val(new Intl.NumberFormat('vi-VN').format(response.tienkhac));
                    $('#tienkhac_cpvt').val(response.tienkhac);

                    $(document).ready(function () {

                        function calculateTotalCost() {
                            var tongphicannang = parseFloat($("#tongphicannang_cpvt").val()) || 0;
                            var nhienlieu = parseFloat($("#nhienlieu_cpvt").val()) || 0;

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
                        $("#phicauduong_cpvt_display, #tienanca_cpvt_display, #luongchuyen_cpvt_display,#luongchunhat_cpvt_display,#tienthuexengoai_cpvt_display").on("input", calculateTotalCost);
                    });
                },
                error: function (xhr, status, error) {
                    // Xử lý lỗi (nếu có)
                    console.log(error);
                }
            });
        });

        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được dbclick
            var id = $(this).data('id');

            // Lấy ID đơn hàng của mục được dblclick
            var id_donhang = $(this).data('id-donhang');
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
            // ktra id == falsy (bao gồm rỗng, null, undefined và 0)
            if (ngaytaoYear < currentYear || (ngaytaoYear === currentYear && ngaytaoMonth < currentMonth) || !id) {
                $('#disableEditModal').modal('show');
            } else {
                // Ngược lại, chuyển hướng đến trang sửa với ID tương ứng
                window.location.href = 'sua_chiphivantai.php?edit_id=' + id + '&donhang_id=' + id_donhang;
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