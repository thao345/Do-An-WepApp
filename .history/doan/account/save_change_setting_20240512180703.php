<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');

//change password
if (isset($_POST['changePasBtn'])) {
    if (isset($_POST['currentPas']) &&
    isset($_POST['newPas']) &&
    isset($_POST['newPas2'])
        ) {
        $currentPas = $_POST['currentPas'];
        $newPas = $_POST['newPas'];
        $newPas2 = $_POST['newPas2'];
        $id = $_SESSION['id_nguoidung'];
        $sql = "SELECT * FROM nguoidung WHERE id_nguoidung = '$id'";
        if()

        $sql = "UPDATE nguoidung
            SET  tendangnhap = '$ten', id_nguoisua = '$id', ngaysua = current_timestamp()
            WHERE id_nguoidung = '$id'";
    
        // var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Sửa thông tin cá nhân thành công";
            header('location:../account_profile.php');
        } else {
            $_SESSION['fail'] = "Sửa thông tin cá nhân thất bại";
            header('location:../account_profile.php');
        }
    }
}
?>