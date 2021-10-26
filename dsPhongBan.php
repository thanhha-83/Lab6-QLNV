<?php
session_start();
if (isset($_SESSION['user'])) {
    // Ket noi CSDL
    require("connect.php");
    // Chuan bi cau truy van & Thuc thi cau truy van
    $strSQL = "SELECT * FROM phongban";
    $result = mysqli_query($dbc, $strSQL);
} else {
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "partials/head.php"; ?>
    <title>Danh sách phòng ban</title>
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
                    <h1 class="mt-4">DANH SÁCH PHÒNG BAN</h1>
                    <button onclick="window.location.href='themPhongBan.php'" class="btn btn-primary mb-3">Thêm mới</button>
                    <?php
                    if (isset($_SESSION['thongbao'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['thongbao'] . "</div>";
                        unset($_SESSION['thongbao']);
                    }
                    ?>

                    <table class="table table-striped table-hover table-bordered w-75" style="margin: auto;">
                        <thead>
                            <tr>
                                <th>Mã phòng ban</th>
                                <th>Tên phòng ban</th>
                                <th colspan="2">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) == 0) {
                                echo "<tr>";
                                echo "<td colspan='4'>Chưa có phòng ban nào</td>";
                                echo "</tr>";
                            } else {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>$row[0]</td>";
                                    echo "<td>$row[1]</td>";
                                    echo "<td>
                                            <a href='suaPhongBan.php?maPB=$row[0]'><i class='fas fa-edit'></i></a> ||
                                            <a href='' data-id='$row[0]' data-bs-toggle='modal' data-bs-target='#deletePhongBanModal'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                          </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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
    <!-- Confirm delete phongban -->
    <div class="modal fade" id="deletePhongBanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa phòng ban?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa phòng ban này?</p>
                </div>
                <div class="modal-footer">
                    <button id="btn-delete-phongban" type="button" class="btn btn-danger">Xóa bỏ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete hidden form -->
    <form name="delete-phongban-form" method="POST">
        <input type="hidden" id="inputMaPB" name="maPB" value="" />
    </form>
    <!-- Script here -->
    <?php include "partials/footer.php"; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var maNV;
            var deleteForm = document.forms['delete-phongban-form'];
            var maPBField = document.getElementById('inputMaPB');
            var btnDeleteNV = document.getElementById('btn-delete-phongban');
            // When dialog confirm clicked
            $('#deletePhongBanModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                maPB = button.data('id');
                console.log(maPB);
            });

            // When delete phongban btn clicked
            btnDeleteNV.onclick = function() {
                deleteForm.action = 'xoaPhongBan.php';
                maPBField.value = maPB;
                deleteForm.submit();
            };
        });
    </script>
</body>

</html>