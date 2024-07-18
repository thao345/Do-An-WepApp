<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');

//get page number
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

//total row to display
$total_records_per_page = 10;
//get the page offset for LIMIT query
$offset = ($page_no - 1) * $total_records_per_page;
// echo $offset;
//get previous page
$previous_page = $page_no - 1;
//get next page
$next_page = $page_no + 1;

//get total count of records
$sqlCount = "SELECT COUNT(*) as total_rows FROM tintuc";
$stmtCount = $conn->prepare($sqlCount);
$queryCount = $stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total_records = $rowCount['total_rows']; // tổng dòng
//get total page
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$sql = "SELECT tintuc.id_tintuc, tintuc.tieude,tintuc.noidung,tintuc.img, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung,DATE(tintuc.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung,DATE(tintuc.ngaysua) as ngaysua FROM tintuc INNER JOIN nguoidung ON tintuc.id_nguoitao = nguoidung.id_nguoidung LEFT JOIN nguoidung AS nguoidung2 ON tintuc.id_nguoisua = nguoidung2.id_nguoidung WHERE 1
        ORDER BY tintuc.ngaytao DESC
        LIMIT $offset,$total_records_per_page";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

// if(isset($_POST['thembtn']))
// if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
//     $from_date = $_GET['from_date'];
//     $to_date = $_GET['to_date'];

//     $sql = "SELECT nhansu.id_nhansu, nhansu.ten, nhansu.tenphongban,nhansu.chucvu, nhansu.nguyenquan, nhansu.diachithuongtru, nhansu.ngaysinh, nhansu.cmnd, nhansu.sđt, nhansu.stk,nhansu.tennganhang, nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(nhansu.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(nhansu.ngaysua) as ngaysua
//             FROM nhansu INNER JOIN nguoidung ON nhansu.id_nguoitao = nguoidung.id_nguoidung
//             LEFT JOIN nguoidung AS nguoidung2 ON nhansu.id_nguoisua = nguoidung2.id_nguoidung
//             WHERE tinhthanh.ngaysua BETWEEN '$from_date' AND '$to_date'
//             ORDER BY tinhthanh.ngaytao DESC
//             LIMIT $offset,$total_records_per_page";

//     $stmt = $conn->prepare($sql);
//     $query = $stmt->execute();
//     $result = array();
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $result[] = $row;

//     }

// if (empty($result)) {
//     echo "No Record Found";
// } else {
//     foreach ($result as $row) {
//         echo "day la timkiem";
//         echo "ID: " . $row['id_tinhthanh'] . "<br>";
//         echo "Tên tỉnh thành: " . $row['ten'] . "<br>";
//         echo "Người tạo: " . $row['nguoitao'] . "<br>";
//         echo "ID người tạo: " . $row['id_nguoidung'] . "<br>";
//         echo "Ngày tạo: " . $row['ngaytao'] . "<br>";
//         echo "Người sửa: " . $row['nguoisua'] . "<br>";
//         echo "ID người sửa: " . $row['id_nguoidung'] . "<br>";
//         echo "Ngày sửa: " . $row['ngaysua'] . "<br>";
//         echo "<br>";
//     }
// }

// } else {

