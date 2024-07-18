<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_khachhang'] &&
        $_POST['ten'] &&
        $_POST['diachi'] &&
        $_POST['masothue'] &&
        $_POST['nguoidaidien']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_khachhang = $_POST['id_khachhang'];
        $ten = $_POST['ten'];
        $diachi = $_POST['diachi'];
        $sodienthoai = $_POST['sodienthoai'];
        $email = $_POST['email'];
        $masothue = $_POST['masothue'];
        $tennganhang = $_POST['tennganhang'];
        $stk = $_POST['stk'];
        $nguoidaidien = $_POST['nguoidaidien'];
        $sđtgiaonhan = $_POST['sđtgiaonhan'];
        $id_tuyenvantai = $_POST['id_tuyenvantai'];

        $sql = "INSERT INTO `khachhang`( `id_khachhang`, `ten`,`diachi`, `sodienthoai`, `email`,`masothue`, 
        `tennganhang`,`stk`, `nguoidaidien`, `sđtgiaonhan`, `id_tuyenvantai`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_khachhang', '$ten','$diachi','$sodienthoai', '$email','$masothue','$tennganhang', '$stk', '$nguoidaidien', '$sđtgiaonhan', '$id_tuyenvantai', current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm khách hàng mới thành công";
            header('location:list_khachhang.php');
        } else {
            $_SESSION['fail'] = "Thêm khách hàng mới thất bại";
            header('location:list_khachhang.php');
        }
    }
}


if (isset($_POST['luubtn'])) {

    $id_khachhang = $_POST['id_khachhang'];
    $ten = $_POST['ten'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $email = $_POST['email'];
    $masothue = $_POST['masothue'];
    $tennganhang = $_POST['tennganhang'];
    $stk = $_POST['stk'];
    $nguoidaidien = $_POST['nguoidaidien'];
    $sđtgiaonhan = $_POST['sđtgiaonhan'];
    $id_tuyenvantai = $_POST['id_tuyenvantai'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE khachhang
        SET ten='$ten', diachi = '$diachi' ,sodienthoai ='$sodienthoai',  email = '$email', masothue = '$masothue',id_nhomhanghoa = '$id_nhomhanghoa', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_khachhang = '$id_khachhang'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa khách hàng thành công";
        header('location:list_khachhang.php');
    } else {
        $_SESSION['fail'] = "Sửa khách hàng thất bại";
        header('location:list_khachhang.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `khachhang` SET `id_nguoisua`='2' WHERE id_khachhang = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `khachhang` WHERE id_khachhang = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa khách hàng thành công";
        header('location:list_khachhang.php');
    } else {
        $_SESSION['fail'] = "Xóa khách hàng thất bại";
        header('location:list_khachhang.php');
    }
}

?>