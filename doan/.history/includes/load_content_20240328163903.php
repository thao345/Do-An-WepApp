<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        // tỉnh thành
        case 'list_tinhthanh':
            include '../danhmuc/tinhthanh/list_tinhthanh.php';
            break;
        case 'them_tinhthanh':
            include '../danhmuc/tinhthanh/them_tinhthanh.php';
            break;
        case 'sua_tinhthanh': 
            include '../danhmuc/tinhthanh/sua_tinhthanh.php';
            break;
        case 'xoa_tinhthanh':
            include '../danhmuc/tinhthanh/xoa_tinhthanh.php';
            break;

    }
}
?>