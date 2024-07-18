<?php
// Định nghĩa các biến và chức năng làm sạch
$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

// Kiểm tra xem có bấm nút submit không
if (isset($_POST["submit"])) {
    // Kiểm tra tên
    if (empty($_POST["name"])) {
        $error .= '<script type="text/javascript">
        alert("Vui lòng tên của bạn"); 
    </script>
';
    } else {
        $name = clean_text($_POST["name"]);
        if (!preg_match("/^[\p{L} ]*$/u", $name)) {
            $error .= '<script type="text/javascript">
            alert("Chỉ được nhập chữ cái"); 
        </script>
';
        }
    }

    // Kiểm tra email
    if (empty($_POST["email"])) {
        $error .= '<script type="text/javascript">
        alert("Vui lòng nhập email"); 
    </script>
';
    } else {
        $email = clean_text($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= '<script type="text/javascript">
            alert("Định dạng email không hợp lệ"); 
        </script>
    ';
        }
    }

    // Kiểm tra chủ đề
    if (empty($_POST["subject"])) {
        $error .= '<script type="text/javascript">
        alert("Vui lòng nhập chủ đề"); 
    </script>
';
    } else {
        $subject = clean_text($_POST["subject"]);
    }

    // Kiểm tra tin nhắn
    if (empty($_POST["message"])) {
        $error .= '<script type="text/javascript">
        alert("Vui lòng nhập tin nhắn"); 
    </script>
';
    } else {
        $message = clean_text($_POST["message"]);
    }

    // Nếu không có lỗi, gửi email
    if ($error == '') {
        require "PHPMailer-master/src/PHPMailer.php"; 
        require "PHPMailer-master/src/SMTP.php"; 
        require 'PHPMailer-master/src/Exception.php'; 
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        
        // Cấu hình SMTP
        $mail->SMTPDebug = 0; 

        $mail->IsSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com'; // Thay thế bằng máy chủ SMTP của bạn
        $mail->SMTPAuth = true;
        $mail->Username = 'thao86002@st.vimaru.edu.vn'; // Thay thế bằng tên người dùng SMTP
        $mail->Password = 'aoow ichk kzgc apol'; // Thay thế bằng mật khẩu SMTP
        $mail->Port = '465'; // Hoặc '465' tùy thuộc vào máy chủ
        $mail->SMTPSecure = 'ssl'; // Hoặc 'ssl' tùy thuộc vào máy chủ
        $mail->From = $_POST["email"];
        $mail->FromName = $_POST["name"];
        $mail->AddAddress('thaodzgaming123@gmail.com', 'PACIFIC'); // Thay thế bằng địa chỉ cần nhận
        $mail->AddCC($_POST["email"], $_POST["name"]); // Gửi bản sao cho người gửi
        $mail->WordWrap = 50;
        $mail->IsHTML(true);    
        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"];
        
        // Sử dụng try-catch để xử lý lỗi
        try {
            $mail->Send();
            $error = '<label class="text-success">Cảm ơn bạn đã liên hệ với chúng tôi</label>';
        } catch (Exception $e) {
            $error = '<label class="text-danger">Lỗi: ' . $mail->ErrorInfo . '</label>';
        }

        // Đặt lại các biến sau khi gửi thành công
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
    }
}

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

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                <a href="news.php" class="nav-item nav-link ">Tin Tức</a>
                <a href="service.php" class="nav-item nav-link">Dịch Vụ</a>
                
                <a href="contact.php" class="nav-item nav-link active">Liên Hệ</a>
            </div>
            <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i>+ 84 225 3273 868
            </h4>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Liên Hệ Với Chúng Tôi</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Trang Chủ</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="Tin Tức">Liên Hệ</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container contact-page py-5 px-lg-0">
            <div class="row g-5 mx-lg-0">
                <div class="col-md-6 contact-form wow fadeInLeft" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase">Liên Lạc</h6>
                    <h1 class="mb-4">Liên Hệ Nếu Có Bất Kỳ Câu Hỏi Nào</h1>
                    <br>
                    <?php echo $error; ?>
                    <div class="bg-light p-4 wow fadeInLeft" data-wow-delay="0.2s">
                        <form method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" placeholder="Your Name">
                                        <label for="name">Tên của bạn</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>" placeholder="Your Email">
                                        <label for="email">Email của bạn</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="subject" id="subject" value="<?php echo $subject ?>" placeholder="Subject">
                                        <label for="subject">Chủ Đề</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" value="<?php echo $message ?>" name="message" id="message"
                                            style="height: 100px"></textarea>
                                        <label for="message">Nội Dung</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" name="submit" type="submit">Gửi Tin Nhắn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="introduce-header">
                    <h1 align="center">Google Map </h1>
                </div>
                <div style="text-align: center; ">
                    
                </div> -->
                <div class="col-md-6 pe-lg-0 wow fadeInRight" data-wow-delay="0.1s">
                    <div class="position-relative h-100">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.125757143237!2d106.68813245060494!3d20.86698083123905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7aef41ef07c9%3A0xf810c4da6afc5ba7!2zVMOyYSBOaMOgIFRow6BuaCDEkOG6oXQgMQ!5e0!3m2!1svi!2s!4v1708315897461!5m2!1svi!2s"
                        class="position-absolute w-100 h-100" style="object-fit: cover;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


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