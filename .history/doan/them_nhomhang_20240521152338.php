<?php
session_start();
if (isset($_SESSION['tendangnhap']) && isset($_SESSION['id_nguoidung'])) {
    $id_nguoidung = $_SESSION['id_nguoidung'];
} else
    header('location:login.php');

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_nhomhanghoa']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_nhomhanghoa'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO nhomhanghoa (id_nhomhanghoa, ten, id_nguoitao, ngaytao) VALUES ('$idtt', '$ten', '$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm nhóm hàng hoá mới thành công";
            header('location:list_nhomhang.php');
        } else {
            $_SESSION['fail'] = "Thêm nhóm hàng hoá mới thất bại";
            header('location:list_nhomhang.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idtt = $_POST['id_edit'];
    $ten = $_POST['ten_edit'];
    $sql = "UPDATE nhomhanghoa
        SET id_nhomhanghoa='$idtt', ten = '$ten', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_nhomhanghoa = '$idtt'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa nhóm hàng hoá thành công";
        header('location:list_nhomhang.php');
    } else {
        $_SESSION['fail'] = "Sửa nhóm hàng hoá thất bại";
        header('location:list_nhomhang.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idtt = $_POST['delete_id'];
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `hangtau` SET `id_nguoisua`='$id_nguoidung' WHERE id_hangtau = '$idtt'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();

    $sql = "DELETE FROM `nhomhanghoa` WHERE id_nhomhanghoa = '$idtt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa nhóm hàng hoá thành công";
        header('location:list_nhomhang.php');
    } else {
        $_SESSION['fail'] = "Xóa nhóm hàng hoá thất bại";
        header('location:list_nhomhang.php');
    }
}

?>