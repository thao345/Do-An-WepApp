<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_tinhthanh']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_tinhthanh'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO tinhthanh (id_tinhthanh, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '$id_nguoidung', current_timestamp())";

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
        SET id_tinhthanh='$idtt', ten = '$ten', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
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

 // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
 $sql1 = "UPDATE `hangtau` SET `id_nguoisua`='$id_nguoidung' WHERE id_hangtau = '$idtt'";
 $stmt1 = $conn->prepare($sql1);
 $query1 = $stmt1->execute();
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