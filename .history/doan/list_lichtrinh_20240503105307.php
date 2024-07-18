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
$sqlCount = "SELECT COUNT(*) as total_rows FROM lichtrinh";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT lichtrinh.id_lichtrinh, lichtrinh.ten, lichtrinh.loaihang, nhomhanghoa.ten as tennhomhanghoa, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(lichtrinh.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(lichtrinh.ngaysua) as ngaysua
        FROM lichtrinh
        INNER JOIN nhomhanghoa ON lichtrinh.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
        INNER JOIN nguoidung ON lichtrinh.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON lichtrinh.id_nguoisua = nguoidung2.id_nguoidung
        WHERE 1
        ORDER BY lichtrinh.ngaytao DESC
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


// if(isset($_POST['thembtn']))
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    // echo $from_date;
    $to_date = $_GET['to_date'];
    // echo $to_date;

    $sql = "SELECT lichtrinh.id_lichtrinh, lichtrinh.ten, lichtrinh.loaihang, nhomhanghoa.ten as tennhomhanghoa, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(lichtrinh.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(lichtrinh.ngaysua) as ngaysua
            FROM lichtrinh
            INNER JOIN nhomhanghoa ON lichtrinh.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
            INNER JOIN nguoidung ON lichtrinh.id_nguoitao = nguoidung.id_nguoidung
            LEFT JOIN nguoidung AS nguoidung2 ON lichtrinh.id_nguoisua = nguoidung2.id_nguoidun
            WHERE lichtrinh.ngaysua BETWEEN '$from_date' AND '$to_date'
            ORDER BY lichtrinh.ngaytao DESC
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
    //         echo "ID: " . $row['id_lichtrinh'] . "<br>";
    //         echo "Tên lịch trình: " . $row['ten'] . "<br>";
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách lịch trình</h1>
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



                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm lịch trình</button>

                <form class="form-inline ml-auto mr-4 border p-3 rounded filterlichtrinh" method="GET">
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
                <div class="modal-dialog modal-sm modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                lịch trình</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_lichtrinh.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã lịch trình</label>
                                        <input type="text" class="form-control" name="id_lichtrinh"
                                            id="validationCustom01" placeholder="Mã lịch trình" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã lịch trình.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên lịch trình</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên lịch trình" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên lịch trình.
                                        </div>
                                    </div>

                                    <div class="col-md-4  mb-3">
                                        <label for="validationCustom01">Loại hàng</label>
                                        <select name="select_loaihang" class="" id="select_loaihang" required>
                                            <option value="">--Chọn loại hàng--</option>
                                            <?php
                                            $options = array("1", "2", "3");
                                            foreach ($options as $selectloaihang): ?>
                                                <option value="<?php echo $selectloaihang; ?>" >
                                                    <?php echo $selectloaihang; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Loại hàng.
                                        </div>
                                    </div>
                                    <script>
                                        new TomSelect("#select_loaihang", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "incr"
                                            }
                                        });

                                    </script>


                                    <div class="col-md-4  mb-3">
                                        <label for="validationCustom01">Nhóm hàng hoá</label>
                                        <select name="id_nhomhanghoa" class="" id="id_nhomhanghoa">
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
                                <th>Mã lịch trình </th>
                                <th>Tên lịch trình</th>
                                <th>Loại hàng</th>
                                <th>Nhóm hàng hoá</th>
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

                                <tr data-id="<?php echo $items['id_lichtrinh']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_lichtrinh']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ten']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['loaihang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tennhomhanghoa']; ?>
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
                                        <form action="sua_lichtrinh.php" method="POST">
                                            <input type="hidden" name="edit_id"
                                                value="<?php echo $items['id_lichtrinh']; ?>">
                                            <button name="suabtn" class="btn btn-success">Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal-<?php echo $items['id_lichtrinh']; ?>"
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
                                                        <p>Bạn có chắc chắn muốn xóa lịch trình
                                                            <strong>
                                                                <?php echo $items['ten']; ?></strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_lichtrinh.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_lichtrinh']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal-<?php echo $items['id_lichtrinh']; ?>">Xoá</button>
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
            window.location.href = 'sua_lichtrinh.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>