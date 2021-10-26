<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_GET['maPB']) && $_GET['maPB'] != "") {
        $maPB = $_GET['maPB'];
        // Ket noi CSDL
        require("connect.php");
        $phongban = mysqli_query($dbc, "SELECT * FROM phongban WHERE MAPHONG = '$maPB'");
        if (mysqli_num_rows($phongban) != 0) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $maPB = $_POST['maPB'];
                $tenPB = $_POST['tenPB'];
                $query = "UPDATE phongban SET TENPHONG = '$tenPB' WHERE MAPHONG = '$maPB'";
                $result = mysqli_query($dbc, $query);
                if (mysqli_affected_rows($dbc) == 1 || mysqli_affected_rows($dbc) == 0) {
                    $_SESSION['thongbao'] = "Sửa thành công";
                    header("location: dsPhongBan.php");
                }
            }
        } else {
            header("location: 404.php");
            return;
        }
    } else {
        header("location: 404.php");
        return;
    }
} else {
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/head.php"; ?>
    <title>Sửa phòng ban</title>
</head>

<body class="sb-nav-fixed">
    <!-- Header here -->
    <?php include "partials/header.php" ?>
    <!-- End header -->

    <div id="layoutSidenav">
        <!-- Menu here -->
        <?php include "partials/menu.php" ?>
        <!--End menu -->

        <!-- Content here -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">SỬA THÔNG TIN PHÒNG BAN</h1>
                    <?php
                    $pb = mysqli_fetch_array($phongban);
                    ?>
                    <div class="mt-3">
                        <form action="" method="POST" enctype="multipart/form-data" onSubmit="return validateSuaNV();">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="maPB" class="form-label"><b>Mã phòng ban</b></label>
                                    <input type="text" class="form-control w-50" id="maPB" name="maPB" readonly value="<?php echo $pb[0] ?>">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tenPB" class="form-label"><b>Tên phòng ban</b></label>
                                    <input type="text" class="form-control w-50" id="tenPB" name="tenPB" onKeyUp="validateTenPB();" onBlur="validateTenPB();" value="<?php echo $pb[1] ?>">
                                    <span class="text-danger" id="errorTenPB" style="visibility: hidden;"></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; Ha Thanh 2021</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Error sua phongban -->
    <div class="modal fade" id="errorSuaPhongBan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lỗi sửa phòng ban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn chưa điền đủ thông tin hoặc còn thông tin đang không đúng yêu cầu</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Script here -->
    <?php include "partials/footer.php"; ?>
    <script type="text/javascript" src="formValidate.js"></script>
</body>

</html>