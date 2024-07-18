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
$sqlCount = "SELECT COUNT(*) as total_rows FROM chitietdonhangtamung";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT chitietdonhangtamung.id_ctdhtu,chitietdonhangtamung.id_donhang,DATE(chitietdonhangtamung.ngaytamung) as ngaytamung ,chitietdonhangtamung.id_nhansu as idnhansutamung,nhansu.ten as tennhansutamung,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.giothanhtoan,chitietdonhangtamung.ghichu,chitietdonhangtamung.anh1,donhang.booking,DATE(donhang.ngaytao) as ngaytaodonhang,donhang.loaihang,donhang.id_nhomhanghoa,nhomhanghoa.ten as tennhomhanghoa,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.sokg,donhang.id_khachhang,khachhang.ten as tenkhachhang,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(chitietdonhangtamung.ngaytao) as ngaytao, 
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

WHERE 1 AND chitietdonhangtamung.ngaytamung >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND chitietdonhangtamung.ngaytamung < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
ORDER BY chitietdonhangtamung.ngaytao DESC
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


if (isset($_GET['filter'])) {
    $id_nhansu = '';

    if (isset($_GET['filter_nhansu']) && $_GET['filter_nhansu'] == '1') {
        // Kiểm tra xem checkbox "Cán bộ tạm ứng" được chọn hay không
        if (isset($_GET['nhansu'])) {
            $id_nhansu = $_GET['nhansu'];
        }
    }

    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';


    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT chitietdonhangtamung.id_ctdhtu,chitietdonhangtamung.id_donhang,DATE(chitietdonhangtamung.ngaytamung) as ngaytamung ,chitietdonhangtamung.id_nhansu as idnhansutamung,nhansu.ten as tennhansutamung,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chitietdonhangtamung.ngaythanhtoan,chitietdonhangtamung.giothanhtoan,chitietdonhangtamung.ghichu,chitietdonhangtamung.anh1,donhang.booking,DATE(donhang.ngaytao) as ngaytaodonhang,donhang.loaihang,donhang.id_nhomhanghoa,nhomhanghoa.ten as tennhomhanghoa,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.sokg,donhang.id_khachhang,khachhang.ten as tenkhachhang,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(chitietdonhangtamung.ngaytao) as ngaytao, 
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
    
    WHERE 1 ";

    if (!empty($id_nhansu)) {
        // Thêm điều kiện tìm kiếm theo id_nhansu
        $sql .= " AND chitietdonhangtamung.id_nhansu = :id_nhansu";
    }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND chitietdonhangtamung.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND chitietdonhangtamung.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY chitietdonhangtamung.ngaytao DESC LIMIT $offset, $total_records_per_page";

    $stmt = $conn->prepare($sql);

    if (!empty($id_nhansu)) {
        $stmt->bindParam(':id_nhansu', $id_nhansu);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách tạm ứng</h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_nhansu"
                            id="filter_nhansu" value="1" <?php echo isset($_GET['filter_nhansu']) && $_GET['filter_nhansu'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Cán bộ tạm ứng</span>
                            </div>
                            <select disabled class="form-control mr-5" name="nhansu" id="exampleFormControlSelect1">
                                <option value="">--Chọn cán bộ--</option>

                                <?php foreach ($resultNhanSu as $itemsNS): ?>
                                    <option value="<?php echo $itemsNS['id_auto_increment']; ?>" <?php echo isset($_GET['nhansu']) && $_GET['nhansu'] == $itemsNS['id_auto_increment'] ? 'selected' : ''; ?>>
                                        <?php echo $itemsNS['ten']; ?>
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
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="list_tamung.php" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
            <script>
                // phần này để khi chọn checkbox rồi khi filter reload trang sẽ ko bị mất checkbox đã checked
                const form = document.getElementById('filterForm');
                const filternhansu = document.getElementById('filter_nhansu');
                const nhansuSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    nhansuSelect.disabled = !filternhansu.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filternhansu.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);

                form.addEventListener('submit', function (e) {
                    if (filternhansu.checked && nhansuSelect.disabled) {
                        e.preventDefault();
                    }

                    if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                        e.preventDefault();
                    }
                });
            </script>

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
                            <tr data-id="<?php echo $items['id_ctdhtu']; ?>"
                                data-ngaytao="<?php echo $items['ngaytao']; ?>">
                                <th>STT</th>
                                <th>Mã tạm ứng</th>
                                <th>Mã đơn hàng</th>
                                <th>Ngày tạm ứng</th>
                                <th>Cán bộ tạm ứng</th>
                                <th>Tiền cước vỏ (VNĐ)</th>
                                <th>Tiền hải quan (VNĐ)</th>
                                <th>Tiền nâng hạ (VNĐ)</th>
                                <th>Tiền khác (VNĐ)</th>
                                <th>Ngày thanh toán</th>
                                <th>Giờ thanh toán</th>
                                <th>Ghi chú</th>
                                <th>Ảnh hoàn ứng</th>

                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th>Ngày sửa</th>
                                <th>Người sửa</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                              ?>

                                <tr data-id="<?php echo $items['id_ctdhtu']; ?>"
                                    data-ngaytao="<?php echo $items['ngaytao']; ?>"
                                    data-id-donhang="<?php echo $items['id_donhang']; ?>">

                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_ctdhtu']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaytamung'])); ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tennhansutamung']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tiencuocvo = $items['tiencuocvo'];
                                        $formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', '.');
                                        echo $formatted_tiencuocvo;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienhaiquan = $items['tienhaiquan'];
                                        $formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', '.');
                                        echo $formatted_tienhaiquan;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tiennangha = $items['tiennangha'];
                                        $formatted_tiennangha = number_format($tiennangha, 0, ',', '.');
                                        echo $formatted_tiennangha;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $tienkhac = $items['tienkhac'];
                                        $formatted_tienkhac = number_format($tienkhac, 0, ',', '.');
                                        echo $formatted_tienkhac;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo ($items['ngaythanhtoan'] == '0000-00-00' || $items['ngaythanhtoan'] == null) ? '' : $items['ngaythanhtoan']; ?>
                                    </td>

                                    <td>
                                        <?php echo ($items['giothanhtoan'] == '00:00:00' || $items['giothanhtoan'] == null) ? '' : $items['giothanhtoan']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichu']; ?>
                                    </td>

                                    <td>
                                        <a href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                            <img style="width: 104px;height: 50px;" src="img/<?php echo $items['anh1']; ?>">
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

                                    <td>
                                        <form action="sua_tamung.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_ctdhtu']; ?>">
                                            <input type="hidden" name="edit_id_donhang"
                                                value="<?php echo $items['id_donhang']; ?>">
                                            <button name="suabtn" class="btn   btn-edit  btn-block" <?php echo $disableSua; ?>><i class="fas fa-edit"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_ctdhtu']; ?>" tabindex="-1"
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
                                                        <p>Bạn có chắc chắn muốn xóa tạm ứng có mã:
                                                            <strong>
                                                                <?php echo $items['id_ctdhtu']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_tamung.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_ctdhtu']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn  btn-delete  btn-block" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_ctdhtu']; ?>" <?php echo $disableXoa; ?>><i class="fas fa-trash"></i> </button>
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
            if (ngaytaoYear < currentYear || (ngaytaoYear === currentYear && ngaytaoMonth < currentMonth)) {
                $('#disableEditModal').modal('show');
            } else {
                // Ngược lại, chuyển hướng đến trang sửa với ID tương ứng
                window.location.href = 'sua_tamung.php?edit_id=' + id + '&donhang_id=' + id_donhang;
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