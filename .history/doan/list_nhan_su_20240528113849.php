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


$sql = "SELECT nhansu.id_auto_increment, id_auto_increment,nhansu.id_nhansu, nhansu.ten, nhansu.tenphongban,nhansu.chucvu, nhansu.nguyenquan, nhansu.diachithuongtru, nhansu.ngaysinh, nhansu.cmnd, nhansu.sđt, nhansu.stk,nhansu.tennganhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(nhansu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(nhansu.ngaysua) as ngaysua
        FROM nhansu INNER JOIN nguoidung ON nhansu.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON nhansu.id_nguoisua = nguoidung2.id_nguoidung

        WHERE 1
        ORDER BY nhansu.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

if (isset($_GET['filter']))
    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];

        $sql = "SELECT nhansu.id_auto_increment, id_auto_increment,nhansu.id_nhansu, nhansu.ten, nhansu.tenphongban,nhansu.chucvu, nhansu.nguyenquan, nhansu.diachithuongtru, nhansu.ngaysinh, nhansu.cmnd, nhansu.sđt, nhansu.stk,nhansu.tennganhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(nhansu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(nhansu.ngaysua) as ngaysua
                FROM nhansu INNER JOIN nguoidung ON nhansu.id_nguoitao = nguoidung.id_nguoidung
                LEFT JOIN nguoidung AS nguoidung2 ON nhansu.id_nguoisua = nguoidung2.id_nguoidung
                WHERE nhansu.ngaytao BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
                ORDER BY nhansu.ngaytao DESC
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách nhân sự</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
                <div class="d-flex mt-3 mb-3 float-right">
                    <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                        data-target="#exampleModal" data-whatever="@mdo">Thêm nhân sự</button>
                    
                </div>
                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">

                    <div class="form-group">

                        <label class="mr-2">Từ ngày: </label>
                        <input enable type="date" class="form-control" name="from_date"
                            value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <label class="mr-2">Đến ngày: </label>
                        <input enable type="date" class="form-control" name="to_date"
                            value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Lọc</button>
                        <a href="list_nhan_su.php" class="btn btn-danger">Làm mới</a>
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
                            <form class="needs-validation" novalidate action="them_nhan_su.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã nhân sự:</label>
                                        <input type="text" class="form-control" name="id_nhansu" id="validationCustom01"
                                            placeholder="Mã nhân sự" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã nhân sự.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên nhân sự:</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên nhân sự" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên nhân sự.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tên phòng ban:</label>
                                        <input type="text" class="form-control" name="tenphongban"
                                            id="validationCustom02" placeholder="Tên phòng ban" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên phòng ban.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Chức vụ:</label>
                                        <input type="text" class="form-control" name="chucvu" id="validationCustom02"
                                            placeholder="Chức vụ" value="" required>
                                        <div class="invalid-feedback">
                                            Chức vụ.
                                        </div>
                                    </div>




                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Nguyên quán:</label>
                                        <input type="text" class="form-control" name="nguyenquan"
                                            id="validationCustom02" placeholder="Nguyên quán" value="" required>
                                        <div class="invalid-feedback">
                                            Nguyên quán.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Địa chỉ thường trú:</label>
                                        <input type="text" class="form-control" name="diachithuongtru"
                                            id="validationCustom02" placeholder="Địa chỉ thường trú" value="" required>
                                        <div class="invalid-feedback">
                                            Địa chỉ thường trú.
                                        </div>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Ngày sinh:</label>
                                        <input type="date" class="form-control" name="ngaysinh" id="validationCustom02"
                                            placeholder="Ngày sinh" value="" required>
                                        <div class="invalid-feedback">
                                            Ngày sinh.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Căn cước công dân:</label>
                                        <input type="text" class="form-control" name="cmnd" id="validationCustom02"
                                            placeholder="Căn cước công dân" value="" required>
                                        <div class="invalid-feedback">
                                            Căn cước công dân.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Số điện thoại:</label>
                                        <input type="text" class="form-control" name="sđt" id="validationCustom02"
                                            placeholder="Số điện thoại" value="" required>
                                        <div class="invalid-feedback">
                                            Số điện thoại.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tên ngân hàng:</label>
                                        <input type="text" class="form-control" name="nganhang" id="validationCustom02"
                                            placeholder="Tên ngân hàng" value="" required>
                                        <div class="invalid-feedback">
                                            Tên ngân hàng.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Số tài khoản:</label>
                                        <input type="text" class="form-control" name="stk" id="validationCustom02"
                                            placeholder="Số tài khoản" value="" required>
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

                    <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;" class="thead-dark">
                            <tr>
                                <th class="text-center">STT</th>
                                 <th class="text-center">Mã nhân sự </th>
                                 <th class="text-center">Tên nhân sự</th>
                                 <th class="text-center">Tên phòng ban</th>
                                 <th class="text-center">Chức vụ</th>
                                 <th class="text-center">Nguyên quán</th>
                                 <th class="text-center">Địa chỉ thường trú</th>
                                 <th class="text-center">Ngày sinh</th>
                                 <th class="text-center">Căn cước</th>
                                 <th class="text-center">Số điện thoại</th>
                                 <th class="text-center">Số tài khoản</th>
                                 <th class="text-center">Tên ngân hàng</th>
                                 <th class="text-center">Ngày tạo</th>
                                 <th class="text-center">Người tạo</th>
                                 <th class="text-center">Ngày sửa</th>
                                 <th class="text-center">Người sửa</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                  ?>

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
                                        <?php echo date('d-m-Y', strtotime($items['ngaysinh'])); ?>
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
                                        <form action="sua_nhan_su.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_nhansu']; ?>">
                                            <button name="suabtn" class="btn   btn-edit  btn-block"><i
                                                    class="fas fa-edit"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal-<?php echo $items['id_auto_increment']; ?>"
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
                                                        <p>Bạn có chắc chắn muốn xóa nhân sự
                                                            <strong>
                                                                <?php echo $items['ten']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_nhan_su.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_nhansu']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn  btn-delete  btn-block" data-toggle="modal"
                                            data-target="#deleteModal-<?php echo $items['id_auto_increment']; ?>">
                                            <i class="fas fa-trash"></i> </button>
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
            window.location.href = 'sua_nhan_su.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>