<?php
session_start();
include ('includes/connect.php');

$id_donhang = $_POST['id_donhang'];
// echo $id_donhang;
$sqlDonHang = "SELECT hanghoa.ten as tenhanghoa, nhomhanghoa.ten as tennhomhanghoa,donhang.sokg,donhang.culy,donhang.dautieuthu ,donhang.nguoigiaonhan,donhang.dienthoai,tuyenvantai.ten as tentuyenvt,tuyenvantai.diemdau,tuyenvantai.diemcuoi,donhang.id_sales,nhansu.ten as tensale,donhang.id_hangtau,chiphivantai.id_donhang,DATE(chiphivantai.ngaytao) as ngaytao, khachhang.email,khachhang.diachi,khachhang.masothue,
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
INNER JOIN hanghoa ON hanghoa.id_hanghoa = donhang.id_hanghoa 
INNER JOIN nhomhanghoa ON nhomhanghoa.id_nhomhanghoa = donhang.id_nhomhanghoa 
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

$tiencoc = 10 / 100 * $resultDH[0]['tongchiphi'];
$formatted_tiencoc = number_format($tiencoc, 0, ',', ',');

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Contract</title>
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

    <script>
        function Export2Word(element, filename = '') {
            var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
            var postHtml = "</body></html>";
            var html = preHtml + document.getElementById(element).innerHTML + postHtml;

            var blob = new Blob(['\ufeff', html], {
                type: 'application/msword'
            });

            // Specify link url
            var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

            // Specify file name
            filename = filename ? filename + '.doc' : 'document.doc';

            // Create download link element
            var downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = url;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }

            document.body.removeChild(downloadLink);
        }
    </script>
</head>

