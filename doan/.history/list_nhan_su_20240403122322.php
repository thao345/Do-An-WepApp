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
$sqlCount = "SELECT COUNT(*) as total_rows FROM nhansu";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT nhansu.id_nhansu, nhansu.ten, nhansu.tenphongban,nhansu.chucvu, nhansu.nguyenquan, nhansu.diachithuongtru, nhansu.ngaysinh, nhansu.cmnd, nhansu.sđt, nhansu.stk,nhansu.tennganhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(nhansu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(nhansu.ngaysua) as ngaysua
        FROM nhansu INNER JOIN nguoidung ON nhansu.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON nhansu.id_nguoisua = nguoidung2.id_nguoidung
        
        WHERE 1
        ORDER BY nhansu.id_nhansu DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

// if(isset($_POST['thembtn']))
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    // echo $from_date;
    $to_date = $_GET['to_date'];
    // echo $to_date;

    $sql = "SELECT nhansu.id_nhansu, nhansu.ten, nhansu.tenphongban,nhansu.chucvu, nhansu.nguyenquan, nhansu.diachithuongtru, nhansu.ngaysinh, nhansu.cmnd, nhansu.sđt, nhansu.stk,nhansu.tennganhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(nhansu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(nhansu.ngaysua) as ngaysua
            FROM nhansu INNER JOIN nguoidung ON nhansu.id_nguoitao = nguoidung.id_nguoidung
            LEFT JOIN nguoidung AS nguoidung2 ON nhansu.id_nguoisua = nguoidung2.id_nguoidung
            WHERE tinhthanh.ngaysua BETWEEN '$from_date' AND '$to_date'
            ORDER BY tinhthanh.ngaytao DESC
            LIMIT $offset,$total_records_per_page";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;

    }

    // if (empty($result)) {
    //     echo "No Record Found";
    // } else {
    //     foreach ($result as $row) {
    //         echo "day la timkiem";
    //         echo "ID: " . $row['id_tinhthanh'] . "<br>";
    //         echo "Tên tỉnh thành: " . $row['ten'] . "<br>";
    //         echo "Người tạo: " . $row['nguoitao'] . "<br>";
    //         echo "ID người tạo: " . $row['id_nguoidung'] . "<br>";
    //         echo "Ngày tạo: " . $row['ngaytao'] . "<br>";
    //         echo "Người sửa: " . $row['nguoisua'] . "<br>";
    //         echo "ID người sửa: " . $row['id_nguoidung'] . "<br>";
    //         echo "Ngày sửa: " . $row['ngaysua'] . "<br>";
    //         echo "<br>";
    //     }
    // }

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách nhân sự</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
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



                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal"
                    data-whatever="@mdo">Thêm nhân sự</button>

                <form class="form-inline ml-auto mr-4 " method="GET">
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
                        <button type="submit" name="filter" class="btn btn-primary">Filter</button>

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
                                nhân sự</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_tinhthanh.php" method="POST">
                                <div class="form-row">
                                <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Mã nhân sự</label>
                                            <input type="text" class="form-control" name="id_nhansu"
                                                id="validationCustom01" placeholder="Mã nhân sự" value="" required>
                                            <div class="invalid-feedback">
                                                Nhập mã nhân sự.
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Tên nhân sự</label>
                                            <input type="text" class="form-control" name="ten" id="validationCustom02"
                                                placeholder="Tên nhân sự" value="" required>
                                            <div class="invalid-feedback">
                                                Nhập tên nhân sự.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Tên phòng ban</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Tên phòng ban" value="" required>
                                            <div class="invalid-feedback">
                                                Nhập tên phòng ban.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Chức vụ</label>
                                            <input type="text" class="form-control" name="chucvu"
                                                id="validationCustom02" placeholder="Chức vụ" value="" required>
                                            <div class="invalid-feedback">
                                                Chức vụ.
                                            </div>
                                        </div>
                                        



                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Nguyên quán</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Nguyên quán" value="" required>
                                            <div class="invalid-feedback">
                                                Nguyên quán.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Địa chỉ thường trú</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Địa chỉ thường trú" value="" required>
                                            <div class="invalid-feedback">
                                                Địa chỉ thường trú.
                                            </div>
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Ngày sinh</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Ngày sinh" value="" required>
                                            <div class="invalid-feedback">
                                                Ngày sinh.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Căn cước công dân</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Căn cước công dân" value="" required>
                                            <div class="invalid-feedback">
                                                Căn cước công dân.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Số điện thoại</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Số điện thoại" value="" required>
                                            <div class="invalid-feedback">
                                            Số điện thoại.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Tên Ngân hàng</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Tên Ngân hàng" value="" required>
                                            <div class="invalid-feedback">
                                                Tên Ngân hàng.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Số tài khoản</label>
                                            <input type="text" class="form-control" name="tenphongban"
                                                id="validationCustom02" placeholder="Số tài khoản" value="" required>
                                            <div class="invalid-feedback">
                                                Số tài khoản.
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

                    <table class=" table table-striped table-bordered table-hover " id="myTable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã nhân sự </th>
                                <th>Tên nhân sự</th>
                                <th>Tên phòng ban</th>
                                <th>Chức vụ</th>
                                <th>Nguyên quán</th>
                                <th>Địa chỉ thường trú</th>
                                <th>Ngày sinh</th>
                                <th>Căn cước</th>
                                <th>Số điện thoại</th>
                                <th>Số tài khoản</th>
                                <th>Tên ngân hàng</th>
                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th>Ngày sửa</th>
                                <th>Người sửa</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                 ?>

                                <tr data-id="<?php echo $items['id_nhansu']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_nhansu']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ten']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tenphongban']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['chucvu']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguyenquan']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['diachithuongtru']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ngaysinh']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['cmnd']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['sđt']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['stk']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennganhang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['ngaytao']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoitao']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ngaysua']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoisua']; ?>
                                    </td>

                                    <td>
                                        <form action="sua_tinhthanh.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_nhansu']; ?>">
                                            <button name="suabtn" class="btn btn-success">Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa tỉnh
                                                            <?php echo $items['ten']; ?>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_tinhthanh.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_tinhthanh']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal">Xoá</button>
                                    </td>
                                </tr>

                            <?php endforeach ?>
                            <?php if (!$hasData): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Không tìm thấy dữ liệu phù hợp!</td>
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


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>