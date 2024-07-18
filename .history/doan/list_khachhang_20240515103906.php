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
$sqlCount = "SELECT COUNT(*) as total_rows FROM khachhang";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT khachhang.id_khachhang, khachhang.ten, khachhang.diachi, khachhang.sodienthoai, khachhang.email, khachhang.masothue, khachhang.tennganhang, khachhang.stk, khachhang.nguoidaidien, khachhang.sđtgiaonhan, tuyenvantai.ten AS tentuyenvantai, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(khachhang.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(khachhang.ngaysua) as ngaysua
        FROM khachhang
        INNER JOIN tuyenvantai on khachhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
        INNER JOIN nguoidung ON khachhang.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON khachhang.id_nguoisua = nguoidung2.id_nguoidung
        WHERE 1
        ORDER BY khachhang.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

$sqltuyenvantai = "SELECT * FROM tuyenvantai";
$stmt1 = $conn->prepare($sqltuyenvantai);
$query = $stmt1->execute();
$resulttuyenvantai = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTVT[] = $row;
}


if (isset($_GET['filter']))
    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        // echo $from_date;
        $to_date = $_GET['to_date'];
        // echo $to_date;

        $sql = "SELECT khachhang.id_khachhang, khachhang.ten, khachhang.diachi, khachhang.sodienthoai, khachhang.email, khachhang.masothue, khachhang.tennganhang, khachhang.stk, khachhang.nguoidaidien, khachhang.sđtgiaonhan, tuyenvantai.ten AS tentuyenvantai, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(khachhang.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(khachhang.ngaysua) as ngaysua
            FROM khachhang
            INNER JOIN tuyenvantai on khachhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
            INNER JOIN nguoidung ON khachhang.id_nguoitao = nguoidung.id_nguoidung
            LEFT JOIN nguoidung AS nguoidung2 ON khachhang.id_nguoisua = nguoidung2.id_nguoidung
            WHERE khachhang.ngaytao BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
            ORDER BY khachhang.ngaytao DESC
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
                <?php
                include 'includes/userInformation.php';
                ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách khách hàng</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm khách hàng</button>
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





                <form class="form-inline ml-auto mr-4 border p-3 rounded filterkhachhang" method="GET">
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
                        <a href="list_khachhang.php" class="btn btn-danger">Làm mới</a>
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
                                khách hàng</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_khachhang.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã khách hàng</label>
                                        <input type="text" class="form-control" name="id_khachhang"
                                            id="validationCustom01" placeholder="Mã khách hàng" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã khách hàng.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên khách hàng</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên khách hàng" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên khách hàng.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Địa chỉ</label>
                                        <input type="text" class="form-control" name="diachi" id="validationCustom01"
                                            placeholder="Địa chỉ" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập địa chỉ.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số điện thoại</label>
                                        <input type="text" class="form-control" name="sodienthoai"
                                            id="validationCustom01" placeholder="Số điện thoại" value="">
                                        <div class="invalid-feedback">
                                            Nhập Số điện thoại.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Email</label>
                                        <input type="text" class="form-control" name="email" id="validationCustom01"
                                            placeholder="Email" value="">
                                        <div class="invalid-feedback">
                                            Nhập Email.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã số thuế</label>
                                        <input type="text" class="form-control" name="masothue" id="validationCustom01"
                                            placeholder="Mã số thuế" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã số thuế.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Tên ngân hàng</label>
                                        <input type="text" class="form-control" name="tennganhang"
                                            id="validationCustom01" placeholder="Tên ngân hàng" value="">
                                        <div class="invalid-feedback">
                                            Nhập Tên ngân hàng.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số tài khoản</label>
                                        <input type="text" class="form-control" name="stk" id="validationCustom01"
                                            placeholder="Số tài khoản" value="">
                                        <div class="invalid-feedback">
                                            Nhập số tài khoản.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Người đại diện</label>
                                        <input type="text" class="form-control" name="nguoidaidien"
                                            id="validationCustom01" placeholder="Người đại diện" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên người đại diện.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Số điện thoại giao nhận</label>
                                        <input type="text" class="form-control" name="sđtgiaonhan"
                                            id="validationCustom01" placeholder="Số điện thoại giao nhận" value="">
                                        <div class="invalid-feedback">
                                            Nhập số điện thoại giao nhận.
                                        </div>
                                    </div>


                                    <div class="col-md-8  mb-3">
                                        <label for="validationCustom01">Tên tuyến vận tải</label>
                                        <select name="id_tuyenvantai" class="" id="id_tuyenvantai" required>
                                            <option value="">--Chọn tuyến vận tải--</option>
                                            <?php foreach ($resultTVT as $itemsTVT): ?>
                                                <option value="<?php echo $itemsTVT['id_tuyenvantai']; ?>" required>
                                                    <?php echo $itemsTVT['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn tuyến vận tải.
                                        </div>
                                    </div>
                                    <!-- select search -->
                                    <script>
                                        new TomSelect("#id_tuyenvantai", {
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
                                <th>Mã khách hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Mã số thuế</th>
                                <th>Tên ngân hàng</th>
                                <th>Số tài khoản</th>
                                <th>Người đại diện</th>
                                <th>Số điện thoại giao nhận</th>
                                <th>Tên tuyến vận tải</th>
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
                                ?>

                                <tr data-id="<?php echo $items['id_khachhang']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_khachhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ten']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['diachi']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['sodienthoai']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['masothue']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennganhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['stk']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoidaidien']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['sđtgiaonhan']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tentuyenvantai']; ?>
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

                                    <td>
                                        <form action="sua_khachhang.php" method="POST">
                                            <input type="hidden" name="edit_id"
                                                value="<?php echo $items['id_khachhang']; ?>">
                                            <button name="suabtn" class="btn btn-success">Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal-<?php echo $items['id_khachhang']; ?>"
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
                                                        <p>Bạn có chắc chắn muốn xóa khách hàng
                                                            <strong>
                                                                <?php echo $items['ten']; ?></strong> ?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_khachhang.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_khachhang']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal-<?php echo $items['id_khachhang']; ?>">Xoá</button>
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
        // Bắt sự kiện nhấp đúp vào hàng để sửa
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_khachhang.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>