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
        $_POST['id_nhomhanghoa'] &&
        

    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_hanghoa = $_POST['id_hanghoa'];
        $ten = $_POST['ten'];
        $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
        $diachi = $_POST['diachi'];
        $cmnd = $_POST['cmnd'];
        $sobanglai = $_POST['sobanglai'];
        $id_thauphu = $_POST['select_TP'];

        $sql = "INSERT INTO `taixe`( `id_hanghoa`, `ten`,`id_nhomhanghoa`, `diachi`, `cmnd`, 
        `sobanglai`, `id_thauphu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_hanghoa', '$ten','$id_nhomhanghoa','$diachi','$cmnd','$sobanglai','$id_thauphu', current_timestamp(),'5')";

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

    $id_hanghoa = $_POST['id_hanghoa'];
    $ten = $_POST['ten'];
    $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
    $diachi = $_POST['diachi'];
    $cmnd = $_POST['cmnd'];
    $sobanglai = $_POST['sobanglai'];
    $id_thauphu = $_POST['select_TP'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE taixe
        SET ten='$ten', id_nhomhanghoa = '$id_nhomhanghoa' ,diachi ='$diachi', cmnd = '$cmnd',sobanglai = '$sobanglai',  id_thauphu = '$id_thauphu', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_hanghoa = '$id_hanghoa'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa tài xế thành công";
        header('location:list_taixe.php');
    } else {
        $_SESSION['fail'] = "Sửa tài xế thất bại";
        header('location:list_taixe.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `taixe` SET `id_nguoisua`='2' WHERE id_hanghoa = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `taixe` WHERE id_hanghoa = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa tài xế thành công";
        header('location:list_taixe.php');
    } else {
        $_SESSION['fail'] = "Xóa tài xế thất bại";
        header('location:list_taixe.php');
    }
}

?>