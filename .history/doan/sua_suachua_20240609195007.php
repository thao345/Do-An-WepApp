<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    // $id_donhang = $_POST['edit_id_donhang'];
    $id_suachua = $_POST['edit_id'];

    $sqlSC = "SELECT id_suachua,suachua.id_xe,xe.bienso, DATE(suachua.ngaysuachua) as ngaysuachua,sokmdongho,noidungsuachua,dongiavattu,tiennhancong,soluong,nguoisuachua,thoigianbaohanh,tongtien,anh1,ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(suachua.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(suachua.ngaysua) as ngaysua
    FROM suachua 
    
    INNER JOIN nguoidung ON suachua.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON suachua.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN xe on suachua.id_xe = xe.id_xe
    
    WHERE id_suachua='$id_suachua'";

    $stmt2 = $conn->prepare($sqlSC);
    $query2 = $stmt2->execute();
    $resultSC = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultSC[] = $row;
    }


} else {
    // phần này để doubleclick vào row trong table
    $id_suachua = $_GET['edit_id'];

    $sqlSC = "SELECT id_suachua,suachua.id_xe,xe.bienso, DATE(suachua.ngaysuachua) as ngaysuachua,sokmdongho,noidungsuachua,dongiavattu,tiennhancong,soluong,nguoisuachua,thoigianbaohanh,tongtien,anh1,ghichu,nguoidung.tendangnhap AS nguoitao, nguoidung.id_nguoidung, DATE(suachua.ngaytao) as ngaytao, nguoidung2.tendangnhap AS nguoisua, nguoidung2.id_nguoidung, DATE(suachua.ngaysua) as ngaysua
    FROM suachua 
    
    INNER JOIN nguoidung ON suachua.id_nguoitao = nguoidung.id_nguoidung
    LEFT JOIN nguoidung AS nguoidung2 ON suachua.id_nguoisua = nguoidung2.id_nguoidung
    INNER JOIN xe on suachua.id_xe = xe.id_xe
    
    WHERE id_suachua='$id_suachua'";

    $stmt2 = $conn->prepare($sqlSC);
    $query2 = $stmt2->execute();
    $resultSC = array();
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $resultSC[] = $row;
    }
}


