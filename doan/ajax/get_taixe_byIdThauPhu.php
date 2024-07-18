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

$thauphuId = $_POST['thauphuId'];


// lấy tài xế 
$stmt2 = $conn->prepare("SELECT taixe.id_taixe,taixe.ten as tentaixe,taixe.sodienthoai 
FROM taixe 
INNER JOIN thauphu ON thauphu.id_thauphu = taixe.id_thauphu
WHERE taixe.id_thauphu = :thauphuId");


$stmt2->bindParam(':thauphuId', $thauphuId);
$stmt2->execute();

$data = array();

while ($rowTaiXe = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $item = array(
        'id_taixe' => $rowTaiXe['id_taixe'],
        'tentaixe' => $rowTaiXe['tentaixe']
    );
    $data[] = $item; // Thêm một bản ghi vào mảng dữ liệu
}

if (!empty($data)) {
    echo json_encode($data);
} else {
    echo json_encode(array());
}

$conn = null;
?>