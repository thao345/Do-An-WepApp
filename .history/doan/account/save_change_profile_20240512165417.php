<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['changeProfileBtn'])) {
    if (isset($_POST['inputUsername'])) {
        $ten = $_POST['inputUsername'];
        $sql = "UPDATE nguoidung
            SET  tendangnhap = '$ten', id_nguoisua = '$_SESSION['', ngaysua = current_timestamp()
            WHERE id_nguoidung = '$idtt'";
    
        // var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Sửa tỉnh thành thành công";
            header('location:list_nguoidung.php');
        } else {
            $_SESSION['fail'] = "Sửa tỉnh thành thất bại";
            header('location:list_nguoidung.php');
        }
    }
}
?>