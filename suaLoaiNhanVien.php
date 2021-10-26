<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_GET['maLNV']) && $_GET['maLNV'] != "") {
        $maLNV = $_GET['maLNV'];
        // Ket noi CSDL
        require("connect.php");
        $loainnv = mysqli_query($dbc, "SELECT * FROM loainv WHERE MALOAINV = '$maLNV'");
        if (mysqli_num_rows($loainnv) != 0) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $maLNV = $_POST['maLNV'];
                $tenLNV = $_POST['tenLNV'];
                $query = "UPDATE loainv SET TENLOAINV = '$tenLNV' WHERE MALOAINV = '$maLNV'";
                $result = mysqli_query($dbc, $query);
                if (mysqli_affected_rows($dbc) == 1 || mysqli_affected_rows($dbc) == 0) {
                    $_SESSION['thongbao'] = "Sửa thành công";
                    header("location: dsLoaiNhanVien.php");
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
    <title>Sửa loại nhân viên</title>
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
                    <h1 class="mt-4">SỬA THÔNG TIN LOẠI NHÂN VIÊN</h1>
                    <?php
                    $lnv = mysqli_fetch_array($loainnv);
                    ?>
                    <div class="mt-3">
                        <form action="" method="POST" enctype="multipart/form-data" onSubmit="return validateSuaNV();">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="maLNV" class="form-label"><b>Mã loại nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="maLNV" name="maLNV" readonly value="<?php echo $lnv[0] ?>">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tenLNV" class="form-label"><b>Tên loại nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="tenLNV" name="tenLNV" onKeyUp="validateTenLNV();" onBlur="validateTenLNV();" value="<?php echo $lnv[1] ?>">
                                    <span class="text-danger" id="errorTenLNV" style="visibility: hidden;"></span>
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
    <!-- Error sua loainhanvien -->
    <div class="modal fade" id="errorSuaLoaiNhanVien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lỗi sửa loại nhân viên</h5>
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