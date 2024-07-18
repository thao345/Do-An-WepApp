<?php
session_start();
include ('includes/connect.php');

$id_donhang = $_POST['id_donhang'];
// echo $id_donhang;
$sqlDonHang = "SELECT chiphivantai.id_donhang,DATE(chiphivantai.ngaytao) as ngaytao, khachhang.email,khachhang.diachi,
khachhang.ten as tenkh, khachhang.id_khachhang ,donhang.sokg * 500 as thanhtienkg,phieudonhienlieu.thanhtien as thanhtiennhienlieu,
chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,
chiphivantai.phicauduong,chiphivantai.tienanca,chiphivantai.luongchuyen,chiphivantai.luongchunhat,chiphivantai.tienthuexengoai,
chiphivantai.tongchiphi,donhang.hanthanhtoan
FROM donhang 
INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang 
 WHERE donhang.id_donhang  ='$id_donhang'";

$stmt1 = $conn->prepare($sqlDonHang);
$query1 = $stmt1->execute();
$resultDH = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultDH[] = $row;
}


$thanhtienkg = $resultDH[0]['thanhtienkg'];
$formatted_thanhtienkg = number_format($thanhtienkg, 0, ',', ',');

$thanhtiennhienlieu = $resultDH[0]['thanhtiennhienlieu'];
$formatted_thanhtiennhienlieu = number_format($thanhtiennhienlieu, 0, ',', ',');

$tiencuocvo = $resultDH[0]['tiencuocvo'];
$formatted_tiencuocvo = number_format($tiencuocvo, 0, ',', ',');

$tienhaiquan = $resultDH[0]['tienhaiquan'];
$formatted_tienhaiquan = number_format($tienhaiquan, 0, ',', ',');

$tiennangha = $resultDH[0]['tiennangha'];
$formatted_tiennangha = number_format($tiennangha, 0, ',', ',');

$tienkhac = $resultDH[0]['tienkhac'];
$formatted_tienkhac = number_format($tienkhac, 0, ',', ',');

$phicauduong = $resultDH[0]['phicauduong'];
$formatted_phicauduong = number_format($phicauduong, 0, ',', ',');

$tienanca = $resultDH[0]['tienanca'];
$formatted_tienanca = number_format($tienanca, 0, ',', ',');

$luongchuyen = $resultDH[0]['luongchuyen'];
$formatted_luongchuyen = number_format($luongchuyen, 0, ',', ',');

$luongchunhat = $resultDH[0]['luongchunhat'];
$formatted_luongchunhat = number_format($luongchunhat, 0, ',', ',');

$tienthuexengoai = $resultDH[0]['tienthuexengoai'];
$formatted_tienthuexengoai = number_format($tienthuexengoai, 0, ',', ',');

$tongchiphi = $resultDH[0]['tongchiphi'];
$formatted_tongchiphi = number_format($tongchiphi, 0, ',', ',');

