<?php
session_start();
session_unset();
session_destroy();
$_SESSION['success']='Đăng xuất thành công.';
head
?>