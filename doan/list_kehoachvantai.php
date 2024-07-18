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
    SELECT  dieuhanh.id_donhang,donhang.booking,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.loaihang,donhang.id_nhomhanghoa,dieuhanh.id_thauphu,dieuhanh.tenthauphu,donhang.ngaydongcontainer,donhang.giodongcontainer,donhang.id_hangtau,dieuhanh.tinhtrangdonhang,donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao, 
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung AS id_nguoidung_2, DATE(dieuhanh.ngaysua) as ngaysua
FROM dieuhanh 

INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN donhang ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu

WHERE 1     
    
) AS subquery";

$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT dieuhanh.id_donhang,dieuhanh.id_dieuhanh,donhang.booking,donhang.id_khachhang,khachhang.ten as tenkh,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.loaihang,donhang.id_nhomhanghoa,dieuhanh.id_thauphu,dieuhanh.tenthauphu,donhang.ngaydongcontainer,donhang.giodongcontainer,donhang.id_hangtau,dieuhanh.tinhtrangdonhang,donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao,
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(dieuhanh.ngaysua) as ngaysua
FROM dieuhanh

INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN donhang ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang

WHERE 1  AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY dieuhanh.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
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


    $sql = "SELECT dieuhanh.id_donhang,dieuhanh.id_dieuhanh,donhang.booking,donhang.id_khachhang,khachhang.ten as tenkh,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.loaihang,donhang.id_nhomhanghoa,dieuhanh.id_thauphu,dieuhanh.tenthauphu,donhang.ngaydongcontainer,donhang.giodongcontainer,donhang.id_hangtau,dieuhanh.tinhtrangdonhang,donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao,
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(dieuhanh.ngaysua) as ngaysua
    FROM dieuhanh
    
    INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN donhang ON dieuhanh.id_donhang = donhang.id_donhang
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    
    WHERE 1";

    if (!empty($id_khachhang)) {
        // Thêm điều kiện tìm kiếm theo id_nhansu
        $sql .= " AND donhang.id_khachhang = :id_khachhang";
    }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND dieuhanh.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND dieuhanh.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY dieuhanh.ngaytao DESC LIMIT $offset, $total_records_per_page";

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
        <div > 
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: ".$tendangnhap; ?></span>
            <br>
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: ".$thoigiandangnhap; ?></span>
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Kế hoạch vận tải</h1>
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
                        <a href="list_kehoachvantai.php" class="btn btn-danger">Làm mới</a>
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
                <div>
                    <a href="#" onclick="exportTableToExcel('myTable')" id="excelButton" class="btn btn-success mr-2"
                        style="min-width: 90px;"><i class="fas fa-download mr-2"></i>Excel</a>
                </div>
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
                                <th>Mã đơn hàng</th>
                                <th>Mã điều hành</th>
                                <th>Booking</th>
                                <th>Khách hàng</th>
                                <th>Tuyến vận tải</th>
                                <th>Hàng hóa </th>
                                <th>Loại hàng</th>
                                <th>Nhóm hàng hóa</th>
                                <th>Thầu phụ</th>
                                <th>Ngày đóng/trả</th>
                                <th>Giờ đóng/trả</th>
                                <th>Line/Fwd</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Ghi chú(Đơn hàng)</th>
                                <th>Ghi chú(Điều hành)</th>

                                <th class="hidden-column">Ngày tạo</th>
                                <th class="hidden-column">Người tạo</th>
                                <th class="hidden-column">Ngày sửa</th>
                                <th class="hidden-column">Người sửa</th>
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

                                <tr class="<?php echo $classMauRow; ?>" data-id="<?php echo $items['id_dieuhanh']; ?>"
                                    data-loaihang="<?php echo $items['loaihang']; ?>"
                                    data-id-nhomhanghoa="<?php echo $items['id_nhomhanghoa']; ?>">

                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_dieuhanh']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['booking']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_khachhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tentuyenvantai']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_hanghoa']; ?>
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
                                        <?php echo $items['id_nhomhanghoa']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_thauphu']; ?>
                                    </td>

                                    <td>

                                        <?php echo date('d-m-Y', strtotime($items['ngaydongcontainer'])); ?>
                                    </td>

                                    <td>
                                        <?php echo $items['giodongcontainer'] !== NULL && $items['giodongcontainer'] !== '00:00:00' ? $items['giodongcontainer'] : ''; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_hangtau']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tinhtrangdonhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichudonhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichudieuhanh']; ?>
                                    </td>

                                    <td class="hidden-column">
                                        <?php
                                        if ($items['ngaytao'] !== NULL) {
                                            echo date('d-m-Y', strtotime($items['ngaytao']));
                                        } else {
                                            echo "";
                                        }
                                        ?>

                                    </td>

                                    <td class="hidden-column">
                                        <?php echo $items['nguoitao']; ?>
                                    </td>

                                    <td class="hidden-column">
                                        <?php
                                        if ($items['ngaysua'] !== NULL) {
                                            echo date('d-m-Y', strtotime($items['ngaysua']));
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                    </td>

                                    <td class="hidden-column">
                                        <?php echo $items['nguoisua']; ?>
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
                <script>
                    function exportTableToExcel(tableID) {
                        var downloadLink;
                        var dataType = 'application/vnd.ms-excel';
                        var tableSelect = document.getElementById(tableID);

                        // Clone the table element to preserve the original table
                        var clonedTable = tableSelect.cloneNode(true);

                        // Remove unwanted columns
                        var unwantedColumns = ['Ngày tạo', 'Người tạo', 'Ngày sửa', 'Người sửa'];
                        var headers = clonedTable.getElementsByTagName('th');
                        for (var i = headers.length - 1; i >= 0; i--) {
                            var headerText = headers[i].textContent.trim();
                            if (unwantedColumns.includes(headerText)) {
                                headers[i].remove();
                                var rows = clonedTable.getElementsByTagName('tr');
                                for (var j = 0; j < rows.length; j++) {
                                    var cells = rows[j].getElementsByTagName('td');
                                    if (cells[i]) {
                                        cells[i].remove();
                                    }
                                }
                            }
                        }

                        // Add CSS styles for borders to the cloned table
                        clonedTable.style.borderCollapse = 'collapse';
                        var cells = clonedTable.getElementsByTagName('td');
                        for (var i = 0; i < cells.length; i++) {
                            cells[i].style.border = '1px solid black';
                        }

                        var headers = clonedTable.getElementsByTagName('th');
                        for (var i = 0; i < headers.length; i++) {
                            headers[i].style.border = '1px solid black';
                        }

                        var tableHTML = clonedTable.outerHTML.replace(/ /g, '%20');

                        // Lấy URL hiện tại
                        var currentURL = window.location.href;

                        // Kiểm tra xem URL có chứa tham số "from_date" và "to_date" hay không
                        if (currentURL.includes("from_date") && currentURL.includes("to_date")) {
                            // Trích xuất giá trị của tham số "from_date" và "to_date" từ URL
                            var urlParams = new URLSearchParams(currentURL);
                            var fromDate = urlParams.get("from_date");
                            var toDate = urlParams.get("to_date");

                            // Kiểm tra nếu giá trị của tham số không rỗng
                            if (fromDate && toDate) {
                                // Tạo filename theo định dạng 'baocaosuachua_from_date_to_date'
                                var filename = 'baocaokhvt_' + fromDate + '_' + toDate;
                            }
                        }

                        // Nếu không tìm thấy tham số hoặc giá trị của tham số rỗng
                        if (!filename) {
                            // Lấy ngày tháng năm hiện tại
                            var currentDate = new Date();
                            var year = currentDate.getFullYear();
                            var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                            var firstDay = '01';
                            var lastDay = new Date(year, month, 0).getDate();

                            // Tạo filename theo định dạng 'baocaosuachua_firstDay_lastDay'
                            filename = 'baocaokhvt_' + year + '-' + month + '-' + firstDay + '_' + year + '-' + month + '-' + lastDay;
                        }

                        // Create download link element
                        downloadLink = document.createElement("a");

                        document.body.appendChild(downloadLink);

                        if (navigator.msSaveOrOpenBlob) {
                            var blob = new Blob(['\ufeff', tableHTML], {
                                type: dataType
                            });
                            navigator.msSaveOrOpenBlob(blob, filename);
                        } else {
                            // Create a link to the file
                            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                            // Setting the file name
                            downloadLink.download = filename;

                            // Trigger the download
                            downloadLink.click();
                        }
                    }
                </script>
                <!-- start pagination -->
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
            <!-- end pagination -->

            <div class="modal fade" id="modalKHVT" tabindex="-1" aria-labelledby="modalKHVTLabel" aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="modalKHVTLabel">Chi
                                tiết kế hoạch vận tải</h1>

                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-sm-8">
                                        <div class="card text-white bg-khvt mb-3">
                                            <div class="card-header">
                                                Thông tin kế hoạch
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">

                                                    <div class="col-md-4 mb-3">
                                                        <label for="id_donhang">Mã đơn hàng :</label>
                                                        <input type="text" class="form-control" id="id_donhang"
                                                            placeholder="mã đơn hàng" value="" readonly>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="id_dieuhanh">Mã điều hành :</label>
                                                        <input type="text" class="form-control" id="id_dieuhanh"
                                                            placeholder="Mã điều hành" value="" readonly>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="">Booking :</label>
                                                        <input type="text" class="form-control" id="booking"
                                                            placeholder="booking" value="" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="">Mã khách hàng :</label>
                                                        <input type="text" class="form-control" id="id_khachhang"
                                                            placeholder="mã kh" value="" readonly>
                                                    </div>

                                                    <div class="col-md-9 mb-3">
                                                        <label for="">Tên khách hàng :</label>
                                                        <!-- <input type="text" class="form-control" id="tenkh"
                                                            placeholder="tên khách hàng" value="" readonly> -->

                                                        <textarea class="form-control" id="tenkh"
                                                            placeholder="Ghi chú đơn hàng..." rows="2"
                                                            disabled></textarea>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="">Tuyến vận tải :</label>
                                                        <input type="text" class="form-control" id="tuyenvantai"
                                                            placeholder="Tuyến vận tải" value="" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="">Hàng hóa :</label>
                                                        <input type="text" class="form-control" id="hanghoa"
                                                            placeholder="Hàng hóa" value="" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="">Nhóm hàng hóa :</label>
                                                        <input type="text" class="form-control" id="nhomhanghoa"
                                                            placeholder="Nhóm hàng hóa" value="" readonly>
                                                    </div>



                                                    <div class="col-md-3 mb-3">
                                                        <label for="">Mã thầu phụ :</label>
                                                        <input type="text" class="form-control" id="id_thauphu"
                                                            placeholder="Mã thầu phụ" value="" readonly>
                                                    </div>

                                                    <div class="col-md-9 mb-3">
                                                        <label for="">Tên thầu phụ :</label>
                                                        <input type="text" class="form-control" id="tenthauphu"
                                                            placeholder="Tên thầu phụ" value="" readonly>
                                                    </div>



                                                    <div class="col-md-3 mb-3">
                                                        <label for="">Loại hàng :</label>
                                                        <input type="text" class="form-control" id="loaihang"
                                                            placeholder="Loại hàng" value="" readonly>
                                                    </div>

                                                    <div class="col-md-5 mb-3">
                                                        <label for="">Line/Fwd :</label>
                                                        <input type="text" class="form-control" id="hangtau"
                                                            placeholder="Line/Fwd..." value="" readonly>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="">Trạng thái đơn hàng :</label>
                                                        <input type="text" class="form-control" id="trangthaidonhang"
                                                            placeholder="Trạng thái đơn hàng" value="" readonly>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="">Ngày đóng/trả :</label>
                                                        <input disabled type="date" class="form-control"
                                                            id="ngaydongtra" value="">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="">Giờ đóng/trả :</label>
                                                        <input disabled type="time" class="form-control" id="giodongtra"
                                                            value="">
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="">Ghi chú đơn hàng :</label>
                                                        <textarea class="form-control" id="ghichu_donhang"
                                                            placeholder="Ghi chú đơn hàng..." rows="3"
                                                            disabled></textarea>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="">Ghi chú điều hành :</label>
                                                        <textarea class="form-control" id="ghichu_dieuhanh"
                                                            placeholder="Ghi chú điều hành..." rows="3"
                                                            disabled></textarea>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-4 mt-0">
                                        <div class="card  bg-lichtrinh  mb-0">
                                            <div class="card-header text-white">
                                                Lịch trình
                                            </div>
                                            <div class="card-body">
                                                <!-- Timeline -->
                                                <ul class="timeline">
                                                    <!-- data ajax timeline -->
                                                    <!-- <li class="timeline-item bg-white rounded ml-3 p-3 shadow">
                                                        <div class="timeline-arrow"></div>
                                                        <h2 class="h5 mb-0">Mã lịch trình</h2>
                                                        <p class="text-small mt-2 font-weight-light">Tên lịch trình
                                                        </p>
                                                    </li> -->

                                                </ul>
                                                <!-- End Timeline -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Trở
                                lại</button>
                        </div>

                        </form>
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

        $('tr[data-id]').on('dblclick', function () {
            var id_loaihang = $(this).data('loaihang');
            var id_nhh = $(this).data('id-nhomhanghoa');
            var id_dieuhanh = $(this).data('id');

            $('#modalKHVT').modal('show');

            // lấy data của kế hoạch và lịch trình qua id_loaihang và id_nhh
            $.ajax({
                url: 'ajax/get_kehoachvantai.php',
                type: 'POST',
                dataType: "json",
                data: { id_dieuhanh: id_dieuhanh },
                success: function (response) {
                    // console.log(response);
                    $('#id_donhang').val(response.id_donhang);
                    $('#id_dieuhanh').val(response.id_dieuhanh);
                    $('#booking').val(response.booking);
                    $('#id_khachhang').val(response.id_khachhang);
                    $('#tenkh').val(response.tenkh);
                    $('#tuyenvantai').val(response.tentuyenvantai);
                    $('#hanghoa').val(response.tenhanghoa);
                    $('#nhomhanghoa').val(response.id_nhomhanghoa);
                    $('#id_thauphu').val(response.id_thauphu);
                    $('#tenthauphu').val(response.tenthauphu);
                    $('#loaihang').val(response.loaihang);
                    $('#hangtau').val(response.id_hangtau);
                    $('#trangthaidonhang').val(response.tinhtrangdonhang);
                    $('#ngaydongtra').val(response.ngaydongcontainer);
                    $('#giodongtra').val(response.giodongcontainer);
                    $('#ghichu_donhang').val(response.ghichudonhang);
                    $('#ghichu_dieuhanh').val(response.ghichudieuhanh);

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });

            // lấy lịch trình
            $.ajax({
                url: 'ajax/get_lichtrinh.php',
                type: 'POST',
                dataType: "json",
                data: { id_loaihang: id_loaihang, id_nhh: id_nhh },
                success: function (response) {
                    // console.log(response);
                    var timeline = $('.timeline');

                    // Xóa các phần tử hiện tại trong timeline (nếu có)
                    timeline.empty();

                    for (var i = 0; i < response.length; i++) {
                        var item = response[i];
                        var li = $('<li></li>').addClass('timeline-item bg-white rounded ml-3 p-3 shadow');
                        var arrow = $('<div></div>').addClass('timeline-arrow');
                        var h2 = $('<h2></h2>').addClass('h5 mb-0').text(item.id_lichtrinh);
                        var p = $('<p></p>').addClass('text-small mt-2 font-weight-light').text(item.ten);

                        li.append(arrow);
                        li.append(h2);
                        li.append(p);
                        timeline.append(li);
                    }

                    // <li class="timeline-item bg-white rounded ml-3 p-3 shadow">
                    //     <div class="timeline-arrow"></div>
                    //     <h2 class="h5 mb-0">Mã lịch trình</h2>
                    //     <p class="text-small mt-2 font-weight-light">Tên lịch trình
                    //     </p>
                    // </li>

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });



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