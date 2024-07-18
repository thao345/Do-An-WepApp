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


$nhomHangHoaId = $_POST['nhomHangHoaId'];

$stmt = $conn->prepare("SELECT * FROM hanghoa WHERE id_nhomhanghoa  = :nhomHangHoaId");

$stmt->bindParam(':nhomHangHoaId', $nhomHangHoaId);
$stmt->execute();

$data = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $item = array(
        'id_hanghoa' => $row['id_hanghoa'],
        'ten' => $row['ten']
    );
    $data[] = $item; // Thêm một bản ghi vào mảng dữ liệu
}

if (!empty($data)) {
    echo json_encode($data);
} else {
    echo "Không tìm thấy";
}

$conn = null;
?>