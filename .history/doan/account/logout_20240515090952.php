<?php
session_start();
session_unset();
session_destroy();

echo "<script>window.open('../l.php','_self')</script>";
?>