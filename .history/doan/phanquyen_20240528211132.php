<?php
session_start();
include ('includes/header.php');
include ('includes/navbar.php');

include_once ('includes/connect.php');

$sql = "SELECT * FROM `chucnang`";
// $sql ="CALL GetDonHang($offset,$total_records_per_page)";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}

$id_nguoidung = $_POST['id_nguoidung'];
$tennguoidung = $_POST['tendangnhap'];

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
            <h1 class="h3 mb-4 text-gray-800  text-center header-crud">Phân Quyền Người Dùng</h1>

            <h4>Người dùng: <strong><?php echo $tennguoidung; ?></strong> </h4>

            <form action="xuly_phanquyen.php" method="POST">
                <input type="hidden" name="id_nguoidung" value="<?php echo $items['id_nguoidung']; ?>">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="white-space: nowrap;" class="thead-dark">
                            <th>Tên chức năng</th>
                            <th>Phân quyền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?php echo $row['tenchucnang']; ?></td>
                                <td>
                                    <?php
                                    $sql_check_permission = "SELECT * FROM phanquyen WHERE id_nguoidung = " . $id_nguoidung . " AND id_chucnang = " . $row['id_chucnang'];

                                    $stmt = $conn->prepare($sql_check_permission);
                                    $stmt->execute();

                                    $is_checked = ""; // Default checkbox state (unchecked)
                                
                                    if ($stmt->rowCount() > 0) {
                                        $is_checked = "checked"; // Set checkbox as checked if permission exists
                                    }
                                    ?>
                                    <input class="checkbox-to" type="checkbox" name="id_chucnang[]"
                                        value="<?php echo $row['id_chucnang']; ?>" <?php echo $is_checked; ?>>
                                    <input type="hidden" name="id_nguoidung" value="<?php echo $id_nguoidung; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                <br>

                <div class="text-right">
                    <a href="list_nguoidung.php" class="btn btn-secondary mr-1">Trở lại </a>
                    <button type="submit" name="thembtn" class="btn btn-primary dieuhanh">Lưu phân quyền</button>
                    <!-- <button type="button" onclick="showArrayValues()" class="btn btn-info">Xem giá trị mảng</button> -->
                </div>
            </form>
            <!-- <script>
                function showArrayValues() {
                    // Get all checked checkboxes
                    var checkboxes = document.querySelectorAll('input[name="id_chucnang[]"]:checked');
                    var values = [];

                    // Loop through checked checkboxes and extract values
                    for (var i = 0; i < checkboxes.length; i++) {
                        values.push(checkboxes[i].value);
                    }

                    // Display the array values (replace with your preferred method)
                    alert("Các giá trị được chọn trong mảng id_chucnang[]:\n" + values.join(", "));
                }
            </script> -->



        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    <?php
    include ('includes/footer.php');
    include ('includes/scripts.php');
    ?>