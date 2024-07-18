<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    

    // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];
    $img = $_FILES["img"]["name"];

    $img_tmp = $_FILES["img"]["tmp_name"];

    $sql = "INSERT INTO tintuc ( tieude, noidung, img,ngaytao, id_nguoitao) 
                VALUES ( '$tieude','$noidung','$img', current_timestamp(),'2')";


    // $stmt = $conn->prepare($sql);
    // $query = $stmt->execute();
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if (move_uploaded_file($img_tmp, '../website_gt/images/' . $img)) {
        if ($query) {
            $_SESSION['success'] = "Thêm tin mới thành công";
            header('location:list_tintuc.php');
        } else {
            $_SESSION['fail'] = "Thêm thất bại";
            header('location:list_tintuc.php');
        }
    }else {
        $_SESSION['fail'] = "Thêm ảnh thất bại";
        header('location:list_tintuc.php');
    }

}



if (isset($_POST['luubtn'])) {

    // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $id_tintuc = $_POST["id_tintuc"];
    $tieude = $_POST["tieude"];

    if ($_FILES["img"]["name"] != '') {
        $img = $_FILES['img']['name']; // Lấy tên file mới 
        $img_tmp = $_FILES['img']['tmp_name']; // Đường dẫn tạm thời
        move_uploaded_file($img_tmp, '../website_gt/images/'.$img); // Di chuyển file mới vào thư mục ảnh
    } else {
        // Nếu không có file mới, sử dụng tên ảnh cũ
        $img = $_POST['current_img'];
    }
  
    $noidung = $_POST["noidung"];
  
  
    $sql = "UPDATE  tintuc SET  tieude='$tieude',  noidung='$noidung', img='$img',
          id_nguoisua= '3', ngaysua=current_timestamp()  where id_tintuc = '$id_tintuc' ";
    // var_dump($sql);
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa thành công";
        header('location:list_tintuc.php');
    } else {
        $_SESSION['fail'] = "Sửa thất bại";
        header('location:list_tintuc.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_tintuc = $_POST['delete_id'];

    $sql = "DELETE FROM `tintuc` WHERE id_tintuc = '$id_tintuc'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query) {
        $_SESSION['success'] = "Xóathành công";
        header('location:list_tintuc.php');
    } else {
        $_SESSION['fail'] = "Xóa thất bại";
        header('location:list_tintuc.php');
    }
}

?>