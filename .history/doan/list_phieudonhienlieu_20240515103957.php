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


$sql = "SELECT phieudonhienlieu.id_pdnl,donhang.trangthai,phieudonhienlieu.id_donhang, DATE(phieudonhienlieu.ngaydonhienlieu) as ngaydonhienlieu,donvicungcapdau.ten as tendonvicungcapdau ,phieudonhienlieu.soluongnhienlieu,phieudonhienlieu.id_nhienlieu,nhienlieu.ten as tennhienlieu,phieudonhienlieu.thanhtien,phieudonhienlieu.anh1,phieudonhienlieu.ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(phieudonhienlieu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(phieudonhienlieu.ngaysua) as ngaysua
FROM phieudonhienlieu 
INNER JOIN nguoidung ON phieudonhienlieu.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON phieudonhienlieu.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN donhang ON phieudonhienlieu.id_donhang = donhang.id_donhang
INNER JOIN donvicungcapdau ON phieudonhienlieu.id_dvccdau = donvicungcapdau.id_donviccdau
INNER JOIN nhienlieu ON phieudonhienlieu.id_nhienlieu = nhienlieu.id_nhienlieu
WHERE 1
        ORDER BY phieudonhienlieu.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

// mặc định chỉ cho thêm phiếu dầu cho đơn hàng tháng hiện tại 
$sqlDonhang = "SELECT * FROM donhang WHERE ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01') AND 
ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01') ORDER BY id_donhang DESC"; // 2024-04-01 -> 2024-05-01
$stmt1 = $conn->prepare($sqlDonhang);
$query = $stmt1->execute();
$resultDonhang = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultDonhang[] = $row;
}

$sqlDVCCD = "SELECT * FROM `donvicungcapdau`";
$stmt2 = $conn->prepare($sqlDVCCD);
$query = $stmt2->execute();
$resultDVCCD = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultDVCCD[] = $row;
}

$sqlNL = "SELECT * FROM `nhienlieu`";
$stmt3 = $conn->prepare($sqlNL);
$query = $stmt3->execute();
$resultNL = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultNL[] = $row;
}


