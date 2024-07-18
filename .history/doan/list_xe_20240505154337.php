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
$sqlCount = "SELECT COUNT(*) as total_rows FROM xe";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT xe.id_xe, xe.bienso, xe.trangthaixe, xe.tennhomxe, nhienlieu.ten as tennhienlieu, nhomhanghoa.ten as tennhomhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(xe.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(xe.ngaysua) as ngaysua
        FROM xe
        INNER JOIN nhienlieu on xe.id_nhienlieu = nhienlieu.id_nhienlieu
        INNER JOIN thauphu on xe.id_thauphu = thauphu.id_thauphu
        INNER JOIN nhomhanghoa on xe.id_nhomhang = nhomhanghoa.id_nhomhanghoa
        INNER JOIN nguoidung ON xe.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON xe.id_nguoisua = nguoidung2.id_nguoidung
        WHERE 1
        ORDER BY xe.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

$sqlNhomXe = "SELECT * FROM nhomxe ";
$stmt1 = $conn->prepare($sqlNhomXe);
$query = $stmt1->execute();
$resultNhomXe = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNhomXe[] = $row;
}

$sqlNhienlieu = "SELECT * FROM nhienlieu ";
$stmt1 = $conn->prepare($sqlNhienlieu);
$query = $stmt1->execute();
$resultNhienlieu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNL[] = $row;
}

$sqlNhomHang = "SELECT * FROM nhomhanghoa";
$stmt1 = $conn->prepare($sqlNhomHang);
$query = $stmt1->execute();
$resultNhomHang = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNH[] = $row;
}

$sqlThauPhu = "SELECT * FROM thauphu";
$stmt1 = $conn->prepare($sqlThauPhu);
$query = $stmt1->execute();
$resultThauPhu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTP[] = $row;
}



if(isset($_GET['filter']))
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    // echo $from_date;
    $to_date = $_GET['to_date'];
    // echo $to_date;

    $sql = "SELECT xe.id_xe, xe.bienso, xe.trangthaixe, xe.tennhomxe, nhienlieu.ten as tennhienlieu, nhomhanghoa.ten as tennhomhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(xe.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(xe.ngaysua) as ngaysua
            FROM xe
            INNER JOIN nhienlieu on xe.id_nhienlieu = nhienlieu.id_nhienlieu
            INNER JOIN thauphu on xe.id_thauphu = thauphu.id_thauphu
            INNER JOIN nhomhanghoa on xe.id_nhomhang = nhomhanghoa.id_nhomhanghoa
            INNER JOIN nguoidung ON xe.id_nguoitao = nguoidung.id_nguoidung
            LEFT JOIN nguoidung AS nguoidung2 ON xe.id_nguoisua = nguoidung2.id_nguoidung
            WHERE xe.ngaytao BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
            ORDER BY xe.ngaytao DESC
            LIMIT $offset,$total_records_per_page";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;

    }

    
} else {

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách xe</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
            <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm xe</button>

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



                
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterTinhThanh" method="GET">
                    <div class="form-group">
                        <label class="mr-2">Từ ngày:</label>
                        <input type="date" class="form-control" name="from_date"
                            value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <label class="mr-2">Đến ngày:</label>
                        <input type="date" class="form-control" name="to_date"
                            value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                    <button type="submit" name="filter" class="btn btn-primary mr-2">Lọc</button>
                        <a href="list_xe.php" class="btn btn-danger">Làm mới</a>

                    </div>
                </form>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                xe</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_xe.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Biển số xe</label>
                                        <input type="text" class="form-control" name="bienso" id="validationCustom01"
                                            placeholder="Nhập biển số xe" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập biển số xe.
                                        </div>
                                    </div>
                                    <!-- Biển xe chưa bắt lỗi định dạng -->

                                    <div class="col-md-6  mb-3">
                                        <label for="validationCustom01">Nhóm xe</label>
                                        <select name="select_NX" class="" id="select_NX" required>
                                            <option value="">--Chọn nhóm xe--</option>
                                            <?php foreach ($resultNhomXe as $itemsNhomXe): ?>
                                                <option value="<?php echo $itemsNhomXe['id_nhomxe']; ?>">
                                                    <?php echo $itemsNhomXe['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhóm xe.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#select_NX", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-6  mb-3">
                                        <label for="validationCustom01">Nhiên liệu</label>
                                        <select name="select_NL" class="" id="select_NL" required>
                                            <option value="">--Chọn nhiên liệu--</option>
                                            <?php foreach ($resultNL as $itemsNL): ?>
                                                <option value="<?php echo $itemsNL['id_nhienlieu']; ?>">
                                                    <?php echo $itemsNL['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhiên liệu.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#select_NL", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>
                                   
                                    <div class="col-md-6  mb-3">
                                        <label for="validationCustom01">Nhóm hàng</label>
                                        <select name="select_NH" class="" id="select_NH" required>
                                            <option value="">--Chọn nhóm hàng--</option>
                                            <?php foreach ($resultNH as $itemsNH): ?>
                                                <option value="<?php echo $itemsNH['id_nhomhanghoa']; ?>">
                                                    <?php echo $itemsNH['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhóm hàng.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#select_NH", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>
                                    <div class="col-md-6  mb-3">
                                        <label for="validationCustom01">Thầu phụ</label>
                                        <select name="select_TP" class="" id="select_TP" required>
                                            <option value="">--Chọn thầu phụ--</option>
                                            <?php foreach ($resultTP as $itemsTP): ?>
                                                <option value="<?php echo $itemsTP['id_thauphu']; ?>">
                                                    <?php echo $itemsTP['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn thầu phụ.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#select_TP", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

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
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class=" table table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;">
                            <tr>
                                <th>STT</th>
                                <th>Biển số xe</th>
                                <th>Trạng thái xe</th>
                                <th>Nhóm xe</th>
                                <th>Nhiên liệu</th>
                                <th>Nhóm hàng</th>
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
                                $hasData = true; // Đánh dấu có dữ liệu                       ?>

                                <tr data-id="<?php echo $items['id_xe']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>
                                    <td
                                        style="background-color: <?php echo ($items['trangthaixe'] == 'OK') ? '#1cc88a' : '#e74a3b'; ?>">
                                        <?php echo $items['trangthaixe']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennhomxe']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennhienlieu']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennhomhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaytao'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoitao']; ?>
                                    </td>
                                    <td>
                                    <?php if($items['ngaysua'] != null) echo date('d-m-Y', strtotime($items['ngaysua'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoisua']; ?>
                                    </td>

                                    <td>
                                        <form action="sua_xe.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_xe']; ?>">
                                            <button name="suabtn" class="btn btn-success">Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_xe']; ?>" tabindex="-1" role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa xe có biển số
                                                            <strong>
                                                                <?php echo $items['bienso']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_xe.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_xe']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_xe']; ?>">Xoá</button>
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




        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // viết js custom ở đây
        // Bắt sự kiện nhấp đúp vào hàng để sửa
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_xe.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>