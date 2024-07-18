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


$id_loaihang = $_POST['id_loaihang'];
$id_nhh = $_POST['id_nhh'];

$stmt = $conn->prepare("SELECT * FROM `lichtrinh` WHERE id_nhomhanghoa = :id_nhomhanghoa and loaihang =:loaihang");

$stmt->bindParam(':id_nhomhanghoa', $id_nhh);
$stmt->bindParam(':loaihang', $id_loaihang);
$stmt->execute();

$data = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $item = array(
        'id_lichtrinh' => $row['id_lichtrinh'],
        'ten' => $row['ten']
    );
    $data[] = $item;
}

if (!empty($data)) {
    echo json_encode($data);
} else {
    echo json_encode(array());
}

$conn = null;
?>