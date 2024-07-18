<?php
session_start();

include ('../doan/includes/connect.php');

$sql = "SELECT tintuc.id_tintuc, tintuc.tieude,tintuc.noidung,tintuc.img, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung,DATE(tintuc.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung,DATE(tintuc.ngaysua) as ngaysua FROM tintuc INNER JOIN nguoidung ON tintuc.id_nguoitao = nguoidung.id_nguoidung LEFT JOIN nguoidung AS nguoidung2 ON tintuc.id_nguoisua = nguoidung2.id_nguoidung WHERE 1
        ORDER BY tintuc.ngaytao ";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
$sql3 = "SELECT 
COUNT(*) AS tong_don_hang
FROM 
donhang
";
$stmt3 = $conn->prepare($sql3);
$query = $stmt3->execute();
$resultpt = $stmt3->fetch(PDO::FETCH_ASSOC);

$sql4 = "SELECT 
COUNT(*) AS so_luong_khach
FROM 
khachhang";
$stmt4 = $conn->prepare($sql4);
$query = $stmt4->execute();
$resultkh = $stmt4->fetch(PDO::FETCH_ASSOC);

$sql5 = "SELECT 
COUNT(*) AS so_xe
FROM 
xe";
$stmt5 = $conn->prepare($sql5);
$query = $stmt5->execute();
$resultxe = $stmt5->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PACIFIC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">



