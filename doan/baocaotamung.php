<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');



// DATE_FORMAT(NOW(), '%Y-%m-01') = 2024-05-01
// DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01') = 2024-06-01


// tổng tiền tạm ứng theo các cán bộ trong tháng hiện tại
$sql = "SELECT chitietdonhangtamung.id_donhang, nhansu.ten as canbotamung, chitietdonhangtamung.ngaytamung,
chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,
chitietdonhangtamung.tienkhac,chitietdonhangtamung.ghichu,sums.tiencuocvo_sum, sums.tienhaiquan_sum, sums.tiennangha_sum, 
sums.tienkhac_sum
FROM chitietdonhangtamung

INNER JOIN nhansu ON chitietdonhangtamung.id_nhansu = nhansu.id_nhansu
CROSS JOIN (
    SELECT SUM(tiencuocvo) AS tiencuocvo_sum, SUM(tienhaiquan) AS tienhaiquan_sum, SUM(tiennangha) AS tiennangha_sum, SUM(tienkhac) AS tienkhac_sum
    FROM chitietdonhangtamung 
    WHERE chitietdonhangtamung.ngaytamung >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  chitietdonhangtamung.ngaytamung < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS sums
	WHERE chitietdonhangtamung.ngaytamung >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  chitietdonhangtamung.ngaytamung < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY chitietdonhangtamung.ngaytamung ASC";

$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

// tổng tiền tạm ứng theo từng cán bộ trong tháng hiện tại
$sql1 = "SELECT chitietdonhangtamung.id_donhang, chitietdonhangtamung.id_nhansu,nhansu.ten as canbotamung, chitietdonhangtamung.ngaytamung,chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ghichu,sums.tiencuocvo_sum, sums.tienhaiquan_sum, sums.tiennangha_sum, sums.tienkhac_sum
FROM chitietdonhangtamung
INNER JOIN nhansu ON chitietdonhangtamung.id_nhansu = nhansu.id_nhansu
INNER JOIN (
    SELECT id_nhansu,SUM(tiencuocvo) AS tiencuocvo_sum, SUM(tienhaiquan) AS tienhaiquan_sum, SUM(tiennangha) AS tiennangha_sum, SUM(tienkhac) AS tienkhac_sum
    FROM chitietdonhangtamung 
    WHERE chitietdonhangtamung.ngaytamung >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  chitietdonhangtamung.ngaytamung < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
    GROUP BY id_nhansu
) AS sums ON chitietdonhangtamung.id_nhansu = sums.id_nhansu 
	WHERE chitietdonhangtamung.ngaytamung >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  chitietdonhangtamung.ngaytamung < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
GROUP BY chitietdonhangtamung.id_nhansu 
ORDER BY chitietdonhangtamung.ngaytamung ASC";

$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$resultTamUngUnique = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTamUngUnique[] = $row;
}


$sqlKH = "SELECT * FROM `khachhang` ORDER BY `khachhang`.`id_khachhang` DESC";
$stmtKH = $conn->prepare($sqlKH);
$query = $stmtKH->execute();
$resultKH = array();
while ($row = $stmtKH->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}


