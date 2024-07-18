<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');




// tổng tiền theo các xe trong tháng hiện tại
$sql = "SELECT suachua.*, xe.bienso, sums.tongtien_sum, sums.dongiavattu_sum, sums.tiennhancong_sum
FROM suachua
INNER JOIN xe ON suachua.id_xe = xe.id_xe
CROSS JOIN (
    SELECT SUM(tongtien) AS tongtien_sum, SUM(dongiavattu) AS dongiavattu_sum, SUM(tiennhancong) AS tiennhancong_sum
    FROM suachua 
    WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS sums
WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY suachua.ngaysuachua ASC";
// LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}



// tổng tiền phân biệt từng xe trong tháng hiện tại
$sql1 = "SELECT suachua.*, xe.bienso, sums.tongtien_sum, sums.dongiavattu_sum, sums.tiennhancong_sum
FROM suachua
INNER JOIN xe ON suachua.id_xe = xe.id_xe
INNER JOIN (
    SELECT id_xe, SUM(tongtien) AS tongtien_sum, SUM(dongiavattu) AS dongiavattu_sum, SUM(tiennhancong) AS tiennhancong_sum
    FROM suachua WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
    GROUP BY id_xe
) AS sums ON suachua.id_xe = sums.id_xe     WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') AND  suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
GROUP BY suachua.id_xe  -- Thêm GROUP BY ở đây
ORDER BY suachua.ngaysuachua ASC";
// LIMIT $offset,$total_records_per_page";
$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$resultUniqueXe = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultUniqueXe[] = $row;
}


$sqlKH = "SELECT * FROM `khachhang` ORDER BY `khachhang`.`id_khachhang` DESC";
$stmtKH = $conn->prepare($sqlKH);
$query = $stmtKH->execute();
$resultKH = array();
while ($row = $stmtKH->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}


