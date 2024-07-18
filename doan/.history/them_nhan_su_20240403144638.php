<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if ($_POST['id_nhansu'] && 
    $_POST['ten'] && 
    $_POST['tenphongban'] && 
    $_POST['chucvu'] && 
    $_POST['nguyenquan'] && 
    $_POST['diachithuongtru'] && $_POST['ngaysinh'] && $_POST['cmnd'] && $_POST['sđt'] && $_POST['nganhang'] && $_POST['stk']) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_tinhthanh'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO tinhthanh (id_tinhthanh, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '2', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm tỉnh thành thành công";
            header('location:list_tinhthanh.php');
        } else {
            $_SESSION['fail'] = "Thêm tỉnh thành thất bại";
            header('location:list_tinhthanh.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
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

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];


    $sql = "DELETE FROM `tinhthanh` WHERE id_tinhthanh = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa tỉnh thành thành công";
        header('location:list_tinhthanh.php');
    } else {
        $_SESSION['fail'] = "Xóa tỉnh thành thất bại";
        header('location:list_tinhthanh.php');
    }
}

?>