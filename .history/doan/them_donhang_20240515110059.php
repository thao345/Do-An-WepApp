<?php
session_start();
if(isset($_SESSION['tendangnhap']) && isset( $_SESSION['id_nguoidung'])){
	$id_nguoidung = $_SESSION['id_nguoidung'];
}
else header('location:login.php'); 

include ('includes/connect.php');


if (isset($_POST['thembtn'])) {
    if (
        $_POST['select_sales'] &&
        $_POST['select_KH'] &&
        $_POST['masothue'] &&
        $_POST['booking'] &&
        $_POST['select_loaihang'] &&
        $_POST['select_NHH'] &&
        $_POST['select_HH'] &&
        $_POST['soluong'] &&
        $_POST['sokg'] &&
        $_POST['select_TVT'] &&
        $_POST['culy'] &&
        $_POST['dautieuthu'] &&
        $_POST['ngaydongcontainer'] &&
        $_POST['nguoigiaonhan'] &&
        $_POST['hanthanhtoan'] 
    ) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $select_sales = $_POST['select_sales'];
        $select_KH = $_POST['select_KH'];
        $masothue = $_POST['masothue'];
        $booking = $_POST['booking'];
        $select_loaihang = $_POST['select_loaihang'];
        $select_hangtau = $_POST['select_hangtau'];
        $select_NHH = $_POST['select_NHH'];
        $select_HH = $_POST['select_HH'];
        $soluong = $_POST['soluong'];
        $sokg = $_POST['sokg'];
        $select_TVT = $_POST['select_TVT'];
        $culy = $_POST['culy'];
        $dautieuthu = $_POST['dautieuthu'];
        $ngaydongcontainer = $_POST['ngaydongcontainer'];
        $giodongcontainer = $_POST['giodongcontainer'];
        $ngaycatmang = $_POST['ngaycatmang'];
        $giocatmang = $_POST['giocatmang'];
        $nguoigiaonhan = $_POST['nguoigiaonhan'];
        $dienthoai = $_POST['dienthoai'];
        $giacuoc = $_POST['giacuoc'];
        $thuthutuc = $_POST['thuthutuc'];
        $thukhac = $_POST['thukhac'];
        $hanthanhtoan = $_POST['hanthanhtoan'];
        $ghichu = $_POST['ghichu'];
        $anh1 = $_POST['anh1'];
        $anh2 = $_POST['anh2'];
        $trangthai = $_POST['trangthai']??'Hoàn thành';

        $image1 = $_FILES["anh1"]["name"];

        $image_tmp1 = $_FILES["anh1"]["tmp_name"];

        $image2 = $_FILES["anh2"]["name"];

        $image_tmp2 = $_FILES["anh2"]["tmp_name"];


        $sql = "INSERT INTO `donhang`( `id_sales`, `id_khachhang`, `masothue`, `booking`, `loaihang`, `id_hangtau`, `id_nhomhanghoa`,
         `id_hanghoa`, `soluong`, `sokg`, `trangthai`, `ngaydongcontainer`, `giodongcontainer`, `id_tuyenvantai`, `culy`, `dautieuthu`, 
         `ngaycatmang`, `giocatmang`, `nguoigiaonhan`, `dienthoai`, `giacuoc`, `thuthutuc`, `thukhac`, `hanthanhtoan`, 
         `ghichu`, `anh1`, `anh2`, `ngaytao`, `id_nguoitao`)  
        VALUES ('$select_sales', '$select_KH','$masothue','$booking','$select_loaihang','$select_hangtau','$select_NHH',
        '$select_HH', '$soluong','$sokg','$trangthai','$ngaydongcontainer','$giodongcontainer','$select_TVT','$culy','$dautieuthu',
        '$ngaycatmang','$giocatmang','$nguoigiaonhan','$dienthoai','$giacuoc','$thuthutuc','$thukhac','$hanthanhtoan',
        '$ghichu','$image1','$image2',current_timestamp(),'$id_nguoidung')";

        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        move_uploaded_file($image_tmp1, 'img/' . $image);
        move_uploaded_file($image_tmp2, 'img/' . $image);
        if ($query) {
            $_SESSION['success'] = "Thêm đơn hàng mới thành công";
            header('location:list_donhang.php');
        } else {
            $_SESSION['fail'] = "Thêm đơn hàng mới thất bại";
            header('location:list_donhang.php');
        }
    }
}