// lấy các xe thuộc thầu phụ PACIFIC
$sqlXe = "SELECT xe.id_xe, xe.bienso
FROM xe
INNER JOIN thauphu ON thauphu.id_thauphu = xe.id_thauphu
WHERE xe.id_thauphu IN ('PLJ-L', 'PLJ-F')";
$stmt1 = $conn->prepare($sqlXe);
$query = $stmt1->execute();
$resultXe = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultXe[] = $row;
}

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Tên đăng nhập: " . $tendangnhap; ?></span>
                <br>
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "Thời gian đăng nhập: " . $thoigiandangnhap; ?></span>
            </div>
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
           

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa sửa chữa</h1>

            <form class="needs-validation" novalidate action="them_suachua.php" method="POST"
                enctype="multipart/form-data">
                <?php foreach ($resultSC as $items): ?>
                    <div class="form-row">

                        <div class="col-md-12 mb-3">
                            <input type="hidden" readonly class="form-control" name="id_edit" id="validationCustom01"
                                placeholder="Mã sửa chữa" value="<?php echo $items['id_suachua']; ?>" required>
                        </div>

                        <div class="col-md-4  mb-3">
                            <label for="validationCustom01">Chọn xe :</label>
                            <select name="select_xe" class="" id="select_xe" required>
                                <option value="">--Chọn xe--</option>
                                <?php foreach ($resultXe as $itemsXe): ?>
                                    <option value="<?php echo $itemsXe['id_xe']; ?>" <?php echo ($itemsXe['id_xe'] == $items['id_xe']) ? 'selected' : ''; ?>>
                                        <?php echo $itemsXe['bienso']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn xe.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_xe", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Ngày sửa chữa :</label>
                            <input type="date" class="form-control" name="ngaysuachua" id="validationCustom02"
                                placeholder="Ngày sửa chữa" value="<?php echo $items['ngaysuachua']; ?>" required>
                            <div class="invalid-feedback">
                                Chọn ngày sửa chữa
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="sokmdongho">Số km đồng hồ :</label>

                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="sokmdongho_display"
                                    placeholder="Nhập số km đồng hồ..." value="<?php echo $items['sokmdongho']; ?>"
                                    required>
                                <input type="hidden" name="sokmdongho" id="sokmdongho"
                                    value="<?php echo $items['sokmdongho']; ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        Km</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập số km đồng hồ
                                </div>
                            </div>
                        </div>
                        <!--  chỉ cho nhập số và định dạng -->
                        <script>
                            $(document).ready(function () {
                                $('#sokmdongho_display').on('input', function (e) {
                                    var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                    var realValue = parseInt(displayValue, 10) || 0;
                                    $('#sokmdongho').val(realValue); // Thiết lập giá trị của trường ẩn

                                    if (displayValue.length > 0) {
                                        $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                    } else {
                                        $(this).val('');
                                    }
                                });

                                // Định dạng giá trị ban đầu
                                var hiddenValue = $('#sokmdongho').val();
                                if (hiddenValue.length > 0) {
                                    $('#sokmdongho_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                }
                            });
                        </script>

                        <div class="col-md-12 mb-3">
                            <label for="noidungsuachua">Nội dung sửa chữa :</label>
                            <textarea class="form-control" name="noidungsuachua" id="noidungsuachua"
                                placeholder="Nhập nội dung..." rows="3"
                                required><?php echo $items['noidungsuachua']; ?></textarea>
                            <div class="invalid-feedback">
                                Nhập nội dung.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="dongiavattu">Đơn giá vật tư :</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="dongiavattu_display"
                                    placeholder="Nhập đơn giá vật tư..." value="<?php echo $items['dongiavattu']; ?>"
                                    required>
                                <input type="hidden" name="dongiavattu" id="dongiavattu"
                                    value="<?php echo $items['dongiavattu']; ?>" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập đơn giá vật tư.
                                </div>
                            </div>
                        </div>

                        <!--  chỉ cho nhập số và định dạng -->
                        <script>
                            $(document).ready(function () {
                                $('#dongiavattu_display').on('input', function (e) {
                                    var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                    var realValue = parseInt(displayValue, 10) || 0;
                                    $('#dongiavattu').val(realValue); // Thiết lập giá trị của trường ẩn

                                    if (displayValue.length > 0) {
                                        $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                    } else {
                                        $(this).val('');
                                    }
                                });

                                // Định dạng giá trị ban đầu
                                var hiddenValue = $('#dongiavattu').val();
                                if (hiddenValue.length > 0) {
                                    $('#dongiavattu_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                }
                            });
                        </script>

                        <div class="col-md-4 mb-3">
                            <label for="soluong">Số lượng :</label>
                            <input type="number" class="form-control" name="soluong" id="soluong"
                                placeholder="Nhập số lượng..." value="<?php echo $items['soluong']; ?>">

                            <div class="invalid-feedback">
                                Nhập số lượng.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tiennhancong">Tiền nhân công :</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="tiennhancong_display"
                                    placeholder="Nhập tiền nhân công..." value="<?php echo $items['tiennhancong']; ?>">
                                <input type="hidden" name="tiennhancong" id="tiennhancong"
                                    value="<?php echo $items['tiennhancong']; ?>">
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ</div>
                                </div>

                            </div>
                        </div>
                        <!--  chỉ cho nhập số và định dạng -->
                        <script>
                            $(document).ready(function () {
                                $('#tiennhancong_display').on('input', function (e) {
                                    var displayValue = $(this).val().replace(/[^\d]/g, ''); // Loại bỏ các ký tự không phải số
                                    var realValue = parseInt(displayValue, 10) || 0;
                                    $('#tiennhancong').val(realValue); // Thiết lập giá trị của trường ẩn

                                    if (displayValue.length > 0) {
                                        $(this).val(new Intl.NumberFormat('vi-VN').format(realValue));
                                    } else {
                                        $(this).val('');
                                    }
                                });

                                // Định dạng giá trị ban đầu
                                var hiddenValue = $('#tiennhancong').val();
                                if (hiddenValue.length > 0) {
                                    $('#tiennhancong_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                }
                            });
                        </script>

                        <div class="col-md-4 mb-3">
                            <label for="tongtien">Tổng tiền :</label>
                            <div class="input-group mb-2">

                                <input type="text" class="form-control" id="tongtien_display"
                                    placeholder="Nhập tổng tiền..." value="<?php echo $items['tongtien']; ?>" required
                                    readonly>
                                <input type="hidden" name="tongtien" id="tongtien" value="<?php echo $items['tongtien']; ?>"
                                    required readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ</div>
                                </div>

                            </div>
                        </div>
                        <!--  chỉ cho nhập số và định dạng -->
                        <script>
                            $(document).ready(function () {
                                // Định dạng giá trị ban đầu
                                var hiddenValue = $('#tongtien').val();
                                if (hiddenValue.length > 0) {
                                    $('#tongtien_display').val(new Intl.NumberFormat('vi-VN').format(hiddenValue));
                                }
                            });
                        </script>

                        <script>
                            $(document).ready(function () {
                                $('#dongiavattu_display, #soluong,#tiennhancong_display').on('input', function () {
                                    var dongia = parseFloat($('#dongiavattu').val());
                                    var soluong = parseInt($('#soluong').val());
                                    var tiennhancong = parseInt($('#tiennhancong').val());
                                    var tongtien = dongia * soluong + tiennhancong;

                                    if (!isNaN(tongtien)) {
                                        $('#tongtien_display').val(new Intl.NumberFormat('vi-VN').format(tongtien));
                                        $('#tongtien').val(tongtien);
                                    }
                                });
                            });
                        </script>



                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Người sửa chữa :</label>
                            <input type="text" class="form-control" name="nguoisuachua" id="validationCustom02"
                                placeholder="Nhập người sửa chữa..." value="<?php echo $items['nguoisuachua']; ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Thời gian bảo hành :</label>
                            <input type="date" class="form-control" name="thoigianbaohanh" id="validationCustom02"
                                placeholder="Thời gian bảo hành..." value="<?php echo $items['thoigianbaohanh']; ?>">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="ghichu">Ghi chú :</label>
                            <textarea class="form-control" name="ghichu" id="ghichu" placeholder="Nhập ghi chú..."
                                rows="3"><?php echo $items['ghichu']; ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="customFile">Ảnh hóa đơn : </label>
                            <div class="custom-file">
                                <?php
                                if (!empty($items['anh1'])) {
                                    echo '<input type="file" class="custom-file-input" name="anh1"  id="customFile"  onchange="hienThiTenFile()" value="' . $items['anh1'] . '">';
                                    echo '<label class="custom-file-label" for="customFile">' . $items['anh1'] . '</label>';
                                } else {
                                    echo '<input type="file" class="custom-file-input" name="anh1" id="customFile"  onchange="hienThiTenFile()">';
                                    echo '<span class="custom-file-label" id="customFileLabel">Chọn ảnh</span>';
                                }
                                ?>
                            </div>
                            <div class="invalid-feedback">
                                Chọn file ảnh
                            </div>
                            <a class="mt-3" width="100px" href="img/<?php echo $items['anh1']; ?>" target="_blank">
                                <img class="mt-3" width="100px" src="img/<?php echo $items['anh1']; ?>">
                            </a>
                        </div>


                        <!-- hiện tên ảnh -->
                        <script>
                            function hienThiTenFile() {
                                var input = document.getElementById('customFile');
                                var label = document.querySelector('.custom-file-label');
                                label.textContent = input.files[0].name;
                            }
                        </script>
                    </div>
                <?php endforeach ?>

                <div class="modal-footer">
                    <a href="list_suachua.php" class="btn btn-secondary mr-3">Trở lại </a>
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

    <?php
    // include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>