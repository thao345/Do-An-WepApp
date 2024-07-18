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
$sqlCount = "SELECT COUNT(*) as total_rows FROM hanghoa";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT hanghoa.id_hanghoa, hanghoa.ten, nhomhanghoa.ten AS tennhomhanghoa, hanghoa.kichthuoc, hanghoa.donvitinh, hanghoa.ghichu, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(hanghoa.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(hanghoa.ngaysua) as ngaysua
        FROM hanghoa
        INNER JOIN nhomhanghoa ON hanghoa.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
        INNER JOIN nguoidung ON hanghoa.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON hanghoa.id_nguoisua = nguoidung2.id_nguoidung
        WHERE 1
        ORDER BY hanghoa.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

$sqlnhomhanghoa = "SELECT * FROM nhomhanghoa";
$stmt1 = $conn->prepare($sqlnhomhanghoa);
$query = $stmt1->execute();
$resultnhomhanghoa = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNHH[] = $row;
}


if(isset($_GET['filter']))
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    // echo $from_date;
    $to_date = $_GET['to_date'];
    // echo $to_date;

    $sql = "SELECT hanghoa.id_hanghoa, hanghoa.ten, nhomhanghoa.ten AS tennhomhanghoa, hanghoa.kichthuoc, hanghoa.donvitinh, hanghoa.ghichu, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(hanghoa.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(hanghoa.ngaysua) as ngaysua
            FROM hanghoa
            INNER JOIN nhomhanghoa ON hanghoa.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
            INNER JOIN nguoidung ON hanghoa.id_nguoitao = nguoidung.id_nguoidung
            LEFT JOIN nguoidung AS nguoidung2 ON hanghoa.id_nguoisua = nguoidung2.id_nguoidung
            WHERE hanghoa.ngaytao BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'
            ORDER BY hanghoa.ngaytao DESC
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách hàng hoá</h1>
            <!-- Topbar Search -->
            <div class="d-flex"> 
                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm hàng hoá</button>
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



               

                <form class="form-inline ml-auto mr-4 border p-3 rounded filterhanghoa" method="GET">
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
                        <a href="list_hanghoa.php" class="btn btn-danger">Làm mới</a>
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
                                hàng hoá</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_hanghoa.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã hàng hoá</label>
                                        <input type="text" class="form-control" name="id_hanghoa"
                                            id="validationCustom01" placeholder="Mã hàng hoá" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã hàng hoá.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên hàng hoá</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên hàng hoá" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên hàng hoá.
                                        </div>
                                    </div>

                                    <div class="col-md-4  mb-3">
                                        <label for="validationCustom01">Nhóm hàng hoá</label>
                                        <select name="id_nhomhanghoa" class="" id="id_nhomhanghoa" required>
                                            <option value="">--Chọn nhóm hàng hoá--</option>
                                            <?php foreach ($resultNHH as $itemsNHH): ?>
                                                <option value="<?php echo $itemsNHH['id_nhomhanghoa']; ?>">
                                                    <?php echo $itemsNHH['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhóm hàng hoá.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#id_nhomhanghoa", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>


                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Kích thước</label>
                                        <input type="text" class="form-control" name="kichthuoc"
                                            id="validationCustom01" placeholder="Kích thước" value="" >
                                        <div class="invalid-feedback">
                                            Nhập kích thước.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Đơn vị tính</label>
                                        <input type="text" class="form-control" name="donvitinh"
                                            id="validationCustom01" placeholder="Đơn vị tính" value="" >
                                        <div class="invalid-feedback">
                                            Nhập đơn vị tính.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">Ghi chú</label>
                                        <input type="text" class="form-control" name="ghichu"
                                            id="validationCustom01" placeholder="Ghi chú" value="" >
                                        <div class="invalid-feedback">
                                            Ghi chú.
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

                    <table class=" table table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;">
                            <tr>
                                <th>STT</th>
                                <th>Mã hàng </th>
                                <th>Tên hàng</th>
                                <th>Nhóm hàng hoá</th>
                                <th>Kích thước</th>
                                <th>Đơn vị tính</th>
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
                                ?>

                                <tr data-id="<?php echo $items['id_hanghoa']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_hanghoa']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ten']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tennhomhanghoa']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['kichthuoc']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['donvitinh']; ?>
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

                                    <td>
                                        <form action="sua_hanghoa.php" method="POST">
                                        <input type="hidden" name="edit_id"value="<?php echo $items['id_hanghoa']; ?>">
                                            <button name="suabtn" class="btn   btn-edit  btn-block"><i
                                                    class="fas fa-edit"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal-<?php echo $items['id_hanghoa']; ?>" tabindex="-1" role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa hàng hoá
                                                            <strong>
                                                                <?php echo $items['ten']; ?></strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_hanghoa.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_hanghoa']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn  btn-delete  btn-block" data-toggle="modal"
                                            data-target="#deleteModal-<?php echo $items['id_hanghoa']; ?>">
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
        // Bắt sự kiện nhấp đúp vào hàng để sửa
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_hanghoa.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>