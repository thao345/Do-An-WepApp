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
        $_POST['id_nhomhanghoa']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_lichtrinh = $_POST['id_lichtrinh'];
        $ten = $_POST['ten'];
        $loaihang = $_POST['loaihang'];
        $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
        $kichthuoc = $_POST['kichthuoc'];
        $donvitinh = $_POST['donvitinh'];
        $ghichu = $_POST['ghichu'];
        $id_thauphu = $_POST['select_TP'];

        $sql = "INSERT INTO `lichtrinh`( `id_lichtrinh`, `ten`,`loaihang`, `id_nhomhanghoa`, `donvitinh`, 
        `ghichu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_lichtrinh', '$ten','$id_nhomhanghoa','$id_nhomhanghoa','$donvitinh','$ghichu', current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm lịch trình mới thành công";
            header('location:list_hanghoa.php');
        } else {
            $_SESSION['fail'] = "Thêm lịch trình mới thất bại";
            header('location:list_hanghoa.php');
        }
    }
}




if (isset($_POST['luubtn'])) {

    $id_lichtrinh = $_POST['id_lichtrinh'];
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
        WHERE id_lichtrinh = '$id_lichtrinh'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa lịch trình thành công";
        header('location:list_hanghoa.php');
    } else {
        $_SESSION['fail'] = "Sửa lịch trình thất bại";
        header('location:list_hanghoa.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `hanghoa` SET `id_nguoisua`='2' WHERE id_lichtrinh = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `hanghoa` WHERE id_lichtrinh = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa lịch trình thành công";
        header('location:list_hanghoa.php');
    } else {
        $_SESSION['fail'] = "Xóa lịch trình thất bại";
        header('location:list_hanghoa.php');
    }
}

?>