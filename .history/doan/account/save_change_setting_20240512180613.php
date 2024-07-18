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
        
        $id = $_SESSION['id_nguoidung'];
        $ten = $_POST['inputUsername'];
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