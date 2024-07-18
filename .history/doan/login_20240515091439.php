<?php
session_start();
if(isset($_SESSION['tendangnhap'])){
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Đăng nhập</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="position-relative" style="overflow: hidden; height: 100%">
        <div class="col-lg-12 bg-login-image"
            style="height: 100vh; background-size: cover; background-position: center;">
            <!-- Hình ảnh -->
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
                <!-- Phần đăng nhập -->
                <div class="col-lg-5 bg-white p-5 " style="border-radius: 30px;">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Chào mừng trở lại!</h1>
                    </div>
                    <form class="user" method="POST">
                        <!-- Form đăng nhập -->
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username"
                                id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Tên đăng nhập"
                                required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="password"
                                id="exampleInputPassword" placeholder="Mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Nhớ mật khẩu</label>
                            </div>
                        </div>
                        <button type="submit" name="loginbtn" class="btn btn-primary btn-user btn-block">Đăng
                            nhập</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Quên mật khẩu?</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
include ('includes/connect.php');

if (isset($_POST['loginbtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM nguoidung where tendangnhap ='$username' and matkhau='$password'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }
    $row = $stmt->rowCount();
    if ($row == 1) {
        $_SESSION['tendangnhap'] = $result['tendangnhap'];
        $_SESSION['id_nguoidung'] = $result['id_nguoidung'];

        // header('location: index.php');
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        echo "<script>alert('Đăng nhập thất bại .$sql . ')</script>";
    }
}
?>