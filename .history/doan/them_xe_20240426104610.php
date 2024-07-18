<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['bienso'] &&
        $_POST['select_NX'] &&
        $_POST['select_NL'] &&
        $_POST['select_NH'] 
       
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $bienso = $_POST['bienso'];
        $id_nhomxe = $_POST['select_NX'];
        $tennhomxe = get_name($id_nhomxe, '')
        $id_nhienlieu = $_POST['select_NL'];

        $id_thauphu = $_POST['id_thauphu'];
        $id_nhomhang = $_POST['select_NH'];
        


        $sql = "INSERT INTO `xe`( `id_tuyenvantai`, `ten`,`diemdau`, `id_tinhthanhdau`, `diemcuoi`,
        `id_tinhthanhcuoi`, `culy`, `dautieuthu`, `ghichu`,`ngaytao`, `id_nguoitao`) 
        VALUES ('$id_tuyenvantai', '$ten','$diemdau','$id_tinhthanhdau','$diemcuoi','$id_tinhthanhcuoi','$culy','$dau_tieuthu','$ghichu', current_timestamp(),'5')";

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
        ghichu = '$ghichu', id_nguoisua = '3', ngaysua = current_timestamp()
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
    $sql1 = "UPDATE `tuyenvantai` SET `id_nguoisua`='2' WHERE id_tuyenvantai = '$id'";
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