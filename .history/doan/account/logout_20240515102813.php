<?php
session_start();
session_unset();
session_destroy();
$_SESSION['success']='';
echo "<script>window.open('../login.php','_self')</script>";
?>