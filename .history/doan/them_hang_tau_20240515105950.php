<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_hangtau']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_hangtau'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO hangtau (id_hangtau, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '2', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm hãng tàu thành công";
            header('location:list_hang_tau.php');
        } else {
            $_SESSION['fail'] = "Thêm hãng tàu thất bại";
            header('location:list_hang_tau.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idtt = $_POST['id_edit'];
    $ten = $_POST['ten_edit'];
    $sql = "UPDATE hangtau
        SET id_hangtau='$idtt', ten = '$ten', id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_hangtau = '$idtt'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa hãng tàu thành công";
        header('location:list_hang_tau.php');
    } else {
        $_SESSION['fail'] = "Sửa hãng tàu thất bại";
        header('location:list_hang_tau.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];


    $sql = "DELETE FROM `hangtau` WHERE id_hangtau = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa hãng tàu thành công";
        header('location:list_hang_tau.php');
    } else {
        $_SESSION['fail'] = "Xóa hãng tàu thất bại";
        header('location:list_hang_tau.php');
    }
}

?>