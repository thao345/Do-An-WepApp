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
$sqlCount = "SELECT COUNT(*) as total_rows FROM nguoidung";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT nguoidung.id_nguoidung, nguoidung.tendangnhap, nguoidung.matkhau,nguoidung.trangthai, nguoidung.isadmin,  nguoidung.tendangnhap AS nguoitao, DATE(nguoidung.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, DATE(nguoidung.ngaysua) as ngaysua
        FROM nguoidung 
        LEFT JOIN nguoidung AS nguoidung2 ON nguoidung.id_nguoisua = nguoidung2.id_nguoidung

        WHERE 1
        ORDER BY nguoidung.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}


if (isset($_GET['filter'])) {
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';
    $trangthai = isset($_GET['trangthai']) ? $_GET['trangthai'] : '';


    $sql = "SELECT nguoidung.id_nguoidung, nguoidung.tendangnhap, nguoidung.matkhau,nguoidung.trangthai, nguoidung.isadmin,  nguoidung.tendangnhap AS nguoitao, DATE(nguoidung.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, DATE(nguoidung.ngaysua) as ngaysua
                FROM nguoidung 
                LEFT JOIN nguoidung AS nguoidung2 ON nguoidung.id_nguoisua = nguoidung2.id_nguoidung
                WHERE 1";

    if (!empty($trangthai)) {
        // Thêm điều kiện trạng thái
        $sql .= " AND nguoidung.trangthai = '$trangthai'";
    }

    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND nguoidung.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND nguoidung.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY nguoidung.ngaytao DESC LIMIT $offset, $total_records_per_page";

    $stmt = $conn->prepare($sql);



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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách người dùng</h1>

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
                                <option value="true" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] == 'true' ? 'selected' : '') : ''; ?>>true</option>
                                <option value="false" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] == 'false' ? 'selected' : '') : ''; ?>>false</option>

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
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Lọc</button>
                        <a href="list_nguoidung.php" class="btn btn-danger">Làm mới</a>
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
                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm người dùng</button>
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


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                người dùng</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_nguoidung.php" method="POST">
                                <div class="form-row">

                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tên đăng nhập</label>
                                        <input type="text" class="form-control" name="tendangnhap"
                                            id="validationCustom02" placeholder="Tên đăng nhập" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên tên đăng nhập.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Admin</label>
                                        <select name="isadmin" class="form-control" id="validationCustom02" required>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>

                                        <div class="invalid-feedback">
                                            Mật khẩu.
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Mật khẩu</label>
                                        <input type="text" class="form-control" name="matkhau" id="validationCustom02"
                                            placeholder="Mật khẩu" value="" required>
                                        <div class="invalid-feedback">
                                            Mật khẩu.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Trạng thái</label>
                                        <input type="text" class="form-control" name="trangthai" id="validationCustom02"
                                            value="true" required readonly>
                                        <div class="invalid-feedback">
                                            Trạng thái
                                        </div>
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
            </div>

            <div class="card-body">
                <div class="table-responsive">

                <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;" class="thead-dark">
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Mã người dùng </th>
                                <th class="text-center">Tên đăng nhập</th>
                                <th class="text-center">Mật khẩu</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Ngày sửa</th>
                                <th class="text-center">Người sửa</th>
                                <th colspan="3" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                  ?>

                                <tr data-id="<?php echo $items['id_nguoidung']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_nguoidung']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tendangnhap']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['matkhau']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $trangthai = $items['trangthai'];
                                        if ($trangthai == 'false') {
                                            echo '<i class="fas fa-times text-danger"></i>';
                                        } else if ($trangthai == 'true') {
                                            echo '<i class="fas fa-check text-success"></i>';
                                        } else {
                                            echo $trangthai;
                                        }
                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <?php

                                        $admin = $items['isadmin'];
                                        if ($admin == 'false') {
                                            echo '<i class="fas fa-times text-danger"></i>';
                                        } else if ($admin == 'true') {
                                            echo '<i class="fas fa-check text-success"></i>';
                                        } else {
                                            echo $admin;
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaytao'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoitao']; ?>
                                    </td>
                                    <td>
                                        <?php if ($items['ngaysua'] != null)
                                            echo date('d-m-Y', strtotime($items['ngaysua'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoisua']; ?>
                                    </td>

                                    <td>
                                        <form action="sua_nguoidung.php" method="POST">
                                            <input type="hidden" name="edit_id"
                                                value="<?php echo $items['id_nguoidung']; ?>">
                                            <button name="suabtn" class="btn btn-success btn-icon-split ">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Sửa</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="phanquyen.php" method="POST">
                                            <input type="hidden" name="id_nguoidung"
                                                value="<?php echo $items['id_nguoidung']; ?>">
                                            <input type="hidden" name="tendangnhap"
                                                value="<?php echo $items['tendangnhap']; ?>">
                                            <input type="hidden" name="isadmin" value="<?php echo $items['isadmin']; ?>">
                                            <button name="PhanQuyenbtn" class="btn btn-info btn-icon-split  pq-button">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Phân
                                                    quyền</span>
                                            </button>
                                        </form>
                                    </td>
                                    <!-- check nút phân quyền -->
                                    <script>
                                        window.addEventListener('DOMContentLoaded', function () {
                                            var printButtons = document.getElementsByClassName('pq-button');

                                            for (var i = 0; i < printButtons.length; i++) {
                                                var isadmin = printButtons[i].form.elements['isadmin'].value;

                                                if (isadmin == 'true') {
                                                    printButtons[i].addEventListener('click', function (event) {
                                                        event.preventDefault();
                                                        $('#adminModal').modal('show');
                                                    });
                                                }
                                            }
                                        });
                                    </script>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal-<?php echo $items['id_nguoidung']; ?>"
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
                                                        <p>Bạn có chắc chắn muốn xóa người dùng
                                                            <strong>
                                                                <?php echo $items['tendangnhap']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_nguoidung.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_nguoidung']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                       
                                        <button name="suabtn" class="btn  btn-delete btn-block btn-icon-split "
                                            data-toggle="modal"
                                            data-target="#deleteModal-<?php echo $items['id_nguoidung']; ?>">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text text-white">Xóa</span>
                                        </button>
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

            </div>

            <?php include ('phantrang.php'); ?>




            <!-- Modal thông báo k cho phân quyền -->
            <div id="adminModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adminModalLabel">Thông báo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Người dùng là admin, không cần phân quyền!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // viết js custom ở đây
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_nguoidung.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>