<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['select_thauphu_dh'] &&
        $_POST['tenthauphu_dh'] &&
        $_POST['masothue_dh'] &&
        $_POST['select_bienso_dh'] &&
        $_POST['select_taixe_dh'] &&
        $_POST['sodienthoai_dh'] &&
        $_POST['select_tinhtrangdonhang_dh'] &&
        $_POST['sodonkethop_dh'] &&
        $_POST['ghichu_dh'] &&
        $_POST['id_donhang_dieuhanh']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $select_thauphu_dh = $_POST['select_thauphu_dh'];
        $tenthauphu_dh = $_POST['tenthauphu_dh'];
        $masothue_dh = $_POST['masothue_dh'];
        $select_bienso_dh = $_POST['select_bienso_dh'];
        $select_taixe_dh = $_POST['select_taixe_dh'];
        $sodienthoai_dh = $_POST['sodienthoai_dh'];
        $select_tinhtrangdonhang_dh = $_POST['select_tinhtrangdonhang_dh'];
        $sodonkethop_dh = $_POST['sodonkethop_dh'];
        $ghichu_dh = $_POST['ghichu_dh'];
        $id_donhang_dieuhanh = $_POST['id_donhang_dieuhanh'];

        // $trangthai = $_POST['trangthai'] ?? 'Hoàn thành';


        $sql = "INSERT INTO `dieuhanh`(`id_donhang`, `id_thauphu`, `masothue`, `tenthauphu`, `id_xe`, `id_taixe`, `dienthoai`, 
        `tinhtrangdonhang`, `sodonkethop`, `ghichu`, `ngaytao`, `id_nguoitao`)  
        VALUES ('$id_donhang_dieuhanh', '$select_thauphu_dh','$masothue_dh','$tenthauphu_dh','$select_bienso_dh',
        '$select_taixe_dh', '$sodienthoai_dh','$select_tinhtrangdonhang_dh','$sodonkethop_dh','$ghichu_dh',
        current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm điều hành thành công";
            header('location:list_dieuhanh.php');
        } else {
            $_SESSION['fail'] = "Thêm điều hành thất bại";
            header('location:list_dieuhanh.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_dieuhanh = $_POST['id_edit'];

    $id_donhang_dieuhanh = $_POST['id_donhang_dieuhanh'];
    $select_thauphu_dh = $_POST['select_thauphu_dh'];
    $tenthauphu_dh = $_POST['tenthauphu_dh'];
    $masothue_dh = $_POST['masothue_dh'];
    $select_bienso_dh = $_POST['select_bienso_dh'];
    $select_taixe_dh = $_POST['select_taixe_dh'];
    $sodienthoai_dh = $_POST['sodienthoai_dh'];
    $select_tinhtrangdonhang_dh = $_POST['select_tinhtrangdonhang_dh'];
    $sodonkethop_dh = $_POST['sodonkethop_dh'];
    $ghichu_dh = $_POST['ghichu_dh'];


    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $sql = "UPDATE `dieuhanh` SET `id_donhang`='$id_donhang_dieuhanh',`id_thauphu`='$select_thauphu_dh',`masothue`='$masothue_dh',
    `tenthauphu`='$tenthauphu_dh',`id_xe`='$select_bienso_dh',`id_taixe`='$select_taixe_dh',`dienthoai`='$sodienthoai_dh',
    `tinhtrangdonhang`='$select_tinhtrangdonhang_dh',`sodonkethop`='$sodonkethop_dh',
    `ghichu`='$ghichu_dh',`ngaysua`=current_timestamp(),`id_nguoisua`='$id_nguoidung'
    WHERE id_dieuhanh = '$id_dieuhanh'";


    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa điều hành thành công";
        header('location:list_dieuhanh.php');
    } else {
        $_SESSION['fail'] = "Sửa điều hành thất bại";
        header('location:list_dieuhanh.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_dieuhanh = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `dieuhanh` SET `id_nguoisua`='$id_nguoidung' WHERE id_dieuhanh = '$id_dieuhanh'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `dieuhanh` WHERE id_dieuhanh = '$id_dieuhanh'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa điều hành thành công";
        header('location:list_dieuhanh.php');
    } else {
        $_SESSION['fail'] = "Xóa điều hành thất bại";
        header('location:list_dieuhanh.php');
    }
}

?>