<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['tendangnhap'] &&
        $_POST['matkhau'] &&
        $_POST['trangthai'] &&
        $_POST['isadmin'] 
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $tendangnhap = $_POST['tendangnhap'];
        $matkhau = $_POST['matkhau'];
        $trangthai = $_POST['trangthai'];
        $isadmin = $_POST['isadmin'];
       

        $sql = "INSERT INTO nguoidung ( tendangnhap, matkhau, trangthai, isadmin, id_nguoitao,ngaytao) 
                VALUES ( '$tendangnhap','$matkhau', '$trangthai' ,'$isadmin','$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm người dùng mới thành công";
            header('location:list_nguoidung.php');
        } else {
            $_SESSION['fail'] = "Thêm người dùng mới thất bại";
            header('location:list_nguoidung.php');
        }
    }
}



if (isset($_POST['luubtn'])) {  

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idnd = $_POST['id_nguoidung'];
    $tendangnhap = $_POST['tendangnhap'];
    $matkhau = $_POST['matkhau'];
    $trangthai = $_POST['trangthai'];
    $isadmin = $_POST['isadmin'];

    $sql = "UPDATE nguoidung
        SET tendangnhap='$tendangnhap', matkhau = '$matkhau', trangthai = '$trangthai', isadmin = '$isadmin', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_nguoidung = '$idnd'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa người dùng thành công";
        header('location:list_nguoidung.php');
    } else {
        $_SESSION['fail'] = "Sửa người dùng thất bại";
        header('location:list_nguoidung.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idnd = $_POST['delete_id'];
    
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `nguoidung` SET `id_nguoisua`='2' WHERE id_nguoidung = '$idnd'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();



    $sql = "DELETE FROM `nguoidung` WHERE id_nguoidung = '$idnd'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa người dùng thành công";
        header('location:list_nguoidung.php');
    } else {
        $_SESSION['fail'] = "Xóa người dùng thất bại";
        header('location:list_nguoidung.php');
    }
}

?>