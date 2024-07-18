<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['select_sales_tamung'] &&
        $_POST['ngaytamung'] &&
        $_POST['id_donhang_tamung']
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $id_donhang_tamung = $_POST['id_donhang_tamung'];
        $select_sales_tamung = $_POST['select_sales_tamung'];
        $ngaytamung = $_POST['ngaytamung'];
        $ngaythanhtoan_tamung = $_POST['ngaythanhtoan_tamung'];
        $giothanhtoan_tamung = $_POST['giothanhtoan_tamung'];
        $tiencuocvo_tamung = $_POST['tiencuocvo_tamung'];
        $tienhaiquan_tamung = $_POST['tienhaiquan_tamung'];
        $tiennangha_tamung = $_POST['tiennangha_tamung'];
        $tienkhac_tamung = $_POST['tienkhac_tamung'];
        $ghichu_tamung = $_POST['ghichu_tamung'];

        // $trangthai = $_POST['trangthai'] ?? 'Hoàn thành';

        $anh = $_POST['anh1_tamung'];

        $image = $_FILES["anh1_tamung"]["name"];

        $image_tmp = $_FILES["anh1_tamung"]["tmp_name"];



        $sql = "INSERT INTO `chitietdonhangtamung`( `id_donhang`, `ngaytamung`, `id_nhansu`, `tiencuocvo`, `tienhaiquan`, 
        `tiennangha`, `tienkhac`, `ngaythanhtoan`, `giothanhtoan`, `ghichu`, `anh1`, `ngaytao`, `id_nguoitao`)  
        VALUES ('$id_donhang_tamung', '$ngaytamung','$select_sales_tamung','$tiencuocvo_tamung','$tienhaiquan_tamung',
        '$tiennangha_tamung', '$tienkhac_tamung','$ngaythanhtoan_tamung','$giothanhtoan_tamung','$ghichu_tamung',
        '$image',current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        move_uploaded_file($image_tmp, 'img/' . $image);
        if ($query) {
            $_SESSION['success'] = "Thêm tạm ứng thành công";
            header('location:list_tamung.php');
        } else {
            $_SESSION['fail'] = "Thêm tạm ứng thất bại";
            header('location:list_tamung.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_ctdhtu = $_POST['id_edit'];

    $sql = "select * from chitietdonhangtamung where id_ctdhtu ='$id_ctdhtu'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }   

    
    $id_donhang_tamung = $_POST['id_donhang_tamung'];
    $select_sales_tamung = $_POST['select_sales_tamung'];
    $ngaytamung = $_POST['ngaytamung'];
    $ngaythanhtoan_tamung = $_POST['ngaythanhtoan_tamung'];
    $giothanhtoan_tamung = $_POST['giothanhtoan_tamung'];
    $tiencuocvo_tamung = $_POST['tiencuocvo_tamung'];
    
    $tienhaiquan_tamung = $_POST['tienhaiquan_tamung'];
    $tiennangha_tamung = $_POST['tiennangha_tamung'];
    $tienkhac_tamung = $_POST['tienkhac_tamung'];
    $ghichu_tamung = $_POST['ghichu_tamung'];
   

    if ($_FILES["anh1_tamung"]["name"] == '') {
        $image = $result[0]['anh1'];
    } else {
        $image = $_FILES['anh1_tamung']['name']; // lấy tên file mới 
        $image_tmp = $_FILES['anh1_tamung']['tmp_name']; // đường dẫn tạm thời
        move_uploaded_file($image_tmp, 'img/' . $image); // di chuyển đường dẫn mới vào folder img
    }


    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $sql = "UPDATE `chitietdonhangtamung` SET `id_donhang`='$id_donhang_tamung',`ngaytamung`='$ngaytamung',`id_nhansu`='$select_sales_tamung',
    `tiencuocvo`='$tiencuocvo_tamung',`tienhaiquan`='$tienhaiquan_tamung',`tiennangha`='$tiennangha_tamung',`tienkhac`='$tienkhac_tamung',
    `ngaythanhtoan`='$ngaythanhtoan_tamung',
    `giothanhtoan`='$giothanhtoan_tamung',`ghichu`='$ghichu_tamung',`anh1`='$image',`ngaysua`=current_timestamp(),`id_nguoisua`='3'
    WHERE id_ctdhtu = '$id_ctdhtu'";


    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa tạm ứng thành công";
        header('location:list_tamung.php');
    } else {
        $_SESSION['fail'] = "Sửa tạm ứng thất bại";
        header('location:list_tamung.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_ctdhtu = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `chitietdonhangtamung` SET `id_nguoisua`='2' WHERE id_ctdhtu = '$id_ctdhtu'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `chitietdonhangtamung` WHERE id_ctdhtu = '$id_ctdhtu'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa tạm ứng thành công";
        header('location:list_tamung.php');
    } else {
        $_SESSION['fail'] = "Xóa tạm ứng thất bại";
        header('location:list_tamung.php');
    }
}

?>