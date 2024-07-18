<?php
session_start();
if (isset($_SESSION['tendangnhap']) && isset($_SESSION['id_nguoidung'])) {
    $id_nguoidung = $_SESSION['id_nguoidung'];
} else
    header('location:login.php');

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (isset($_POST['id_nhomxe']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id = $_POST['id_nhomxe'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO nhomxe (id_nhomxe, ten, id_nguoitao, ngaytao) VALUES ('$id', '$ten', '$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm nhóm xe thành công";
            header('location:list_nhomxe.php');
        } else {
            $_SESSION['fail'] = "Thêm nhóm xe thất bại";
            header('location:list_nhomxe.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $id = $_POST['id_edit'];
    $ten = $_POST['ten_edit'];
    $sql = "UPDATE nhomxe
        SET id_nhomxe='$id', ten = '$ten', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_nhomxe = '$id'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa nhóm xe thành công";
        header('location:list_nhomxe.php');
    } else {
        $_SESSION['fail'] = "Sửa nhóm xe thất bại";
        header('location:list_nhomxe.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `nhomxa` SET `id_nguoisua`='$id_nguoidung' WHERE id_nhomxa = '$idtt'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();

    $sql = "DELETE FROM `nhomxe` WHERE id_nhomxe = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóa nhóm xe thành công";
        header('location:list_nhomxe.php');
    } else {
        $_SESSION['fail'] = "Xóa nhóm xe thất bại";
        header('location:list_nhomxe.php');
    }
}

?>