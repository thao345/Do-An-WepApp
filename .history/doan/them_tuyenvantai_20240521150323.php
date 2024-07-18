<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['id_tuyenvantai'] &&
        $_POST['ten'] &&
        $_POST['diemdau'] &&
        $_POST['diemcuoi'] &&
        $_POST['id_tinhthanhdau'] &&
        $_POST['id_tinhthanhcuoi'] &&
        $_POST['culy'] &&
        $_POST['dau_tieuthu']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_tuyenvantai = $_POST['id_tuyenvantai'];
        $ten = $_POST['ten'];
        $id_tinhthanhdau = $_POST['id_tinhthanhdau'];
        $diemdau = $_POST['diemdau'];
        $id_tinhthanhcuoi = $_POST['id_tinhthanhcuoi'];
        $diemcuoi = $_POST['id_tinhthanhdau'];;
        $culy = $_POST['culy'];
        $dau_tieuthu = $_POST['dau_tieuthu'];
        $ghichu = $_POST['ghichu'];


        $sql = "INSERT INTO `tuyenvantai`( `id_tuyenvantai`, `ten`,`diemdau`, `id_tinhthanhdau`, `diemcuoi`,
        `id_tinhthanhcuoi`, `culy`, `dautieuthu`, `ghichu`,`ngaytao`, `id_nguoitao`) 
        VALUES ('$id_tuyenvantai', '$ten','$diemdau','$id_tinhthanhdau','$diemcuoi','$id_tinhthanhcuoi','$culy','$dau_tieuthu','$ghichu', current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm tuyến vận tải mới thành công";
            header('location:list_tuyen_van_tai.php');
        } else {
            $_SESSION['fail'] = "Thêm tuyến vận tải mới thất bại";
            header('location:list_tuyen_van_tai.php');
        }
    }
}

function get_tentinhthanh($id)
{
    include ('includes/connect.php');
    $sql = "SELECT ten FROM `tinhthanh` WHERE id_tinhthanh ='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['ten'];
}



if (isset($_POST['luubtn'])) {

    $id = $_POST['id_tuyenvantai'];

    $ten = $_POST['ten'];
    $id_tinhthanhdau = $_POST['id_tinhthanhdau'];
    $diemdau = get_tentinhthanh($id_tinhthanhdau);
    $id_tinhthanhcuoi = $_POST['id_tinhthanhcuoi'];
    $diemcuoi = get_tentinhthanh($id_tinhthanhcuoi);
    $culy = $_POST['culy'];
    $dau_tieuthu = $_POST['dau_tieuthu'];
    $ghichu = $_POST['ghichu'];

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 


    $sql = "UPDATE tuyenvantai
        SET ten='$ten', diemdau ='$diemdau', id_tinhthanhdau = '$id_tinhthanhdau',diemcuoi = '$diemcuoi',  id_tinhthanhcuoi = '$id_tinhthanhcuoi', 
        culy = '$culy',  dautieuthu = '$dau_tieuthu', 
        ghichu = '$ghichu', id_nguoisua = '$id_nguoidung', ngaysua = current_timestamp()
        WHERE id_tuyenvantai = '$id'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa tuyến vận tải thành công";
        header('location:list_tuyen_van_tai.php');
    } else {
        $_SESSION['fail'] = "Sửa tuyến vận tải thất bại";
        header('location:list_tuyen_van_tai.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `tuyenvantai` SET `id_nguoisua`='$id_nguoidung' WHERE id_tuyenvantai = '$id'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `tuyenvantai` WHERE id_tuyenvantai = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa tuyến vận tải thành công";
        header('location:list_tuyen_van_tai.php');
    } else {
        $_SESSION['fail'] = "Xóa tuyến vận tải thất bại";
        header('location:list_tuyen_van_tai.php');
    }
}

?>