$tongchiphithem = 1.5 / 100 * $resultDH[0]['tongchiphi'];
$formatted_tongchiphithem = number_format($tongchiphithem, 0, ',', ',');

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Invoice</title>
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

    <!-- Invoice 6 start -->
    <div class="invoice-6 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner clearfix">
                        <div class="invoice-info clearfix" id="invoice_wrapper">
                            <div class="invoice-headar">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-logo">
                                            <!-- logo started -->
                                            <div class="logo">
                                                <img src="assets/img/logos/logo-rm.png" alt="logo">
                                            </div>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-contact-us">
                                            <h1>Contact Us</h1>
                                            <ul class="link">
                                                <li>
                                                    <i class="fa fa-map-marker"></i>Brand 1: Dinh Vu Industrial Park,
                                                    Dong Hai 2
                                                    Ward, Hai An District, Hai Phong City, Vietnam.
                                                </li>
                                                <li>
                                                    <i class="fa fa-map-marker"></i>Brand 2: No. 3A Dien Bien Phu,
                                                    Ward 25,
                                                    Binh Thanh District, Ho Chi Minh City, Vietnam.
                                                </li>
                                                <li>
                                                    <i class="fa fa-envelope"></i> <a
                                                        href="mailto:sales@hotelempire.com">pacific@gmail.com</a>
                                                </li>
                                                <li>
                                                    <i class="fa fa-phone"></i> <a href="tel:+55-417-634-7071">+00 123
                                                        647 840</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-contant">
                                <div class="invoice-top">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h1 class="invoice-name">Invoice</h1>
                                        </div>
                                        <div class="col-sm-6 mb-30">
                                            <div class="invoice-number-inner">
                                                <h2 class="name">Invoice No:
                                                    <?php echo '#' . $resultDH[0]['id_donhang']; ?>
                                                </h2>
                                                <p class="mb-0">Invoice Date:
                                                    <span><?php echo date('d-m-Y', strtotime($resultDH[0]['ngaytao'])); ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-30">
                                            <div class="invoice-number">
                                                <h4 class="inv-title-1">Invoice To</h4>
                                                <h2 class="name mb-10"><?php echo $resultDH[0]['tenkh']; ?></h2>
                                                <p class="invo-addr-1 mb-0">
                                                    <i class="fa fa-envelope"></i> <?php echo $resultDH[0]['email']; ?>
                                                    <br />
                                                    <i class="fa fa-map-marker"></i>
                                                    <?php echo $resultDH[0]['diachi']; ?> <br />
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-30">
                                            <div class="invoice-number">
                                                <div class="invoice-number-inner">
                                                    <h4 class="inv-title-1">Invoice From</h4>
                                                    <h2 class="name mb-10"> PACIFIC LOGISTICS JOINT STOCK COMPANY
                                                    </h2>
                                                    <p class="invo-addr-1 mb-0">
                                                        <i class="fa fa-envelope"></i> pacific@gmail.com <br />
                                                        <i class="fa fa-map-marker"></i> Brand 1: Dinh Vu Industrial
                                                        Park, Dong
                                                        Hai 2
                                                        Ward, Hai An District, Hai Phong City, Vietnam. <br />
                                                        <i class="fa fa-map-marker"></i> Brand 2: No. 3A Dien Bien Phu,
                                                        Ward 25,
                                                        Binh Thanh District, Ho Chi Minh City, Vietnam. <br />
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-center">
                                    <div class="order-summary">
                                        <div class="table-outer">
                                            <table style="margin-top: 30px;" class="default-table invoice-table">
                                                <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <th>Price</th>
                                                        <th>VAT (20%)</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>Weight Fee (Phí trọng lượng)</td>
                                                        <td><?php echo $formatted_thanhtienkg . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_thanhtienkg . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fuel Fee (Phí nhiên liệu)</td>
                                                        <td><?php echo $formatted_thanhtiennhienlieu . ' VNĐ'; ?> </td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_thanhtiennhienlieu . ' VNĐ'; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Empty Container Fee (Phí cước vỏ)</td>
                                                        <td><?php echo $formatted_tiencuocvo . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tiencuocvo . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customs Fee (Phí hải quan)</td>
                                                        <td><?php echo $formatted_tienhaiquan . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tienhaiquan . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Handling Fee (Phí nâng hạ)</td>
                                                        <td><?php echo $formatted_tiennangha . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tiennangha . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other Charges (Phí khác)</td>
                                                        <td><?php echo $formatted_tienkhac . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tienkhac . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toll Fee (Phí cầu đường)</td>
                                                        <td><?php echo $formatted_phicauduong . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_phicauduong . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Meal Allowance (Tiền ăn ca)</td>
                                                        <td><?php echo $formatted_tienanca . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tienanca . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trip Wage (Lương chuyến)</td>
                                                        <td><?php echo $formatted_luongchuyen . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_luongchuyen . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sunday Wage (Lương chủ nhật)</td>
                                                        <td><?php echo $formatted_luongchunhat . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_luongchunhat . ' VNĐ'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Out-of-route Fee (Tiền thua xe ngoài)</td>
                                                        <td><?php echo $formatted_tienthuexengoai . ' VNĐ'; ?></td>
                                                        <td>0 VNĐ</td>
                                                        <td><?php echo $formatted_tienthuexengoai . ' VNĐ'; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Total Due</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong><?php echo $formatted_tongchiphi . ' VNĐ'; ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-bottom">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <div class="terms-conditions mb-30">
                                                <h3 class="inv-title-1 mb-10">Terms & Conditions</h3>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy.
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5">
                                            <div class="payment-method mb-30">
                                                <h3 class="inv-title-1 mb-10">Payment Method</h3>
                                                <ul class="payment-method-list-1 text-14">
                                                    <li><strong>Account No:</strong> 0300 4124 9999</li>
                                                    <li><strong>Account Name:</strong> PACIFIC</li>
                                                    <li><strong>Bank Name:</strong> Sacombank</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="nates mb-30">
                                                <h4 class="inv-title-1">Notes</h4>
                                                <p class="text-muted">A finance charge of 1.5% will be made on unpaid
                                                    balances after
                                                    <strong><?php echo date('d-m-Y', strtotime($resultDH[0]['hanthanhtoan'])); ?>.</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <!-- <a href="javascript:history.back()" class="btn btn-lg btn-success">
                                <i class="fa fa-arrow-left"></i> Back
                            </a> -->
                            <a href="javascript:window.print()" class="btn btn-lg btn-print">
                                <i class="fa fa-print"></i> Print Invoice
                            </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme"
                                data-id-donhang="<?php echo $resultDH[0]['id_donhang']; ?>"
                                data-ngaytao="<?php echo $resultDH[0]['ngaytao']; ?>">
                                <i class="fa fa-download"></i> Download Invoice
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 6 end -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>