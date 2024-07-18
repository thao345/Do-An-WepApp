<?php
session_start();
session_unset();
session_destroy();
$_SESSION['success'] = "Thêm điều hành thành công";
header('Location:../login.php')
?>