if (isset($_GET['filter']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {


    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';

    // tổng tiền tất cả xe trong tháng hiện tại
    $sql = "SELECT suachua.*, xe.bienso, sums.tongtien_sum, sums.dongiavattu_sum, sums.tiennhancong_sum
    FROM suachua
    INNER JOIN xe ON suachua.id_xe = xe.id_xe
    CROSS JOIN (
        SELECT SUM(tongtien) AS tongtien_sum, SUM(dongiavattu) AS dongiavattu_sum, SUM(tiennhancong) AS tiennhancong_sum
        FROM suachua 
        WHERE 1";

    // tổng tiền theo từng xe trong tháng hiện tại
    $sql1 = "SELECT suachua.*, xe.bienso, sums.tongtien_sum, sums.dongiavattu_sum, sums.tiennhancong_sum
    FROM suachua
    INNER JOIN xe ON suachua.id_xe = xe.id_xe
    INNER JOIN (
        SELECT id_xe, SUM(tongtien) AS tongtien_sum, SUM(dongiavattu) AS dongiavattu_sum, SUM(tiennhancong) AS tiennhancong_sum
        FROM suachua
        WHERE 1";


    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND suachua.ngaysuachua >= :from_date";
        $sql1 .= " AND suachua.ngaysuachua >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND suachua.ngaysuachua <= :to_date ) as sums where suachua.ngaysuachua >= :from_date and  suachua.ngaysuachua  < :to_date ";
        $sql1 .= " AND suachua.ngaysuachua <= :to_date GROUP BY id_xe) as sums ON suachua.id_xe = sums.id_xe where suachua.ngaysuachua >= :from_date and  suachua.ngaysuachua  < :to_date ";
    }

    $sql .= " ORDER BY suachua.ngaysuachua ASC";
    $sql1 .= " GROUP BY suachua.id_xe ORDER BY suachua.ngaysuachua ASC";

    $stmt = $conn->prepare($sql);
    $stmt1 = $conn->prepare($sql1);

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
    $resultUniqueXe = $stmt1->fetchAll(PDO::FETCH_ASSOC);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Báo cáo sửa chữa</h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterBCSC" method="GET">

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
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="baocaosuachua.php" class="btn btn-danger">Reset</a>
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
                                <th>Người sửa chữa</th>
                                <th>Biển số </th>
                                <th>Ngày sửa chữa</th>
                                <th>Số km đồng hồ (Km)</th>
                                <th>Nội dung sửa chữa</th>
                                <th>Số lượng</th>
                                <th>Đơn giá vật tư (VNĐ)</th>
                                <th>Tiền nhân công (VNĐ)</th>
                                <th>Tổng tiền (VNĐ)</th>

                                <th>Ghi chú</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <tr class="bg-row-header">
                                <td colspan="11">Tổng theo tất cả xe</td>
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
                                        <?php echo $items['nguoisuachua']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaysuachua'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['sokmdongho']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['noidungsuachua']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['soluong']; ?>
                                    </td>
                                    <td>

                                        <?php
                                        $dongiavattu = $items['dongiavattu'];
                                        $formatted_dongiavattu = number_format($dongiavattu, 0, ',', ',');
                                        echo $formatted_dongiavattu;
                                        ?>
                                    </td>
                                    <td>

                                        <?php
                                        $tiennhancong = $items['tiennhancong'];
                                        $formatted_tiennhancong = number_format($tiennhancong, 0, ',', ',');
                                        echo $formatted_tiennhancong;
                                        ?>
                                    </td>
                                    <td>

                                        <?php
                                        $tongtien = $items['tongtien'];
                                        $formatted_tongtien = number_format($tongtien, 0, ',', ',');
                                        echo $formatted_tongtien;
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
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['dongiavattu_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennhancong_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tongtien_sum'], 0, ',', ','); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="11"></td>
                                </tr>

                                <tr class="bg-row-head  er">
                                    <td colspan="11">Tổng theo từng xe</td>
                                </tr>

                                <?php $count = 1;
                                $hasData = false; // Biến kiểm tra dữ liệu
                                foreach ($resultUniqueXe as $itemsUniqueXe):
                                    $hasData = true; // Đánh dấu có dữ liệu     
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?> </td>
                                        <td></td>
                                        <td><?php echo $itemsUniqueXe['bienso']; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="bg-row-sum">
                                            <?php
                                            $dongiavattu = $itemsUniqueXe['dongiavattu_sum'];
                                            $formatted_dongiavattu = number_format($dongiavattu, 0, ',', ',');
                                            echo $formatted_dongiavattu;
                                            ?>
                                        </td>
                                        <td class="bg-row-sum">
                                            <?php
                                            $tiennhancong = $itemsUniqueXe['tiennhancong_sum'];
                                            $formatted_tiennhancong = number_format($tiennhancong, 0, ',', ',');
                                            echo $formatted_tiennhancong;
                                            ?>
                                        </td>
                                        <td class="bg-row-sum">
                                            <?php
                                            $tongtien = $itemsUniqueXe['tongtien_sum'];
                                            $formatted_tongtien = number_format($tongtien, 0, ',', ',');
                                            echo $formatted_tongtien;
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>


                                <?php endforeach ?>

                                <tr class="bg-row-sum">
                                    <td>Tổng cộng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($items['dongiavattu_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tiennhancong_sum'], 0, ',', ','); ?></td>
                                    <td><?php echo number_format($items['tongtien_sum'], 0, ',', ','); ?></td>
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
                                var filename = 'baocaosuachua_' + fromDate + '_' + toDate;
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
                            + '<h3>BẢNG THANH TOÁN CHI PHÍ SỬA CHỮA THIẾT BỊ</h3><p>Từ ngày: ' + encodedFromDate + ' - Đến ngày: ' + encodedToDate + '</p>';
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
                            filename = 'baocaosuachua_' + year + '-' + month + '-' + firstDay + '_' + year + '-' + month + '-' + lastDay;
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