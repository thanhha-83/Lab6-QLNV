<?php
session_start();
if (isset($_SESSION['user'])) {
    // Ket noi CSDL
    require("connect.php");
    $loainv = mysqli_query($dbc, "SELECT * FROM loainv");
    $phongban = mysqli_query($dbc, "SELECT * FROM phongban");
    // Tìm tổng số trang
    $rowsPerPage = 3;
    $searchHoTen = "";
    $searchGT = "";
    $searchLNV = "";
    $searchPB = "";
    $strSQL = "SELECT nv.*, lnv.TENLOAINV, pb.TENPHONG 
                FROM nhanvien nv, phongban pb, loainv lnv
                WHERE 1=1 AND nv.MALOAINV = lnv.MALOAINV AND nv.MAPHONG = pb.MAPHONG";
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['searchBtn']) && $_GET['searchBtn'] != "") {
        $searchHoTen = $_GET['hoTen'];
        if (isset($_GET['gioiTinh'])) {
            $searchGT = $_GET['gioiTinh'];
        }
        $searchLNV = $_GET['loainv'];
        $searchPB = $_GET['phongBan'];
        if ($searchHoTen != "") {
            $strSQL .= " AND CONCAT(HO, ' ', TEN) LIKE '%$searchHoTen%'";
        }
        if ($searchGT != "") {
            $strSQL .= " AND GIOITINH = '$searchGT'";
        }
        if ($searchLNV != "") {
            $strSQL .= " AND nv.MALOAINV = '$searchLNV'";
        }
        if ($searchPB != "") {
            $strSQL .= " AND nv.MAPHONG = '$searchPB'";
        }
    }
    $result = mysqli_query($dbc, $strSQL);
    $numRows = mysqli_num_rows($result);
    $maxPage = ceil($numRows / $rowsPerPage);

    if (!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $maxPage) {
        $_GET['page'] = 1;
    }

    $offset = ($_GET['page'] - 1) * $rowsPerPage;
    $strSQLPaginate = $strSQL . " LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($dbc, $strSQLPaginate);
} else {
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/head.php"; ?>
    <title>Danh sách nhân viên</title>
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
                    <h1 class="mt-4">DANH SÁCH NHÂN VIÊN</h1>
                    <button onclick="window.location.href='themNhanVien.php'" class="btn btn-primary mb-3">Thêm mới</button>
                    <form action="" method="GET">
                        <table style="margin: auto; width:350px;">
                            <tr>
                                <td><b>Họ tên: </b></td>
                                <td><input type="text" name="hoTen" class="form-control" value="<?php echo $searchHoTen; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Giới tính: </b></td>
                                <td>
                                    <select name="gioiTinh" class="form-control">
                                        <option value='' <?php if ($searchGT == '') echo 'selected'?>>--- Chọn tất cả ---</option>
                                        <option value='1' <?php if ($searchGT != "" && $searchGT == '1') echo 'selected'?>>Nam</option>
                                        <option value='0' <?php if ($searchGT != "" && $searchGT == '0') echo 'selected'?>>Nữ</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Loại nhân viên: </b></td>
                                <td>
                                    <select name="loainv" class="form-control">
                                        <option value="">--- Chọn tất cả ---</option>
                                        <?php
                                        while ($row = mysqli_fetch_array($loainv)) {
                                            if ($searchLNV != "" && $searchLNV == $row[0]) {
                                                echo "<option value='$row[0]' selected>$row[1]</option>";
                                            } else {
                                                echo "<option value='$row[0]'>$row[1]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Phòng ban: </b></td>
                                <td>
                                    <select name="phongBan" class="form-control">
                                        <option value="">--- Chọn tất cả ---</option>
                                        <?php
                                        while ($row = mysqli_fetch_array($phongban)) {
                                            if ($searchPB != "" && $searchPB == $row[0]) {
                                                echo "<option value='$row[0]' selected>$row[1]</option>";
                                            } else {
                                                echo "<option value='$row[0]'>$row[1]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Lọc" class="btn btn-primary" name="searchBtn" />
                                    <a href="dsNhanVien.php" class="btn btn-primary">Làm mới</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <?php
                    if (isset($_SESSION['thongbao'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['thongbao'] . "</div>";
                        unset($_SESSION['thongbao']);
                    }
                    ?>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Mã nhân viên</th>
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Địa chỉ</th>
                                <th>Ảnh</th>
                                <th>Loại nhân viên</th>
                                <th>Phòng ban</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) == 0) {
                                echo "<tr>";
                                echo "<td colspan='9' style='text-align:center'>Chưa có nhân viên nào</td>";
                                echo "</tr>";
                            } else {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>$row[0]</td>";
                                    echo "<td>$row[1] $row[2]</td>";
                                    $date = date_create($row[3]);
                                    $ngaySinh = date_format($date, "d/m/Y");
                                    echo "<td>$ngaySinh</td>";
                                    $gt = $row[4] == 1 ? "Nam" : "Nữ";
                                    echo "<td>$gt</td>";
                                    echo "<td>$row[5]</td>";
                                    echo "<td>
                                                <img src='images/$row[6]' height='50' width='50' alt='$row[1] $row[2]'>
                                            </td>";
                                    echo "<td>" . $row['TENLOAINV'] . "</td>";
                                    echo "<td>" . $row['TENPHONG'] . "</td>";
                                    echo "<td style='text-align: center'>
                                                <a href='suaNhanvien.php?maNV=$row[0]'><i class='fas fa-edit'></i></a> ||
                                                <a href='' data-id='$row[0]' 
                                                data-bs-toggle='modal' data-bs-target='#deleteNhanVienModal'>
                                                    <i class='fas fa-trash'></i>
                                                </a>
                                            </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div>
                        <ul class="pagination" style="justify-content: center">
                            <?php
                            $qr = $_SERVER['QUERY_STRING'];
                            function xuLyQuery($qr, $str)
                            {
                                if ($qr == "") {
                                    return $str; // ?page=x
                                } else if (!is_bool(strpos($qr, 'page='))) {
                                    $start = strpos($qr, 'page');
                                    $needlToReplace = substr($qr, $start);

                                    // ?hoTen=x&...&page=x to ?hoTen=x&...&page=y
                                    return str_replace($needlToReplace, $str, $qr);
                                } else {
                                    // ?hoTen=x&... to ?hoTen=x&...&page=x
                                    return $qr . '&' . $str;
                                }
                            }
                            if ($_GET['page'] == 1) {
                                echo "<li class='page-item disabled'>
                                        <span class='page-link'><i class='fas fa-angle-double-left'></i></span>
                                        </li>";
                                echo "<li class='page-item disabled'>
                                        <span class='page-link'><i class='fas fa-angle-left'></i></span>
                                        </li>";
                            } else {
                                $prePage = $_GET['page'] - 1;
                                $first = xuLyQuery($qr, "page=1");
                                $back = xuLyQuery($qr, "page=$prePage");
                                echo "<li class='page-item'>
                                        <a class='page-link' href='?$first'><i class='fas fa-angle-double-left'></i></a>
                                        </li>";
                                echo "<li class='page-item'>
                                        <a class='page-link' href='?$back'><i class='fas fa-angle-left'></i></a>
                                        </li>";
                            }
                            for ($i = 1; $i <= $maxPage; $i++) {
                                $numPage = xuLyQuery($qr, "page=$i");
                                if ($_GET['page'] == $i) {
                                    echo "<li class='page-item active' aria-current='page'>
                                        <span class='page-link'>$i</span>
                                        </li>";
                                } else {
                                    echo "<li class='page-item' aria-current='page'>
                                        <a class='page-link' href='?$numPage'>$i</a>
                                        </li>";
                                }
                            }
                            if ($_GET['page'] == $maxPage) {
                                echo "<li class='page-item disabled'>
                                        <span class='page-link'><i class='fas fa-angle-right'></i></span>
                                        </li>";
                                echo "<li class='page-item disabled'>
                                        <span class='page-link'><i class='fas fa-angle-double-right'></i></span>
                                        </li>";
                            } else {
                                $nextPage = $_GET['page'] + 1;
                                $next = xuLyQuery($qr, "page=$nextPage");
                                $last = xuLyQuery($qr, "page=$maxPage");
                                echo "<li class='page-item'>
                                        <a class='page-link' href='?$next'><i class='fas fa-angle-right'></i></a>
                                        </li>";
                                echo "<li class='page-item'>
                                        <a class='page-link' href='?$last'><i class='fas fa-angle-double-right'></i></a>
                                        </li>";
                            }
                            ?>
                        </ul>
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
    <!-- Confirm delete nhanvien -->
    <div class="modal fade" id="deleteNhanVienModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa nhân viên?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa nhân viên này?</p>
                </div>
                <div class="modal-footer">
                    <button id="btn-delete-nhanvien" type="button" class="btn btn-danger">Xóa bỏ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete hidden form -->
    <form name="delete-nhanvien-form" method="POST">
        <input type="hidden" id="inputMaNV" name="maNV" value="" />
    </form>
    <!-- Script here -->
    <?php include "partials/footer.php"; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var maNV;
            var deleteForm = document.forms['delete-nhanvien-form'];
            var maNVField = document.getElementById('inputMaNV');
            var btnDeleteNV = document.getElementById('btn-delete-nhanvien');
            // When dialog confirm clicked
            $('#deleteNhanVienModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                maNV = button.data('id');
                console.log(maNV);
            });

            // When delete nhanvien btn clicked
            btnDeleteNV.onclick = function() {
                deleteForm.action = 'xoaNhanVien.php';
                maNVField.value = maNV;
                deleteForm.submit();
            };
        });
    </script>
</body>

</html>