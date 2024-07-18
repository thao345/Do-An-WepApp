<?php
session_start();
if(!isset($_SESSION['username'])){
	header('location:signin.php'); 
}
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['phicauduong_cpvt'] &&
        $_POST['tienanca_cpvt'] &&
        $_POST['luongchuyen_cpvt'] &&
        $_POST['luongchunhat_cpvt'] &&
        $_POST['tienthuexengoai_cpvt'] &&
        $_POST['tongchiphi_cpvt'] &&
        $_POST['id_donhang_cpvt']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_donhang_cpvt = $_POST['id_donhang_cpvt'];
        $phicauduong_cpvt = $_POST['phicauduong_cpvt'];
        $tienanca_cpvt = $_POST['tienanca_cpvt'];
        $luongchuyen_cpvt = $_POST['luongchuyen_cpvt'];
        $luongchunhat_cpvt = $_POST['luongchunhat_cpvt'];
        $tienthuexengoai_cpvt = $_POST['tienthuexengoai_cpvt'];
        $tongchiphi_cpvt = $_POST['tongchiphi_cpvt'];
        $ghichu_cpvt = $_POST['ghichu_cpvt'];


        $sql = "INSERT INTO `chiphivantai`( `id_donhang`,  `phicauduong`, `tienanca`, `luongchuyen`, `luongchunhat`, `tienthuexengoai`,
         `tongchiphi`, `ghichu`, `ngaytao`, `id_nguoitao`)  
        VALUES ('$id_donhang_cpvt', '$phicauduong_cpvt','$tienanca_cpvt','$luongchuyen_cpvt','$luongchunhat_cpvt',
        '$tienthuexengoai_cpvt', '$tongchiphi_cpvt','$ghichu_cpvt',current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            $_SESSION['success'] = "Thêm chi phí thành công";
            header('location:list_chiphivantai.php');
        } else {
            $_SESSION['fail'] = "Thêm chi phí thất bại";
            header('location:list_chiphivantai.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_cpvt = $_POST['id_edit'];

    
    $id_donhang_cpvt = $_POST['id_donhang_cpvt'];
    $phicauduong_cpvt = $_POST['phicauduong_cpvt'];
    $tienanca_cpvt = $_POST['tienanca_cpvt'];
    $luongchuyen_cpvt = $_POST['luongchuyen_cpvt'];
    $luongchunhat_cpvt = $_POST['luongchunhat_cpvt'];
    $tienthuexengoai_cpvt = $_POST['tienthuexengoai_cpvt'];
    
    $tongchiphi_cpvt = $_POST['tongchiphi_cpvt'];
    $ghichu_cpvt = $_POST['ghichu_cpvt'];
  

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $sql = "UPDATE `chiphivantai` SET  `id_donhang`='$id_donhang_cpvt',`phicauduong`='$phicauduong_cpvt',`tienanca`='$tienanca_cpvt',
    `luongchuyen`='$luongchuyen_cpvt',`luongchunhat`='$luongchunhat_cpvt',`tienthuexengoai`='$tienthuexengoai_cpvt',`tongchiphi`='$tongchiphi_cpvt',
    `ghichu`='$ghichu_cpvt',`ngaysua`=current_timestamp(),`id_nguoisua`='3'
    WHERE id_cpvt = '$id_cpvt'";


    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa chi phí thành công";
        header('location:list_chiphivantai.php');
    } else {
        $_SESSION['fail'] = "Sửa chi phí thất bại";
        header('location:list_chiphivantai.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_cpvt = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `chiphivantai` SET `id_nguoisua`='2' WHERE id_cpvt = '$id_cpvt'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `chiphivantai` WHERE id_cpvt = '$id_cpvt'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa chi phí thành công";
        header('location:list_chiphivantai.php');
    } else {
        $_SESSION['fail'] = "Xóa chi phí thất bại";
        header('location:list_chiphivantai.php');
    }
}

?>