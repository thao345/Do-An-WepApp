<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('../includes/connect.php');


if (isset($_POST['changeProfileBtn'])) {
    // if (isset($_POST['inputUsername'])) {
    //     $username = $_SESSION['tendangnhap'];
    //     $ten = $_POST['inputUsername'];
    //     $sql = "UPDATE nguoidung
    //         SET  tendangnhap = '$ten', id_nguoisua = '$id', ngaysua = current_timestamp()
    //         WHERE id_nguoidung = '$id'";
    
    //     // var_dump($sql);
    //     $stmt = $conn->prepare($sql);
    //     $query = $stmt->execute();
    //     if ($query) {
    //         $_SESSION['success'] = "Sửa thông tin cá nhân thành công";
    //         header('location:../account_profile.php');
    //     } else {
    //         $_SESSION['fail'] = "Sửa thông tin cá nhân thất bại";
    //         header('location:../account_profile.php');
    //     }
    // }
    
}
?>