if (isset($_GET['filter']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {
    // $id_khachhang = '';

    // if (isset($_GET['filter_khachhang']) && $_GET['filter_khachhang'] == '1') {
    //     // Kiểm tra xem checkbox "Cán bộ tạm ứng" được chọn hay không
    //     if (isset($_GET['khachhang'])) {
    //         $id_khachhang = $_GET['khachhang'];
    //     }
    // }

    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';

    // tổng tiền tất cả xe trong tháng hiện tại
    $sql = "SELECT chitietdonhangtamung.id_donhang, nhansu.ten as canbotamung, chitietdonhangtamung.ngaytamung,
    chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,
    chitietdonhangtamung.tienkhac,chitietdonhangtamung.ghichu,sums.tiencuocvo_sum, sums.tienhaiquan_sum, sums.tiennangha_sum, 
    sums.tienkhac_sum
    FROM chitietdonhangtamung
    INNER JOIN nhansu ON chitietdonhangtamung.id_nhansu = nhansu.id_nhansu
    CROSS JOIN (
        SELECT SUM(tiencuocvo) AS tiencuocvo_sum, SUM(tienhaiquan) AS tienhaiquan_sum, SUM(tiennangha) AS tiennangha_sum, SUM(tienkhac) AS tienkhac_sum
        FROM chitietdonhangtamung 
        WHERE 1";

    // tổng tiền theo từng xe trong tháng hiện tại
    $sql1 = "SELECT chitietdonhangtamung.id_donhang, chitietdonhangtamung.id_nhansu,nhansu.ten as canbotamung, chitietdonhangtamung.ngaytamung,chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ghichu,sums.tiencuocvo_sum, sums.tienhaiquan_sum, sums.tiennangha_sum, sums.tienkhac_sum
    FROM chitietdonhangtamung
    INNER JOIN nhansu ON chitietdonhangtamung.id_nhansu = nhansu.id_nhansu
    INNER JOIN (
        SELECT id_nhansu,SUM(tiencuocvo) AS tiencuocvo_sum, SUM(tienhaiquan) AS tienhaiquan_sum, SUM(tiennangha) AS tiennangha_sum, SUM(tienkhac) AS tienkhac_sum
        FROM chitietdonhangtamung 
        WHERE 1";


    // if (!empty($id_khachhang)) {
    //     // Thêm điều kiện tìm kiếm theo id_nhansu
    //     $sql .= " AND donhang.id_khachhang = :id_khachhang";
    // }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND chitietdonhangtamung.ngaytamung >= :from_date";
        $sql1 .= " AND chitietdonhangtamung.ngaytamung >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND chitietdonhangtamung.ngaytamung <= :to_date ) as sums where chitietdonhangtamung.ngaytamung  >= :from_date and   chitietdonhangtamung.ngaytamung  < :to_date ";
        $sql1 .= " AND chitietdonhangtamung.ngaytamung <= :to_date GROUP BY id_nhansu) as sums ON chitietdonhangtamung.id_nhansu = sums.id_nhansu  where chitietdonhangtamung.ngaytamung >= :from_date and  chitietdonhangtamung.ngaytamung  < :to_date ";
    }

    $sql .= " ORDER BY chitietdonhangtamung.ngaytamung ASC";
    $sql1 .= " GROUP BY chitietdonhangtamung.id_nhansu ORDER BY chitietdonhangtamung.ngaytamung ASC";

    $stmt = $conn->prepare($sql);
    $stmt1 = $conn->prepare($sql1);

    // if (!empty($id_khachhang)) {
    //     $stmt->bindParam(':id_khachhang', $id_khachhang);
    // }

    if (!empty($from_date)) {
        $stmt->bindParam(':from_date', $from_date);
        $stmt1->bindParam(':from_date', $from_date);
    }

    if (!empty($to_date)) {
        $stmt->bindParam(':to_date', $to_date);
        $stmt1->bindParam(':to_date', $to_date);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt1->execute();
    $resultTamUngUnique = $stmt1->fetchAll(PDO::FETCH_ASSOC);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Báo cáo tạm ứng</h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterBCTU" method="GET">

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
                        <a href="baocaotamung.php" class="btn btn-danger">Làm mới</a>
                    </div>
                </form>
            </div>
            <!-- // phần này để khi chọn checkbox rồi khi filter reload trang sẽ ko bị mất checkbox đã checked -->
            <script>
                const form = document.getElementById('filterForm');
                // const filterkhachhang = document.getElementById('filter_khachhang');
                // const khachhangSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    // khachhangSelect.disabled = !filterkhachhang.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                // filterkhachhang.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);
                if (form) {
                    form.addEventListener('submit', function (e) {
                        // if (filterkhachhang.checked && khachhangSelect.disabled) {
                        //     e.preventDefault();
                        // }

                        if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                            e.preventDefault();
                        }
                    });
                }
            </script>
            <!-- search input -->
            <div class="d-flex mt-3 mb-3 float-right">
                <a href="#" onclick="exportTableToExcel('myTable')" id="excelButton" class="btn btn-success mr-2"
                    style="min-width: 90px;"><i class="fas fa-download mr-2"></i>Excel</a>

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
                                <th>Cán bộ tạm ứng</th>
                                <th>Ngày tạm ứng</th>
                                <th>Ngày thanh toán</th>
                                <th>Tiền cước vỏ (VNĐ)</th>
                                <th>Tiền hải quan (VNĐ)</th>
                                <th>Tiền nâng hạ (VNĐ)</th>
                                <th>Tiền khác (VNĐ)</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <tr class="bg-row-header">
                                <td colspan="10">Tổng tiền tạm ứng theo tất cả cán bộ</td>
                            </tr>
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu     
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['canbotamung']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaytamung'])); ?>
                                    </td>
                                    <td>
                                        <?php echo ($items['ngaythanhtoan'] == '0000-00-00' || $items['ngaythanhtoan'] == null) ? '' : date('d-m-Y', strtotime($items['ngaythanhtoan'])); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tiencuocvo = $items['tiencuocvo'];
                                        $formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', ',');
                                        echo $formatted_tiencuocvo;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienhaiquan = $items['tienhaiquan'];
                                        $formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', ',');
                                        echo $formatted_tienhaiquan;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tiennangha = $items['tiennangha'];
                                        $formatted_tiennangha = number_format($tiennangha, 0, ',', ',');
                                        echo $formatted_tiennangha;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienkhac = $items['tienkhac'];
                                        $formatted_tienkhac = number_format($tienkhac, 0, ',', ',');
                                        echo $formatted_tienkhac;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ghichu']; ?>
                                    </td>
                                </tr>

                            <?php endforeach ?>
                            <?php if ($hasData): ?>

                                <tr class="bg-row-sum">
                                    <td>Tổng cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['tiencuocvo_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienhaiquan_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennangha_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienkhac_sum'], 0, ',', ','); ?></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="10"></td>
                            </tr>

                            <tr class="bg-row-header">
                                <td colspan="10">Tổng tiền tạm ứng theo từng cán bộ</td>
                            </tr>

                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($resultTamUngUnique as $itemsUniqueTamUng):
                                $hasData = true; // Đánh dấu có dữ liệu     
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?> </td>
                                    <td></td>
                                    <td><?php echo $itemsUniqueTamUng['canbotamung']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tiencuocvo = $itemsUniqueTamUng['tiencuocvo_sum'];
                                        $formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', ',');
                                        echo $formatted_tiencuocvo;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienhaiquan = $itemsUniqueTamUng['tienhaiquan_sum'];
                                        $formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', ',');
                                        echo $formatted_tienhaiquan;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tiennangha = $itemsUniqueTamUng['tiennangha_sum'];
                                        $formatted_tiennangha = number_format($tiennangha, 0, ',', ',');
                                        echo $formatted_tiennangha;
                                        ?>
                                    </td>
                                    <td class="bg-row-sum">
                                        <?php
                                        $tienkhac = $itemsUniqueTamUng['tienkhac_sum'];
                                        $formatted_tienkhac = number_format($tienkhac, 0, ',', ',');
                                        echo $formatted_tienkhac;
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>

                            <?php endforeach ?>
                            <?php if ($hasData): ?>
                                <tr class="bg-row-sum">
                                    <td>Tổng cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['tiencuocvo_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienhaiquan_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennangha_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tienkhac_sum'], 0, ',', ','); ?></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
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

                        // Định dạng lại các giá trị ngày tháng trong bảng
                        var cells = clonedTable.getElementsByTagName('td');
                        for (var i = 0; i < cells.length; i++) {
                            var dateValue = cells[i].innerHTML;
                            var formattedDate = dateValue.replace(/(\d{2})-(\d{2})-(\d{4})/g, '$1/$2/$3');
                            cells[i].innerHTML = formattedDate;
                        }

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
                                var filename = 'baocaotamung_' + fromDate + '_' + toDate;
                            }
                        }

                        // Khởi tạo giá trị mặc định cho fromDate và toDate nếu không có trên URL
                        var fromDateDefault, toDateDefault;

                        if (!fromDate || !toDate) {
                            // Lấy ngày tháng hiện tại
                            var currentDate = new Date();
                            var currentYear = currentDate.getFullYear();
                            var currentMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                            var firstDay = '01';
                            var lastDay = new Date(currentYear, currentMonth, 0).getDate();

                            // Tạo chuỗi ngày tháng năm mặc định
                            fromDateDefault = firstDay + '/' + currentMonth + '/' + currentYear;
                            toDateDefault = lastDay + '/' + currentMonth + '/' + currentYear;
                        } else {
                            // Chuyển đổi định dạng ngày từ "yyyy-mm-dd" sang "dd/mm/yyyy"
                            var fromDateParts = fromDate.split("-");
                            var formattedFromDate = fromDateParts[2] + '/' + fromDateParts[1] + '/' + fromDateParts[0];
                            var toDateParts = toDate.split("-");
                            var formattedToDate = toDateParts[2] + '/' + toDateParts[1] + '/' + toDateParts[0];

                            // Gán giá trị đã được định dạng cho fromDate và toDate
                            fromDateDefault = formattedFromDate;
                            toDateDefault = formattedToDate;
                        }

                        // Mã hóa giá trị ngày thành URL-safe
                        var encodedFromDate = encodeURIComponent(fromDateDefault);
                        var encodedToDate = encodeURIComponent(toDateDefault);

                        // Add caption with report title and company name
                        var caption = document.createElement('caption');
                        caption.innerHTML = '<h2>CÔNG TY CỔ PHẦN TIẾP VẬN THÁI BÌNH DƯƠNG</h2><p>Địa chỉ: KCN Đình Vũ, Đông Hải 2, Hải An, Hải Phòng</p>'
                            + '<h3>BẢNG THANH TOÁN HOÀN ỨNG CHO CÁN BỘ</h3><p>Từ ngày: ' + encodedFromDate + ' - Đến ngày: ' + encodedToDate + '</p>';
                        // caption.style.textAlign = 'left';
                        caption.style.fontWeight = 'bold';
                        caption.style.fontSize = '16px';
                        caption.style.color = 'blue';
                        clonedTable.insertBefore(caption, clonedTable.firstChild);

                        var tableHTML = clonedTable.outerHTML.replace(/ /g, '%20');


                        // Nếu không tìm thấy tham số hoặc giá trị của tham số rỗng
                        if (!filename) {
                            // Lấy ngày tháng năm hiện tại
                            var currentDate = new Date();
                            var year = currentDate.getFullYear();
                            var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                            var firstDay = '01';
                            var lastDay = new Date(year, month, 0).getDate();

                            // Tạo filename theo định dạng 'baocaosuachua_firstDay_lastDay'
                            filename = 'baocaotamung_' + year + '-' + month + '-' + firstDay + '_' + year + '-' + month + '-' + lastDay;
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


            </div>
            <!-- /.container-fluid -->
            <?php
            include ('includes/footer.php');
            // include ('includes/scripts.php');
            ?>

        </div>
        <!-- End of Main Content -->
        <script>

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