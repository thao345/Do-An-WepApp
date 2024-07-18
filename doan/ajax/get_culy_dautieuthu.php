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


$idTuyen = $_POST['idTuyen'];

$stmt = $conn->prepare("SELECT * FROM tuyenvantai WHERE id_tuyenvantai  = :id_tuyenvantai");

$stmt->bindParam(':id_tuyenvantai', $idTuyen);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = [
        'culy' => $row['culy'],
        'dautieuthu' => $row['dautieuthu'],
    ];
    echo json_encode($data);
} else {
   
    echo "Không tìm thấy ";
}

$conn = null;
?>