<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id_tintuc = $_POST['edit_id'];
    $sql = "SELECT * FROM `tintuc` WHERE id_tintuc ='$id_tintuc'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $id_tintuc = $_GET['edit_id'];
    $sql = "SELECT * FROM `tintuc` WHERE id_tintuc ='$id_tintuc'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}



?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <div > 
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: ".$tendangnhap; ?></span>
            <br>
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: ".$thoigiandangnhap; ?></span>
        </div>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa Tin tức</h1>

            <form class="needs-validation" novalidate action="them_tintuc.php" method="POST"
                enctype="multipart/form-data">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Mã tin tức</label>
                            <input type="text" class="form-control" name="id_tintuc" id="validationCustom01"
                                placeholder="Mã tin tức" value="<?php echo $id_tintuc; ?>" required readonly>
                            <div class="invalid-feedback">
                                Nhập mã tin tức.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Tiêu đề</label>
                            <input type="text" class="form-control" name="tieude" id="validationCustom02"
                                placeholder="Tiêu đề" value="<?php echo $items['tieude']; ?>" required>
                            <div class="invalid-feedback">
                                Nhập Tiêu đề.
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="">Nội dung</label>

                            <textarea name="noidung" id="editor1"
                                class="form-control"><?php echo $items['noidung']; ?></textarea>
                        </div>
                        <div class="col-md-4 mb-3 ml-3">
                            <label for="exampleFormControlFile1">Chọn ảnh</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="img">
                            <?php
                            if (!empty($items['img'])) {
                                echo '<input type="hidden" name="current_img" value="' . $items['img'] . '">';
                                echo '<p class="current-img">Ảnh cũ: ' . $items['img'] . '</p>';
                            }
                            ?>
                        </div>

                    </div>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_tintuc.php" class="btn btn-secondary mr-3">Trở lại </a>
                    <button type="submit" name="luubtn" class="btn btn-primary">Lưu</button>
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
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

    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>