<body>

    <!-- Invoice 6 start -->
    <div id="exportContent">

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
                                        <div class="col-sm-6" contenteditable>
                                            <div class="invoice-contact-us">
                                                <h1>Contact Us</h1>
                                                <ul class="link">
                                                    <li>
                                                        <i class="fa fa-map-marker"></i>Brand 1: Dinh Vu Industrial
                                                        Park,
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
                                                        <i class="fa fa-phone"></i> <a href="tel:+55-417-634-7071">+00
                                                            123
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
                                                <h1 class="invoice-name" contenteditable>Contract</h1>
                                            </div>
                                            <div class="col-sm-6 mb-30">
                                                <div class="invoice-number-inner">
                                                    <h2 class="name" contenteditable>Contract No:
                                                        <?php echo '#' . $resultDH[0]['id_donhang']; ?>
                                                    </h2>
                                                    <p class="mb-0" contenteditable>Contract Date:
                                                        <span><?php echo date('d-m-Y', strtotime($resultDH[0]['ngaytao'])); ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-30">
                                                <div class="invoice-number">
                                                    <h4 class="inv-title-1">Contract To</h4>
                                                    <h2 class="name mb-10" contenteditable>
                                                        <?php echo $resultDH[0]['tenkh']; ?>
                                                    </h2>
                                                    <p class="invo-addr-1 mb-0" contenteditable>
                                                        <i class="fa fa-envelope"></i>
                                                        <?php echo $resultDH[0]['email']; ?>
                                                        <br />
                                                        <i class="fa fa-map-marker" contenteditable></i>
                                                        <?php echo $resultDH[0]['diachi']; ?> <br />
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-30">
                                                <div class="invoice-number" contenteditable>
                                                    <div class="invoice-number-inner">
                                                        <h4 class="inv-title-1">Contract From</h4>
                                                        <h2 class="name mb-10"> PACIFIC LOGISTICS JOINT STOCK COMPANY
                                                        </h2>
                                                        <p class="invo-addr-1 mb-0">
                                                            <i class="fa fa-envelope"></i> pacific@gmail.com <br />
                                                            <i class="fa fa-map-marker"></i> Brand 1: Dinh Vu Industrial
                                                            Park, Dong
                                                            Hai 2
                                                            Ward, Hai An District, Hai Phong City, Vietnam. <br />
                                                            <i class="fa fa-map-marker"></i> Brand 2: No. 3A Dien Bien
                                                            Phu,
                                                            Ward 25,
                                                            Binh Thanh District, Ho Chi Minh City, Vietnam. <br />
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h3 class="inv-title-1 mb-10">Customer Information:</h3>
                                        <ul class="payment-method-list-1 text-14" contenteditable>
                                            <li><strong>Name:</strong> <?php echo $resultDH[0]['tenkh']; ?></li>
                                            <li><strong>Mã số thuế:</strong> <?php echo $resultDH[0]['masothue']; ?>
                                            </li>
                                            <li><strong>Address:</strong> <?php echo $resultDH[0]['diachi']; ?></li>
                                            <li><strong>Người giao/nhận:</strong>
                                                <?php echo $resultDH[0]['nguoigiaonhan']; ?></li>
                                            <li><strong>Số điện thoại:</strong> <?php echo $resultDH[0]['dienthoai']; ?>
                                            </li>
                                        </ul>

                                        <h3 class="inv-title-1 mb-10">Booking Information:</h3>
                                        <ul class="payment-method-list-1 text-14" contenteditable>
                                            <li><strong>Sales:</strong> <?php echo $resultDH[0]['tensale']; ?></li>
                                            <li><strong>Lines:</strong> <?php echo $resultDH[0]['id_hangtau']; ?></li>
                                            <li><strong>Loại hàng:</strong> <?php echo $resultDH[0]['tenhanghoa']; ?>
                                            </li>
                                            <li><strong>Nhóm hàng:</strong>
                                                <?php echo $resultDH[0]['tennhomhanghoa']; ?>
                                            </li>
                                            <li><strong>Trọng lượng:</strong> <?php echo $resultDH[0]['sokg']; ?></li>
                                            <li><strong>Điểm đầu:</strong> <?php echo $resultDH[0]['diemdau']; ?></li>
                                            <li><strong>Điểm cuối:</strong> <?php echo $resultDH[0]['diemcuoi']; ?></li>
                                            <li><strong>Tuyến vận tải:</strong>
                                                <?php echo $resultDH[0]['tentuyenvt']; ?>
                                            </li>
                                            <li><strong>Cự ly(dự kiến):</strong> <?php echo $resultDH[0]['culy']; ?>
                                            </li>
                                            <li><strong>Dầu tiêu thụ(dự kiến):</strong>
                                                <?php echo $resultDH[0]['dautieuthu']; ?></li>

                                        </ul>

                                        <h3 class="inv-title-1 mb-10">Service Information:</h3>
                                        <ul class="payment-method-list-1 text-14" contenteditable>
                                            <li><strong>Cost of 1kg:</strong> 500 VNĐ</li>
                                            <li><strong>Cost of duel:</strong> 19.500 VNĐ</li>

                                        </ul>

                                    </div>

                                    <div class="invoice-center">
                                        <div class="order-summary">
                                            <div class="table-outer">
                                                <h3 class="inv-title-1 mb-10">Cost Information:</h3>
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
                                                            <td contenteditable>
                                                                <?php echo $formatted_thanhtienkg . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_thanhtienkg . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fuel Fee (Phí nhiên liệu)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_thanhtiennhienlieu . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_thanhtiennhienlieu . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Empty Container Fee (Phí cước vỏ)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tiencuocvo . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tiencuocvo . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customs Fee (Phí hải quan)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienhaiquan . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienhaiquan . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Handling Fee (Phí nâng hạ)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tiennangha . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tiennangha . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Other Charges (Phí khác)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienkhac . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienkhac . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Toll Fee (Phí cầu đường)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_phicauduong . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_phicauduong . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Meal Allowance (Tiền ăn ca)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienanca . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienanca . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Trip Wage (Lương chuyến)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_luongchuyen . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_luongchuyen . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sunday Wage (Lương chủ nhật)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_luongchunhat . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_luongchunhat . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Out-of-route Fee (Tiền thua xe ngoài)</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienthuexengoai . ' VNĐ'; ?>
                                                            </td>
                                                            <td>0 VNĐ</td>
                                                            <td contenteditable>
                                                                <?php echo $formatted_tienthuexengoai . ' VNĐ'; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Total Due</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td contenteditable>
                                                                <strong><?php echo $formatted_tongchiphi . ' VNĐ'; ?></strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-bottom">
                                        <div class="row" contenteditable>
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
                                                    <p class="text-muted">Tiền cọc 10%:
                                                        <strong><?php echo $formatted_tiencoc . ' VNĐ'; ?>.</strong>
                                                    </p>
                                                    <p class="text-muted">A finance charge of 1.5% will be made on
                                                        unpaid
                                                        balances after
                                                        <strong><?php echo date('d-m-Y', strtotime($resultDH[0]['hanthanhtoan'])); ?>.</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invoice-bottom" contenteditable>
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    <p class="invo-addr-1 mb-2 " style="    margin-left: 411px;">
                                                        Ngày .... Tháng .... Năm 20....
                                                    </p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="important-note mb-3">
                                                        <h3 class="inv-title-1">Khách hàng</h3>
                                                        <p class="mb-0 text-13">(Ký, ghi rõ họ tên)</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-offsite">
                                                    <div class="text-end payment-info mb-30">

                                                        <h3 class="inv-title-1">Người lên hợp đồng</h3>
                                                        <p class="mb-0 text-13">(Ký, ghi rõ họ tên)</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-offsite">
                                                    <br> <br> <br> <br> <br>
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
                                    <i class="fa fa-print"></i> Print Contract
                                </a>
                                <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme"
                                    data-id-donhang="<?php echo $resultDH[0]['id_donhang']; ?>"
                                    data-ngaytao="<?php echo $resultDH[0]['ngaytao']; ?>">
                                    <i class="fa fa-download"></i> Download Contract
                                </a>

                                <!-- <button onclick="Export2Word('exportContent');">Word</button> -->
                                <button onclick="Export2Word('exportContent', 'word-content.docx');">Export as .docx</button>
                            </div>
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

    <script>
        /* Shivving (IE8 is not supported, but at least it won't look as awful)
    /* ========================================================================== */

        (function (document) {
            var
                head = document.head = document.getElementsByTagName('head')[0] || document.documentElement,
                elements = 'article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output picture progress section summary time video x'.split(' '),
                elementsLength = elements.length,
                elementsIndex = 0,
                element;

            while (elementsIndex < elementsLength) {
                element = document.createElement(elements[++elementsIndex]);
            }

            element.innerHTML = 'x<style>' +
                'article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}' +
                'audio[controls],canvas,video{display:inline-block}' +
                '[hidden],audio{display:none}' +
                'mark{background:#FF0;color:#000}' +
                '</style>';

            return head.insertBefore(element.lastChild, head.firstChild);
        })(document);

        /* Prototyping
        /* ========================================================================== */

        (function (window, ElementPrototype, ArrayPrototype, polyfill) {
            function NodeList() { [polyfill] }
            NodeList.prototype.length = ArrayPrototype.length;

            ElementPrototype.matchesSelector = ElementPrototype.matchesSelector ||
                ElementPrototype.mozMatchesSelector ||
                ElementPrototype.msMatchesSelector ||
                ElementPrototype.oMatchesSelector ||
                ElementPrototype.webkitMatchesSelector ||
                function matchesSelector(selector) {
                    return ArrayPrototype.indexOf.call(this.parentNode.querySelectorAll(selector), this) > -1;
                };

            ElementPrototype.ancestorQuerySelectorAll = ElementPrototype.ancestorQuerySelectorAll ||
                ElementPrototype.mozAncestorQuerySelectorAll ||
                ElementPrototype.msAncestorQuerySelectorAll ||
                ElementPrototype.oAncestorQuerySelectorAll ||
                ElementPrototype.webkitAncestorQuerySelectorAll ||
                function ancestorQuerySelectorAll(selector) {
                    for (var cite = this, newNodeList = new NodeList; cite = cite.parentElement;) {
                        if (cite.matchesSelector(selector)) ArrayPrototype.push.call(newNodeList, cite);
                    }

                    return newNodeList;
                };

            ElementPrototype.ancestorQuerySelector = ElementPrototype.ancestorQuerySelector ||
                ElementPrototype.mozAncestorQuerySelector ||
                ElementPrototype.msAncestorQuerySelector ||
                ElementPrototype.oAncestorQuerySelector ||
                ElementPrototype.webkitAncestorQuerySelector ||
                function ancestorQuerySelector(selector) {
                    return this.ancestorQuerySelectorAll(selector)[0] || null;
                };
        })(this, Element.prototype, Array.prototype);

        /* Helper Functions
        /* ========================================================================== */

        function generateTableRow() {
            var emptyColumn = document.createElement('tr');

            emptyColumn.innerHTML = '<td><a class="cut">-</a><span contenteditable></span></td>' +
                '<td><span contenteditable></span></td>' +
                '<td><span data-prefix>$</span><span contenteditable>0.00</span></td>' +
                '<td><span contenteditable>0</span></td>' +
                '<td><span data-prefix>$</span><span>0.00</span></td>';

            return emptyColumn;
        }

        function parseFloatHTML(element) {
            return parseFloat(element.innerHTML.replace(/[^\d\.\-]+/g, '')) || 0;
        }

        function parsePrice(number) {
            return number.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,');
        }

        /* Update Number
        /* ========================================================================== */

        function updateNumber(e) {
            var
                activeElement = document.activeElement,
                value = parseFloat(activeElement.innerHTML),
                wasPrice = activeElement.innerHTML == parsePrice(parseFloatHTML(activeElement));

            if (!isNaN(value) && (e.keyCode == 38 || e.keyCode == 40 || e.wheelDeltaY)) {
                e.preventDefault();

                value += e.keyCode == 38 ? 1 : e.keyCode == 40 ? -1 : Math.round(e.wheelDelta * 0.025);
                value = Math.max(value, 0);

                activeElement.innerHTML = wasPrice ? parsePrice(value) : value;
            }

            updateInvoice();
        }

        /* Update Invoice
        /* ========================================================================== */

        function updateInvoice() {
            var total = 0;
            var cells, price, total, a, i;

            // update inventory cells
            // ======================

            for (var a = document.querySelectorAll('table.inventory tbody tr'), i = 0; a[i]; ++i) {
                // get inventory row cells
                cells = a[i].querySelectorAll('span:last-child');

                // set price as cell[2] * cell[3]
                price = parseFloatHTML(cells[2]) * parseFloatHTML(cells[3]);

                // add price to total
                total += price;

                // set row total
                cells[4].innerHTML = price;
            }

            // update balance cells
            // ====================

            // get balance cells
            cells = document.querySelectorAll('table.balance td:last-child span:last-child');

            // set total
            cells[0].innerHTML = total;

            // set balance and meta balance
            cells[2].innerHTML = document.querySelector('table.meta tr:last-child td:last-child span:last-child').innerHTML = parsePrice(total - parseFloatHTML(cells[1]));

            // update prefix formatting
            // ========================

            var prefix = document.querySelector('#prefix').innerHTML;
            for (a = document.querySelectorAll('[data-prefix]'), i = 0; a[i]; ++i) a[i].innerHTML = prefix;

            // update price formatting
            // =======================

            for (a = document.querySelectorAll('span[data-prefix] + span'), i = 0; a[i]; ++i) if (document.activeElement != a[i]) a[i].innerHTML = parsePrice(parseFloatHTML(a[i]));
        }

        /* On Content Load
        /* ========================================================================== */

        function onContentLoad() {
            updateInvoice();

            var
                input = document.querySelector('input'),
                image = document.querySelector('img');

            function onClick(e) {
                var element = e.target.querySelector('[contenteditable]'), row;

                element && e.target != document.documentElement && e.target != document.body && element.focus();

                if (e.target.matchesSelector('.add')) {
                    document.querySelector('table.inventory tbody').appendChild(generateTableRow());
                }
                else if (e.target.className == 'cut') {
                    row = e.target.ancestorQuerySelector('tr');

                    row.parentNode.removeChild(row);
                }

                updateInvoice();
            }

            function onEnterCancel(e) {
                e.preventDefault();

                image.classList.add('hover');
            }

            function onLeaveCancel(e) {
                e.preventDefault();

                image.classList.remove('hover');
            }

            function onFileInput(e) {
                image.classList.remove('hover');

                var
                    reader = new FileReader(),
                    files = e.dataTransfer ? e.dataTransfer.files : e.target.files,
                    i = 0;

                reader.onload = onFileLoad;

                while (files[i]) reader.readAsDataURL(files[i++]);
            }

            function onFileLoad(e) {
                var data = e.target.result;

                image.src = data;
            }

            if (window.addEventListener) {
                document.addEventListener('click', onClick);

                document.addEventListener('mousewheel', updateNumber);
                document.addEventListener('keydown', updateNumber);

                document.addEventListener('keydown', updateInvoice);
                document.addEventListener('keyup', updateInvoice);

                input.addEventListener('focus', onEnterCancel);
                input.addEventListener('mouseover', onEnterCancel);
                input.addEventListener('dragover', onEnterCancel);
                input.addEventListener('dragenter', onEnterCancel);

                input.addEventListener('blur', onLeaveCancel);
                input.addEventListener('dragleave', onLeaveCancel);
                input.addEventListener('mouseout', onLeaveCancel);

                input.addEventListener('drop', onFileInput);
                input.addEventListener('change', onFileInput);
            }
        }

        window.addEventListener && document.addEventListener('DOMContentLoaded', onContentLoad);

    </script>
</body>

</html>