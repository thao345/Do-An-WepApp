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

$nhomhanghoa = $_POST['nhomhanghoa'];

$stmt = $conn->prepare("SELECT id_thauphu, thauphu.ten as tentp FROM thauphu INNER JOIN nhomhanghoa ON nhomhanghoa.id_nhomhanghoa
 = thauphu.id_nhomhanghoa WHERE thauphu.id_nhomhanghoa = :nhomhanghoa");

$stmt->bindParam(':nhomhanghoa', $nhomhanghoa);
$stmt->execute();

$data = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $item = array(
        'id_thauphu' => $row['id_thauphu'],
        'tentp' => $row['tentp']
    );
    $data[] = $item; // Thêm một bản ghi vào mảng dữ liệu
}

if (!empty($data)) {
    echo json_encode($data);
} else {
    echo "Không tìm thấy id_tp";
}

$conn = null;
?>