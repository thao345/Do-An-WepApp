<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_nhansu'] &&
        $_POST['ten'] &&
        $_POST['tenphongban'] &&
        $_POST['chucvu'] &&
        $_POST['nguyenquan'] &&
        $_POST['diachithuongtru'] &&
        $_POST['ngaysinh'] &&
        $_POST['cmnd'] && $_POST['sđt'] &&
        $_POST['nganhang'] &&
        $_POST['stk']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idns = $_POST['id_nhansu'];
        $ten = $_POST['id_nhansu'];
        $tenphongban = $_POST['tenphongban'];
        $chucvu = $_POST['chucvu'];
        $nguyenquan = $_POST['nguyenquan'];
        $diachithuongtru = $_POST['diachithuongtru'];
        $ngaysinh = $_POST['ngaysinh'];
        $cmnd = $_POST['cmnd'];
        $sđt = $_POST['sđt'];
        $nganhang = $_POST['nganhang'];
        $stk = $_POST['stk'];

        $sql = "INSERT INTO nhansu (id_nhansu, ten, tenphongban, chucvu, nguyenquan, diachithuongtru, ngaysinh, cmnd, sđt, stk, tennganhang, id_nguoitao,ngaysua) 
                VALUES ('$idns', '$ten','$tenphongban','$chucvu','$nguyenquan','$diachithuongtru','$ngaysinh','$cmnd','$sđt','$stk','$nganhang','2', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm nhân sự mới thành công";
            header('location:list_nhan_su.php');
        } else {
            $_SESSION['fail'] = "Thêm nhân sự mới thất bại";
            header('location:list_nhan_su.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idns = $_POST['id_nhansu'];
    $ten = $_POST['id_nhansu'];
    $tenphongban = $_POST['tenphongban'];
    $chucvu = $_POST['chucvu'];
    $nguyenquan = $_POST['nguyenquan'];
    $diachithuongtru = $_POST['diachithuongtru'];
    $ngaysinh = $_POST['ngaysinh'];
    $cmnd = $_POST['cmnd'];
    $sđt = $_POST['sđt'];
    $nganhang = $_POST['nganhang'];
    $stk = $_POST['stk'];

    $sql = "UPDATE nhansu
        SET ten = '$ten', tenphongban = '', id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_nhansu = '$idns'";

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