if (isset($_POST['luubtn'])) {
    $id_donhang = $_POST['id_edit'];

    $sql = "select * from donhang where id_donhang ='$id_donhang'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

   
    $select_sales = $_POST['select_sales'];
    $select_KH = $_POST['select_KH'];
    $masothue = $_POST['masothue'];
    $booking = $_POST['booking'];
    $select_loaihang = $_POST['select_loaihang'];
    $select_hangtau = isset($_POST['select_hangtau']) ? $_POST['select_hangtau'] : NULL;
    $select_NHH  = $_POST['select_NHH'];
    $select_HH  = $_POST['select_HH'];
    $soluong  = $_POST['soluong'];
    $sokg  = $_POST['sokg'];
    $select_TVT  = $_POST['select_TVT'];
    $culy  = $_POST['culy'];
    $dautieuthu  = $_POST['dautieuthu'];
    $ngaydongcontainer  = $_POST['ngaydongcontainer'];
    $giodongcontainer  = $_POST['giodongcontainer'];
    $ngaycatmang  = $_POST['ngaycatmang'];
    $giocatmang  = $_POST['giocatmang'];
    $nguoigiaonhan  = $_POST['nguoigiaonhan'];
    $dienthoai  = $_POST['dienthoai'];
    $giacuoc  = $_POST['giacuoc'];
    $thuthutuc  = $_POST['thuthutuc'];
    $thukhac  = $_POST['thukhac'];
    $hanthanhtoan  = $_POST['hanthanhtoan'];
    $ghichu  = $_POST['ghichu'];
    $trangthai  = $_POST['trangthai'] ??'Hoàn thành';
    // echo gettype($select_hangtau);


    if ($_FILES["anh1"]["name"] == '') {
         $image = $result[0]['anh1'];
      } else {
        $image = $_FILES['anh1']['name']; // lấy tên file mới 
        $image_tmp = $_FILES['anh1']['tmp_name']; // đường dẫn tạm thời
        move_uploaded_file($image_tmp, 'img/' . $image); // di chuyển đường dẫn mới vào folder img
      }

      if ($_FILES["anh2"]["name"] == '') {
        $image1 = $result[0]['anh2'];
     } else {
       $image1 = $_FILES['anh2']['name']; // lấy tên file mới 
       $image_tmp1 = $_FILES['anh2']['tmp_name']; // đường dẫn tạm thời
       move_uploaded_file($image_tmp1, 'img/' . $image1); // di chuyển đường dẫn mới vào folder img
     }
   
 // chỗ này chưa có lưu session lên k lấy dc ai là người sửa 
    $sql = "UPDATE donhang
    SET `id_sales`='$select_sales',`id_khachhang`='$select_KH',`masothue`='$masothue',`booking`='$booking',`loaihang`='$select_loaihang',
   `id_hangtau`='$select_hangtau',`id_nhomhanghoa`='$select_NHH',`id_hanghoa`='$select_HH',`soluong`='$soluong',`sokg`='$sokg',
   `trangthai`='$trangthai',`ngaydongcontainer`='$ngaydongcontainer',`giodongcontainer`='$giodongcontainer',`id_tuyenvantai`='$select_TVT',
   `culy`='$culy',`dautieuthu`='$dautieuthu',`ngaycatmang`='$ngaycatmang',`giocatmang`='$giocatmang',`nguoigiaonhan`='$nguoigiaonhan',
   `dienthoai`='$dienthoai',`giacuoc`='$giacuoc',`thuthutuc`='$thuthutuc',`thukhac`='$thukhac',`hanthanhtoan`='$hanthanhtoan',
   `ghichu`='$ghichu',`anh1`='$image',`anh2`='$image1',`ngaysua`=current_timestamp(),`id_nguoisua`='$id_nguoidung'
    WHERE id_donhang = '$id_donhang'";
 

    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    if ($query) {
        $_SESSION['success'] = "Sửa đơn hàng thành công";
        header('location:list_donhang.php');
    } else {
        $_SESSION['fail'] = "Sửa đơn hàng thất bại";
        header('location:list_donhang.php');
    }

}

if (isset($_POST['xoabtn'])) {
    $id_donhang = $_POST['delete_id'];

    // chỗ này lấy $SESSION người dùng lưu vào người sửa để lấy ra ai là ng xóa
    $sql1 = "UPDATE `donhang` SET `id_nguoisua`='2' WHERE id_donhang = '$id_donhang'";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();


    $sql = "DELETE FROM `donhang` WHERE id_donhang = '$id_donhang'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    if ($query && $query1) {
        $_SESSION['success'] = "Xóa đơn hàng thành công";
        header('location:list_donhang.php');
    } else {
        $_SESSION['fail'] = "Xóa đơn hàng thất bại";
        header('location:list_donhang.php');
    }
}

?>