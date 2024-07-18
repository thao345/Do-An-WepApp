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


$idKhachHang = $_POST['idKhachHang'];

$stmt = $conn->prepare("SELECT * FROM `khachhang` WHERE id_khachhang  = :idKhachHang");

$stmt->bindParam(':idKhachHang', $idKhachHang);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = [
        'masothue' => $row['masothue'],
    ];
    echo json_encode($data);
} else {
   
    echo "Không tìm thấy ";
}

$conn = null;
?>