<?php
session_start();
if (isset($_SESSION['user'])) {
    // Ket noi CSDL
    require("connect.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $maPB = $_POST['maPB'];
        $tenPB = $_POST['tenPB'];
        $query = "INSERT INTO phongban VALUES ('$maPB','$tenPB')";
        $result = mysqli_query($dbc, $query);
        if(mysqli_affected_rows($dbc) == 1) {
            $_SESSION['thongbao'] = "Thêm thành công";
            header("location: dsPhongBan.php");
        }
    }
} else {
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/head.php"; ?>
    <title>Thêm mới phòng ban</title>
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
                    <h1 class="mt-4">THÊM MỚI PHÒNG BAN</h1>
                    <div class="mt-3">
                        <form action="" method="POST" onSubmit="return validateThemPB();">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="maPB" class="form-label"><b>Mã phòng ban</b></label>
                                    <input type="text" class="form-control w-50" id="maPB" name="maPB" onKeyUp="validateMaPB();" onBlur="validateMaPB();">
                                    <span class="text-danger" id="errorMaPB"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tenPB" class="form-label"><b>Tên phòng ban</b></label>
                                    <input type="text" class="form-control w-50" id="tenPB" name="tenPB" onKeyUp="validateTenPB();" onBlur="validateTenPB();">
                                    <span class="text-danger" id="errorTenPB"></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm</button>
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
    <!-- Error them phongban -->
    <div class="modal fade" id="errorThemPhongBan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lỗi thêm phòng ban</h5>
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