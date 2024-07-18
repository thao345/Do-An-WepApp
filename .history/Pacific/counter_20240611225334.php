<?php
session_start();

// Đường dẫn tới tập tin lưu trữ số lượng truy cập
$file = 'count.txt';

// Đọc số lượng truy cập hiện tại từ file
$count = (int)file_get_contents($file);

// Hiển thị số lượng người truy cập
echo "Số lượng người đang truy cập: " . $count;
?>