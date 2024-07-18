<?php
session_start();
if (isset($_SESSION['tendangnhap']) && isset($_SESSION['id_nguoidung'])) {
    $id_nguoidung = $_SESSION['id_nguoidung'];
} else
    header('location:login.php');

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        isset($_POST['id_nhienlieu']) &&
        isset($_POST['ten']) &&
        isset($_POST['dongiasauthue'])
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_nhienlieu'];
        $ten = $_POST['ten'];
        $dongiasauthue = $_POST['dongiasauthue'];
        $ngayapdung = $_POST['ngayapdung'];
        $sql = "INSERT INTO nhienlieu (id_nhienlieu, ten, dongiasauthue, ngayapdung, id_nguoitao, ngaytao) 
                VALUES ('$idtt', '$ten','$dongiasauthue','$ngayapdung', '$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm nhiên liệu thành công";
            header('location:list_nhienlieu.php');
        } else {
            $_SESSION['fail'] = "Thêm nhiên liệu thất bại";
            header('location:list_nhienlieu.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idtt = $_POST['id_nhienlieu'];
    $ten = $_POST['ten'];
    $dongiasauthue = $_POST['dongiasauthue'];
    $ngayapdung = $_POST['ngayapdung'];
    $sql = "UPDATE nhienlieu
        SET ten = '$ten',dongiasauthue =  '$dongiasauthue', ngayapdung = '$ngayapdung', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_nhienlieu = '$idtt'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa nhiên liệu thành công";
        header('location:list_nhienlieu.php');
    } else {
        $_SESSION['fail'] = "Sửa nhiên liệu thất bại";
        header('location:list_nhienlieu.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];
 // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
 $sql1 = "UPDATE `hangtau` SET `id_nguoisua`='$id_nguoidung' WHERE id_hangtau = '$idtt'";
 $stmt1 = $conn->prepare($sql1);
 $query1 = $stmt1->execute();

    $sql = "DELETE FROM `nhienlieu` WHERE id_nhienlieu = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa nhiên liệu thành công";
        header('location:list_nhienlieu.php');
    } else {
        $_SESSION['fail'] = "Xóa nhiên liệu thất bại";
        header('location:list_nhienlieu.php');
    }
}

?>