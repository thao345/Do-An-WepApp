<?php
session_start();
session_unset();
session_destroy();
$_SESSION['su']
echo "<script>window.open('../login.php','_self')</script>";
?>