<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id_donhang = $_POST['edit_id_donhang'];
    $id_cpvt = $_POST['edit_id'];

    // data ĐƠn hàng
    $sqlDonHang = "SELECT *,  nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh,dieuhanh.id_xe,
    xe.bienso,tuyenvantai.ten as tentuyenvantai,hanghoa.ten as tenhanghoa,phieudonhienlieu.thanhtien,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
    INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa 
    INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
     WHERE donhang.id_donhang  ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data cpvt
    $sqlCPVT = "SELECT * FROM `chiphivantai` WHERE id_cpvt ='$id_cpvt'";

    $stmt2 = $conn->prepare($sqlCPVT);
    $query2 = $stmt2->execute();
    $resultCPVT = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultCPVT[] = $row;
    }



} else {
    // phần này để doubleclick vào row trong table
    $id_donhang = $_GET['donhang_id'];
    $id_cpvt = $_GET['edit_id'];

    // data ĐƠn hàng
    $sqlDonHang = "SELECT *,  nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh,dieuhanh.id_xe,
    xe.bienso,tuyenvantai.ten as tentuyenvantai,hanghoa.ten as tenhanghoa,phieudonhienlieu.thanhtien,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac
    FROM donhang 
    INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
    INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
    INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
    INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
    INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
    INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa 
    INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
    INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
     WHERE donhang.id_donhang  ='$id_donhang'";

    $stmt1 = $conn->prepare($sqlDonHang);
    $query1 = $stmt1->execute();
    $resultDH = array();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $resultDH[] = $row;
    }

    // data cpvt
    $sqlCPVT = "SELECT * FROM `chiphivantai` WHERE id_cpvt ='$id_cpvt'";

    $stmt2 = $conn->prepare($sqlCPVT);
    $query2 = $stmt2->execute();
    $resultCPVT = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultCPVT[] = $row;
    }
}


