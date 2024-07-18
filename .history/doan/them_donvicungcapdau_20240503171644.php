<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_donviccdau']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_donviccdau'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO donvicungcapdau (id_donviccdau, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '2', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm tỉnh thành thành công";
            header('location:list_donvicungcapdau.php');
        } else {
            $_SESSION['fail'] = "Thêm tỉnh thành thất bại";
            header('location:list_donvicungcapdau.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idtt = $_POST['id_edit']; 
    $ten = $_POST['ten_edit'];
    $sql = "UPDATE donvicungcapdau
        SET ten = '$ten', id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_donviccdau = '$idtt'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa tỉnh thành thành công";
        header('location:list_donvicungcapdau.php');
    } else {
        $_SESSION['fail'] = "Sửa tỉnh thành thất bại";
        header('location:list_donvicungcapdau.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];


    $sql = "DELETE FROM `donvicungcapdau` WHERE id_donviccdau = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa tỉnh thành thành công";
        header('location:list_donvicungcapdau.php');
    } else {
        $_SESSION['fail'] = "Xóa tỉnh thành thất bại";
        header('location:list_donvicungcapdau.php');
    }
}

?>