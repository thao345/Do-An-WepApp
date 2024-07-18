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

// lấy xe
$stmt1 = $conn->prepare("SELECT xe.id_xe,xe.bienso
FROM xe 
INNER JOIN thauphu ON thauphu.id_thauphu = xe.id_thauphu 
WHERE xe.trangthaixe = 'OK'  and xe.id_thauphu = :thauphuId");

$stmt1->bindParam(':thauphuId', $thauphuId);
$stmt1->execute();

$data = array();

while ($rowXe = $stmt1->fetch(PDO::FETCH_ASSOC))  {
    $item = array(
        'id_xe' => $rowXe['id_xe'] ,
        'bienso' => $rowXe['bienso'] ,
      
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