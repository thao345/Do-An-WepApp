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
$sqlCount = "SELECT COUNT(*) as total_rows FROM dieuhanh";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT dieuhanh.id_dieuhanh,dieuhanh.id_donhang,dieuhanh.tinhtrangdonhang,dieuhanh.sodonkethop,dieuhanh.id_thauphu,
thauphu.ten as tenthauphu ,thauphu.masothue,dieuhanh.id_xe,xe.bienso,dieuhanh.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai,
dieuhanh.ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao, 
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(dieuhanh.ngaysua) as ngaysua,donhang.id_nhomhanghoa
FROM dieuhanh 
INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung

INNER JOIN donhang ON donhang.id_donhang = dieuhanh.id_donhang
INNER JOIN thauphu ON thauphu.id_thauphu = dieuhanh.id_thauphu
INNER JOIN xe ON xe.id_xe = dieuhanh.id_xe
INNER JOIN taixe ON taixe.id_taixe = dieuhanh.id_taixe

WHERE 1
ORDER BY dieuhanh.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
// $sql ="CALL GetDonHang($offset,$total_records_per_page)";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}



$sqlThauphu = "SELECT * FROM `thauphu` ORDER BY `thauphu`.`ngaytao` DESC";
$stmt1 = $conn->prepare($sqlThauphu);
$query = $stmt1->execute();
$resultThauPhu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultThauPhu[] = $row;
}


