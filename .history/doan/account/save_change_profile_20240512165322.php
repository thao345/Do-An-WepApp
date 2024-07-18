<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['changeProfileBtn'])) {
    if (isset($_POST['inputUsername']) ) {
        $idtt = $_POST['id_edit']; 
        $ten = $_POST['ten_edit'];
        $sql = "UPDATE tinhthanh
            SET id_tinhthanh='$idtt', ten = '$ten', id_nguoisua = '3', ngaysua = current_timestamp()
            WHERE id_tinhthanh = '$idtt'";
    
        // var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Sửa tỉnh thành thành công";
            header('location:list_tinhthanh.php');
        } else {
            $_SESSION['fail'] = "Sửa tỉnh thành thất bại";
            header('location:list_tinhthanh.php');
        }
    }
}
?>