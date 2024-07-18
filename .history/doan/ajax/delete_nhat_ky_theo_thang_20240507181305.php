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
$stmt = $conn->prepare("DELETE FROM nhatky WHERE MONTH(thoigian) = $thang;");

$stmt->bindParam(':id_tuyenvantai', $idTuyen);
$stmt->execute();

?>