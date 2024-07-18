<?php
session_start();

// Đường dẫn tới tập tin lưu trữ số lượng truy cập
$file = 'count.txt';

// Kiểm tra nếu file không tồn tại thì tạo nó và khởi tạo giá trị là "0|0"
if (!file_exists($file)) {
    file_put_contents($file, '0|0');
}

// Đọc số lượng truy cập hiện tại từ file
$data = file_get_contents($file);
list($current_visitors, $total_visitors) = explode('|', $data);
$current_visitors = (int)$current_visitors;
$total_visitors = (int)$total_visitors;

// Kiểm tra hành động (tăng hoặc giảm)
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'increment' && !isset($_SESSION['has_visited'])) {
        $_SESSION['has_visited'] = true;
        $current_visitors++;
        $total_visitors++;
    } elseif ($_GET['action'] == 'decrement' && isset($_SESSION['has_visited'])) {
        unset($_SESSION['has_visited']);
        $current_visitors--;
    }
    file_put_contents($file, $current_visitors . '|' . $total_visitors);
}

// Trả về số lượng người truy cập hiện tại và tổng số người truy cập
echo json_encode([
    'current_visitors' => $current_visitors,
    'total_visitors' => $total_visitors
]);
?>