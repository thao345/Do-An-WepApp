<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_thauphu'] &&
        $_POST['ten'] &&
        $_POST['diachi'] &&
        $_POST['masothue']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_thauphu = $_POST['id_thauphu'];
        $ten = $_POST['ten'];
        $diachi = $_POST['diachi'];
        $sodienthoai = $_POST['sodienthoai'];
        $masothue = $_POST['masothue'];
        $ghichu = $_POST['ghichu'];
        $id_thauphu = $_POST['select_TP'];

        $sql = "INSERT INTO `hanghoa`( `id_thauphu`, `ten`,`diachi`, `sodienthoai`, `masothue`, 
        `ghichu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_thauphu', '$ten','$diachi','$sodienthoai','$masothue','$ghichu', current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm hàng hoá mới thành công";
            header('location:list_hanghoa.php');
        } else {
            $_SESSION['fail'] = "Thêm hàng hoá mới thất bại";
            header('location:list_hanghoa.php');
        }
    }
}




if (isset($_POST['luubtn'])) {

    $id_thauphu = $_POST['id_thauphu'];
    $ten = $_POST['ten'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $masothue = $_POST['masothue'];
    $ghichu = $_POST['ghichu'];
    $id_thauphu = $_POST['select_TP'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE hanghoa
        SET ten='$ten', diachi = '$diachi' ,sodienthoai ='$sodienthoai', masothue = '$masothue',ghichu = '$ghichu', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_thauphu = '$id_thauphu'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa hàng hoá thành công";
        header('location:list_hanghoa.php');
    } else {
        $_SESSION['fail'] = "Sửa hàng hoá thất bại";
        header('location:list_hanghoa.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `hanghoa` SET `id_nguoisua`='2' WHERE id_hanghoa = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `hanghoa` WHERE id_hanghoa = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa hàng hoá thành công";
        header('location:list_hanghoa.php');
    } else {
        $_SESSION['fail'] = "Xóa hàng hoá thất bại";
        header('location:list_hanghoa.php');
    }
}

?>