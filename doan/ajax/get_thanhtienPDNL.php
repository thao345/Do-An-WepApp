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

// Lấy id_nhienlieu từ yêu cầu POST
$idNhienLieu = $_POST['id_nhienlieu'];

$stmt = $conn->prepare("SELECT `dongiasauthue`FROM `nhienlieu` WHERE id_nhienlieu  = :id_nhienlieu");

$stmt->bindParam(':id_nhienlieu', $idNhienLieu);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = [
        'dongiasauthue' => $row['dongiasauthue'],
    ];
    echo json_encode($data);
} else {
   
    echo "Không tìm thấy ";
}

$conn = null;
?>