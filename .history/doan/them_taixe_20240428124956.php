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

        $sql = "INSERT INTO `taixe`( `id_taixe`, `ten`,`id_nhomxe`, `tennhomxe`, `id_nhienlieu`, 
        `id_thauphu`, `id_nhomhang`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$bienso', 'OK','$id_nhomxe','$tennhomxe','$id_nhienlieu','$id_thauphu','$id_nhomhang', current_timestamp(),'5')";

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

    $id = $_POST['id_xe'];
    $bienso = $_POST['bienso'];
    $trangthaixe = $_POST['select_TrangThai'];
    $id_nhomxe = $_POST['select_NX'];
    $tennhomxe = get_name($id_nhomxe, 'nhomxe', 'id_nhomxe');
    $id_nhienlieu = $_POST['select_NL'];
    $id_thauphu = $_POST['select_TP'];
    $id_nhomhang = $_POST['select_NH'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 


    $sql = "UPDATE xe
        SET bienso='$bienso', trangthaixe = '$trangthaixe' ,id_nhomxe ='$id_nhomxe', tennhomxe = '$tennhomxe',id_nhienlieu = '$id_nhienlieu',  id_thauphu = '$id_thauphu', 
        id_nhomhang = '$id_nhomhang', id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_xe = '$id'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa xe $id thành công";
        header('location:list_xe.php');
    } else {
        $_SESSION['fail'] = "Sửa xe thất bại";
        header('location:list_xe.php');
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
        header('location:list_xe.php');
    } else {
        $_SESSION['fail'] = "Xóa xe thất bại";
        header('location:list_xe.php');
    }
}

?>