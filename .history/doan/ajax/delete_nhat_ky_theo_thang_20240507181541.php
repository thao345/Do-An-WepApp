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

$thang = $_POST['thang'];
$stmt = $conn->prepare("DELETE FROM nhatky WHERE MONTH(thoigian) = :thang");
$stmt->bindParam(':thang', $thang, PDO::PARAM_INT);

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