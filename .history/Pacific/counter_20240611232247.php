<?php

$file = 'count.txt';

// Đọc số lượng truy cập hiện tại từ file
$count = (int)file_get_contents(count.txt);

// Hiển thị số lượng người truy cập
echo "Số lượng người đang truy cập: " . $count;
?>