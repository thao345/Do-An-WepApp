<?php
session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['select_donhang'] &&
        $_POST['soluongnhienlieu'] &&
        $_POST['select_NL'] &&
        $_POST['thanhtien'] &&
        $_POST['ngaydonhienlieu'] &&
        $_POST['select_DVCCD']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $select_donhang = $_POST['select_donhang'];
        $soluongnhienlieu = $_POST['soluongnhienlieu'];
        $select_NL = $_POST['select_NL'];
        $thanhtien = $_POST['thanhtien'];
        $ngaydonhienlieu = $_POST['ngaydonhienlieu'];
        $select_DVCCD = $_POST['select_DVCCD'];
        $ghichu = $_POST['ghichu'];

        $image = $_FILES["anh1"]["name"];

        $image_tmp = $_FILES["anh1"]["tmp_name"];


        $sql = "INSERT INTO `phieudonhienlieu`( `id_donhang`, `ngaydonhienlieu`, `id_dvccdau`, 
        `soluongnhienlieu`, `id_nhienlieu`, `anh1`, `thanhtien`, `ghichu`, `ngaytao`, `id_nguoitao`) 
        VALUES ('$select_donhang', '$ngaydonhienlieu','$select_DVCCD','$soluongnhienlieu','$select_NL','$image','$thanhtien','$ghichu', current_timestamp(),'5')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        move_uploaded_file($image_tmp, 'img/' . $image);
        if ($query) {
            $_SESSION['success'] = "Thêm phiếu mới thành công";
            header('location:list_phieudonhienlieu.php');
        } else {
            $_SESSION['fail'] = "Thêm phiếu mới thất bại";
            header('location:list_phieudonhienlieu.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_pdnl = $_POST['id_edit'];

    $sql = "select * from phieudonhienlieu where id_pdnl ='$id_pdnl'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $select_donhang = $_POST['select_donhang'];
    $soluongnhienlieu = $_POST['soluongnhienlieu'];
    $select_NL = $_POST['select_NL'];
    $thanhtien = $_POST['thanhtien'];
    $ngaydonhienlieu = $_POST['ngaydonhienlieu'];
    $select_DVCCD = $_POST['select_DVCCD'];
    $ghichu  = $_POST['ghichu'];

    if ($_FILES["anh1"]["name"] == '') {
         $image = $result[0]['anh1'];
      } else {
        $image = $_FILES['anh1']['name']; // lấy tên file mới 
        $image_tmp = $_FILES['anh1']['tmp_name']; // đường dẫn tạm thời
        move_uploaded_file($image_tmp, 'img/' . $image); // di chuyển đường dẫn mới vào folder img
      }
   

    $sql = "UPDATE phieudonhienlieu
        SET id_donhang = '$select_donhang', ngaydonhienlieu = '$ngaydonhienlieu', id_dvccdau = '$select_DVCCD', 
        soluongnhienlieu = '$soluongnhienlieu', id_nhienlieu = '$select_NL', anh1 = '$image', thanhtien = '$thanhtien', 
        ghichu = '$ghichu', id_nguoisua = '3', ngaysua = current_timestamp()
        WHERE id_pdnl = '$id_pdnl'";

    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa phiếu thành công";
        header('location:list_phieudonhienlieu.php');
    } else {
        $_SESSION['fail'] = "Sửa phiếu thất bại";
        header('location:list_phieudonhienlieu.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_pdnl = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `phieudonhienlieu` SET `id_nguoisua`='2' WHERE id_pdnl = '$id_pdnl'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `phieudonhienlieu` WHERE id_pdnl = '$id_pdnl'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa phiếu thành công";
        header('location:list_phieudonhienlieu.php');
    } else {
        $_SESSION['fail'] = "Xóa phiếu thất bại";
        header('location:list_phieudonhienlieu.php');
    }
}

?>