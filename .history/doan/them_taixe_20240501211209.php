<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_taixe'] &&
        $_POST['ten'] &&
        $_POST['sodienthoai'] &&
        $_POST['diachi'] &&
        $_POST['select_TP']

    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_taixe = $_POST['id_taixe'];
        $ten = $_POST['ten'];
        $sodienthoai = $_POST['sodienthoai'];
        $diachi = $_POST['diachi'];
        $cmnd = $_POST['cmnd'];
        $sobanglai = $_POST['sobanglai'];
        $id_thauphu = $_POST['select_TP'];

        $sql = "INSERT INTO `taixe`( `id_taixe`, `ten`,`sodienthoai`, `diachi`, `cmnd`, 
        `sobanglai`, `id_thauphu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_taixe', '$ten','$sodienthoai','$diachi','$cmnd','$sobanglai','$id_thauphu', current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm tài xế mới thành công";
            header('location:list_taixe.php');
        } else {
            $_SESSION['fail'] = "Thêm tài xế mới thất bại";
            header('location:list_taixe.php');
        }
    }
}

function get_name($id, $table, $id_column)
{
    include ('includes/connect.php');
    $sql = "SELECT ten FROM `$table` WHERE $id_column ='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['ten'];
}



if (isset($_POST['luubtn'])) {

    $id_taixe = $_POST['id_taixe'];
    $ten = $_POST['ten'];
    $sodienthoai = $_POST['sodienthoai'];
    $diachi = $_POST['diachi'];
    $cmnd = $_POST['cmnd'];
    $sobanglai = $_POST['sobanglai'];
    $id_thauphu = $_POST['select_TP'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 


    $sql = "UPDATE taixe
        SET ten='$ten', sodienthoai = '$sodienthoai' ,diachi ='$diachi', cmnd = '$cmnd',sobanglai = '$sobanglai',  id_thauphu = '$id_thauphu', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_taixe = '$id_taixe'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa tài xế thành công";
        header('location:list_taixe.php');
    } else {
        $_SESSION['fail'] = "Sửa xe thất bại";
        header('location:list_taixe.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `xe` SET `id_nguoisua`='2' WHERE id_xe = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `xe` WHERE id_xe = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa xe thành công";
        header('location:list_taixe.php');
    } else {
        $_SESSION['fail'] = "Xóa xe thất bại";
        header('location:list_taixe.php');
    }
}

?>