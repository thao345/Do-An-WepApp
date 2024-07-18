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

$stmt = $conn->prepare("SELECT chiphivantai.id_donhang,DATE(chiphivantai.ngaytao) as ngaytao, khachhang.ten as tenkh, khachhang.id_khachhang ,donhang.sokg * 500 as thanhtienkg,phieudonhienlieu.thanhtien as thanhtiennhienlieu,chitietdonhangtamung.tiencuocvo,chitietdonhangtamung.tienhaiquan,chitietdonhangtamung.tiennangha,chitietdonhangtamung.tienkhac,chiphivantai.phicauduong,chiphivantai.tienanca,chiphivantai.luongchuyen,chiphivantai.luongchunhat,chiphivantai.tienthuexengoai,chiphivantai.tongchiphi
FROM donhang 
INNER JOIN nhansu ON donhang.id_sales = nhansu.id_auto_increment 
INNER JOIN khachhang ON donhang.id_khachhang = khachhang.id_khachhang 
INNER JOIN dieuhanh ON donhang.id_donhang = dieuhanh.id_donhang 
INNER JOIN xe ON dieuhanh.id_xe = xe.id_xe 
INNER JOIN tuyenvantai ON donhang.id_tuyenvantai = tuyenvantai.id_tuyenvantai 
INNER JOIN phieudonhienlieu ON donhang.id_donhang = phieudonhienlieu.id_donhang 
INNER JOIN chitietdonhangtamung ON chitietdonhangtamung.id_donhang = donhang.id_donhang 
INNER JOIN chiphivantai ON chiphivantai.id_donhang = donhang.id_donhang 
 WHERE donhang.id_donhang = :id_donhang");

$stmt->bindParam(':id_donhang', $id_donhang);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $data = [
        'id_donhang' => $row['id_donhang'],
        'ngaydongcontainer' => $row['ngaydongcontainer'],
        'ngaytao' => $row['ngaytao'],
        'booking' => $row['booking'],
        'tenkh' => $row['tenkh'],
        'tenhanghoa' => $row['tenhanghoa'],
        'id_nhomhanghoa' => $row['id_nhomhanghoa'],
        'tentuyenvantai' => $row['tentuyenvantai'],
        'bienso' => $row['bienso'],
        'thanhtiendau' => $row['thanhtien'],
        'thuthutuc' => $row['thuthutuc'],
        'thukhac' => $row['thukhac'],
        'thanhtiensokg' => $row['sokg'] *500 , //500đ /1kg
        'sokg' => $row['sokg'] ,
        'tiencuocvo' => $row['tiencuocvo'] ,
        'tienhaiquan' => $row['tienhaiquan'] ,
        'tiennangha' => $row['tiennangha'] ,
        'tienkhac' => $row['tienkhac'] 
    ];
    echo json_encode($data);
} else {

    echo "Không tìm thấy ";
}

$conn = null;
?>