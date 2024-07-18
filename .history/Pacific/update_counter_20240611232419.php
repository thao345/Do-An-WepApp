<?php
session_start();

// Đường dẫn tới tập tin lưu trữ số lượng truy cập
$file = 'count.txt';

// Kiểm tra nếu file không tồn tại thì tạo nó và khởi tạo giá trị là 0
if (!file_exists($file)) {
    file_put_contents($file, '0');
}

// Đọc số lượng truy cập hiện tại từ file
$count = (int)file_get_contents($file);

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'increment' && !isset($_SESSION['has_visited'])) {
        $_SESSION['has_visited'] = true;
        $count++;
    } elseif ($_GET['action'] == 'decrement' && isset($_SESSION['has_visited'])) {
        unset($_SESSION['has_visited']);
        $count--;
    }
    file_put_contents($file, $count);
}
echo $count;
?>