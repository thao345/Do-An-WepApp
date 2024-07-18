<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "student";
$password = "123456";
$dbname = "qlxe"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
 

$id_donhang = $_POST['id_donhang'];

$stmt = $conn->prepare("SELECT donhang.id_donhang,donhang.id_sales,donhang.masothue,donhang.booking,donhang.loaihang,
donhang.id_hangtau,donhang.id_nhomhanghoa,donhang.id_hanghoa,donhang.soluong,donhang.sokg,donhang.trangthai,
donhang.ngaydongcontainer,donhang.giodongcontainer,donhang.id_tuyenvantai,donhang.culy,donhang.dautieuthu,donhang.ngaycatmang,
donhang.nguoigiaonhan,donhang.dienthoai,donhang.giacuoc,donhang.thuthutuc,donhang.thukhac,donhang.hanthanhtoan,donhang.ghichu,
nhansu.ten as tensales, DATE(donhang.ngaytao) as ngaytao,khachhang.ten as tenkh 
FROM donhang 
INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
 WHERE id_donhang = :id_donhang");

$stmt->bindParam(':id_donhang', $id_donhang);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $loaihang = '';

    if ($row['loaihang'] == 1) {
        $loaihang = 'Nhập';
    } elseif ($row['loaihang'] == 2) {
        $loaihang = 'Xuất';
    } elseif ($row['loaihang'] == 3) {
        $loaihang = 'Nội địa';
    }

    $data = [
        'id_donhang' => $row['id_donhang'],
        'tensales' => $row['tensales'],
        'ngaytao' => $row['ngaytao'],
        'booking' => $row['booking'],
        'tenkh' => $row['tenkh'],
        'loaihang' => $loaihang,
        'id_nhomhanghoa' => $row['id_nhomhanghoa'],
        'id_tuyenvantai' => $row['id_tuyenvantai'],
        'sokg' => $row['sokg'],
        'ghichu' => $row['ghichu'],
    ];
    echo json_encode($data);
} else {

    echo "Không tìm thấy ";
}

$conn = null;
?>