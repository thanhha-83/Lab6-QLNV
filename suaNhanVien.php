<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_GET['maNV']) && $_GET['maNV'] != "") {
        $maNV = $_GET['maNV'];
        // Ket noi CSDL
        require("connect.php");
        $nhanvien = mysqli_query($dbc, "SELECT * FROM nhanvien WHERE MANV = '$maNV'");
        if (mysqli_num_rows($nhanvien) != 0) {
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
                if(isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['name'] != ""){
                    $hinh = $_FILES['hinhAnh'];
                    $tenAnh = $hinh['name'];
                    move_uploaded_file($hinh['tmp_name'], "images/" . $tenAnh);
                    $query = "UPDATE nhanvien SET HO = '$hoNV', TEN = '$tenNV',
				    NGAYSINH = '$ngaySinh', GIOITINH = '$gioiTinh', DIACHI = '$diaChi',
                    ANH = '$tenAnh', MALOAINV ='$maLNV', MAPHONG = '$maPB' WHERE MANV = '$maNV'";
                }
                else {
                    $query = "UPDATE nhanvien SET HO = '$hoNV', TEN = '$tenNV',
				    NGAYSINH = '$ngaySinh', GIOITINH = '$gioiTinh', DIACHI = '$diaChi',
                    MALOAINV ='$maLNV', MAPHONG = '$maPB' WHERE MANV = '$maNV'";
                }
                $result = mysqli_query($dbc, $query);
                if (mysqli_affected_rows($dbc) == 1 || mysqli_affected_rows($dbc) == 0) {
                    $_SESSION['thongbao'] = "Sửa thành công";
                    header("location: dsNhanVien.php");
                }
            }
        }
        else {
            header("location: 404.php");
            return;
        }
    }
    else {
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
    <title>Sửa nhân viên</title>
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
                    <h1 class="mt-4">SỬA THÔNG TIN NHÂN VIÊN</h1>
                    <?php
                        $nv = mysqli_fetch_array($nhanvien);
                    ?>
                    <div class="mt-3">
                        <form action="" method="POST" enctype="multipart/form-data" onSubmit="return validateSuaNV();">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="maNV" class="form-label"><b>Mã nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="maNV" name="maNV" readonly value="<?php echo $nv[0] ?>">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="hoNV" class="form-label"><b>Họ nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="hoNV" name="hoNV" onKeyUp="validateHoNV();" onBlur="validateHoNV();" value="<?php echo $nv[1] ?>">
                                    <span class="text-danger" id="errorHoNV" style="visibility: hidden;"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="tenNV" class="form-label"><b>Tên nhân viên</b></label>
                                    <input type="text" class="form-control w-50" id="tenNV" name="tenNV" onKeyUp="validateTenNV();" onBlur="validateTenNV();" value="<?php echo $nv[2] ?>">
                                    <span class="text-danger" id="errorTenNV" style="visibility: hidden;"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="ngaySinh" class="form-label"><b>Ngày sinh</b></label>
                                    <input type="date" class="form-control w-50" id="ngaySinh" name="ngaySinh" onKeyUp="validateNS();" onBlur="validateNS();" value="<?php echo $nv[3] ?>">
                                    <span class="text-danger" id="errorNgaySinh" style="visibility: hidden;"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="gioiTinh" class="form-label"><b>Giới tính</b></label><br>
                                    <input type="radio" name="gioiTinh" value="1" <?php if ($nv[4] == '1') echo "checked"; ?>> Nam
                                    <input type="radio" name="gioiTinh" value="0" <?php if ($nv[4] == '0') echo "checked"; ?>> Nữ
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="diaChi" class="form-label"><b>Địa chỉ</b></label>
                                    <input type="text" class="form-control w-50" id="diaChi" name="diaChi" onKeyUp="validateDC();" onBlur="validateDC();" value="<?php echo $nv[5] ?>">
                                    <span class="text-danger" id="errorDiaChi" style="visibility: hidden;"></span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="hinhAnh" class="form-label"><b>Hình ảnh</b></label>
                                    <input type="file" class="form-control w-50" accept="image/*" id="hinhAnh" name="hinhAnh">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="loaiNV" class="form-label"><b>Loại nhân viên</b></label>
                                    <select name="loaiNV" class="form-control w-50">
                                        <?php
                                        while ($row = mysqli_fetch_array($loainv)) {
                                            if($row[0] == $nv['MALOAINV']) {
                                                echo "<option value='$row[0]' selected>$row[1]</option>";
                                            }
                                            else {
                                                echo "<option value='$row[0]'>$row[1]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="phongBan" class="form-label"><b>Phòng ban</b></label>
                                    <select name="phongBan" class="form-control w-50">
                                        <?php
                                        while ($row = mysqli_fetch_array($phongban)) {
                                            if($row[0] == $nv['MAPHONG']) {
                                                echo "<option value='$row[0]' selected>$row[1]</option>";
                                            }
                                            else {
                                                echo "<option value='$row[0]'>$row[1]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
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
    <!-- Error sua nhanvien -->
    <div class="modal fade" id="errorSuaNhanVien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lỗi sửa nhân viên</h5>
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