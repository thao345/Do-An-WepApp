<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');
include ('filter_by_create_at.php');

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
$sqlCount = "SELECT COUNT(*) as total_rows FROM tuyenvantai";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT tuyenvantai.id_tuyenvantai,tuyenvantai.ten,tuyenvantai.diemdau,tuyenvantai.id_tinhthanhdau,tuyenvantai.diemcuoi, tuyenvantai.id_tinhthanhcuoi,tuyenvantai.culy, tuyenvantai.dautieuthu,tuyenvantai.ghichu,tuyenvantai.ngaytao, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(tuyenvantai.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(tuyenvantai.ngaysua) as ngaysua
        FROM tuyenvantai INNER JOIN nguoidung ON tuyenvantai.id_nguoitao = nguoidung.id_nguoidung
        LEFT JOIN nguoidung AS nguoidung2 ON tuyenvantai.id_nguoisua = nguoidung2.id_nguoidung
        WHERE 1
        ORDER BY tuyenvantai.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
$sqlTinhThanh = "SELECT id_tinhthanh, ten FROM `tinhthanh` ";
$stmt1 = $conn->prepare($sqlTinhThanh);
$query = $stmt1->execute();
$resultTinhThanh = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultTinhThanh[] = $row;
}
if (isset($_GET['filter']))
    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        $sql = "SELECT ";
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách tuyến vận tải</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
            <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm tuyến vận tải</button>
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

                <form class="form-inline ml-auto mr-4 border p-3 rounded filterTuyenVanTai" method="GET">
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
                        <a href="list_hang_tau.php" class="btn btn-danger">Làm mới</a>

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
                                tuyến vận tải</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_tuyenvantai.php" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom01">Mã tuyến vận tải</label>
                                        <input type="text" class="form-control" name="id_tuyenvantai"
                                            id="validationCustom01" placeholder="Mã tuyến vận tải" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập mã tuyến vận tải.
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="validationCustom02">Tên tuyến vận tải</label>
                                        <input type="text" class="form-control" name="ten" id="validationCustom02"
                                            placeholder="Tên tuyến vận tải" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tên tuyến vận tải.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tỉnh thành đầu</label>
                                        <select class="form-control" name="id_tinhthanhdau" id="validationCustom02"
                                            required>
                                            <option value="">--Chọn tỉnh thành đầu--</option>
                                            <?php foreach ($resultTinhThanh as $items): ?>
                                                <option value="<?php echo $items['id_tinhthanh']; ?>">
                                                    <?php echo $items['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                            <!-- Phần tử option sẽ được thêm bằng JavaScript từ dữ liệu JSON -->
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn tỉnh thành đầu.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Tỉnh thành cuối</label>
                                        <select class="form-control" name="id_tinhthanhcuoi" id="validationCustom02"
                                            required>
                                            <option value="">--Chọn tỉnh thành cuối--</option>
                                            <?php foreach ($resultTinhThanh as $items): ?>
                                                <option value="<?php echo $items['id_tinhthanh']; ?>">
                                                    <?php echo $items['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                            <!-- Phần tử option sẽ được thêm bằng JavaScript từ dữ liệu JSON -->
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn tỉnh thành cuối.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationSLNL">Cự ly</label>

                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="validationSLNL"
                                                placeholder="Cự ly" required name="culy">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    km</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập cự ly
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationSLNL">Dầu ước tính</label>

                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="dau_tieuthu"
                                                placeholder="Lượng dầu tiêu thụ" required name="dau_tieuthu" readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    lít</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Lượng dầu tiêu thụ
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        var inputCuly = document.getElementById('validationSLNL');
                                        var inputDauTieuThu = document.getElementById('dau_tieuthu');
                                        inputCuly.addEventListener('input', function () {
                                            var culy = parseFloat(inputCuly.value);
                                            var dauTieuThu = culy / 8;
                                            inputDauTieuThu.value = dauTieuThu.toFixed(2);
                                        });

                                    </script>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom02">Ghi chú</label>
                                        <input type="text" class="form-control" name="ghichu" id="validationCustom02"
                                            placeholder="Ghi chú" value="">
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
                                <th>Mã tuyến</th>
                                <th>Tên tuyến</th>
                                <th>Điểm đầu</th>
                                <th>Điểm cuối</th>
                                <th>Cự ly (km)</th>
                                <th>Dầu tiêu thụ (lít)</th>
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
                                $hasData = true; // Đánh dấu có dữ liệu                           ?>

                                <tr data-id="<?php echo $items['id_tuyenvantai']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_tuyenvantai']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ten']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['diemdau']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['diemcuoi']; ?>
                                    </td>

                                    <td>

                                        <?php
                                        $culy = $items['culy'];
                                        $format_culy = number_format($culy, 0, '.', '.');
                                        echo $format_culy;
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                        $dautieuthu_formatted = number_format($items['dautieuthu'], 0, ',', '.');
                                        echo $dautieuthu_formatted; ?>
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
                                        <form action="sua_tuyenvantai.php" method="POST">
                                            <input type="hidden" name="edit_id"
                                                value="<?php echo $items['id_tuyenvantai']; ?>">
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
                                                        <p>Bạn có chắc chắn muốn xóa tuyến vận tải
                                                            "<?php echo $items['ten']; ?>"?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_tuyenvantai.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_tuyenvantai']; ?>">
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
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_tuyenvantai.php?edit_id=' + id;
        });
    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>