if (isset($_GET['filter'])) {
    $id_thauphu = '';

    if (isset($_GET['filter_thauphu']) && $_GET['filter_thauphu'] == '1') {
        // Kiểm tra xem checkbox "thầu phụ" được chọn hay không
        if (isset($_GET['thauphu'])) {
            $id_thauphu = $_GET['thauphu'];
        }
    }

    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT dieuhanh.id_dieuhanh,dieuhanh.id_donhang,dieuhanh.tinhtrangdonhang,dieuhanh.sodonkethop,dieuhanh.id_thauphu,
    thauphu.ten as tenthauphu ,thauphu.masothue,dieuhanh.id_xe,xe.bienso,dieuhanh.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai,
    dieuhanh.ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(dieuhanh.ngaysua) as ngaysua,donhang.id_nhomhanghoa
    FROM dieuhanh 
    INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung
    
    INNER JOIN donhang ON donhang.id_donhang = dieuhanh.id_donhang
    INNER JOIN thauphu ON thauphu.id_thauphu = dieuhanh.id_thauphu
    INNER JOIN xe ON xe.id_xe = dieuhanh.id_xe
    INNER JOIN taixe ON taixe.id_taixe = dieuhanh.id_taixe
    
    WHERE 1";

    if (!empty($id_thauphu)) {

        $sql .= " AND dieuhanh.id_thauphu = :id_thauphu";
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

    if (!empty($id_thauphu)) {
        $stmt->bindParam(':id_thauphu', $id_thauphu);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách điều hành</h1>
            <!-- Topbar Search -->
            <div class="d-flex">

                <!-- filter ngày và ... -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_thauphu"
                            id="filter_thauphu" value="1" <?php echo isset($_GET['filter_thauphu']) && $_GET['filter_thauphu'] == '1' ? 'checked' : ''; ?>>
                        <label class="mr-2" for="exampleFormControlSelect1">Thầu phụ: </label>
                        <select disabled class="form-control mr-5" name="thauphu" id="exampleFormControlSelect1">
                            <option value="">--Chọn thầu phụ--</option>

                            <?php foreach ($resultThauPhu as $itemsTP): ?>
                                <option value="<?php echo $itemsTP['id_thauphu']; ?>" <?php echo isset($_GET['thauphu']) && $_GET['thauphu'] == $itemsTP['id_thauphu'] ? 'selected' : ''; ?>>
                                    <?php echo $itemsTP['id_thauphu']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_date" id="filter_date"
                            value="1" <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>

                        <label class="mr-2">Từ ngày:</label>
                        <input disabled type="date" class="form-control" name="from_date"
                            value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <label class="mr-2">Đến ngày:</label>
                        <input disabled type="date" class="form-control" name="to_date"
                            value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="list_tamung.php" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
            <!-- // phần này để khi chọn checkbox rồi khi filter reload trang sẽ ko bị mất checkbox đã checked -->
            <script>

                const form = document.getElementById('filterForm');
                const filterthauphu = document.getElementById('filter_thauphu');
                const thauphuSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    thauphuSelect.disabled = !filterthauphu.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filterthauphu.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);

                form.addEventListener('submit', function (e) {
                    if (filterthauphu.checked && thauphuSelect.disabled) {
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
                            <tr>
                                <th>STT</th>
                                <th>Mã điều hành</th>
                                <th>Mã đơn hàng</th>
                                <th>Tình trạng</th>
                                <th>Số đơn kết hợp</th>
                                <th>Mã thầu phụ</th>
                                <th>Tên thầu phụ</th>
                                <th>Mã số thuế</th>
                                <th>Biển số</th>
                                <th>Tài xế</th>
                                <th>Số điện thoại</th>
                                <th>Ghi chú</th>

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
                                $hasData = true; // Đánh dấu có dữ liệu  
                                // Kiểm tra giá trị và gán tên lớp CSS tương ứng
                                if ($items['tinhtrangdonhang'] == 'Kết hợp') {
                                    $classMauRow = 'bg-gradient-warning text-white';
                                } elseif ($items['tinhtrangdonhang'] == 'Đơn') {
                                    $classMauRow = '';
                                } else {
                                    $classMauRow = ''; // Nếu không có điều kiện nào khớp, không gán lớp CSS
                                } ?>

                                <tr data-id="<?php echo $items['id_dieuhanh']; ?>"
                                    data-id-nhh="<?php echo $items['id_nhomhanghoa']; ?>"
                                    data-id-tp="<?php echo $items['id_thauphu']; ?>"
                                    data-ngaytao="<?php echo $items['ngaytao']; ?>"
                                    data-id-donhang="<?php echo $items['id_donhang']; ?>"
                                    class="<?php echo $classMauRow; ?>">

                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_dieuhanh']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tinhtrangdonhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['sodonkethop'] ?? 0; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_thauphu']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tenthauphu']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['masothue']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tentaixe']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['sodienthoai']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ghichu']; ?>
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
                                        <form action="sua_dieuhanh.php" method="POST">
                                            <input type="hidden" name="edit_id_nhh"
                                                value="<?php echo $items['id_nhomhanghoa']; ?>">
                                            <input type="hidden" name="edit_id_tp"
                                                value="<?php echo $items['id_thauphu']; ?>">
                                            <input type="hidden" name="edit_id"
                                                value="<?php echo $items['id_dieuhanh']; ?>">
                                            <input type="hidden" name="edit_id_donhang"
                                                value="<?php echo $items['id_donhang']; ?>">
                                            <button name="suabtn" class="btn btn-dieuhanh" <?php echo $disableSua; ?>>Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_dieuhanh']; ?>"
                                            tabindex="-1" role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa điều hành có mã:
                                                            <strong>
                                                                <?php echo $items['id_dieuhanh']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_dieuhanh.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_dieuhanh']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_dieuhanh']; ?>" <?php echo $disableXoa; ?>>Xoá</button>
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

                    <div class="d-flex justify-content-between">

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
            var id_thauphu = $(this).data('id-tp');
            var id_nhomhanghoa = $(this).data('id-nhh');
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
                window.location.href = 'sua_dieuhanh.php?edit_id=' + id + '&donhang_id=' + id_donhang + '&edit_id_tp=' + id_thauphu + '&edit_id_nhh=' + id_nhomhanghoa;
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

        // form validation
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



        // fullscreen
        var fullscreenButton = document.getElementById('fullscreenButton');
        var isFullscreen = false;

        fullscreenButton.addEventListener('click', function () {
            if (!isFullscreen) {
                enterFullscreen();
            } else {
                exitFullscreen();
            }
        });

        function enterFullscreen() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) { /* Firefox */
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { /* IE/Edge */
                document.documentElement.msRequestFullscreen();
            }

            fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>';
            isFullscreen = true;
        }
        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { /* Firefox */
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE/Edge */
                document.msExitFullscreen();
            }

            fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>';
            isFullscreen = false;
        }


    </script>


    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>