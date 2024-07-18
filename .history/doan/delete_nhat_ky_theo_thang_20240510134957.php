<?php
// Kết nối cơ sở dữ liệu

session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php'); 
// }
include ('includes/connect.php');
if (isset($_POST['thembtn'])) {

}
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



?>