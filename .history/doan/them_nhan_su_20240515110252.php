<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_nhansu'] &&
        $_POST['ten'] &&
        $_POST['tenphongban'] &&
        $_POST['chucvu'] &&
        $_POST['nguyenquan'] &&
        $_POST['diachithuongtru'] &&
        $_POST['ngaysinh'] &&
        $_POST['cmnd'] && $_POST['sđt'] &&
        $_POST['nganhang'] &&
        $_POST['stk']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idns = $_POST['id_nhansu'];
        $ten = $_POST['ten'];
        $tenphongban = $_POST['tenphongban'];
        $chucvu = $_POST['chucvu'];
        $nguyenquan = $_POST['nguyenquan'];
        $diachithuongtru = $_POST['diachithuongtru'];
        $ngaysinh = $_POST['ngaysinh'];
        $cmnd = $_POST['cmnd'];
        $sđt = $_POST['sđt'];
        $nganhang = $_POST['nganhang'];
        $stk = $_POST['stk'];

        $sql = "INSERT INTO nhansu (id_nhansu, ten, tenphongban, chucvu, nguyenquan, diachithuongtru, ngaysinh, cmnd, sđt, stk, tennganhang, id_nguoitao,ngaytao) 
                VALUES ('$idns', '$ten','$tenphongban','$chucvu','$nguyenquan','$diachithuongtru','$ngaysinh','$cmnd','$sđt','$stk','$nganhang','$id_nguoidung', current_timestamp())";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm nhân sự mới thành công";
            header('location:list_nhan_su.php');
        } else {
            $_SESSION['fail'] = "Thêm nhân sự mới thất bại";
            header('location:list_nhan_su.php');
        }
    }
}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $idns = $_POST['id_nhansu'];
    $ten = $_POST['ten'];
    $tenphongban = $_POST['tenphongban'];
    $chucvu = $_POST['chucvu'];
    $nguyenquan = $_POST['nguyenquan'];
    $diachithuongtru = $_POST['diachithuongtru'];
    $ngaysinh = $_POST['ngaysinh'];
    $cmnd = $_POST['cmnd'];
    $sđt = $_POST['sđt'];
    $nganhang = $_POST['nganhang'];
    $stk = $_POST['stk'];

    $sql = "UPDATE nhansu
        SET ten = '$ten', tenphongban = '$tenphongban', chucvu = '$chucvu', nguyenquan = '$nguyenquan', diachithuongtru = '$diachithuongtru', ngaysinh = '$ngaysinh', cmnd = '$cmnd', sđt = '$sđt', stk = '$stk', tennganhang = '$nganhang', id_nguoisua = '$id_nguoidungx', ngaysua = current_timestamp()
        WHERE id_nhansu = '$idns'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa nhân sự thành công";
        header('location:list_nhan_su.php');
    } else {
        $_SESSION['fail'] = "Sửa nhân sự thất bại";
        header('location:list_nhan_su.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $idns = $_POST['delete_id'];
    
    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `nhansu` SET `id_nguoisua`='$id_nguoidung' WHERE id_nhansu = '$idns'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();



    $sql = "DELETE FROM `nhansu` WHERE id_nhansu = '$idns'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa nhân sự thành công";
        header('location:list_nhan_su.php');
    } else {
        $_SESSION['fail'] = "Xóa nhân sự thất bại";
        header('location:list_nhan_su.php');
    }
}

?>