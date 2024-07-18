<?php
include_once ('includes/connect.php');



// echo  $tendangnhap;
// echo  $id_nguoidung;

$sql = "SELECT phanquyen.id_nguoidung,nguoidung.tendangnhap,phanquyen.id_chucnang,chucnang.tenchucnang FROM `phanquyen` 
INNER JOIN chucnang ON chucnang.id_chucnang=phanquyen.id_chucnang 
INNER JOIN nguoidung ON nguoidung.id_nguoidung =phanquyen.id_nguoidung 
WHERE phanquyen.id_nguoidung = '$id_nguoidung' ";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$chucnang = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chucnang[] = $row;
}

$sql1 = "SELECT isadmin FROM `nguoidung` WHERE id_nguoidung ='$id_nguoidung' ";
$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$resultIsAdmin = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultIsAdmin[] = $row;
}

$isadmin = $resultIsAdmin[0]['isadmin'];
//  echo  'isadmin:'.$isadmin;



?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-sidebars1 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="img/logo-rm.png" alt="">
        </div>

    </a>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider my-0"> -->

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active mt-2">
        <?php
        $coChucNangDB = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'dashboard') {
                $coChucNangDB = true;
                break;
            }
        }
        // echo 'cocn'.$coChucNangDB; 
        // var_dump($coChucNangDB);
        // var_dump($isadmin);
        if ($isadmin == 'true' || $coChucNangDB) {
            echo '<a class="nav-link" href="index.php">';
            echo '<i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a>';
        } else {
            echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a>';
        }
        ?>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản trị
    </div>

    <!-- Nav Item Quản trị Menu -->
    <li class="nav-item">
        <?php
        $coChucNangHeThong = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'hethong') {
                $coChucNangHeThong = true;
                break;
            }
        }
        if ($isadmin == 'true' || $coChucNangHeThong) {
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#heThong" aria-expanded="true" aria-controls="heThong">';
            echo '<i class="fas fa-fw fa-cog"></i><span>Hệ thống</span></a>';
        } else {
            echo '<a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fas fa-fw fa-cog"></i><span>Hệ thống</span></a>';
        }
        ?>
        <div id="heThong" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="list_nguoidung.php"> <i
                        class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Người dùng</a>
                <a class="collapse-item" href="list_chucnang.php"><i
                        class="fa-solid fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Chức năng</a>
                <a class="collapse-item" href="list_nguoidung.php"><i
                        class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Phân quyền</a>
                <a class="collapse-item" href="nhatky.php"><i
                        class="fa-solid fa-address-book fa-sm fa-fw mr-2 text-gray-400"></i>Nhật ký</a>
            </div>
        </div>
    </li>

    <!-- Nav Item danh mục Menu -->
    <li class="nav-item">
        <?php
        $coChucNangDMDL = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'danhmucdulieu') {
                $coChucNangDMDL = true;
                break;
            }
        }
        if ($isadmin == 'true' || $coChucNangDMDL) {
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#danhMuc" aria-expanded="true" aria-controls="danhMuc">';
            echo '<i class="fa-solid fa-database"></i><span>Danh mục dữ liệu</span></a>';
        } else {
            echo '<a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fa-solid fa-database"></i><span>Danh mục dữ liệu</span></a>';
        }
        ?>
        <div id="danhMuc" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Dữ liệu:</h6>
                <a class="collapse-item" href="list_tintuc.php">Tin tức</a>
                <a class="collapse-item" href="list_nhan_su.php">Nhân sự</a>
                <a class="collapse-item" href="list_tinhthanh.php">Tỉnh thành</a>
                <a class="collapse-item" href="list_hang_tau.php">Hãng tàu</a>
                <a class="collapse-item" href="list_tuyen_van_tai.php">Tuyến vận tải</a>
                <a class="collapse-item" href="list_nhomxe.php">Nhóm xe</a>
                <a class="collapse-item" href="list_xe.php">Xe</a>
                <a class="collapse-item" href="list_taixe.php">Tài xế</a>
                <a class="collapse-item" href="list_nhomhang.php">Nhóm hàng</a>
                <a class="collapse-item" href="list_hanghoa.php">Hàng hóa</a>
                <a class="collapse-item" href="list_thauphu.php">Thầu phụ</a>
                <a class="collapse-item" href="list_khachhang.php">Khách hàng</a>
                <a class="collapse-item" href="list_lichtrinh.php">Lịch trình</a>
                <a class="collapse-item" href="list_donvicungcapdau.php">Đơn vị cung cấp dầu</a>
                <a class="collapse-item" href="list_nhienlieu.php">Nhiên liệu</a>


            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Vận đơn
    </div>

    <!-- Nav Item - Đơn hàng Menu -->
    <li class="nav-item">
        <?php
        $coChucNangDH = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'donhang') {
                $coChucNangDH = true;
                break;
            }
        }
        if ($isadmin == 'true' || $coChucNangDH) {
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#donHang" aria-expanded="true" aria-controls="donHang">';
            echo '<i class="fas fa-fw fa-folder"></i><span>Đơn hàng</span></a>';
        } else {
            echo '<a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fas fa-fw fa-folder"></i><span>Đơn hàng</span></a>';
        }
        ?>
        <div id="donHang" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="list_donhang.php"> <i
                        class="fas fa-folder fa-sm fa-fw mr-2 text-gray-400"></i>Đơn hàng</a>
                <a class="collapse-item" href="list_tamung.php"> <i
                        class="fa-solid fa-dollar-sign fa-sm fa-fw mr-2 text-gray-400"></i>Tạm ứng</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Điều vận Menu -->
    <li class="nav-item">
        <?php
        $coChucNangDV = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'dieuvan') {
                $coChucNangDV = true;
                break;
            }
        }
        if ($isadmin == 'true' || $coChucNangDV) {
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dieuVan" aria-expanded="true" aria-controls="dieuVan">';
            echo '<i class="fa-solid fa-truck"></i><span>Điều vận</span></a>';
        } else {
            echo '<a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fa-solid fa-truck"></i><span>Điều vận</span></a>';
        }
        ?>
        <div id="dieuVan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="list_dieuhanh.php"><i
                        class="fa-solid fa-truck fa-sm fa-fw mr-2 text-gray-400"></i>Điều hành xe</a>
                <a class="collapse-item" href="list_phieudonhienlieu.php"><i
                        class="fa-solid fa-receipt fa-sm fa-fw mr-2 text-gray-400"></i>Phiếu đổ nhiên liệu</a>
                <a class="collapse-item" href="list_suachua.php"><i
                        class="fa-solid fa-hammer fa-sm fa-fw mr-2 text-gray-400"></i>Thông tin sửa chữa</a>
                <a class="collapse-item" href="list_chiphivantai.php"> <i
                        class="fa-solid fa-dollar-sign fa-sm fa-fw mr-2 text-gray-400"></i>Chi phí vận tải</a>
                <a class="collapse-item" href="list_kehoachvantai.php"><i
                        class="fa-regular fa-calendar-check fa-sm fa-fw mr-2 text-gray-400"></i>Kế hoạch vận tải</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - báo cáo, thống kê Menu -->

    <li class="nav-item">
        <?php
        $coChucNangBCTK = false;
        foreach ($chucnang as $cn) {
            if ($cn['tenchucnang'] == 'baocaothongke') {
                $coChucNangBCTK = true;
                break;
            }
        }
        if ($isadmin == 'true' || $coChucNangBCTK) {
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#baoCaoThongKe" aria-expanded="true" aria-controls="baoCaoThongKe">';
            echo '<i class="fa-solid fa-flag"></i><span>Báo cáo - Thống kê</span></a>';
        } else {
            echo '<a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#noPermissionModal">';
            echo '<i class="fa-solid fa-flag"></i><span>Báo cáo - Thống kê</span></a>';
        }
        ?>
        <div id="baoCaoThongKe" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="baocaotamung.php"><i
                        class="fa-solid fa-dollar-sign fa-sm fa-fw mr-2 text-gray-400"></i>Tiền tạm ứng</a>
                <a class="collapse-item" href="baocaosuachua.php"><i
                        class="fa-solid fa-hammer fa-sm fa-fw mr-2 text-gray-400"></i>Sửa chữa</a>
                <a class="collapse-item" href="baocaoloinhuan.php"><i
                        class="fa-solid fa-dollar-sign fa-sm fa-fw mr-2 text-gray-400"></i>Lợi nhuận</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng xuất?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Xác nhận đăng xuất?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Đóng</button>
                <a class="btn btn-primary" href="account/logout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>



<!-- Modal Thông báo người dùng không có quyền -->
<div class="modal fade" id="noPermissionModal" tabindex="-1" role="dialog" aria-labelledby="noPermissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noPermissionModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">Bạn không có quyền truy cập vào chức năng này.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

