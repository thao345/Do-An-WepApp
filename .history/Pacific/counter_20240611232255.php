<?php
$count = (int)file_get_contents('count.txt');

// Hiển thị số lượng người truy cập
echo "Số lượng người đang truy cập: " . $count;
?>