<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_hangtau']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_hangtau'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO hangtau (id_hangtau, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '2', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm hãng tàu thành công";
            header('location:list_hang_tau.php');
        } else {
            $_SESSION['fail'] = "Thêm hãng tàu thất bại";
            header('location:list_hang_tau.php');
        }
    }
}
