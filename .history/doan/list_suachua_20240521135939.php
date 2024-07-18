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
$sqlCount = "SELECT COUNT(*) as total_rows FROM phieudonhienlieu";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT id_suachua,suachua.id_xe,xe.bienso,ngaysuachua,sokmdongho,noidungsuachua,dongiavattu,tiennhancong,soluong,nguoisuachua,thoigianbaohanh,tongtien,anh1,ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(suachua.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(suachua.ngaysua) as ngaysua
FROM suachua 

INNER JOIN nguoidung ON suachua.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON suachua.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN xe on suachua.id_xe = xe.id_xe

WHERE 1 AND suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
        ORDER BY suachua.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

// lấy các xe thuộc thầu phụ PACIFIC
$sqlXe = "SELECT xe.id_xe, xe.bienso
FROM xe
INNER JOIN thauphu ON thauphu.id_thauphu = xe.id_thauphu
WHERE xe.id_thauphu IN ('PLJ-L', 'PLJ-F')";
$stmt1 = $conn->prepare($sqlXe);
$query = $stmt1->execute();
$resultXe = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultXe[] = $row;
}



if (isset($_GET['filter'])) {

    $id_xe = '';

    if (isset($_GET['filter_bienso']) && $_GET['filter_bienso'] == '1') {
        if (isset($_GET['bienso'])) {
            $id_xe = $_GET['bienso'];
        }
    }


    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    // $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] . ' 23:59:59' : '';


    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT id_suachua,suachua.id_xe,xe.bienso,ngaysuachua,sokmdongho,noidungsuachua,dongiavattu,tiennhancong,soluong,nguoisuachua,thoigianbaohanh,tongtien,anh1,ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(suachua.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(suachua.ngaysua) as ngaysua
    FROM suachua 
    
    INNER JOIN nguoidung ON suachua.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON suachua.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN xe on suachua.id_xe = xe.id_xe
    
    WHERE 1";

    if (!empty($id_xe)) {

        $sql .= " AND suachua.id_xe = :id_xe";
    }


    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND suachua.ngaysuachua >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND suachua.ngaysuachua <= :to_date";
    }

    $sql .= " ORDER BY suachua.ngaysuachua DESC LIMIT $offset, $total_records_per_page";

    $stmt = $conn->prepare($sql);

    if (!empty($id_xe)) {
        $stmt->bindParam(':id_xe', $id_xe);
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách sửa chữa</h1>
            <!-- Topbar Search -->
            <div class="d-flex">


                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterBCSC " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_bienso"
                            id="filter_bienso" value="1" <?php echo isset($_GET['filter_bienso']) && $_GET['filter_bienso'] == '1' ? 'checked' : ''; ?>>
                        <div class="input-group ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Biển số</span>
                            </div>
                            <select disabled class=" form-control mr-5" name="bienso" id="exampleFormControlSelect1"
                                aria-describedby="basic-addon3">
                                <option value="">--Chọn xe--</option>
                                <?php foreach ($resultXe as $items99): ?>
                                    <option value="<?php echo $items99['id_xe']; ?>" <?php echo isset($_GET['bienso']) && $_GET['bienso'] == $items99['id_xe'] ? 'selected' : ''; ?>>
                                        <?php echo $items99['bienso']; ?>
                                    </option>
                                <?php endforeach ?>
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
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="list_suachua.php" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
            <script>
                const form = document.getElementById('filterForm');
                const filterbienso = document.getElementById('filter_bienso');
                const biensoSelect = document.getElementById('exampleFormControlSelect1');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    biensoSelect.disabled = !filterbienso.checked;
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filterbienso.addEventListener('change', toggleInputDisabledState);
                filterDate.addEventListener('change', toggleInputDisabledState);
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (filterbienso.checked && biensoSelect.disabled) {
                            e.preventDefault();
                        }

                        if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                            e.preventDefault();
                        }
                    });
                }
            </script>

            <div class="d-flex mt-3 mb-3 float-right">
                <button type="button" class="btn btn-primary align-self-center " data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm sửa chữa</button>
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
                                sửa chữa</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_suachua.php" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-4  mb-3">
                                        <label for="validationCustom01">Chọn xe :</label>
                                        <select name="select_xe" class="" id="select_xe" required>
                                            <option value="">--Chọn xe--</option>
                                            <?php foreach ($resultXe as $items): ?>
                                                <option value="<?php echo $items['id_xe']; ?>">
                                                    <?php echo $items['bienso']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn xe.
                                        </div>
                                    </div>

                                    <script>
                                        new TomSelect("#select_xe", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Ngày sửa chữa :</label>
                                        <input type="date" class="form-control" name="ngaysuachua"
                                            id="validationCustom02" placeholder="Ngày sửa chữa" value="" required>
                                        <div class="invalid-feedback">
                                            Chọn ngày sửa chữa
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="validationSLNL">Số km đồng hồ :</label>

                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control " id="validationSLNL"
                                                placeholder="Nhập số km đồng hồ..." required value="" name="sokmdongho">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    Km</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập số km đồng hồ
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="noidungsuachua">Nội dung sửa chữa :</label>
                                        <textarea class="form-control" name="noidungsuachua" id="noidungsuachua"
                                            placeholder="Nhập nội dung..." rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Nhập nội dung.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="dongiavattu">Đơn giá vật tư :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="dongiavattu" id="dongiavattu"
                                                placeholder="Nhập đơn giá vật tư..." value="" required>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập đơn giá vật tư.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="soluong">Số lượng :</label>
                                        <input type="number" class="form-control" name="soluong" id="soluong"
                                            placeholder="Nhập số lượng..." value="1">

                                        <div class="invalid-feedback">
                                            Nhập số lượng.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="tiennhancong">Tiền nhân công :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="tiennhancong"
                                                id="tiennhancong" placeholder="Nhập tiền nhân công..." value="0">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ</div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="tongtien">Tổng tiền :</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="tongtien" id="tongtien"
                                                placeholder="Nhập tổng tiền..." value="" required readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ</div>
                                            </div>

                                        </div>
                                    </div>

                                    <script>
                                        $(document).ready(function () {
                                            $('#dongiavattu, #soluong,#tiennhancong').on('input', function () {
                                                var dongia = parseFloat($('#dongiavattu').val());
                                                var soluong = parseInt($('#soluong').val());
                                                var tiennhancong = parseInt($('#tiennhancong').val());
                                                var tongtien = dongia * soluong + tiennhancong;

                                                if (!isNaN(tongtien)) {
                                                    $('#tongtien').val(tongtien);
                                                }
                                            });
                                        });
                                    </script>



                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Người sửa chữa :</label>
                                        <input type="text" class="form-control" name="nguoisuachua"
                                            id="validationCustom02" placeholder="Nhập người sửa chữa..." value="">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Thời gian bảo hành :</label>
                                        <input type="date" class="form-control" name="thoigianbaohanh"
                                            id="validationCustom02" placeholder="Thời gian bảo hành..." value="">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="ghichu">Ghi chú :</label>
                                        <textarea class="form-control" name="ghichu" id="ghichu"
                                            placeholder="Nhập ghi chú..." rows="3"></textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="customFile">Ảnh hóa đơn : </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="anh1" id="customFile"
                                                onchange="hienThiTenFile()">
                                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            Chọn file ảnh
                                        </div>
                                    </div>

                                </div>
                                <!-- hiện tên ảnh -->
                                <script>
                                    function hienThiTenFile() {
                                        var input = document.getElementById('customFile');
                                        var label = document.querySelector('.custom-file-label');
                                        label.textContent = input.files[0].name;
                                    }
                                </script>

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
                                <th>STT</th>
                                <th>Mã sửa chữa </th>
                                <th>Biển số </th>
                                <th>Ngày sửa chữa</th>
                                <th>Số km đồng hồ (Km)</th>
                                <th>Nội dung sửa chữa</th>
                                <th>Đơn giá vật tư (VNĐ)</th>
                                <th>Số lượng</th>
                                <th>Tiền nhân công (VNĐ)</th>
                                <th>Tổng tiền (VNĐ)</th>
                                <th>Người sửa chữa</th>
                                <th>Thời gian bảo hành</th>

                                <th>Ảnh hóa đơn</th>
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
                                $hasData = true; // Đánh dấu có dữ liệu                                                                       ?>

                                <tr data-id="<?php echo $items['id_suachua']; ?>"
                                    data-ngaytao="<?php echo $items['ngaytao']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_suachua']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['bienso']; ?>
                                    </td>

                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaysuachua'])); ?>
                                    </td>

                                    <td>
                                        <?php echo $items['sokmdongho']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['noidungsuachua']; ?>
                                    </td>

                                    <td>

                                        <?php
                                        $dongiavattu = $items['dongiavattu'];
                                        $formatted_dongiavattu = number_format($dongiavattu, 0, ',', '.');
                                        echo $formatted_dongiavattu;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['soluong']; ?>
                                    </td>


                                    <td>

                                        <?php
                                        $tiennhancong = $items['tiennhancong'];
                                        $formatted_tiennhancong = number_format($tiennhancong, 0, ',', '.');
                                        echo $formatted_tiennhancong;
                                        ?>
                                    </td>

                                    <td>

                                        <?php
                                        $tongtien = $items['tongtien'];
                                        $formatted_tongtien = number_format($tongtien, 0, ',', '.');
                                        echo $formatted_tongtien;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['nguoisuachua']; ?>
                                    </td>

                                    <td>
                                        <?php echo ($items['thoigianbaohanh'] == '0000-00-00' || $items['thoigianbaohanh'] == null) ? '' : date('d-m-Y', strtotime($items['thoigianbaohanh'])); ?>
                                    </td>



                                    <td>
                                        <a href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                            <img style="width: 100px;" src="img/<?php echo $items['anh1']; ?>">
                                        </a>
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
                                        <?php if ($items['ngaysua'] != null)
                                            echo date('d-m-Y', strtotime($items['ngaysua'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoisua']; ?>
                                    </td>

                                    <?php
                                    $ngaytao = $items['ngaytao']; // 'Y-m-d'
                                    $ngayhientai = date('Y-m-d'); // Lấy ngày hiện tại dưới định dạng 'Y-m-d'
                                

                                    // Chuyển đổi ngày thành timestamp
                                    $ngaytao_timestamp = strtotime($ngaytao);
                                    $ngayhientai_timestamp = strtotime($ngayhientai);

                                    $ngaytao_day = date('d', $ngaytao_timestamp);
                                    $ngaytao_month = date('m', $ngaytao_timestamp);
                                    $ngaytao_year = date('Y', $ngaytao_timestamp);

                                    // echo $ngaytao_day ;
                                    // echo '<br>';
                                    // echo $ngaytao_month ;
                                    // echo '<br>';
                                    // echo $ngaytao_year ;
                                    // echo '<br>';
                                
                                    $ngayhientai_day = date('d', $ngayhientai_timestamp);
                                    $ngayhientai_month = date('m', $ngayhientai_timestamp);
                                    $ngayhientai_year = date('Y', $ngayhientai_timestamp);

                                    // echo  $ngayhientai_day;
                                    // echo '<br>';
                                    // echo $ngayhientai_month  ;
                                    // echo '<br>';
                                    // echo   $ngayhientai_year ;
                                    // echo '<br>';
                                
                                    // Nếu năm của ngày tạo nhỏ hơn năm hiện tại hoặc (năm của ngày tạo bằng năm hiện tại và tháng của ngày tạo nhỏ hơn tháng hiện tại)
                                    if ($ngaytao_year < $ngayhientai_year || ($ngaytao_year == $ngayhientai_year && $ngaytao_month < $ngayhientai_month)) {

                                        $disableSua = 'disabled';
                                        $disableXoa = 'disabled';
                                    } else {

                                        $disableSua = '';
                                        $disableXoa = '';
                                    }
                                    ?>

                                    <td>
                                        <form action="sua_suachua.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_suachua']; ?>">
                                            <button name="suabtn" class="btn   btn-edit  btn-block" <?php echo $disableSua; ?>><i class="fas fa-edit"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_suachua']; ?>" tabindex="-1"
                                            role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa sửa chữa có mã
                                                            <strong>
                                                                <?php echo $items['id_suachua']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_suachua.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_suachua']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn  btn-delete  btn-block" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_suachua']; ?>" <?php echo $disableXoa; ?>><i class="fas fa-trash"></i></button>
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
                <div class="mt-4 d-flex justify-content-between">

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

    </div>
    <!-- End of Main Content -->
    <script>
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được dbclick
            var id = $(this).data('id');
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
                window.location.href = 'sua_suachua.php?edit_id=' + id;
            }
        });



    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>