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
$sqlCount = "SELECT COUNT(*) as total_rows FROM nhatky";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$sqlBase = "SELECT nhatky.id_nhatky, nguoidung.tendangnhap as nguoithuchien, DATE(nhatky.thoigian) as thoigian, nhatky.noidung 
            FROM nhatky 
            INNER JOIN nguoidung ON nhatky.id_nguoidung = nguoidung.id_nguoidung";

$sql = "$sqlBase 
        WHERE 1
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}


if (isset($_GET['filter'])) {
    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];

        $sql = "$sqlBase 
                WHERE nhatky.thoigian BETWEEN '$from_date  00:00:00' AND '$to_date 23:59:59'
                ORDER BY nhatky.thoigian DESC
                LIMIT $offset,$total_records_per_page";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        $result = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;

        }


    } else {

    }
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Nhật ký</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
                <div class="d-flex mt-3 mb-3 float-right">

                    <form class="form-inline mr-3 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control border-1 small search-input"
                                placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <form class="form-inline ml-auto mr-4 border p-3 rounded filternhatky" method="GET">
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
                        <a href="nhatky.php" class="btn btn-danger">Làm mới</a>

                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class=" table table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;">
                            <tr>
                                <th>STT</th>
                                <th>Số nhật ký</th>
                                <th>Người thực hiện</th>
                                <th>Thời gian</th>
                                <th>Nội dung</th>

                                <th colspan="2" class="text-center"></th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                      
                                ?>

                                <tr data-id="<?php echo $items['id_nhatky']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_nhatky']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoithuchien']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['thoigian'])); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $string = $items['noidung'];
                                        $pos = strpos($string, ":");
                                        echo substr($string, 0, $pos); ?>...
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#exampleModal-<?php echo $items['id_nhatky']; ?>"
                                            data-whatever="@mdo">Xem chi tiết</button>

                                        <!-- Thêm modal dialog -->
                                        <style>
                                            .modal-body {
                                                white-space: pre-wrap;
                                            }
                                        </style>

                                        <div class="modal fade" id="exampleModal-<?php echo $items['id_nhatky']; ?>"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <!-- modal-sm  modal-xl  modal-lg  -->
                                            <div
                                                class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header header-crud">
                                                        <h1 class="modal-title flex-grow-1 text-gray-800 header-crud"
                                                            id="exampleModalLabel">Chi tiết nhật ký số <?</h1>
                                                        <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="m-3">
                                                        <div >
                                                            <div> <strong>Thời gian: </strong>
                                                                <?php echo $items['thoigian']; ?>
                                                            </div>
                                                            <div>
                                                                <strong>Người thực hiện: </strong>
                                                                <?php echo $items['nguoithuchien']; ?>
                                                            </div>
                                                            <div>
                                                                <strong>Nội dung: </strong>
                                                                <div class = "modal-body">
                                                                    <?php echo $items['noidung']; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


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
            window.location.href = 'xem_nhatky.php?edit_id=' + id;
        });


    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>