$sqlNhanSu = "SELECT * FROM nhansu";
$stmt1 = $conn->prepare($sqlNhanSu);
$query = $stmt1->execute();
$resultNS = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultNS[] = $row;
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

            <!-- Topbar Search -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa chi phí vận tải</h1>

            <form class="needs-validation" novalidate action="them_chiphivantai.php" method="POST"
                enctype="multipart/form-data">
                <div class="form-row">
                    <?php foreach ($resultDH as $items): ?>
                        <?php foreach ($resultCPVT as $itemsCPVT): ?>
                            <!-- thông tin đơn hàng của cpvt -->
                            <div class="col-sm-12">
                                <div class="card text-white bg-secondary mb-3">
                                    <div class="card-header">
                                        Thông tin đơn hàng
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">

                                            <div class="col-md-3 mb-3">
                                                <label for="id_donhang_cpvt">Mã đơn hàng :</label>
                                                <input type="text" class="form-control" name="id_donhang_cpvt"
                                                    id="id_donhang_cpvt" placeholder="mã đơn hàng"
                                                    value="<?php echo $items['id_donhang']; ?>" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Ngày vận chuyển :</label>
                                                <input disabled type="date" class="form-control" id="ngaydongcontainer_cpvt"
                                                    value="<?php echo $items['ngaydongcontainer']; ?>">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Ngày lập :</label>
                                                <input disabled type="date" class="form-control" id="ngaytao_cpvt"
                                                    value="<?php echo $items['ngaytao']; ?>">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Booking :</label>
                                                <input type="text" class="form-control" id="booking_cpvt" placeholder="booking"
                                                    value="<?php echo $items['booking']; ?>" readonly>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label for="">Khách hàng :</label>
                                                <input type="text" class="form-control" id="khachhang_cpvt"
                                                    placeholder="khachhang" value="<?php echo $items['tenkh']; ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Hàng hóa :</label>
                                                <input type="text" class="form-control" id="hanghoa_cpvt"
                                                    placeholder="Hàng hóa..." value="<?php echo $items['tenhanghoa']; ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <label for="">Nhóm hàng hóa :</label>
                                                <input type="text" class="form-control" id="nhomhanghoa_cpvt"
                                                    placeholder="nhomhanghoa" value="<?php echo $items['id_nhomhanghoa']; ?>"
                                                    readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">Tuyến vận tải :</label>
                                                <input type="text" class="form-control" id="tvt_cpvt" placeholder="tvt"
                                                    value="<?php echo $items['tentuyenvantai']; ?>" readonly>
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label for="bienso">Biển số :</label>
                                                <input class="form-control" id="bienso_cpvt" placeholder="Biển số..."
                                                    value="<?php echo $items['bienso']; ?>" readonly></input>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="thuthutuc">Thu thủ tục :</label>
                                                <div class="input-group mb-2 d-flex ">
                                                    <input class="form-control" id="thuthutuc_cpvt" placeholder="Thu thủ tục..."
                                                        value="<?php echo $items['thuthutuc']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="thukhac">Thu khác :</label>
                                                <div class="input-group mb-2 d-flex ">
                                                    <input class="form-control" id="thukhac_cpvt" placeholder="Thu khác..."
                                                        value="<?php echo $items['thukhac']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- card chi phí vận tải -->
                            <div class="col-sm-12 mt-2">
                                <div class="card text-white bg-info  mb-3">
                                    <div class="card-header">
                                        Chi phí vận tải
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- chi phí đơn hàng -->
                                            <div class="col-md-12 mb-3">
                                                <input type="hidden" readonly class="form-control" name="id_edit"
                                                    id="validationCustom01" placeholder="Mã cpvt"
                                                    value="<?php echo $itemsCPVT['id_cpvt']; ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="phi1kg">Phí cân nặng / 1kg :</label>
                                                <div class="input-group mb-2 d-flex">
                                                    <input class="form-control" id="phi1kg" placeholder="Phí cân nặng..."
                                                        value="500"></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            đ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">x</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Trọng lượng :</label>
                                                <div class="input-group mb-2 d-flex">
                                                    <input class="form-control" id="cannang_cpvt" placeholder="Phí cân nặng..."
                                                        readonly value="<?php echo $items['sokg']; ?>"></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            Kg</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">=</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tongphicannang">Phí cân nặng :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="tongphicannang_cpvt"
                                                        placeholder="Phí cân nặng..."
                                                        value="<?php echo $items['sokg'] * 500; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#phi1kg').on('input', function () {
                                                        var phi1kgValue = parseFloat($(this).val());

                                                        var cannangValue = parseFloat($('#cannang_cpvt').val());

                                                        var tongphicannangValue = phi1kgValue * cannangValue;

                                                        // Cập nhật giá trị mới cho "Phí cân nặng"
                                                        $('#tongphicannang_cpvt').val(tongphicannangValue);
                                                    });
                                                });
                                            </script>

                                            <div class="col-md-3 mb-3">
                                                <label for="nhienlieu">Phí nhiên liệu :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="nhienlieu_cpvt"
                                                        placeholder="Phí nhiên liệu..."
                                                        value="<?php echo $items['thanhtien']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <!-- start phí tạm ứng -->
                                            <div class="col-md-3 mb-3">
                                                <label for="tiencuocvo">Tiền cước vỏ :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="tiencuocvo_cpvt"
                                                        placeholder="Tiền cước vỏ..."
                                                        value="<?php echo $items['tiencuocvo']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienhaiquan">Tiền hải quan :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="tienhaiquan_cpvt"
                                                        placeholder="Tiền hải quan..."
                                                        value="<?php echo $items['tienhaiquan']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tiennangha">Tiền nâng hạ :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="tiennangha_cpvt"
                                                        placeholder="Tiền nâng hạ..."
                                                        value="<?php echo $items['tiennangha']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienkhac">Tiền khác :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input class="form-control" id="tienkhac_cpvt" placeholder="Tiền khác..."
                                                        value="<?php echo $items['tienkhac']; ?>" readonly></input>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <!--end  phí tạm ứng -->


                                            <!-- chi phí vt -->
                                            <div class="col-md-3 mb-3">
                                                <label for="phicauduong_cpvt">Phí cầu đường :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input type="text" class="form-control" name="phicauduong_cpvt"
                                                        id="phicauduong_cpvt" placeholder="Phí cầu đường..."
                                                        value="<?php echo $itemsCPVT['phicauduong']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienanca_cpvt">Tiền ăn ca :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input type="text" class="form-control" name="tienanca_cpvt"
                                                        id="tienanca_cpvt" placeholder="Tiền ăn ca..."
                                                        value="<?php echo $itemsCPVT['tienanca']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="luongchuyen_cpvt">Lương chuyến :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input type="text" class="form-control" name="luongchuyen_cpvt"
                                                        id="luongchuyen_cpvt" placeholder="Lương chuyến..."
                                                        value="<?php echo $itemsCPVT['luongchuyen']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="luongchunhat_cpvt">Lương chủ nhật :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input type="text" class="form-control" name="luongchunhat_cpvt"
                                                        id="luongchunhat_cpvt" placeholder="Lương chủ nhật..."
                                                        value="<?php echo $itemsCPVT['luongchunhat']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">+</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tienthuexengoai_cpvt">Tiền thua xe ngoài :</label>
                                                <div class="input-group mb-2 d-flex calculation-input">
                                                    <input type="text" class="form-control" name="tienthuexengoai_cpvt"
                                                        id="tienthuexengoai_cpvt" placeholder="Tiền thua xe ngoài..."
                                                        value="<?php echo $itemsCPVT['tienthuexengoai']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>
                                                    <div class="ml-2  dautinhtoan">=</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="tongchiphi_cpvt">Tổng giá cước :</label>
                                                <div class="input-group mb-2 ">
                                                    <input type="text" class="form-control" name="tongchiphi_cpvt"
                                                        id="tongchiphi_cpvt" placeholder="Tổng giá cước..."
                                                        value="<?php echo $itemsCPVT['tongchiphi']; ?>" readonly>
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                                            VNĐ</div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label for="ghichu_cpvt">Ghi chú :</label>
                                                <textarea class="form-control" name="ghichu_cpvt" id="ghichu_cpvt"
                                                    placeholder="Nhập ghi chú..."
                                                    rows="3"><?php echo $itemsCPVT['ghichu']; ?></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <script>

                                </script>
                            </div>
                            <!-- end card chi phí vận tải -->


                        <?php endforeach ?>

                        <!-- end card tạm ứng -->
                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_chiphivantai.php" class="btn btn-secondary mr-3">Trở lại </a>
                    <button type="submit" name="luubtn" class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function () {

            function calculateTotalCost() {
                var tongphicannang = parseFloat($("#tongphicannang_cpvt").val()) || 0;
                var nhienlieu = parseFloat($("#nhienlieu_cpvt").val()) || 0;
                // var thuthutuc = parseFloat($("#thuthutuc_cpvt").val()) || 0;
                // var thukhac = parseFloat($("#thukhac_cpvt").val()) || 0;
                var phicauduong = parseFloat($("#phicauduong_cpvt").val()) || 0;
                var tienanca = parseFloat($("#tienanca_cpvt").val()) || 0;
                var luongchuyen = parseFloat($("#luongchuyen_cpvt").val()) || 0;
                var luongchunhat = parseFloat($("#luongchunhat_cpvt").val()) || 0;
                var tienthuexengoai = parseFloat($("#tienthuexengoai_cpvt").val()) || 0;
                var tiencuocvo = parseFloat($("#tiencuocvo_cpvt").val()) || 0;
                var tienhaiquan = parseFloat($("#tienhaiquan_cpvt").val()) || 0;
                var tiennangha = parseFloat($("#tiennangha_cpvt").val()) || 0;
                var tienkhac = parseFloat($("#tienkhac_cpvt").val()) || 0;

                var totalCost = tongphicannang + nhienlieu + phicauduong + tienanca + luongchuyen + luongchunhat + tienthuexengoai + tiencuocvo + tienhaiquan + tiennangha + tienkhac;

                $("#tongchiphi_cpvt").val(totalCost);
            }

            calculateTotalCost();

            $("#tiencuocvo_cpvt,#tienhaiquan_cpvt,#tiennangha_cpvt,#tienkhac_cpvt,#phi1kg,#tongphicannang_cpvt, #nhienlieu_cpvt,  #phicauduong_cpvt, #tienanca_cpvt, #luongchuyen_cpvt,#luongchunhat_cpvt,#tienthuexengoai_cpvt").on("input", calculateTotalCost);
        });
    </script>

    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>