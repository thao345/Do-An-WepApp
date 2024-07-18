<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['tenchucnang'] &&
        $_POST['trangthai'] 
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $tenchucnang = $_POST['tenchucnang'];
        $trangthai = $_POST['trangthai'];
       

        $sql = "INSERT INTO chucnang ( tenchucnang, trangthai, id_nguoitao,ngaytao) 
                VALUES ( '$tenchucnang', '$trangthai','5', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm chức năng mới thành công";
            header('location:list_chucnang.php');
        } else {
            $_SESSION['fail'] = "Thêm chức năng mới thất bại";
            header('location:list_chucnang.php');
        }
    }
}



if (isset($_POST['luubtn'])) {  

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idcn = $_POST['id_chucnang'];
    $tendangnhap = $_POST['tenchucnang'];
    $trangthai = $_POST['trangthai'];

    $sql = "UPDATE chucnang 
        SET tenchucnang='$tendangnhap',  trangthai = '$trangthai',  id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_chucnang  = '$idcn'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa chức năng thành công";
        header('location:list_chucnang.php');
    } else {
        $_SESSION['fail'] = "Sửa chức năng thất bại";
        header('location:list_chucnang.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idcn = $_POST['delete_id'];
    
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `chucnang` SET `id_nguoisua`='2' WHERE id_chucnang = '$idcn'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();



    $sql = "DELETE FROM `chucnang` WHERE id_chucnang = '$idcn'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa chức năng thành công";
        header('location:list_chucnang.php');
    } else {
        $_SESSION['fail'] = "Xóa chức năng thất bại";
        header('location:list_chucnang.php');
    }
}

?>