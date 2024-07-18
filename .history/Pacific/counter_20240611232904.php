<?php


// Đường dẫn tới tập tin lưu trữ số lượng truy cập
$file = 'count.txt';

// Đọc số lượng truy cập hiện tại từ file
$data = file_get_contents($file);
list($current_visitors, $total_visitors) = explode('|', $data);
$current_visitors = (int)$current_visitors;
$total_visitors = (int)$total_visitors;

// Hiển thị số lượng người truy cập
echo "Số lượng người đang truy cập: " . $current_visitors . "<br>";
echo "Tổng số người đã truy cập: " . $total_visitors;
?>