</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Đang tải...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.php" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">PACIFIC</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Trang chủ </a>
                <a href="news.php" class="nav-item nav-link">Tin tức</a>
                <a href="service.php" class="nav-item nav-link">Dịch vụ</a>

                <a href="contact.php" class="nav-item nav-link">Liên hệ</a>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="../doan/index.php" target="_blank" class="dropdown-item">Phần mềm nội bộ </a>

                    </div>
                </div>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+ 84 225 3273
                868
            </h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5">
        <div class="owl-carousel header-carousel position-relative mb-5">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(6, 3, 21, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Vận chuyển & Giải pháp
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">#1 Nơi dành cho <span
                                        class="text-primary">giải pháp vận chuyển</span> của bạn </h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">"Đối tác vận chuyển hàng hóa đáng tin cậy
                                    - Chào mừng bạn đến với công ty PACIFIC của chúng tôi!"</p>
                                <!-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Free Quote</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(6, 3, 21, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Vận chuyển & Giải pháp
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">#1 Nơi dành cho <span
                                        class="text-primary">giải pháp vận chuyển</span> của bạn </h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">"Vận chuyển hàng hóa một cách hiệu quả
                                    với công ty logistics chuyên nghiệp."</p>
                                <!-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Free Quote</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" style="boder-radius: 5px;">
        <div class="container py-5">
            <div class="text-center">
                <h6 class="text-secondary text-uppercase">News</h6>
                <h1 class="mb-0">Tin tức nổi bật!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <?php
                $count = 1;
                $hasData = false; // Biến kiểm tra dữ liệu
                foreach ($result as $items):
                    $hasData = true; // Đánh dấu có dữ liệu    ?>
                    <div class="testimonial-item p-4 my-5 team-item new mlr-20px service-item wow overflow-hidden"
                        style="min-height: 520px; min-width: 300px;     border-radius: 10px;">
                        <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                        <div class="d-flex justify-content-center mb-4 " style="min-height: 170px;">
                            <img class="img-fluid flex-shrink-0" src="images/<?php echo $items['img']; ?>"
                                style="width: 60%; height: 250px">
                        </div>
                        <div style="height: 228px">
                            <div class="mb-1" style=" font-size: 18px;color: black; min-height: 81px">
                                <b><?php echo $items['tieude']; ?></b>
                            </div>
                            <div class="content ellipsis-height overflow-hidden"
                                style="color: black; text-align: justify; min-height: 105px">
                                <?php echo $items['noidung']; ?>
                            </div>
                            <a class="btn-slide mt-2" href="news.php"><i class="fa fa-arrow-right"></i><span
                                    style="margin-left: -.4px; min-height:40.1px;">Đọc Thêm</span></a>
                        </div>
                    </div>


                <?php endforeach ?>







            </div>
        </div>
    </div>

    <!-- About Start -->

    <!-- About End -->

    <section name="sectionintro" id="sectionintro" class="container marketing content">
        <div class="container">
            <div class="introduce-header wow fadeIn" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3" style="text-align: center;">Introduce us</h6>
                <h1 text-align="center">Giới Thiệu</h1>
            </div>
            <div class="row wow fadeIn" data-wow-delay="0.1s" id="introduce" style="border-radius: 5px;">
                <div style="display: flex">
                    <div class="first-introduce w-50" style="position: relative;">
                        <div class="top-15 start-10 wow fadeIn" data-wow-delay="0.3s" style="position: absolute;">
                            <h2 style="color: white;">Về chúng tôi</h2>
                            <p style="color: white; text-align: justify;"><strong>PACIFIC GROUP</strong>
                                " xin gửi lời chào trân trọng nhất đến quý khách hàng."
                            </p>
                            <p style="color: white; text-align: justify;">Trước hết chúng tôi xin chân thành cảm ơn
                                những thiện chí và sự
                                hỗ trợ nhiệt tình của quý khách hàng trong thời gian vừa qua. Chúc quý khách hàng luôn
                                thành công và thuận
                                lợi.
                            </p>
                            <p style="color: white; text-align: justify;"><strong>PACIFIC GROUP</strong>
                                là doanh nghiệp năng động và uy tín trong lĩnh vực vận tải biển và giao nhận vận tải.
                                Với sự hiểu biết rộng
                                khắp hoạt động ngành, đội ngũ cán bộ nhân viên giàu kinh nghiệm và mạng lưới đại lý toàn
                                cầu, PACIFIC GROUP
                                có thể cung cấp dịch vận tải biển và giao nhận vận tải hoàn hảo, phục vụ mọi nhu cầu của
                                lô hàng của bạn,
                                tàu của bạn, ở bất kỳ nơi nào trên thế giới.

                            </p>
                            <p style="color: white; text-align: justify;"><strong>PACIFIC GROUP</strong>
                                hướng tới trở thành công ty dịch vụ vận tải biển và giao nhận vận tải chuyên nghiệp và
                                đáng tin cậy, khẳng
                                định chất lượng hàng đầu trên thị trường trong nước và quốc tế.
                            </p>
                        </div>
                    </div>
                    <div class="second-introduce " data-wow-delay="0.1s"
                        style="flex: 1; position: relative; padding: 15px;">
                        <div>
                            <img class="img-intro wow fadeInRight" data-wow-delay="0.1s"
                                src="https://www.pacificlt.com/wp-content/uploads/2021/09/gioi_thieu_pacific_logistics.jpg"
                                alt="gioi_thieu_pacific_logistics">
                            <img class="img-intro-2 wow fadeInRight" data-wow-delay="0.3s"
                                src="https://www.pacificlt.com/wp-content/uploads/2021/09/240481241_1779038898947403_8747757697644873293_n.jpg"
                                alt="gioi_thieu_pacific_logistics">
                        </div>
                    </div>
                </div>
            </div>
            <iframe class="video-intro wow fadeInUp" width="80%" height="auto" data-wow-delay="0.1s"
                src="https://www.youtube.com/embed/ssIgkbbvO24?si=ATai7Nd_Ks9I1fRx" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </section>

    <!-- <section name="locationMap" id="locationMap" class="container marketing content wow fadeIn" data-wow-delay="0.1s">
        <div class="introduce-header">
            <h1 align="center">Google Map </h1>
        </div>
        <div style="text-align: center; ">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.125757143237!2d106.68813245060494!3d20.86698083123905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7aef41ef07c9%3A0xf810c4da6afc5ba7!2zVMOyYSBOaMOgIFRow6BuaCDEkOG6oXQgMQ!5e0!3m2!1svi!2s!4v1708315897461!5m2!1svi!2s"
                style="width: 90%; height: 600px; border-radius: 5px; " allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>



    </section> -->

    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container about py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeInLeft" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/about.jpg"
                            style="object-fit: cover;" alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="text-secondary text-uppercase mb-3">About us</h6>
                    <h1 class="mb-5">Giải pháp Logistics và vận chuyển nhanh chóng</h1>
                    <p class="mb-5" style="text-align: justify;">Giải pháp Logistics và vận chuyển nhanh chóng giúp tối
                        ưu hóa quy trình lưu trữ, vận
                        chuyển và phân phối hàng hóa, đảm bảo hiệu quả và tốc độ. Bằng cách sử dụng công nghệ tiên tiến
                        và quản lý thông minh, doanh nghiệp có thể đáp ứng nhu cầu của khách hàng một cách nhanh chóng
                        và chính xác.
                    </p>
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <i class="fa fa-globe fa-3x text-primary mb-3"></i>
                            <h5>Trải dài toàn cầu</h5>
                            <p class="m-0" style="text-align: justify;">"Trải dài toàn cầu - Kết nối và vận chuyển hàng
                                hóa một cách liên tục và hiệu
                                quả trên khắp thế giới"</p>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                            <i class="fa fa-shipping-fast fa-3x text-primary mb-3"></i>
                            <h5>Chuyển hàng đúng giờ</h5>
                            <p class="m-0 " style="text-align: justify;">"Chuyển hàng đúng giờ - Chúng tôi cam kết đưa
                                hàng hóa của bạn đến đúng địa
                                điểm và thời gian hẹn một cách chính xác và tin cậy."</p>
                        </div>
                    </div>
                    <!-- <a href="" class="btn btn-primary py-3 px-5">Explore More</a> -->
                </div>
            </div>
        </div>
    </div>


    <!-- Fact Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Facts us</h6>
                    <h1 class="mb-5">#1 Nơi quản lý tất cả các đơn hàng của bạn</h1>
                    <p class="mb-5" style="text-align: justify;">Tất cả các đơn đặt hàng, hàng tồn kho, nhà cung cấp và
                        dữ liệu khách hàng của bạn
                        được đồng bộ hóa và tích hợp đầy đủ trên một hệ thống. Đơn hàng là nơi quản lý tất cả các đơn
                        hàng online, đơn đặt hàng trước, đơn cần vận chuyển (đơn gửi hãng vận chuyển, cần thu hộ tiền
                        COD).</p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                        <div class="ps-4">
                            <h6>Liên hệ!</h6>
                            <h3 class="text-primary m-0">+ 84 225 3273 868</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <div class="bg-primary p-4 mb-4 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-users fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">
                                    <?php echo $resultkh['so_luong_khach'] ?>
                                </h2>
                                <p class="text-white mb-0">Khách hàng</p>
                            </div>
                            <div class="bg-secondary p-4 wow fadeIn" data-wow-delay="0.5s">
                                <i class="fa fa-ship fa-2x text-white mb-3"></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up">
                                    <?php echo $resultpt['tong_don_hang']; ?>
                                </h2>
                                <p class="text-white mb-0">Đơn hàng hoàn thành</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-success p-4 wow fadeIn" data-wow-delay="0.7s">
                                <i class=" fa-2x fa-solid fa-truck text-white mb-3" s></i>
                                <h2 class="text-white mb-2" data-toggle="counter-up"><?php echo $resultxe['so_xe'] ?>
                                </h2>
                                <p class="text-white mb-0">Số lượng đầu xe</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->





    <!-- Feature Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container feature py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 feature-text wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Outstanding</h6>
                    <h1 class="mb-5">Chúng tôi là công ty Logistics</h1>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Dịch vụ toàn cầu</h5>
                            <p class="mb-0" style="text-align: justify;">Với mạng lưới rộng khắp, chúng tôi cung cấp các
                                giải pháp đa dạng từ vận chuyển hàng hóa đến dịch vụ tài chính, từ thương mại điện tử
                                đến dịch vụ khách hàng. Khả năng tương tác linh hoạt, kết hợp với công nghệ tiên tiến,
                                giúp chúng tôi đáp ứng mọi nhu cầu của khách hàng một cách nhanh chóng và chuyên nghiệp
                                nhất. Hãy để chúng tôi là đối tác tin cậy của bạn trong mọi thách thức kinh doanh toàn
                                cầu!</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-shipping-fast text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Giao hàng đúng hẹn</h5>
                            <p class="mb-0" style="text-align: justify;">Chúng tôi hiểu rằng thời gian là quan trọng đối
                                với mỗi khách hàng, và việc đảm bảo hàng hóa được giao đúng thời gian là ưu tiên hàng
                                đầu của chúng tôi. Với hệ thống quản lý vận chuyển thông minh và đội ngũ nhân viên
                                chuyên nghiệp, chúng tôi luôn cố gắng hết mình để đảm bảo mỗi lô hàng đều đến đúng địa
                                điểm và đúng thời gian nhất có thể. </p>
                        </div>
                    </div>
                    <div class="d-flex mb-0 wow fadeInUp" data-wow-delay="0.7s">
                        <i class="fa fa-headphones text-primary fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Hỗ trợ 24/7</h5>
                            <p class="mb-0" style="text-align: justify;">Cam kết của chúng tôi để đảm bảo rằng mọi nhu
                                cầu của bạn được đáp ứng mọi lúc, mọi nơi. Không phân biệt múi giờ hoặc ngày đêm, đội
                                ngũ hỗ trợ của chúng tôi luôn sẵn lòng để giải đáp mọi thắc mắc, xử lý mọi vấn đề hoặc
                                cung cấp sự hỗ trợ kỹ thuật nhanh chóng và hiệu quả. Qua điện thoại, email, hoặc các
                                kênh trực tuyến khác, bạn có thể yên tâm rằng chúng tôi sẽ luôn ở đây để giúp đỡ bạn mọi
                                lúc, mọi nơi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0 wow fadeInRight" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/feature.jpg"
                            style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <div id="counter" stt>
        <?php include 'counter.php'; ?>
    </div>
    <div class="bg-dark text-light" style="float: right;  border-top-left-radius: 10px; border-top-right-radius: 10px; " >
        <div class>
        <p class="" style="float: right; margin: 10px 10px 0 10px;"><i class="fa-solid fa-eye"></i> Online: <span id="current_visitors"></span> </p>
        <p  class="" style="float: right; margin-right: 15px;"><i class="fa-solid fa-globe"></i> Truy cập: <span id="total_visitors"></span></p>
        </div>
    </div>

    <?php
    include 'check.html';
    ?>
    <!-- Feature End -->
    <!-- Service Start -->

    <!-- Service End -->







    <!-- Team Start -->
    <!-- <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Leaders</h6>
                <h1 class="mb-5">Đội ngũ lãnh đạo của chúng tôi</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="images/gddh.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Đinh Văn Tuấn</h5>
                        <p>Tổng giám đốc</p>
                        <div class="btn-slide mt-1">
                            <i class="fa fa-share"></i>
                            <span>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="images/phochutich.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Nguyễn Hoài Bảo</h5>
                        <p>Phó chủ tịch</p>
                        <div class="btn-slide mt-1">
                            <i class="fa fa-share"></i>
                            <span>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="images/giamdoc.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Lê Ngọc Ánh Minh</h5>
                        <p>Chủ tịch</p>
                        <div class="btn-slide mt-1">
                            <i class="fa fa-share"></i>
                            <span>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.9s">
                    <div class="team-item p-4">
                        <div class="overflow-hidden mb-4">
                            <img class="img-fluid" src="images/oo.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Phạm Thanh Tùng</h5>
                        <p>Giám đốc kinh doanh</p>
                        <div class="btn-slide mt-1">
                            <i class="fa fa-share"></i>
                            <span>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Team End -->


    <!-- Testimonial Start -->

    <!-- Testimonial End -->
    

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s"
        style="margin-top: 45px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
       
    
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4">Địa Chỉ</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>622-624, Tòa nhà Thành Đạt 1, Số 3 Lê Thánh
                        Tông, TP Hải Phòng.</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+ 84 225 3273 868</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@pacificlt.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4">Dịch Vụ</h4>
                    <a class="btn btn-link" href="service/vanchuyenhangkhong.php">Vận Chuyển Hàng Không</a>
                    <a class="btn btn-link" href="service/thuongmainoidiavaquocte.php">Thương Mại Nội Địa Và Quốc Tế</a>
                    <a class="btn btn-link" href="service/vanchuyenduongbien.php">Vận Chuyển Đường Biển</a>
                    <a class="btn btn-link" href="service/doortodoor.php">Door To Door</a>
                    <a class="btn btn-link" href="service/khaithuehaiquanvaduan.php">Khai Thuê Hàng Hải Quan và Hàng Dự
                        Án</a>
                    <a class="btn btn-link" href="service/nvocc.php">Dịch Vụ NVOCC</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="#sectionintro">Về Chúng Tôi</a>
                    <a class="btn btn-link" href="contact.php">Liên Lạc</a>
                    <a class="btn btn-link" href="service.php">Dịch vụ của chúng tôi</a>
                </div>

            </div>
        </div>
        <hr>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>