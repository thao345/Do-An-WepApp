<?php
session_start();

include ('includes/connect.php');

if (isset($_POST['thembtn'])) {
  $id_nguoidung = $_POST['id_nguoidung'];
  $selected_functions = $_POST['id_chucnang']; // Array of selected function IDs

  try {
    // Begin transaction for data integrity
    $conn->beginTransaction();

    $sql_delete = "DELETE FROM phanquyen WHERE id_nguoidung = :id_nguoidung"; // Delete existing permissions for the user
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(":id_nguoidung", $id_nguoidung);
    $stmt_delete->execute();

    if ($stmt_delete->rowCount() > 0) {
      echo "Existing permissions for user $id_nguoidung deleted.";
    }

    // **Insert Permissions:**
    $sql_insert = "INSERT INTO phanquyen (id_nguoidung, id_chucnang) VALUES (:id_nguoidung, :id_chucnang)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(":id_nguoidung", $id_nguoidung);

    foreach ($selected_functions as $function_id) {
      $stmt_insert->bindParam(":id_chucnang", $function_id);
      $stmt_insert->execute(); // chạy lệnh thêm
    }

    $conn->commit(); 

    $_SESSION['success'] = "Phân quyền thành công!";
  } catch(PDOException $e) {
    $conn->rollBack(); 
    $_SESSION['fail'] = "Phân quyền thất bại: " . $e->getMessage();
  }

  header('location:list_nguoidung.php'); 
  exit; 
}
?>
