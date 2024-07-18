<?php
$conn = new PDO('mysql:host=localhost;dbname=qlxe', 'root', '');
if (empty($_POST['submit'])) {
    $sql = "select tieude, noidung, img, date(ngaytao) from tintuc";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Logistics - Tin Tức</title>
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
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="index.php" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">Logistica</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Trang Chủ</a>
                <a href="news.php" class="nav-item nav-link active">Tin Tức</a>
                <a href="service.php" class="nav-item nav-link">Dịch Vụ</a>
                
                <a href="contact.php" class="nav-item nav-link">Liên Hệ</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+ 84 225 3273 868
            </h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown" style="text-align: left;">Tin Tức</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Trang Chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="Tin Tức">Tin Tức</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <hr>

    <section id="latestnews1" name="latestnews1" class="container marketing content">
        <button type="button" class="btn btn-primary" style="margin: 10px 10px 10px 0;"><a href="index.php"
                style="color: white;">Quay lại</a></button>
        <?php foreach ($result as $items): ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blog-tester">
                <article class="post">
                    <div>
                        <header class="post-header">
                            <div class="day">
                                <?php echo $items['date(ngaytao)']; ?>
                            </div>
                            <h2 class="entry-title" style="font-size: 30px;">
                                <a class="animation-link" href="blog-details.html" title="Superb Slider Gallery Post">
                                    <span class="bt-holder">
                                        <span class="bt_readmore_btn">
                                            <?php echo $items['tieude']; ?>
                                        </span>
                                    </span>
                                </a>
                            </h2>
                          
                        </header>
                        <div class="image-container" style="text-align: center;">
                            <img alt="" class="thumb" width="60%" height="auto"
                                src="images/<?php echo $items['img']; ?>">
                        </div>
                        <div class=" mt-4">
                            <div class="" style="text-align: justify;">
                                <?php echo $items['noidung']; ?>

                            </div>

                        </div>
                    </div>

            </div>
            </article>
            </div>
        <?php endforeach; ?>



    </section>

    <hr>



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" 
    style="margin-top: 6rem;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
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
                    <h4 class="text-light mb-4">Services</h4>
                    <a class="btn btn-link" href="service/vanchuyenhangkhong.php">Vận Chuyển Hàng Không</a>
                    <a class="btn btn-link" href="service/thuongmainoidiavaquocte.php">Thương Mại Nội Địa Và Quốc Tế</a>
                    <a class="btn btn-link" href="service/vanchuyenduongbien.php">Vận Chuyển Đường Biển</a>
                    <a class="btn btn-link" href="service/doortodoor.php">Door To Door</a>
                    <a class="btn btn-link" href="service/khaithuehaiquanvaduan.php">Khai Thuê Hàng Hải Quan và Hàng Dự Án</a>
                    <a class="btn btn-link" href="service/nvocc.php">Dịch Vụ NVOCC</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="index.php">Về Chúng Tôi</a>
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