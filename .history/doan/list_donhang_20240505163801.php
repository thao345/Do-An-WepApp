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
$sqlCount = "SELECT COUNT(*) as total_rows FROM donhang";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua
FROM donhang 
INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai

WHERE 1
ORDER BY donhang.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
// $sql ="CALL GetDonHang($offset,$total_records_per_page)";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

$sqlNhanSu = "SELECT * FROM `nhansu` ORDER BY `nhansu`.`id_nhansu` DESC";
$stmt1 = $conn->prepare($sqlNhanSu);
$query = $stmt1->execute();
$resultNhanSu = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNhanSu[] = $row;
}

$sqlKH = "SELECT * FROM `khachhang` ORDER BY `khachhang`.`id_khachhang` DESC";
$stmt2 = $conn->prepare($sqlKH);
$query = $stmt2->execute();
$resultKH = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultKH[] = $row;
}

$sqlHangTau = "SELECT * FROM `hangtau` ORDER BY `hangtau`.`id_hangtau` DESC";
$stmt3 = $conn->prepare($sqlHangTau);
$query = $stmt3->execute();
$resultHangTau = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultHangTau[] = $row;
}


$sqlNHH = "SELECT * FROM `nhomhanghoa` ORDER BY `nhomhanghoa`.`id_nhomhanghoa` DESC";
$stmt4 = $conn->prepare($sqlNHH);
$query = $stmt4->execute();
$resultNHH = array();
while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    $resultNHH[] = $row;
}

$sqlTVT = "SELECT * FROM `tuyenvantai` ORDER BY `tuyenvantai`.`id_tuyenvantai` DESC";
$stmt5 = $conn->prepare($sqlTVT);
$query = $stmt5->execute();
$resultTVT = array();
while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
    $resultTVT[] = $row;
}

//filter theo  trangthai
if(isset($_GET['trangthai']) ) {

    $trangthai= $_GET['trangthai'];

    $sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
    donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
    hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
    donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
    donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
    donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua
    FROM donhang 
    INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
   
    WHERE  donhang.trangthai='$trangthai'
            ORDER BY donhang.ngaytao DESC
            LIMIT $offset,$total_records_per_page";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;

    }
}
//filter theo  from to date
if(isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    

    $sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
    donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
    hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
    donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
    donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
    donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua
    FROM donhang 
    INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
   
    WHERE (donhang.ngaytao BETWEEN '$from_date' AND '$to_date') 
            ORDER BY donhang.ngaytao DESC
            LIMIT $offset,$total_records_per_page";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;

    }
}


