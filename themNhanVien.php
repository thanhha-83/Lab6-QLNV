<?php
session_start();
if (isset($_SESSION['user'])) {
    // Ket noi CSDL
    require("connect.php");
    $loainv = mysqli_query($dbc, "SELECT * FROM loainv");
    $phongban = mysqli_query($dbc, "SELECT * FROM phongban");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $maNV = $_POST['maNV'];
        $hoNV = $_POST['hoNV'];
        $tenNV = $_POST['tenNV'];
        $ngaySinh = $_POST['ngaySinh'];
        $gioiTinh = $_POST['gioiTinh'];
        $diaChi = $_POST['diaChi'];
        $maLNV = $_POST['loaiNV'];
        $maPB = $_POST['phongBan'];
        $hinh=$_FILES['hinhAnh'];
        $tenAnh = $hinh['name'];
        move_uploaded_file($hinh['tmp_name'], "images/".$tenAnh);
        $query = "INSERT INTO nhanvien VALUES ('$maNV','$hoNV','$tenNV',
				'$ngaySinh','$gioiTinh','$diaChi','$tenAnh','$maLNV','$maPB')";
        $result = mysqli_query($dbc, $query);
        if(mysqli_affected_rows($dbc) == 1) {
            $_SESSION['thongbao'] = "Thêm thành công";
            header("location: dsNhanVien.php");
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
    <title>Thêm mới nhân viên</title>
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
                    <h1 class="mt-4">THÊM MỚI NHÂN VIÊN</h1>
                    <div class="mt-3">
                        <form action="" method="POST" enctype="multipart/form-data" onSubmit="return validateThemNV();">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="maNV" class="form-label"><b>Mã nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="maNV" name="maNV" onKeyUp="validateMaNV();" onBlur="validateMaNV();">
                                    <span class="text-danger" id="errorMaNV"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="hoNV" class="form-label"><b>Họ nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="hoNV" name="hoNV" onKeyUp="validateHoNV();" onBlur="validateHoNV();">
                                    <span class="text-danger" id="errorHoNV"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tenNV" class="form-label"><b>Tên nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="tenNV" name="tenNV" onKeyUp="validateTenNV();" onBlur="validateTenNV();">
                                    <span class="text-danger" id="errorTenNV"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="ngaySinh" class="form-label"><b>Ngày sinh</b></label>
                                    <input type="date" class="form-control w-50" id="ngaySinh" name="ngaySinh" onKeyUp="validateNS();" onBlur="validateNS();">
                                    <span class="text-danger" id="errorNgaySinh"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="gioiTinh" class="form-label"><b>Giới tính</b></label><br>
                                    <input type="radio" name="gioiTinh" value="1" checked="checked"> Nam
                                    <input type="radio" name="gioiTinh" value="0"> Nữ
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="diaChi" class="form-label"><b>Địa chỉ</b></label>
                                    <input type="text" class="form-control w-50" id="diaChi" name="diaChi" onKeyUp="validateDC();" onBlur="validateDC();">
                                    <span class="text-danger" id="errorDiaChi"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="hinhAnh" class="form-label"><b>Hình ảnh</b></label>
                                    <input type="file" class="form-control w-50" accept="image/*" id="hinhAnh" name="hinhAnh" onBlur="validateAnh();" onchange="validateAnh();">
                                    <span class="text-danger" id="errorHinhAnh"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="loaiNV" class="form-label"><b>Loại nhân viên</b></label>
                                    <select name="loaiNV" class="form-control w-50">
                                        <?php
                                        while ($row = mysqli_fetch_array($loainv)) {
                                            echo "<option value='$row[0]'>$row[1]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="phongBan" class="form-label"><b>Phòng ban</b></label>
                                    <select name="phongBan" class="form-control w-50">
                                        <?php
                                        while ($row = mysqli_fetch_array($phongban)) {
                                            echo "<option value='$row[0]'>$row[1]</option>";
                                        }
                                        ?>
                                    </select>
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
    <!-- Error them nhanvien -->
    <div class="modal fade" id="errorThemNhanVien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lỗi thêm nhân viên</h5>
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