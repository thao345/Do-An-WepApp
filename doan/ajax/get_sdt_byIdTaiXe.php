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


$taixeId = $_POST['taixeId'];

$stmt = $conn->prepare("SELECT * from taixe WHERE taixe.id_taixe= :taixeId");

$stmt->bindParam(':taixeId', $taixeId);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = [
        'sodienthoai' => $row['sodienthoai'],
    ];
    echo json_encode($data);
} else {
   
    echo json_encode(array());
}

$conn = null;
?>