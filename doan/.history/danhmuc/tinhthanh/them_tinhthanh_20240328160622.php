<?php
// session_start();
// if(!isset($_SESSION['username'])){
// 	header('location:signin.php');
// }
include ('connect.php');


if (!empty($_POST['submit'])) {
    if (isset($_POST['id_tinhthanh']) && isset($_POST['ten'])) {
        // chỗ này chưa có lưu session lên k lấy dc ai là người thêm 
        $idtt = $_POST['id_tinhthanh'];
        $ten = $_POST['ten'];
        $sql = "INSERT INTO tinhthanh (id_tinhthanh, ten, id_nguoitao) VALUES ('$idtt', '$ten', '2')";

        var_dump($sql);
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            header('location:list_tinhthanh.php');
            
        } else {
            echo "<script> alert('Thêm thất bại')</script>";
        }
    }
}

?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm tỉnh thành
            </header>

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Mã tỉnh thành</label>
                            <input type="text" name="id_tinhthanh" class="form-control"
                                placeholder="Nhập mã tỉnh thành">



                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên tỉnh thành</label>
                            <input type="text" name="ten" class="form-control" placeholder="Nhập tên tỉnh thành">
                        </div>


                        <button type="submit" name="submit" class="btn btn-info">Thêm </button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>