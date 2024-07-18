<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_lichtrinh'] &&
        $_POST['ten'] &&
        $_POST['select_loaihang'] &&
        $_POST['id_nhomhanghoa']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_lichtrinh = $_POST['id_lichtrinh'];
        $ten = $_POST['ten'];
        $loaihang = $_POST['select_loaihang'];
        $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
        $loaihang = $_POST['loaihang'];
       

        $sql = "INSERT INTO `lichtrinh`( `id_lichtrinh`, `ten`,`loaihang`, `id_nhomhanghoa`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_lichtrinh', '$ten','$loaihang','$id_nhomhanghoa', current_timestamp(),'5')";
        
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm lịch trình mới thành công";
            header('location:list_lichtrinh.php');
        } else {
            $_SESSION['fail'] = "Thêm lịch trình mới thất bại";
            header('location:list_lichtrinh.php');
        }
    }
}




if (isset($_POST['luubtn'])) {

    $id_lichtrinh = $_POST['id_lichtrinh'];
    $ten = $_POST['ten'];
    $loaihang = $_POST['select_loaihang'];
    $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
    $loaihang = $_POST['loaihang'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE lichtrinh
        SET ten='$ten', id_nhomhanghoa = '$id_nhomhanghoa' ,loaihang ='$loaihang', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_lichtrinh = '$id_lichtrinh'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa lịch trình thành công";
        header('location:list_lichtrinh.php');
    } else {
        $_SESSION['fail'] = "Sửa lịch trình thất bại";
        header('location:list_lichtrinh.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `lichtrinh` SET `id_nguoisua`='2' WHERE id_lichtrinh = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `lichtrinh` WHERE id_lichtrinh = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa lịch trình thành công";
        header('location:list_lichtrinh.php');
    } else {
        $_SESSION['fail'] = "Xóa lịch trình thất bại";
        header('location:list_lichtrinh.php');
    }
}

?>