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

$stmt = $conn->prepare("SELECT thauphu.ten as tenthauphu,masothue FROM thauphu WHERE   thauphu.id_thauphu  = :thauphuId");

$stmt->bindParam(':thauphuId', $thauphuId);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = [
        'tenthauphu' => $row['tenthauphu'],
        'masothue' => $row['masothue']
    ];
    echo json_encode($data);
} else {
   
    echo "Không tìm thấy ";
}

$conn = null;
?>