//filter theo from to date , trangthai
if (isset($_GET['from_date']) && isset($_GET['to_date']) && isset($_GET['trangthai'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $trangthai= $_GET['trangthai'];
   

    $sql = "SELECT  donhang.id_donhang,donhang.id_sales,nhansu.id_nhansu,nhansu.ten as tensales,donhang.id_khachhang,khachhang.ten as tenKH,khachhang.masothue,
    donhang.booking,donhang.loaihang,donhang.id_hangtau,hangtau.ten as tenHT,donhang.id_nhomhanghoa,donhang.id_hanghoa,
    hanghoa.ten as tenhanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,DATE(donhang.ngaydongcontainer) as ngaydongcontainer,
    donhang.giodongcontainer,tuyenvantai.ten as tentuyenvantai ,tuyenvantai.culy,tuyenvantai.dautieuthu,DATE(donhang.ngaycatmang) as ngaycatmang,donhang.giocatmang,donhang.nguoigiaonhan,
    donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,DATE(donhang.hanthanhtoan) as hanthanhtoan,donhang.ghichu,
    donhang.anh1,donhang.anh2,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(donhang.ngaytao) as ngaytao, 
    nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(donhang.ngaysua) as ngaysua
    FROM donhang 
    INNER JOIN nguoidung ON donhang.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON donhang.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang
    LEFT JOIN hangtau ON donhang.id_hangtau = hangtau.id_hangtau
    INNER JOIN nhomhanghoa ON donhang.id_nhomhanghoa = nhomhanghoa.id_nhomhanghoa
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
   
    WHERE (donhang.ngaytao BETWEEN '$from_date' AND '$to_date') AND donhang.trangthai='$trangthai'
            ORDER BY donhang.ngaytao DESC
            LIMIT $offset,$total_records_per_page";

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;

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
           <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách đơn hàng</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
               
                <!-- filter ngày -->
                <form class="form-inline ml-auto mr-4 border p-3 rounded filterDonHang " method="GET">
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" name="filter_trangthai" id="filter_trangthai" value="1" <?php echo isset($_GET['filter_trangthai']) && $_GET['filter_trangthai'] == '1' ? 'checked' : ''; ?>>
                        <label class="mr-2" for="exampleFormControlSelect1">Trạng thái: </label>
                        <select disabled class="form-control mr-5" name="trangthai" id="exampleFormControlSelect1">
                         <option value="">Chọn trạng thái</option>   
                        <option value="Hủy" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] =='Hủy'?'selected' :'') : ''; ?>>Hủy</option>
                        <option value="Hoàn thành" <?php echo isset($_GET['trangthai']) == true ? ($_GET['trangthai'] =='Hoàn thành' ? 'selected' :'') : ''; ?>>Hoàn thành</option>
                    
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" name="filter_date" id="filter_date" value="1" <?php echo isset($_GET['filter_date']) && $_GET['filter_date'] == '1' ? 'checked' : ''; ?>>

                        <label class="mr-2">Từ ngày:</label>
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
                        <a href="list_donhang.php" class="btn btn-danger">Reset</a>
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

                form.addEventListener('submit', function (e) {
                    if (filterTrangthai.checked && trangthaiSelect.disabled) {
                        e.preventDefault();
                    }

                    if (filterDate.checked && (fromDateInput.disabled || toDateInput.disabled)) {
                        e.preventDefault();
                    }
                });
            </script>

            <div class="d-flex mt-3 mb-3 float-right">
                <button type="button" class="btn btn-primary align-self-center" data-toggle="modal"
                        data-target="#exampleModal" data-whatever="@mdo">Thêm đơn hàng</button>
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
                <div class="modal-dialog modal-xl modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                đơn hàng </h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation"  action="them_donhang.php" method="POST"  enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-3  mb-3">
                                        <label for="select_sales">Sales*</label>
                                        <select name="select_sales" class="" id="select_sales" required>
                                            <option value="">--Chọn sales--</option>
                                            <?php foreach ($resultNhanSu as $items1): ?>
                                                <option value="<?php echo $items1['id_auto_increment']; ?>">
                                                    <?php echo $items1['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn sales.
                                        </div>
                                    </div>

                                    <script>
                                        new TomSelect("#select_sales", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-6  mb-3">
                                        <label for="select_KH">Khách hàng*</label>
                                        <select name="select_KH" class="" id="select_KH" required>
                                            <option value="">--Chọn khách hàng--</option>
                                            <?php foreach ($resultKH as $items2): ?>
                                                <option value="<?php echo $items2['id_khachhang']; ?>">
                                                    <?php echo $items2['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn khách hàng.
                                        </div>
                                    </div>

                                    <script>
                                        new TomSelect("#select_KH", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-3 mb-3">
                                        <label for="masothue">Mã số thuế*</label>
                                        <input type="text" class="form-control" name="masothue"
                                            id="masothue" placeholder="Mã số thuế" value="" required readonly>
                                        <div class="invalid-feedback">
                                            Nhập mã số thuế.
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $("#select_KH").change(function() {
                                            var idKhachHang = $(this).val();
                                            $.ajax({
                                                url: "ajax/get4_khachhangById.php",
                                                method: "POST",
                                                data: {
                                                idKhachHang: idKhachHang
                                                },
                                                dataType: "json",
                                                success: function(response) {
                                                    
                                                $("#masothue").val(response.masothue);
                                                }
                                            });
                                            });
                                        });
                                    </script>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Booking*</label>
                                        <input type="text" class="form-control" name="booking" id="validationCustom02"
                                            placeholder="Nhập booking..." value="" required>
                                        <div class="invalid-feedback">
                                            Nhập booking.
                                        </div>
                                    </div>

                                    <div class="col-md-3  mb-3">
                                        <label for="select_loaihang">Loại hàng*</label>
                                        <select name="select_loaihang" class="" id="select_loaihang" required>
                                            <option value="">--Chọn loại hàng--</option>
                                                <option value="1">Nhập</option>
                                                <option value="2">Xuất</option>
                                                <option value="3">Nội địa</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn loại hàng.
                                        </div>
                                    </div>

                                 
                                    <div class="col-md-5  mb-3">
                                        <label for="validationCustom01">Lines/FWD</label>
                                        <select name="select_hangtau" class="" id="select_hangtau" >
                                            <option value="" >--Chọn hãng tàu--</option>
                                            <?php foreach ($resultHangTau as $items3): ?>
                                                <option value="<?php echo $items3['id_hangtau']; ?>">
                                                    <?php echo $items3['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn hãng tàu.
                                        </div>
                                    </div>

                                    <script>
                                        var selectLoaiHang = new TomSelect("#select_loaihang", {
                                            create: false,
                                            sortField: {
                                            field: "text",
                                            direction: "asc"
                                            }
                                        });

                                        var selectHangTau = new TomSelect("#select_hangtau", {
                                            create: false,
                                            sortField: {
                                            field: "text",
                                            direction: "desc"
                                            }
                                        });
                                        selectHangTau.disable(); // Vô hiệu hóa select_hangtau ban đầu

                                        selectLoaiHang.on("change", function() {
                                            var selectedValue = this.getValue();
                                            if (selectedValue === '2') {
                                            selectHangTau.enable();
                                            selectHangTau.refreshOptions();
                                            } else {
                                            selectHangTau.disable();
                                            }
                                        });
                                    </script>

                                 
                                    <div class="col-md-3  mb-3">
                                        <label for="select_NHH">Nhóm hàng hóa*</label>
                                        <select name="select_NHH" class="" id="select_NHH" required>
                                            <option value="">--Chọn nhóm hàng--</option>
                                            <?php foreach ($resultNHH as $items4): ?>
                                                <option value="<?php echo $items4['id_nhomhanghoa']; ?>">
                                                    <?php echo $items4['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn nhóm hàng hóa.
                                        </div>
                                    </div>      

                                    <div class="col-md-3  mb-3">
                                        <label for="select_HH">Hàng hóa*</label>
                                        <select name="select_HH" class="" id="select_HH" required>
                                            <option value="">--Chọn hàng hóa--</option>
                                            <?php foreach ($resultHH as $items5): ?>
                                                <option value="<?php echo $items5['id_hanghoa']; ?>">
                                                    <?php echo $items5['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn hàng hóa.
                                        </div>
                                    </div>

                                    <script>
                                       new TomSelect("#select_NHH", {
                                            create: false,
                                            sortField: {
                                            field: "text",
                                            direction: "desc"
                                            }
                                        });

                                        var selectHH = new TomSelect("#select_HH", {
                                            create: false,
                                            sortField: {
                                            field: "text",
                                            direction: "desc"
                                            }
                                        });
                                        selectHH.disable();

                                        // Sử dụng Ajax để cập nhật giá trị của select_HH
                                        $("#select_NHH").on("change", function() {
                                            var nhomHangHoaId = $(this).val();
                                            // console.log(nhomHangHoaId);
                                            
                                            if (nhomHangHoaId) {
                                            $.ajax({
                                                url: "ajax/get_hanghoa_loaixe.php", // Đường dẫn tới file xử lý Ajax
                                                method: "POST",
                                                data: {
                                                nhomHangHoaId: nhomHangHoaId
                                                },
                                                dataType: 'json',
                                                success: function(response) {
                                                    // console.log(response);
                                                // Cập nhật giá trị và options của select_HH
                                                selectHH.clearOptions();
                                                  // Lặp qua mảng response và thêm các tùy chọn mới vào select_HH
                                                $.each(response, function(index, item) {
                                                    selectHH.addOption({
                                                        value: item.id_hanghoa,
                                                        text: item.ten
                                                    });
                                                });
                                                selectHH.enable();
                                                selectHH.refreshOptions();
                                            }
                                            });
                                            } else {
                                            selectHH.clearOptions();
                                            }
                                        });

                                    </script>

                                    <div class="col-md-3 mb-3">
                                        <label for="soluong">Số lượng*</label>
                                        <input type="number" class="form-control" name="soluong" id="soluong"
                                            placeholder="Nhập số lượng" value="1" >

                                        <div class="invalid-feedback">
                                            Nhập số lượng.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="sokg">Số kg*</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="sokg" id="sokg"
                                                placeholder="Nhập số kg..." value="" required>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    Kg</div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập số kg.
                                            </div>
                                        </div>
                                    </div>
                                
                                
                                    <div class="col-md-6  mb-3">
                                        <label for="select_TVT">Tuyến vận tải*</label>
                                        <select name="select_TVT" class="" id="select_TVT" required>
                                            <option value="">--Chọn tuyến vận tải--</option>
                                            <?php foreach ($resultTVT as $items6): ?>
                                                <option value="<?php echo $items6['id_tuyenvantai']; ?>">
                                                    <?php echo $items6['ten']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Chọn tuyến vận tải.
                                        </div>
                                    </div>

                                    <script>
                                        new TomSelect("#select_TVT", {
                                            create: false,
                                            sortField: {
                                                field: "text",
                                                direction: "desc"
                                            }
                                        });

                                    </script>

                                    <div class="col-md-3 mb-3">
                                        <label for="culy">Cự ly*</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="culy"
                                                id="culy" placeholder="Cự ly" value=""  readonly>
                                                <div class="input-group-prepend">
                                                    <div
                                                        class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                        Km
                                                    </div>
                                                </div>
                                            <div class="invalid-feedback">
                                                Nhập cự ly.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="dautieuthu">Dầu tiêu thụ*</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="dautieuthu"
                                                id="dautieuthu" placeholder="Dầu tiêu thụ" value=""  readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    lít
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập dầu tiêu thụ
                                            </div>
                                        </div>

                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $("#select_TVT").change(function() {
                                            var idTuyen = $(this).val();
                                            $.ajax({
                                                url: "ajax/get_culy_dautieuthu.php",
                                                method: "POST",
                                                data: {
                                                idTuyen: idTuyen
                                                },
                                                dataType: "json",
                                                success: function(response) {
                                                $("#culy").val(response.culy);
                                                $("#dautieuthu").val(response.dautieuthu);
                                                }
                                            });
                                            });
                                        });
                                    </script>

                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Ngày đóng container*</label>
                                        <input type="date" class="form-control" name="ngaydongcontainer" id="validationCustom02"
                                            placeholder="Chọn ngày đóng container" value="" required>
                                        <div class="invalid-feedback">
                                            Ngày đóng container.
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3 mb-3">
                                        <label for="giodongcontainer">Giờ đóng container</label>
                                        <input type="time" class="form-control" name="giodongcontainer" id="giodongcontainer"
                                            placeholder="Chọn giờ đóng container" value="" >

                                        <div class="invalid-feedback">
                                            Chọn giờ đóng container.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="ngaycatmang">Ngày cắt máng</label>
                                        <input type="date" class="form-control" name="ngaycatmang" id="ngaycatmang"
                                            placeholder="Chọn ngày cắt máng" value="" >
                                        <div class="invalid-feedback">
                                            Ngày cắt máng.
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3 mb-3">
                                        <label for="giocatmang">Giờ cắt máng</label>
                                        <input type="time" class="form-control" name="giocatmang" id="giocatmang"
                                            placeholder="Chọn giờ cắt máng" value="" >

                                        <div class="invalid-feedback">
                                            Chọn giờ cắt máng.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nguoigiaonhan">Người giao nhận*</label>
                                        <input type="text" class="form-control" name="nguoigiaonhan" id="nguoigiaonhan"
                                            placeholder="Nhập người giao nhận" value="" required>

                                        <div class="invalid-feedback">
                                            Nhập người giao nhận.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="dienthoai">Số điện thoại</label>
                                        <input type="text" class="form-control" name="dienthoai" id="dienthoai"
                                            placeholder="Nhập SĐT" value="" >

                                        <div class="invalid-feedback">
                                            Nhập SĐT.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="giacuoc">Giá cước</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="giacuoc" id="giacuoc"
                                                placeholder="Giá cước" value="" readonly>
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                 giá cước.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="thuthutuc">Thu thủ tục</label>
                                        <div class="input-group mb-2">

                                        <input type="text" class="form-control" name="thuthutuc" id="thuthutuc"
                                            placeholder="Nhập thu thủ tục..." value="" >
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Nhập thu thủ tục.
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="thukhac">Thu khác</label>
                                        <div class="input-group mb-2">

                                        <input type="text" class="form-control" name="thukhac" id="thukhac"
                                            placeholder="Nhập thu khác..." value="" >
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                    VNĐ
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                            Nhập thu khác
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="hanthanhtoan">Hạn thanh toán*</label>
                                        <input type="date" class="form-control" name="hanthanhtoan" id="hanthanhtoan"
                                            placeholder="Chọn hạn thanh toán" value="" required>
                                            
                                        <div class="invalid-feedback">
                                            Chọn hạn thanh toán.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="ghichu">Ghi chú</label>
                                        <textarea class="form-control" name="ghichu" id="ghichu" placeholder="Nhập ghi chú..." rows="3"></textarea>
                                        <div class="invalid-feedback">
                                            Nhập ghi chú.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="customFile">Ảnh 1</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="anh1" id="customFile"
                                                 onchange="hienThiTenFile()">
                                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            Chọn file ảnh
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="customFile1">Ảnh 2</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="anh2" id="customFile1"
                                                 onchange="hienThiTenFile1()">
                                            <label class="custom-file-label anh2"  for="customFile1">Chọn ảnh</label>
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

                                        function hienThiTenFile1() {
                                            var input1 = document.getElementById('customFile1');
                                            var label1 = document.querySelector('.anh2');
                                            label1.textContent = input1.files[0].name;
                                        }
                                    </script>

                                    <div class="col-md-12 mb-3 ">
                                        <div class="custom-control custom-checkbox float-right">
                                            <input name="trangthai" type="checkbox" id="customCheckbox" class="custom-control-input" onchange="toggleValue(this);">
                                            <label class="custom-control-label" for="customCheckbox">Hủy</label>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var checkbox = document.getElementById("customCheckbox");
                                            checkbox.value = "Hoàn thành";
                                        });
                                        function toggleValue(checkbox) {
                                            if (checkbox.checked) {
                                            checkbox.value = "Hủy";
                                            } else {
                                            checkbox.value = "Hoàn thành";
                                            }
                                        }
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

                    <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;">
                            <tr data-id="<?php echo $items['id_donhang']; ?>"
                                data-ngaytao="<?php echo $items['ngaytao']; ?>">
                                <th>STT</th>
                                <th>Mã đơn hàng </th>
                                <th>Sales</th>
                                <th>Mã khách hàng</th>
                                <th>Mã số thuế</th>
                                <th>Số booking</th>
                                <th>Loại hàng</th>
                                <th>Lines/FWD</th>
                                <th>Mã nhóm hàng</th>
                                <th>Loại xe(Tên hàng hóa)</th>
                                <th>Số lượng</th>
                                <th>Số kg</th>
                                <th>Trạng thái</th>
                                <th>Ngày đóng cont</th>
                                <th>Giờ đóng cont</th>
                                <th>Tên tuyến vận tải</th>
                                <th>Cự ly(Km)</th>
                                <th>Ngày cắt máng</th>
                                <th>Giờ cắt máng</th>
                                <th>Người giao nhận</th>
                                <th>Số điện thoại</th>
                                <th>Tổng giá cước(VNĐ)</th>
                                <th>Thu thủ tục(VNĐ)</th>
                                <th>Thu khác(VNĐ)</th>
                                <th>Hạn thanh toán</th>
                                <th>Ghi chú</th>
                                <th>Ảnh 1</th>
                                <th>Ảnh 2</th>

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
                                $hasData = true; // Đánh dấu có dữ liệu                              ?>

                                <tr data-id="<?php echo $items['id_donhang']; ?>"
                                data-ngaytao="<?php echo $items['ngaytao']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_donhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tensales']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_khachhang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['masothue']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['booking']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($items['loaihang'] == 1) {
                                            echo "Nhập";
                                        } elseif ($items['loaihang'] == 2) {
                                            echo "Xuất";
                                        } elseif ($items['loaihang'] == 3) {
                                            echo "Nội địa";
                                        } else {
                                            echo "Không xác định";
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $items['id_hangtau']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['id_nhomhanghoa']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tenhanghoa']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['soluong']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['sokg']; ?>
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
                                  
                                        <?php echo date('d-m-Y', strtotime($items['ngaydongcontainer'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['giodongcontainer']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['tentuyenvantai']; ?>
                                    </td>
                                    <td>
                                      

                                        <?php
                                        $culy = $items['culy'];
                                        $formatted_culy = number_format($culy, 0, ',', '.');
                                        echo $formatted_culy ;
                                        ?>
                                    </td>
                                    <td>

                                        <?php echo date('d-m-Y', strtotime($items['ngaycatmang'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['giocatmang']; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['nguoigiaonhan']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['dienthoai']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $giacuoc = $items['giacuoc'];
                                        $formatted_giacuoc = number_format($giacuoc, 0, ',', '.');
                                        echo $formatted_giacuoc ;
                                        ?>
                                        
                                    </td>
                                    <td>

                                        <?php
                                        $thuthutuc = $items['thuthutuc'];
                                        $formatted_thuthutuc = number_format($thuthutuc, 0, ',', '.');
                                        echo $formatted_thuthutuc ;
                                        ?>
                                    </td>
                                    <td>

                                        <?php
                                        $thukhac = $items['thukhac'];
                                        $formatted_thukhac = number_format($thukhac, 0, ',', '.');
                                        echo $formatted_thukhac ;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($items['hanthanhtoan'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['ghichu']; ?>
                                    </td>
                                  
                                    <td>
                                        <a href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                            <img style="width: 100px;" src="img/<?php echo $items['anh1']; ?>">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="img/<?php echo $items['anh2']; ?>" target="_blank">
                                            <img style="width: 100px;" src="img/<?php echo $items['anh2']; ?>">
                                        </a>
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

                                    <?php
                                    $ngaytao = $items['ngaytao']; // 'Y-m-d'
                                    $ngayhientai = date('Y-m-d'); // Lấy ngày hiện tại dưới định dạng 'Y-m-d'
                                
                                    $ngaytao_timestamp = strtotime($ngaytao);
                                    $ngayhientai_timestamp = strtotime($ngayhientai);

                                    $ngaytao_day = date('d', $ngaytao_timestamp);
                                    $ngaytao_month = date('m', $ngaytao_timestamp);
                                    $ngaytao_year = date('Y', $ngaytao_timestamp);

                                    $ngayhientai_day = date('d', $ngayhientai_timestamp);
                                    $ngayhientai_month = date('m', $ngayhientai_timestamp);
                                    $ngayhientai_year = date('Y', $ngayhientai_timestamp);

                                    if ($ngaytao_year < $ngayhientai_year || ($ngaytao_year == $ngayhientai_year && $ngaytao_month < $ngayhientai_month)) {

                                        $disableSua = 'disabled';
                                        $disableXoa = 'disabled';
                                    } else {

                                        $disableSua = '';
                                        $disableXoa = '';
                                    }
                                    ?>

                                    <td>
                                        <form action="sua_donhang.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_donhang']; ?>">
                                            <button name="suabtn" class="btn btn-success" <?php echo $disableSua; ?>>Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <div class="modal" id="deleteModal<?php echo $items['id_donhang']; ?>" tabindex="-1" role="dialog">
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
                                                        <p>Bạn có chắc chắn muốn xóa đơn hàng có mã: 
                                                            <strong>
                                                                <?php echo $items['id_donhang']; ?>
                                                            </strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="them_donhang.php" method="POST">
                                                            <input type="hidden" name="delete_id"
                                                                value="<?php echo $items['id_donhang']; ?>">
                                                            <button name="xoabtn" class="btn btn-danger"
                                                                type="submit">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal<?php echo $items['id_donhang']; ?>" <?php echo $disableXoa; ?>>Xoá</button>
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
                window.location.href = 'sua_donhang.php?edit_id=' + id;
            }
        });

         // tìm kiếm change text search
        $(document).ready(function () {
            $('.search-input').on('input', function () {
                var searchText = $(this).val().toLowerCase();
                $('#myTable tbody tr').each(function () {
                    var rowData = $(this).text().toLowerCase();
                    if (rowData.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });


    </script>


    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>