// }
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <button id="fullscreenButton">
                    <i class="fas fa-expand"></i>
                </button>
                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>



                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <?php
                include 'includes/userInformation.php';
                ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Danh sách tin tức</h1>
            <!-- Topbar Search -->
            <div class="d-flex">
                <form class="form-inline mr-3 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control border-1 small search-input" placeholder="Tìm kiếm..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>



                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal"
                    data-whatever="@mdo">Thêm tin tức</button>

                <!-- <form class="form-inline ml-auto mr-4 " method="GET">
                    <div class="form-group">
                        <label class="mr-2">Từ ngày:</label>
                        <input type="date" class="form-control" name="from_date"
                            value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <label class="mr-2">Đến ngày:</label>
                        <input type="date" class="form-control" name="to_date"
                            value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" name="filter" class="btn btn-primary">Filter</button>

                    </div>
                </form> -->
            </div>








            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <!-- modal-sm  modal-xl  modal-lg  -->
                <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header header-crud ">
                            <h1 class="modal-title  flex-grow-1 text-gray-800  header-crud" id="exampleModalLabel">Thêm
                                Tin tức</h1>

                            <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="them_tintuc.php" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom02">Tiêu đề</label>
                                        <input type="text" class="form-control" name="tieude" id="validationCustom02"
                                            placeholder="Tiêu đề" value="" required>
                                        <div class="invalid-feedback">
                                            Nhập tiêu đề.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom02">Nội dung</label>

                                        <textarea name="noidung" id="editor1" required></textarea>
                                        <div class="invalid-feedback">
                                            nhập Nội dung.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Ảnh</label>
                                        <div class="form-group">

                                            <input type="file" name="img" placeholder="Ảnh" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Vui lòng chọn ảnh.
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Trở
                                        lại</button>
                                    <button type="submit" name="thembtn" class="btn btn-primary">Thêm</button>
                                </div>

                            </form>


                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class=" table  table-bordered table-hover " id="myTable" width="100%" cellspacing="0">
                        <thead style=" white-space: nowrap;">
                            <tr>
                                <th>STT</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Ảnh</th>

                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th>Ngày sửa</th>
                                <th>Người sửa</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody style=" white-space: nowrap;">
                            <?php $count = 1;
                            $hasData = false; // Biến kiểm tra dữ liệu
                            foreach ($result as $items):
                                $hasData = true; // Đánh dấu có dữ liệu                    ?>

                                <tr data-id="<?php echo $items['id_tintuc']; ?>">
                                    <td>
                                        <?php echo $count++; ?>
                                    </td>

                                    <td>
                                        <?php echo $items['tieude']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['noidung']; ?>
                                    </td>
                                    <td>
                                        <img style="width: 100px;" src="../website_gt/images/<?php echo $items['img']; ?> ">

                                    </td>


                                    <td>
                                        <?php echo $items['ngaytao']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoitao']; ?>
                                    </td>
                                    <td>
                                    <?php if($items['ngaysua'] != null) echo date('d-m-Y', strtotime($items['ngaysua'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $items['nguoisua']; ?>
                                    </td>

                                    <td>
                                        <form action="sua_tintuc.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $items['id_tintuc']; ?>">
                                            <button name="suabtn" class="btn btn-success">Sửa</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Thêm modal dialog -->
                                        <!-- Modal for Delete Confirmation -->
                                        <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Xác nhận xóa</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn có chắc chắn muốn xóa tin tức này?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form id="deleteForm" method="POST" action="them_tintuc.php">
                                                            <input type="hidden" name="delete_id" id="delete_id" value="">
                                                            <button type="submit" name="xoabtn"
                                                                class="btn btn-danger">Xoá</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nút "Xóa" -->
                                        <button class="btn btn-danger deleteBtn" data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-id="<?php echo $items['id_tintuc']; ?>">Xoá</button>

                                    </td>
                                </tr>

                            <?php endforeach ?>
                            <?php if (!$hasData): ?>
                                <tr>
                                    <td colspan="100" class="text-center">Không tìm thấy dữ liệu phù hợp!</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between">

                        <div class="p-10 mb-3">
                            <strong>Page
                                <?= $page_no; ?> of
                                <?= $total_no_of_pages; ?>
                            </strong>
                        </div>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>
                                        Previous
                                    </a>
                                </li>

                                <?php
                                $start_page = max(1, $page_no - 2);
                                $end_page = min($start_page + 4, $total_no_of_pages);

                                for ($counter = $start_page; $counter <= $end_page; $counter++) {
                                    ?>
                                    <li class="page-item <?php echo ($page_no == $counter) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page_no=<?= $counter; ?>">
                                            <?= $counter; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>

                                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>




        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>

    <script>

        CKEDITOR.ClassicEditor.create(document.getElementById("editor1"), {
            toolbar: {
                items: [
                    'exportPDF', 'exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },

            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            placeholder: 'Nhập nội dung',
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [
                    {
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }
                ]
            },
            removePlugins: [

                'AIAssistant',
                'CKBox',
                'CKFinder',
                'EasyImage',

                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',

                'MathType',
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced',
                'CaseChange'
            ]
        });
    </script>
    <script>
        // viết js custom ở đây
        $('tr[data-id]').on('dblclick', function () {
            // Lấy ID của mục được nhấp đúp
            var id = $(this).data('id');
            // Chuyển hướng đến trang sửa với ID tương ứng
            window.location.href = 'sua_tintuc.php?edit_id=' + id;
        });


    </script>
    <script>
        $(document).ready(function() {
            $('.deleteBtn').click(function() {
                var id = $(this).data('id');
                $('#delete_id').val(id);
            });
        });
    </script>

    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>