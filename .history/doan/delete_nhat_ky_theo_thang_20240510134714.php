<?php
// Kết nối cơ sở dữ liệu

session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');

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
$query = $stmt->execute();

if ($query) {
    $_SESSION['success'] = "Xóa nhật ký tại tháng $thang thành công";
    header('location:nhatky.php');
} else {
    $_SESSION['fail'] = "Xóa nhật ký thất bại";
    header('location:nhatky.php');
}

?>