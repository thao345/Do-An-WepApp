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
            include '../danhmuc/tinhthanh/suatinhthanh.php';
            break;
        case 'xoa_tinhthanh':
            include '../danhmuc/tinhthanh/xoatinhthanh.php';
            break;
        case 'danhmucnhansu':
            // Tải nội dung của trang chức năng
            include '../danhmuc/danhmucnhansu/listDanhMucNhanSu.php';
            break;
        case 'suanhansu':
            include'../danhmuc/danhmucnhansu/suaNhanSu.php';
            break;
        case 'themnhansu':
            include'../danhmuc/danhmucnhansu/themNhanSu.php';
            break;
        case 'hangtau':
            include '../danhmuc/hangTau/listHangTau.php';
            break;
        case 'suahangtau':
            
    }
}
?>