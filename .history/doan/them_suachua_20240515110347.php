<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['select_xe'] &&
        $_POST['ngaysuachua'] &&
        $_POST['sokmdongho'] &&
        $_POST['noidungsuachua'] &&
        $_POST['dongiavattu'] &&
        $_POST['soluong'] &&
        $_POST['tongtien'] 
      
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $select_xe = $_POST['select_xe'];
        $ngaysuachua = $_POST['ngaysuachua'];
        $sokmdongho = $_POST['sokmdongho'];
        $noidungsuachua = $_POST['noidungsuachua'];
        $dongiavattu = $_POST['dongiavattu'];
        $soluong = $_POST['soluong'];
        $tongtien = $_POST['tongtien'];
        $tiennhancong = $_POST['tiennhancong'];
        $nguoisuachua = $_POST['nguoisuachua'];
        $thoigianbaohanh = $_POST['thoigianbaohanh'];
        $ghichu = $_POST['ghichu'];

        // $trangthai = $_POST['trangthai'] ?? 'Hoàn thành';

        $anh = $_POST['anh1'];

        $image = $_FILES["anh1"]["name"];

        $image_tmp = $_FILES["anh1"]["tmp_name"];



        $sql = "INSERT INTO `suachua`( `id_xe`, `ngaysuachua`, `sokmdongho`, `noidungsuachua`, `dongiavattu`, 
        `tiennhancong`, `soluong`, `nguoisuachua`, `thoigianbaohanh`, `tongtien`, `anh1`, `ghichu`, `ngaytao`, `id_nguoitao`)  
        VALUES ('$select_xe', '$ngaysuachua','$sokmdongho','$noidungsuachua','$dongiavattu',
        '$tiennhancong', '$soluong','$nguoisuachua','$thoigianbaohanh','$tongtien','$image','$ghichu',current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        move_uploaded_file($image_tmp, 'img/' . $image);
        if ($query) {
            $_SESSION['success'] = "Thêm sửa chữa thành công";
            header('location:list_suachua.php');
        } else {
            $_SESSION['fail'] = "Thêm sửa chữa thất bại";
            header('location:list_suachua.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_suachua = $_POST['id_edit'];

    $sql = "select * from suachua where id_suachua ='$id_suachua'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }   

    
    $select_xe = $_POST['select_xe'];
    $ngaysuachua = $_POST['ngaysuachua'];
    $sokmdongho = $_POST['sokmdongho'];
    $noidungsuachua = $_POST['noidungsuachua'];
    $dongiavattu = $_POST['dongiavattu'];
    $soluong = $_POST['soluong'];
    $tongtien = $_POST['tongtien'];
    $tiennhancong = $_POST['tiennhancong'];
    $nguoisuachua = $_POST['nguoisuachua'];
    $thoigianbaohanh = $_POST['thoigianbaohanh'];
    $ghichu = $_POST['ghichu'];
   

    if ($_FILES["anh1"]["name"] == '') {
        $image = $result[0]['anh1'];
    } else {
        $image = $_FILES['anh1']['name']; // lấy tên file mới 
        $image_tmp = $_FILES['anh1']['tmp_name']; // đường dẫn tạm thời
        move_uploaded_file($image_tmp, 'img/' . $image); // di chuyển đường dẫn mới vào folder img
    }


    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $sql = "UPDATE `suachua` SET `id_xe`='$select_xe',`ngaysuachua`='$ngaysuachua',`sokmdongho`='$sokmdongho',`noidungsuachua`='$noidungsuachua',
    `dongiavattu`='$dongiavattu',`tiennhancong`='$tiennhancong',`soluong`='$soluong',`nguoisuachua`='$nguoisuachua',`thoigianbaohanh`='$thoigianbaohanh',
    `tongtien`='$tongtien',`anh1`='$image',`ghichu`='$ghichu',`ngaysua`=current_timestamp(),`id_nguoisua`='$id_nguoidung'
    WHERE id_suachua = '$id_suachua'";


    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa sửa chữa thành công";
        header('location:list_suachua.php');
    } else {
        $_SESSION['fail'] = "Sửa sửa chữa thất bại";
        header('location:list_suachua.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_suachua = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `suachua` SET `id_nguoisua`='$id_nguoidung' WHERE id_suachua = '$id_suachua'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `suachua` WHERE id_suachua = '$id_suachua'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa sửa chữa thành công";
        header('location:list_suachua.php');
    } else {
        $_SESSION['fail'] = "Xóa sửa chữa thất bại";
        header('location:list_suachua.php');
    }
}

?>