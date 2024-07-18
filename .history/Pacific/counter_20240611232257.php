<?php
$count = (int)file_get_contents('count.txt');

echo "Số lượng người đang truy cập: " . $count;
?>