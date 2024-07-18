<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include ('includes/connect.php');

if (isset($_POST['suabtn'])) {
    $id_pdnl = $_POST['edit_id'];
    $sql = "SELECT * FROM `phieudonhienlieu` WHERE id_pdnl ='$id_pdnl'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

} else {
    // phần này để doubleclick vào row trong table
    $id_pdnl = $_GET['edit_id'];
    $sql = "SELECT * FROM `phieudonhienlieu` WHERE id_pdnl ='$id_pdnl'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }

}


$sqlDonhang = "SELECT * FROM donhang WHERE ngaytao >= DATE_FORMAT(NOW(), '%Y-%m-01') AND 
ngaytao < DATE_FORMAT(NOW() + INTERVAL 1 MONTH, '%Y-%m-01') AND donhang.trangthai != 'Hủy' ORDER BY id_donhang DESC";
$stmt1 = $conn->prepare($sqlDonhang);
$query = $stmt1->execute();
$resultDonhang = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $resultDonhang[] = $row;
}

$sqlDVCCD = "SELECT * FROM `donvicungcapdau`";
$stmt2 = $conn->prepare($sqlDVCCD);
$query = $stmt2->execute();
$resultDVCCD = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $resultDVCCD[] = $row;
}

$sqlNL = "SELECT * FROM `nhienlieu`";
$stmt3 = $conn->prepare($sqlNL);
$query = $stmt3->execute();
$resultNL = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $resultNL[] = $row;
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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Sửa phiếu đổ nhiên liệu</h1>

            <form class="needs-validation" novalidate action="them_phieudonhienlieu.php" method="POST"
                enctype="multipart/form-data">
                <?php foreach ($result as $items): ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" readonly class="form-control" name="id_edit" id="validationCustom01"
                                placeholder="Mã pdnl" value="<?php echo $items['id_pdnl']; ?>" required>
                        </div>
                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Mã đơn hàng</label>
                            <select name="select_donhang" class="" id="select_donhang" required>
                                <option value="">--Chọn mã đơn--</option>
                                <?php foreach ($resultDonhang as $items1): ?>
                                    <option value="<?php echo $items1['id_donhang']; ?>" <?php echo ($items1['id_donhang'] == $items['id_donhang']) ? 'selected' : ''; ?>>
                                        <?php echo $items1['id_donhang']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn mã đơn hàng.
                            </div>
                        </div>

                        <script>
                            new TomSelect("#select_donhang", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc" // đơn hàng mới nhất sẽ ở đầu tiên
                                }
                            });

                        </script>

                        <div class="col-md-3">
                            <label for="validationSLNL">Số lượng nhiên liệu</label>

                            <div class="input-group mb-2">
                                <input type="text" class="form-control " id="validationSLNL" placeholder="Số lượng dầu"
                                    required value="<?php echo $items['soluongnhienlieu']; ?>" name="soluongnhienlieu">
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        lít</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập số lượng nhiên liệu
                                </div>
                            </div>
                        </div>
                        <!-- load slnl qua mã đơn hàng -->
                        <script>
                            $(document).ready(function () {
                                $('#select_donhang').change(function () {
                                    var id_donhang = $(this).val();

                                    $.ajax({
                                        url: 'ajax/get_soluongnhienlieu.php', // Đường dẫn tới file xử lý yêu cầu Ajax
                                        type: 'POST',
                                        data: {
                                            id_donhang: id_donhang
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#validationSLNL').val(data.dautieuthu);
                                        }
                                    });
                                });
                            });
                        </script>

                        <div class="col-md-3  mb-3">
                            <label for="validationCustom01">Tên nhiên liệu</label>
                            <select name="select_NL" class="" id="select_NL" required>
                                <option value="">--Chọn nhiên liệu--</option>
                                <?php foreach ($resultNL as $items2): ?>
                                    <option value="<?php echo $items2['id_nhienlieu']; ?>" <?php echo ($items2['id_nhienlieu'] == $items['id_nhienlieu']) ? 'selected' : ''; ?>>
                                        <?php echo $items2['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn nhiên liệu.
                            </div>
                        </div>
                        <!-- select search -->
                        <script>
                            new TomSelect("#select_NL", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-3 mb-3">
                            <label for="validationTT">Thành tiền</label>
                            <div class="input-group mb-2">
                                <input type="number" class="form-control" name="thanhtien" id="validationTT"
                                    placeholder="Thành tiền" value="<?php echo intval(round($items['thanhtien'])); ?>"
                                    required readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text rounded-right text-gray-100 bg-gradient-primary">
                                        VNĐ</div>
                                </div>
                                <div class="invalid-feedback">
                                    Nhập thành tiền.
                                </div>
                            </div>
                        </div>
                        <!-- ajax thành tiền -->
                        <script>
                            $(document).ready(function () {
                                // Lắng nghe sự kiện khi số lượng nhiên liệu hoặc id_nhienlieu thay đổi
                                $('#validationSLNL, #select_NL').change(function () {
                                    // Lấy giá trị số lượng nhiên liệu và id_nhienlieu
                                    var soluongnhienlieu = $('#validationSLNL').val();
                                    var id_nhienlieu = $('#select_NL').val();

                                    // Kiểm tra xem cả hai giá trị có được chọn hay không
                                    if (soluongnhienlieu !== "" && id_nhienlieu !== "") {
                                        // Gửi yêu cầu Ajax để lấy đơn giá sau thuế
                                        $.ajax({
                                            url: 'ajax/get_thanhtienPDNL.php', // Đường dẫn đến tệp xử lý yêu cầu Ajax
                                            method: 'POST', // Phương thức yêu cầu
                                            data: {
                                                id_nhienlieu: id_nhienlieu // Dữ liệu gửi đi (id_nhienlieu)
                                            },
                                            dataType: 'json',
                                            success: function (response) {
                                                // Xử lý kết quả trả về từ máy chủ
                                                var dongiasauthue = parseInt(response.dongiasauthue, 10); // Chuyển đổi chuỗi số thành số thực

                                                var thanhtien = soluongnhienlieu * dongiasauthue; // Tính thành tiền                                                                              
                                                var thanhtien = parseInt(thanhtien, 10); // làm tròn thành int
                                                // console.log(thanhtien);                     
                                                $('#validationTT').val(thanhtien);
                                            },
                                            error: function (xhr, status, error) {
                                                // Xử lý lỗi nếu có
                                                console.log(error); // In thông báo lỗi vào console
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Ngày đổ nhiên liệu</label>
                            <input type="date" class="form-control" name="ngaydonhienlieu" id="validationCustom02"
                                placeholder="Ngày đổ nhiên liệu" value="<?php echo $items['ngaydonhienlieu']; ?>" required>
                            <div class="invalid-feedback">
                                Chọn ngày đổ nhiên liệu
                            </div>
                        </div>

                        <div class="col-md-8  mb-3">
                            <label for="validationCustom01">Đơn vị cung cấp dầu</label>
                            <select name="select_DVCCD" class="" id="select_DVCCD" required>
                                <option value="">--Chọn đơn vị--</option>
                                <?php foreach ($resultDVCCD as $items3): ?>
                                    <option value="<?php echo $items3['id_donviccdau']; ?>" <?php echo ($items3['id_donviccdau'] == $items['id_dvccdau']) ? 'selected' : ''; ?>>
                                        <?php echo $items3['ten']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                Chọn đơn vị.
                            </div>
                        </div>
                        <!-- select search -->
                        <script>
                            new TomSelect("#select_DVCCD", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "desc"
                                }
                            });

                        </script>

                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Ghi chú</label>
                            <input type="text" class="form-control" name="ghichu" id="validationCustom02"
                                placeholder="Ghi chú" value="<?php echo $items['ghichu']; ?>">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="customFile">Phiếu cấp dầu</label>
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

                    </div>
                    <!-- hiện tên ảnh -->
                    <script>
                        function hienThiTenFile() {
                            var input = document.getElementById('customFile');
                            var label = document.querySelector('.custom-file-label');
                            label.textContent = input.files[0].name;
                        }

                    </script>
                <?php endforeach ?>
                <div class="modal-footer">
                    <a href="list_phieudonhienlieu.php" class="btn btn-secondary mr-3">Trở lại </a>
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
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>