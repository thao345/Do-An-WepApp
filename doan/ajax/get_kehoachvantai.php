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


$id_dieuhanh = $_POST['id_dieuhanh'];

$stmt = $conn->prepare("    SELECT dieuhanh.id_donhang,dieuhanh.id_dieuhanh,donhang.booking,donhang.id_khachhang,khachhang.ten as tenkh,donhang.id_tuyenvantai,tuyenvantai.ten as tentuyenvantai,donhang.id_hanghoa,hanghoa.ten as tenhanghoa,donhang.loaihang,donhang.id_nhomhanghoa,dieuhanh.id_thauphu,dieuhanh.tenthauphu,donhang.ngaydongcontainer,donhang.giodongcontainer,donhang.id_hangtau,dieuhanh.tinhtrangdonhang,donhang.ghichu as ghichudonhang,dieuhanh.ghichu as ghichudieuhanh,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(dieuhanh.ngaytao) as ngaytao,
nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(dieuhanh.ngaysua) as ngaysua
FROM dieuhanh

INNER JOIN nguoidung ON dieuhanh.id_nguoitao = nguoidung.id_nguoidung
LEFT JOIN nguoidung AS nguoidung2 ON dieuhanh.id_nguoisua = nguoidung2.id_nguoidung
INNER JOIN donhang ON dieuhanh.id_donhang = donhang.id_donhang
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai
INNER JOIN hanghoa ON donhang.id_hanghoa = hanghoa.id_hanghoa
INNER JOIN thauphu ON dieuhanh.id_thauphu = thauphu.id_thauphu
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang

WHERE id_dieuhanh = :id_dieuhanh");

$stmt->bindParam(':id_dieuhanh', $id_dieuhanh);
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
        'id_dieuhanh' => $row['id_dieuhanh'],
        'booking' => $row['booking'],
        'id_khachhang' => $row['id_khachhang'],
        'tenkh' => $row['tenkh'],
        'tentuyenvantai' => $row['tentuyenvantai'],
        'tenhanghoa' => $row['tenhanghoa'],
        'loaihang' => $loaihang,
        'id_nhomhanghoa' => $row['id_nhomhanghoa'],
        'id_thauphu' => $row['id_thauphu'],
        'tenthauphu' => $row['tenthauphu'],
        'ngaydongcontainer' => $row['ngaydongcontainer'],
        'giodongcontainer' => $row['giodongcontainer'],
        'id_hangtau' => $row['id_hangtau'] ?? '',
        'tinhtrangdonhang' => $row['tinhtrangdonhang'],
        'ghichudonhang' => $row['ghichudonhang'] ?? '',
        'ghichudieuhanh' => $row['ghichudieuhanh'] ?? ''
    ];
    echo json_encode($data);
} else {

    echo "Không tìm thấy ";
}

$conn = null;
?>