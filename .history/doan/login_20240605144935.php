<?php
ob_start();
session_start();
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
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/toast-custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/custom-toast.js"></script>
    
</head>

<body>
    <div id='toast'> </div>
    <?php
    if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
        echo '<script>
                toast({
                title: "Thành công!",
                message: "' . $_SESSION['success'] . '",
                type: "success",
                duration: 5000
                });
            </script>';
        unset($_SESSION['success']);
    } else if (isset($_SESSION['fail']) && $_SESSION['fail'] != '') {
        echo '<script>
                toast({
                title: "Thất bại!",
                message: "' . $_SESSION['fail'] . '",
                type: "error",
                duration: 5000
                });
            </script>';
        unset($_SESSION['fail']);
    }
    ?>

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
                    <form class="user" method="POST" id="loginForm" onsubmit="handleLogin(event)">
                        <!-- Form đăng nhập -->
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" id="username"
                                aria-describedby="emailHelp" placeholder="Tên đăng nhập" required>
                        </div>
                        <div class="form-group position-relative">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-user" name="password"
                                    id="password" placeholder="Mật khẩu" required
                                    style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary border-same"
                                        onclick="togglePasswordVisibility()"
                                        style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i id="toggleIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <script>
                            function togglePasswordVisibility() {
                                const passwordField = document.getElementById('password');
                                const toggleIcon = document.getElementById('toggleIcon');

                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    toggleIcon.classList.remove('fa-eye');
                                    toggleIcon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    toggleIcon.classList.remove('fa-eye-slash');
                                    toggleIcon.classList.add('fa-eye');
                                }
                            }
                        </script>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="rememberMe">
                                <label class="custom-control-label" for="rememberMe">Nhớ mật khẩu</label>
                            </div>
                        </div>
                        <button type="submit" name="loginbtn" class="btn btn-primary btn-user btn-block">Đăng
                            nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- nho mat khau -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Check if localStorage has username and password
            if (localStorage.getItem('username') && localStorage.getItem('password')) {
                document.getElementById('username').value = localStorage.getItem('username');
                document.getElementById('password').value = localStorage.getItem('password');
                document.getElementById('rememberMe').checked = true;
            }
        });

        function handleLogin(event) {
            const rememberMe = document.getElementById('rememberMe').checked;
            if (rememberMe) {
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                localStorage.setItem('username', username);
                localStorage.setItem('password', password);
            } else {
                localStorage.removeItem('username');
                localStorage.removeItem('password');
            }
        }
    </script>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom-toast.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>


<?php
include ('includes/connect.php');

if (isset($_POST['loginbtn'])) {
    if (isset($_POST['username']) && $_POST['password']) {
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
        if ($row == 1) { {
                if ($result[0]['trangthai'] == 'true') {
                    $_SESSION['tendangnhap'] = $username;

                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $_SESSION['thoigiandangnhap'] = date('H:i:s d/m/Y');
                    $_SESSION['id_nguoidung'] = $result[0]['id_nguoidung'];

                    $_SESSION['success'] = "Đăng nhập thành công.";
                    header('location:index.php');
                    exit();
                } else {
                    echo '<script>
                toast({
                title: "Đăng nhập thất bại!",
                message: "Tài khoản của bạn hiện đang bị khoá.",
                type: "error",
                duration: 5000
                });
                </script>';
                }
            }


        } else {

            echo '<script>
                toast({
                title: "Đăng nhập thất bại!",
                message: "Tài khoản hoặc mật khẩu không chính xác!",
                type: "error",
                duration: 5000
                });
                </script>';
        }
    }

}

ob_end_flush();
?>