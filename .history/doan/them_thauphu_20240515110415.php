<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_thauphu'] &&
        $_POST['ten'] &&
        $_POST['diachi'] &&
        $_POST['masothue']


    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_thauphu = $_POST['id_thauphu'];
        $ten = $_POST['ten'];
        $diachi = $_POST['diachi'];
        $sodienthoai = $_POST['sodienthoai'];
        $masothue = $_POST['masothue'];
        $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
        

        $sql = "INSERT INTO `thauphu`( `id_thauphu`, `ten`,`diachi`, `sodienthoai`, `masothue`, 
        `id_nhomhanghoa`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$id_thauphu', '$ten','$diachi','$sodienthoai','$masothue','$id_nhomhanghoa', current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm thầu phụ mới thành công";
            header('location:list_thauphu.php');
        } else {
            $_SESSION['fail'] = "Thêm thầu phụ mới thất bại";
            header('location:list_thauphu.php');
        }
    }
}


if (isset($_POST['luubtn'])) {

    $id_thauphu = $_POST['id_thauphu'];
    $ten = $_POST['ten'];
    $diachi = $_POST['diachi'];
    $sodienthoai = $_POST['sodienthoai'];
    $masothue = $_POST['masothue'];
    $id_nhomhanghoa = $_POST['id_nhomhanghoa'];
   
    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 

    $sql = "UPDATE thauphu
        SET ten='$ten', diachi = '$diachi' ,sodienthoai ='$sodienthoai', masothue = '$masothue',id_nhomhanghoa = '$id_nhomhanghoa', 
        id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_thauphu = '$id_thauphu'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa thầu phụ thành công";
        header('location:list_thauphu.php');
    } else {
        $_SESSION['fail'] = "Sửa thầu phụ thất bại";
        header('location:list_thauphu.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `thauphu` SET `id_nguoisua`='2' WHERE id_thauphu = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `thauphu` WHERE id_thauphu = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa thầu phụ thành công";
        header('location:list_thauphu.php');
    } else {
        $_SESSION['fail'] = "Xóa thầu phụ thất bại";
        header('location:list_thauphu.php');
    }
}

?>