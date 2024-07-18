<?php
session_start();
include ('includes/connect.php');

$id_pdnl = $_POST['id_pdnl'];
// echo $id_donhang;
$sqlDonHang = "SELECT phieudonhienlieu.id_pdnl,phieudonhienlieu.id_donhang,xe.bienso ,taixe.ten as tentaixe,DATE(phieudonhienlieu.ngaydonhienlieu) as ngaydonhienlieu,donvicungcapdau.ten as tendonvicungcapdau,donvicungcapdau.id_donviccdau ,phieudonhienlieu.soluongnhienlieu,phieudonhienlieu.id_nhienlieu,nhienlieu.ngayapdung,nhienlieu.dongiasauthue,nhienlieu.ten as tennhienlieu,phieudonhienlieu.thanhtien
FROM phieudonhienlieu 
INNER JOIN donhang ON phieudonhienlieu.id_donhang = donhang.id_donhang
LEFT JOIN dieuhanh ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN donvicungcapdau ON phieudonhienlieu.id_dvccdau = donvicungcapdau.id_donviccdau
INNER JOIN nhienlieu ON phieudonhienlieu.id_nhienlieu = nhienlieu.id_nhienlieu
LEFT JOIN xe ON dieuhanh.id_xe = xe.id_xe
LEFT JOIN taixe ON dieuhanh.id_taixe = taixe.id_taixe
WHERE phieudonhienlieu.id_pdnl  ='$id_pdnl'";

$stmt1 = $conn->prepare($sqlDonHang);
$query1 = $stmt1->execute();
$resultPDNL = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultPDNL[] = $row;
}




$dongiasauthue = $resultPDNL[0]['dongiasauthue'];
$formatted_dongiasauthue = number_format($dongiasauthue, 0, ',', ',');

$thanhtien = $resultPDNL[0]['thanhtien'];
$formatted_thanhtien = number_format($thanhtien, 0, ',', ',');

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>DISEE - Invoice HTML5 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!-- Invoice 3 start -->
    <div class="invoice-3 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">

                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-name">
                                            <!-- logo started -->
                                            <!-- <div class="logo">
                                                <img src="assets/img/logos/logo-dau1.png" alt="logo" style="">
                                            </div>
                                            <div class="logo">
                                                <img src="assets/img/logos/logo-dau2.png" alt="logo"
                                                    style="height: 90px;">
                                            </div> -->
                                            <?php if ($resultPDNL[0]['id_donviccdau'] === 'HFC'): ?>
                                                <div class="logo">
                                                    <img src="assets/img/logos/logo-dau1.png" alt="logo" style="">
                                                </div>
                                            <?php else: ?>
                                                <div class="logo">
                                                    <img src="assets/img/logos/logo-dau2.png" alt="logo"
                                                        style="height: 90px;">
                                                </div>
                                            <?php endif; ?>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice">
                                            <h1 class="text-end inv-header-1 mb-0">Mã đơn hàng:
                                                <?php echo '#' . $resultPDNL[0]['id_donhang']; ?>
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-30">
                                        <div class="invoice-number">
                                            <h4 class="inv-header-1 text-center">
                                                <?php echo $resultPDNL[0]['tendonvicungcapdau']; ?>
                                            </h4>
                                            <?php if ($resultPDNL[0]['id_donviccdau'] === 'HFC'): ?>
                                                <p class="invo-addr-1 mb-0 text-center">
                                                    Địa chỉ: Km 2 đường 356, Phường Đông Hải 2, Quận Hải An, Thành phố Hải
                                                    Phòng. <br />
                                                </p>
                                            <?php else: ?>
                                                <p class="invo-addr-1 mb-0 text-center">
                                                    Địa chỉ: 46B Đường Chùa Vẽ, P. Đông Hải 1, Q.Hải An, Hải Phòng. <br />
                                                </p>
                                            <?php endif; ?>
                                            <h1 class="title-pcd text-center mt-2">PHIẾU CẤP DẦU</h1>
                                        </div>
                                    </div>



                                </div>

                            </div>
                            <div class="invoice-center">
                                <div class="col-sm-12 mb-30">
                                    <div class="invoice-number">
                                        <h4 class="inv-title-1">Địa điểm nhận:
                                            .............................................................................................................................................
                                        </h4>
                                        <h4 class="inv-title-1">Biển số: <span
                                                class="normal-text invo-addr-1"><?php echo $resultPDNL[0]['bienso']; ?></span>
                                        </h4>

                                        <h4 class="inv-title-1">Tài xế: <span
                                                class="normal-text invo-addr-1"><?php echo $resultPDNL[0]['tentaixe']; ?></span>
                                        </h4>
                                        <h4 class="inv-title-1">Đơn giá dầu sau thuế: <span
                                                class="normal-text invo-addr-1"><?php echo $formatted_dongiasauthue; ?>
                                                VNĐ / lít</span>
                                            <h4 class="inv-title-1">Số lượng dầu/xăng được cấp:
                                            </h4>
                                            <p class="invo-addr-1 mb-0">
                                                1. Dầu:
                                                ............<?php echo $resultPDNL[0]['soluongnhienlieu']; ?>..........(lít)
                                                x <?php echo $formatted_dongiasauthue; ?> =
                                                <?php echo $formatted_thanhtien; ?> VNĐ <br />
                                                2. Xăng: ....................... (lít) <br />
                                            </p>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <p class="invo-addr-1 mb-2 " style="    margin-left: 411px;">
                                            Ngày .... Tháng .... Năm 20....
                                        </p>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="important-note mb-3">
                                            <h3 class="inv-title-1">Người nhận</h3>
                                            <p class="mb-0 text-13">(Ký, ghi rõ họ tên)</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-offsite">
                                        <div class="text-end payment-info mb-30">

                                            <h3 class="inv-title-1">Người lập phiếu</h3>
                                            <p class="mb-0 text-13">(Ký, ghi rõ họ tên)</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-offsite">
                                        <br> <br> <br> <br> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-print">
                                <i class="fa fa-print"></i> Print Invoice
                            </a>
                            <a id="invoice_download_btn1" class="btn btn-lg btn-download btn-theme"
                                data-id-donhang="<?php echo $resultPDNL[0]['id_donhang']; ?>">
                                <i class="fa fa-download"></i> Download Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 3 end -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>