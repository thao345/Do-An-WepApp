<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');
include_once ('includes/connect.php');

$sql = "SELECT 
tong_tongchiphi, 
tong_thuthutuc, 
tong_thukhac,
(
 COALESCE(tong_tongchiphi, 0) + 
 COALESCE(tong_thuthutuc, 0) + 
 COALESCE(tong_thukhac, 0)
) AS tong_tatca
FROM (
SELECT 
    (SELECT SUM(tongchiphi) FROM chiphivantai WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_tongchiphi,
    (SELECT SUM(CASE WHEN trangthai != 'huy' THEN thuthutuc ELSE 0 END) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thuthutuc,
    (SELECT SUM(CASE WHEN trangthai != 'huy' THEN thukhac ELSE 0 END) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thukhac
) AS totals;

";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
;

$sql1 = "SELECT 
tong_tatca - tongchi_sum AS loi_nhuan
FROM (
-- Truy vấn tính tổng chi phí
SELECT 
    COALESCE(tongtiensuachua_sum, 0) +
    COALESCE(tongchi_sum, 0) AS tongchi_sum
FROM (
    SELECT 
        COALESCE(SUM(suachua.tongtien), 0) AS tongtiensuachua_sum
    FROM suachua
    WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') 
        AND suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS suachua_sums,
(
    SELECT 
        COALESCE(SUM(
        COALESCE(chiphivantai.phicauduong, 0) +
        COALESCE(chiphivantai.tienanca, 0) +
        COALESCE(chiphivantai.luongchuyen, 0) +
        COALESCE(chiphivantai.luongchunhat, 0) +
        COALESCE(chiphivantai.tienthuexengoai, 0) +
        COALESCE(phieudonhienlieu.thanhtien, 0) +
        COALESCE(chitietdonhangtamung.tiencuocvo, 0) +
        COALESCE(chitietdonhangtamung.tienhaiquan, 0) +
        COALESCE(chitietdonhangtamung.tiennangha, 0) +
        COALESCE(chitietdonhangtamung.tienkhac, 0)
        ), 0) AS tongchi_sum
    FROM donhang
    LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    LEFT JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    LEFT JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    WHERE donhang.trangthai = 'Hoàn thành'
        AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
) AS chi_sums
) AS chi_phi,
(
-- Truy vấn tính tổng doanh thu
SELECT 
    COALESCE(tong_tongchiphi, 0) AS tong_tongchiphi, 
    COALESCE(tong_thuthutuc, 0) AS tong_thuthutuc, 
    COALESCE(tong_thukhac, 0) AS tong_thukhac,
    (
        COALESCE(tong_tongchiphi, 0) + 
        COALESCE(tong_thuthutuc, 0) + 
        COALESCE(tong_thukhac, 0)
    ) AS tong_tatca
FROM (
    SELECT 
        (SELECT COALESCE(SUM(tongchiphi), 0) FROM chiphivantai WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_tongchiphi,
        (SELECT COALESCE(SUM(CASE WHEN trangthai != 'huy' THEN thuthutuc ELSE 0 END), 0) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thuthutuc,
        (SELECT COALESCE(SUM(CASE WHEN trangthai != 'huy' THEN thukhac ELSE 0 END), 0) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thukhac
) AS totals
) AS doanh_thu;



";

$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$resultyear = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultyear[] = $row;
}

$sql2 = "SELECT COUNT(*) AS so_luong_don_hang
FROM donhang
WHERE trangthai != 'huy'
  AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
  AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')";
$stmt2 = $conn->prepare($sql2);
$query = $stmt2->execute();
$resultsl = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultsl[] = $row;
}


$sql3 = "SELECT 
COUNT(*) AS tong_don_hang,
SUM(CASE WHEN trangthai != 'huy' THEN 1 ELSE 0 END) AS don_hang_khac_huy,
(SUM(CASE WHEN trangthai != 'huy' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) AS phan_tram
FROM 
donhang
WHERE 
YEAR(ngaytao) = YEAR(CURRENT_DATE());";
$stmt3 = $conn->prepare($sql3);
$query = $stmt3->execute();
$resultpt = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultpt[] = $row;
}

$sql4 = "SELECT 
COUNT(*) AS so_luong_khach
FROM 
khachhang";
$stmt4 = $conn->prepare($sql4);
$query = $stmt4->execute();
$resultkh = array();
while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    $resultkh[] = $row;
}


$sql5 = "

WITH suachua_totals AS (
    SELECT 
        DATE_FORMAT(suachua.ngaysuachua, '%m') AS thang,
        SUM(suachua.tongtien) AS tongtiensuachua
    FROM suachua
    WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-01-01') 
      AND suachua.ngaysuachua <= DATE_FORMAT(NOW(), '%Y-%m-%d')
    GROUP BY DATE_FORMAT(suachua.ngaysuachua, '%m')
),

monthly_totals AS (
    SELECT 
        DATE_FORMAT(donhang.ngaytao, '%m') AS thang,
        SUM(COALESCE(chiphivantai.phicauduong, 0) +
            COALESCE(chiphivantai.tienanca, 0) +
            COALESCE(chiphivantai.luongchuyen, 0) +
            COALESCE(chiphivantai.luongchunhat, 0) +
            COALESCE(chiphivantai.tienthuexengoai, 0) +
            COALESCE(phieudonhienlieu.thanhtien, 0) +
            COALESCE(chitietdonhangtamung.tiencuocvo, 0) +
            COALESCE(chitietdonhangtamung.tienhaiquan, 0) +
            COALESCE(chitietdonhangtamung.tiennangha, 0) +
            COALESCE(chitietdonhangtamung.tienkhac, 0)
        ) AS tongchi_sum,
        SUM(CASE WHEN donhang.trangthai != 'huy' THEN COALESCE(donhang.thuthutuc, 0) ELSE 0 END) +
        SUM(CASE WHEN donhang.trangthai != 'huy' THEN COALESCE(donhang.thukhac, 0) ELSE 0 END) +
        SUM(COALESCE(chiphivantai.tongchiphi, 0)) AS tong_tatca
    FROM 
        donhang
    LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
    LEFT JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
    LEFT JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
    LEFT JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
    LEFT JOIN xe ON xe.id_xe = dieuhanh.id_xe
    WHERE 
        donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-01-01') 
        AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
    GROUP BY 
        DATE_FORMAT(donhang.ngaytao, '%m')
)

SELECT 
    mt.thang,
    COALESCE(st.tongtiensuachua, 0) AS tongsua,
    mt.tong_tatca,
    mt.tongchi_sum + COALESCE(st.tongtiensuachua, 0) AS tongchi_sum,
    mt.tong_tatca - (mt.tongchi_sum + COALESCE(st.tongtiensuachua, 0)) AS loi_nhuan
FROM 
    monthly_totals mt
LEFT JOIN 
    suachua_totals st ON mt.thang = st.thang
ORDER BY 
    mt.thang ASC;


";
$stmt5 = $conn->prepare($sql5);
$query = $stmt5->execute();
$resultbd = $stmt5->fetchAll(PDO::FETCH_ASSOC);

$months = [];
$revenues = [];
foreach ($resultbd as $row) {
    $months[] = "Tháng " . $row['thang'];
    $revenues[] = $row['loi_nhuan'];

}

$months_json = json_encode($months);
$revenues_json = json_encode($revenues);


$sql6 = "
SELECT 
    tong_tatca, 
    tongchi_sum, 
    tong_tatca - tongchi_sum AS loi_nhuan
FROM (
    SELECT 
        COALESCE(tongtiensuachua_sum,0) +
        COALESCE(tongchi_sum,0) as tongchi_sum
    FROM (
        SELECT 
            SUM(COALESCE(suachua.tongtien,0)) AS tongtiensuachua_sum
        FROM suachua
        WHERE suachua.ngaysuachua >= DATE_FORMAT(NOW(), '%Y-%m-01') 
            AND suachua.ngaysuachua < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
    ) AS suachua_sums,
    (
        SELECT 
                SUM(COALESCE(chiphivantai.phicauduong, 0) +
                COALESCE(chiphivantai.tienanca, 0) +
                COALESCE(chiphivantai.luongchuyen, 0) +
                COALESCE(chiphivantai.luongchunhat, 0) +
                COALESCE(chiphivantai.tienthuexengoai, 0) +
                COALESCE(phieudonhienlieu.thanhtien, 0) +
                COALESCE(chitietdonhangtamung.tiencuocvo, 0) +
                COALESCE(chitietdonhangtamung.tienhaiquan, 0) +
                COALESCE(chitietdonhangtamung.tiennangha, 0) +
                COALESCE(chitietdonhangtamung.tienkhac, 0)
            ) AS tongchi_sum
        FROM donhang
        LEFT JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang
        LEFT JOIN phieudonhienlieu ON phieudonhienlieu.id_donhang = donhang.id_donhang
        LEFT JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang
        WHERE donhang.trangthai = 'Hoàn thành'
            AND donhang.ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01')
            AND donhang.ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01')
    ) AS chi_sums
) AS chi_phi,
(
    
    SELECT 
        tong_tongchiphi, 
        tong_thuthutuc, 
        tong_thukhac,
        (
            COALESCE(tong_tongchiphi, 0) + 
            COALESCE(tong_thuthutuc, 0) + 
            COALESCE(tong_thukhac, 0)
        ) AS tong_tatca
    FROM (
        SELECT 
            (SELECT SUM(tongchiphi) FROM chiphivantai WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_tongchiphi,
            (SELECT SUM(CASE WHEN trangthai != 'huy' THEN thuthutuc ELSE 0 END) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thuthutuc,
            (SELECT SUM(CASE WHEN trangthai != 'huy' THEN thukhac ELSE 0 END) FROM donhang WHERE MONTH(ngaytao) = MONTH(CURRENT_DATE()) AND YEAR(ngaytao) = YEAR(CURRENT_DATE())) AS tong_thukhac
    ) AS totals
) AS doanh_thu;
";

// Chuẩn bị và thực thi truy vấn
$stmt6 = $conn->prepare($sql6);
$query = $stmt6->execute();

// Lấy kết quả truy vấn
$resultpie = $stmt6->fetch(PDO::FETCH_ASSOC);
// Lưu kết quả vào các biến
$tong_tatca = $resultpie['tong_tatca'];
$tongchi_sum = $resultpie['tongchi_sum'];
$loi_nhuan = $resultpie['loi_nhuan'];
if ($tong_tatca != 0) {
    $tongchi_percentage = ($tongchi_sum / $tong_tatca) * 100;
    $loinhuan_percentage = ($loi_nhuan / $tong_tatca) * 100;
}



?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: " . $tendangnhap; ?></span>
                <br>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: " . $thoigiandangnhap; ?></span>
            </div>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
           

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
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Trang chủ</h1>

            </div>

            <!-- Content Row -->
            <div class="row">
                <?php
                foreach ($result as $items):
                    ?>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Doanh thu ( hàng tháng)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo number_format($items['tong_tatca'], 0, ',', '.'); ?> VNĐ
                                        </div>
                                    <?php endforeach ?>

                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Lợi nhuận( hàng tháng)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        foreach ($resultyear as $items):

                                            echo number_format($items['loi_nhuan'], 0, ',', '.'); ?> VNĐ
                                        <?php endforeach ?>


                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đang thực hiện
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                <?php
                                                foreach ($resultsl as $items):

                                                    echo $items['so_luong_don_hang']; ?> đơn
                                                <?php endforeach ?>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php
                                                if (!empty($resultpt)) {
                                                    foreach ($resultpt as $items) {
                                                        echo $items['phan_tram'];
                                                    }
                                                }
                                                ?>%;" aria-valuenow="<?php echo $items['phan_tram']; ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-file-contract fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Khách hàng tiềm năng</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        foreach ($resultkh as $items):

                                            echo $items['so_luong_khach']; ?>
                                        <?php endforeach ?>
                                        khách hàng
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <!-- <i class="fa-solid fa-user fa-2x text-gray-300"></i> -->
                                    <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tổng quan lợi nhuận các tháng</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                         <style>
                            .card-body {
                                width: 100%;
                                box-sizing: border-box;
                            }

                            .chart-area {
                                width: 100%;
                            }

                            #myChart {
                                width: 100% !important;
                                height: auto;
                            }
                        </style>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myChart" style="width:100%" width="600" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tổng quan</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2 "
                                style="display: flex; justify-content: center; align-items: center;">
                                <canvas id="pie" width="200" height="100"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle" style="Color:rgba(255,224,230,255)"></i> Chi Phí
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle" style="Color:rgba(215,236,251,255)"></i> Lợi nhuận
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <!-- <div class="row">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-primary text-white shadow">
                            <div class="card-body">
                                Primary
                                <div class="text-white-50 small">#4e73df</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                Success
                                <div class="text-white-50 small">#1cc88a</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                Info
                                <div class="text-white-50 small">#36b9cc</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-warning text-white shadow">
                            <div class="card-body">
                                Warning
                                <div class="text-white-50 small">#f6c23e</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-danger text-white shadow">
                            <div class="card-body">
                                Danger
                                <div class="text-white-50 small">#e74a3b</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-secondary text-white shadow">
                            <div class="card-body">
                                Secondary
                                <div class="text-white-50 small">#858796</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-light text-black shadow">
                            <div class="card-body">
                                Light
                                <div class="text-black-50 small">#f8f9fc</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-dark text-white shadow">
                            <div class="card-body">
                                Dark
                                <div class="text-white-50 small">#5a5c69</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Nhận dữ liệu JSON từ PHP
            var months = <?php echo $months_json; ?>;
            var revenues = <?php echo $revenues_json; ?>;

            // Cấu hình biểu đồ
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Lợi nhuận Đơn Hàng',
                        data: revenues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền
                        borderColor: 'rgba(75, 192, 192, 1)', // Màu đường viền
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Lợi nhuận (VND)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        var ctx = document.getElementById('pie').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    label: 'My First Dataset',
                    data: [<?php echo $tongchi_percentage ?>, <?php echo $loinhuan_percentage ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                var value = context.raw || 0;
                                var roundedValue = Math.round(value * 100) / 100;
                                return label + ': ' + roundedValue + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>



    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>