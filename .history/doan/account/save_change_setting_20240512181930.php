<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');

$username = $_SESSION['tendangnhap'];
//change password
if (isset($_POST['changePasBtn'])) {
    if (
        isset($_POST['currentPas']) &&
        isset($_POST['newPas']) &&
        isset($_POST['newPas2'])
    ) {
        $currentPas = $_POST['currentPas'];
        $newPas = $_POST['newPas'];
        $newPas2 = $_POST['newPas2'];

        if ($newPas == $newPas2) {
            $sql = "SELECT tendangnhap, matkhau FROM nguoidung WHERE tendangnhap = '$username'";
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $pas = $result['matkhau'];


            if ($currentPas == $pas) {
                $sql = "UPDATE nguoidung SET matkhau = '$newPas' WHERE tendangnhap = '$username'";
                $stmt = $conn->prepare($sql);
                $query = $stmt->execute();
                if ($query) {
                    $_SESSION['success'] = "Đổi mật khẩu thành công";
                    header('location:../account_profile.php');
                } else {
                    $_SESSION['fail'] = "Đổi mật khẩu thất bại";
                    header('location:../account_profile.php');
                }
            } else {
                $_SESSION['fail'] = "Mật khẩu hiện tại không đúng";
                header('location:../account_profile.php');
            }
        } else {
            $_SESSION['fail'] = "Sai ";
            header('location:../account_profile.php');
        }




    }
}
?>