<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_hanghoa'] &&
        $_POST['ten'] &&
        $_POST['id_nhomhanghoa']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_hanghoa = $_POST['id_hanghoa'];
        $ten = $_POST['ten'];
        $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
        $kichthuoc = $_POST['kichthuoc'];
        $donvitinh = $_POST['donvitinh'];
        $ghichu = $_POST['ghichu'];
        $id_thauphu = $_POST['select_TP'];

        $sql = "INSERT INTO `hanghoa`( `id_hanghoa`, `ten`,`id_nhomhanghoa`, `kichthuoc`, `donvitinh`, 
        `ghichu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_hanghoa', '$ten','$id_nhomhanghoa','$kichthuoc','$donvitinh','$ghichu', current_timestamp(),'5')";

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

    $id_hanghoa = $_POST['id_hanghoa'];
    $ten = $_POST['ten'];
    $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
    $kichthuoc = $_POST['kichthuoc'];
    $donvitinh = $_POST['donvitinh'];
    $ghichu = $_POST['ghichu'];
    $id_thauphu = $_POST['select_TP'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE hanghoa
        SET ten='$ten', id_nhomhanghoa = '$id_nhomhanghoa' ,kichthuoc ='$kichthuoc', donvitinh = '$donvitinh',ghichu = '$ghichu', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_hanghoa = '$id_hanghoa'";

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