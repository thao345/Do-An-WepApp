<?php
session_start();
if (isset($_SESSION['tendangnhap']) && isset($_SESSION['id_nguoidung'])) {
    $id_nguoidung = $_SESSION['id_nguoidung'];
} else
    header('location:login.php');

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_donviccdau']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_donviccdau'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO donvicungcapdau (id_donviccdau, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm đơn vị cung cấp dầu thành công";
            header('location:list_donvicungcapdau.php');
        } else {
            $_SESSION['fail'] = "Thêm đơn vị cung cấp dầu thất bại";
            header('location:list_donvicungcapdau.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idtt = $_POST['id_donviccdau'];
    $ten = $_POST['ten'];
    $sql = "UPDATE donvicungcapdau
        SET ten = '$ten', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_donviccdau = '$idtt'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa đơn vị cung cấp dầu thành công";
        header('location:list_donvicungcapdau.php');
    } else {
        $_SESSION['fail'] = "Sửa đơn vị cung cấp dầu thất bại";
        header('location:list_donvicungcapdau.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `donvicungcapdau` SET `id_nguoisua`='$id_nguoidung' WHERE id_donviccdau = '$id_donhang'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();

    $sql = "DELETE FROM `donvicungcapdau` WHERE id_donviccdau = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa đơn vị cung cấp dầu thành công";
        header('location:list_donvicungcapdau.php');
    } else {
        $_SESSION['fail'] = "Xóa đơn vị cung cấp dầu thất bại";
        header('location:list_donvicungcapdau.php');
    }
}

?>