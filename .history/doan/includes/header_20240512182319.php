<!DOCTYPE html>
<html lang="en">
if
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PACIFIC</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <!-- custom css -->
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/toast-custom.css">
    <script src="js/custom-toast.js"></script>

    <!-- search -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <!-- search select -->
    <link href="css/tom-select.css" rel="stylesheet">
<script src="js/tom-select.complete.min.js"></script>

</head>

<body id="page-top">
    <div id='toast'> </div>

    <?php
    if (isset($_SESSION['success']) && $_SESSION['success'] != '') {

        echo '<script>
                toast({
                title: "Thành công!",
                message: "' . $_SESSION['success'] . '",
                type: "success",
                duration: 5000
                });
            </script>';
        unset($_SESSION['success']);
    } else if (isset($_SESSION['fail']) && $_SESSION['fail'] != '') {
        echo '<script>
                toast({
                title: "Thành công!",
                message: "' . $_SESSION['fail'] . '",
                type: "error",
                duration: 5000
                });
            </script>';
        unset($_SESSION['fail']);
    }
    ?>
    <!-- Page Wrapper -->
    <div id="wrapper">