if (isset($_GET['filter'])) {


    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

    // Tạo câu truy vấn SQL với các điều kiện tìm kiếm tùy chọn
    $sql = "SELECT phieudonhienlieu.id_pdnl,donhang.trangthai,phieudonhienlieu.id_donhang, DATE(phieudonhienlieu.ngaydonhienlieu) as ngaydonhienlieu,donvicungcapdau.ten as tendonvicungcapdau ,phieudonhienlieu.soluongnhienlieu,phieudonhienlieu.id_nhienlieu,nhienlieu.ten as tennhienlieu,phieudonhienlieu.thanhtien,phieudonhienlieu.anh1,phieudonhienlieu.ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(phieudonhienlieu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(phieudonhienlieu.ngaysua) as ngaysua
    FROM phieudonhienlieu 
    INNER JOIN nguoidung ON phieudonhienlieu.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON phieudonhienlieu.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN donhang ON phieudonhienlieu.id_donhang = donhang.id_donhang
    INNER JOIN donvicungcapdau ON phieudonhienlieu.id_dvccdau = donvicungcapdau.id_donviccdau
    INNER JOIN nhienlieu ON phieudonhienlieu.id_nhienlieu = nhienlieu.id_nhienlieu
    WHERE 1";


    if (!empty($from_date)) {
        // Thêm điều kiện tìm kiếm theo từ ngày
        $sql .= " AND phieudonhienlieu.ngaytao >= :from_date";
    }

    if (!empty($to_date)) {
        // Thêm điều kiện tìm kiếm theo đến ngày
        $sql .= " AND phieudonhienlieu.ngaytao <= :to_date";
    }

    $sql .= " ORDER BY phieudonhienlieu.ngaytao DESC LIMIT $offset, $total_records_per_page";

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách phiếu đổ nhiên liệu</h1>
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

                <button type="button" class="btn btn-primary align-self-center " data-toggle="modal"
                    data-target="#exampleModal" data-whatever="@mdo">Thêm phiếu</button>

                <form class="form-inline ml-auto mr-4 border p-3 rounded filterPDNL " method="GET">
                    <div class="form-group">
                        <input class="form-check-input checkbox-to" type="checkbox" name="filter_date" id="filter_date" value="1"
                            <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>

                        <label class="mr-2" >Từ ngày:</label>
                        <input disabled type="date" class="form-control" name="from_date"
                            value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <label class="mr-2">Đến ngày:</label>
                        <input disabled type="date" class="form-control" name="to_date"
                            value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary mr-2">Filter</button>
                        <a href="list_phieudonhienlieu.php" class="btn btn-danger">Reset</a>

                    </div>
                </form>
            </div>
            <script>
                const form = document.getElementById('filterForm');
                const filterDate = document.getElementById('filter_date');
                const fromDateInput = document.getElementsByName('from_date')[0];
                const toDateInput = document.getElementsByName('to_date')[0];

                // Function to enable/disable inputs based on checkbox state
                function toggleInputDisabledState() {
                    fromDateInput.disabled = !filterDate.checked;
                    toDateInput.disabled = !filterDate.checked;
                }

                // Initial state on page load
                toggleInputDisabledState();

                filterDate.addEventListener('change', toggleInputDisabledState);

                form.addEventListener('submit', function (e) {
                   
                    if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                        e.preventDefault();
                    }
                });
            </script>




            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                phiếu đổ nhiên liệu</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_phieudonhienlieu.php" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-3  mb-3">
                                        <label for="validationCustom01">Mã đơn hàng</label>
                                        <select name="select_donhang" class="" id="select_donhang" required>
                                            <option value="">--Chọn mã đơn--</option>
                                            <?php foreach ($resultDonhang as $items): ?>
                                                <option value="<?php echo $items['id_donhang']; ?>">
                                                    <?php echo $items['id_donhang']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn mã đơn hàng.
                                        </div>
                                    </div>

                                    <script>
                                        new TomSelect("#select_donhang", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-3">
                                        <label for="validationSLNL">Số lượng nhiên liệu</label>

                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control " id="validationSLNL"
                                                placeholder="Số lượng dầu" required value="" name="soluongnhienlieu">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    lít</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập số lượng nhiên liệu
                                            </div>
                                        </div>
                                    </div>
                                    <!-- load slnl qua mã đơn hàng -->
                                    <script>
                                        $(document).ready(function () {
                                            $('#select_donhang').change(function () {
                                                var id_donhang = $(this).val(); 

                                                $.ajax({
                                                    url: 'ajax/get_soluongnhienlieu.php', // Đường dẫn tới file xử lý yêu cầu Ajax
                                                    type: 'POST',
                                                    data: {
                                                        id_donhang: id_donhang
                                                    },
                                                    dataType: 'json',
                                                    success: function (data) {
                                                        $('#validationSLNL').val(data.dautieuthu);
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <div class="col-md-3  mb-3">
                                        <label for="validationCustom01">Tên nhiên liệu</label>
                                        <select name="select_NL" class="" id="select_NL" required>
                                            <option value="">--Chọn nhiên liệu--</option>
                                            <?php foreach ($resultNL as $items): ?>
                                                <option value="<?php echo $items['id_nhienlieu']; ?>">
                                                    <?php echo $items['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhiên liệu.
                                        </div>
                                    </div>
                                    <!-- select search -->
                                    <script>
                                        new TomSelect("#select_NL", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationTT">Thành tiền</label>
                                        <div class="input-group mb-2">
                                            <input type="number" class="form-control" name="thanhtien" id="validationTT"
                                                placeholder="Thành tiền" value="" required readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập thành tiền.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ajax  thành tiền -->
                                    <script>
                                        $(document).ready(function () {
                                            // Lắng nghe sự kiện khi số lượng nhiên liệu hoặc id_nhienlieu thay đổi
                                            $('#validationSLNL, #select_NL').change(function () {
                                                // Lấy giá trị số lượng nhiên liệu và id_nhienlieu
                                                var soluongnhienlieu = $('#validationSLNL').val();
                                                var id_nhienlieu = $('#select_NL').val();

                                                // Kiểm tra xem cả hai giá trị có được chọn hay không
                                                if (soluongnhienlieu !== "" && id_nhienlieu !== "") {
                                                    // Gửi yêu cầu Ajax để lấy đơn giá sau thuế
                                                    $.ajax({
                                                        url: 'ajax/get_thanhtienPDNL.php', // Đường dẫn đến tệp xử lý yêu cầu Ajax
                                                        method: 'POST', // Phương thức yêu cầu
                                                        data: {
                                                            id_nhienlieu: id_nhienlieu // Dữ liệu gửi đi (id_nhienlieu)
                                                        },
                                                        dataType: 'json',
                                                        success: function (response) {
                                                            // Xử lý kết quả trả về từ máy chủ
                                                            var dongiasauthue = parseInt(response.dongiasauthue, 10); // Chuyển đổi chuỗi số thành số thực

                                                            var thanhtien = soluongnhienlieu * dongiasauthue; // Tính thành tiền                                                                              
                                                            // console.log(thanhtien);                     

                                                            var thanhtien = Math.round(thanhtien);  //  60937.5 ->  60938
                                                            // console.log(thanhtien);                     
                                                            $('#validationTT').val(thanhtien);
                                                        },
                                                        error: function (xhr, status, error) {
                                                            // Xử lý lỗi nếu có
                                                            console.log(error); // In thông báo lỗi vào console
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                    </script>

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Ngày đổ nhiên liệu</label>
                                        <input type="date" class="form-control" name="ngaydonhienlieu"
                                            id="validationCustom02" placeholder="Ngày đổ nhiên liệu" value="" required>
                                        <div class="invalid-feedback">
                                            Chọn ngày đổ nhiên liệu
                                        </div>
                                    </div>

                                    <div class="col-md-8  mb-3">
                                        <label for="validationCustom01">Đơn vị cung cấp dầu</label>
                                        <select name="select_DVCCD" class="" id="select_DVCCD" required>
                                            <option value="">--Chọn đơn vị--</option>
                                            <?php foreach ($resultDVCCD as $items): ?>
                                                <option value="<?php echo $items['id_donviccdau']; ?>">
                                                    <?php echo $items['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn đơn vị.
                                        </div>
                                    </div>
                                    <!-- select search -->
                                    <script>
                                        new TomSelect("#select_DVCCD", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom02">Ghi chú</label>
                                        <input type="text" class="form-control" name="ghichu" id="validationCustom02"
                                            placeholder="Ghi chú" value="">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="customFile">Phiếu cấp dầu</label>
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
                        <thead style=" white-space: nowrap;">
                            <tr>
                                <th>STT</th>
                                <!-- <th>Mã PĐNL</th> -->
                                <th>Mã đơn hàng </th>
                                <th>Trạng thái</th>
                                <th>Ngày đổ nhiên liệu</th>
                                <th>Đơn vị cung cấp</th>
                                <th>Số lượng nhiên liệu (lít)</th>
                                <th>Tên nhiên liệu</th>
                                <th>Thành tiền (VNĐ)</th>
                                <th>Phiếu cấp dầu</th>
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

                                <tr data-id="<?php echo $items['id_pdnl']; ?>"
                                    data-ngaytao="<?php echo $items['ngaytao']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $trangthai = $items['trangthai'];
                                        if ($trangthai == 'Hủy') {
                                            echo '<i class="fas fa-times text-danger"></i>';
                                        } else if ($trangthai == 'Hoàn thành') {
                                            echo '<i class="fas fa-check text-success"></i>';
                                        } else {
                                            echo $trangthai;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['ngaydonhienlieu'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tendonvicungcapdau']; ?>
                                    </td>
                                    <td>
                                        <?php $soluongnhienlieu = $items['soluongnhienlieu'];
                                        $formatted_soluongnhienlieu = number_format($soluongnhienlieu, 0, ',', '.');
                                        echo $formatted_soluongnhienlieu; ?>

                                    </td>
                                    <td>
                                        <?php echo $items['tennhienlieu']; ?>
                                    </td>
                                    <td>

                                        <?php
                                        $thanhtien = $items['thanhtien'];
                                        $formatted_thanhtien = number_format($thanhtien, 0, ',', '.');
                                        echo $formatted_thanhtien;
                                        ?>
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
                                    <?php if($items['ngaysua'] != null) echo date('d-m-Y', strtotime($items['ngaysua'])); ?>
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
                                        <form action="sua_phieudonhienlieu.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_pdnl']; ?>">
                                            <button name="suabtn" class="btn btn-success" <?php echo $disableSua; ?>>Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_pdnl']; ?>" tabindex="-1"
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
                                                        <p>Bạn có chắc chắn muốn xóa phiếu đổ nhiên liệu có mã
                                                            <strong>
                                                                <?php echo $items['id_pdnl']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_phieudonhienlieu.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_pdnl']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_pdnl']; ?>" <?php echo $disableXoa; ?>>Xoá</button>
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
                window.location.href = 'sua_phieudonhienlieu.php?edit_id=' + id;
            }
        });
    </script>


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>