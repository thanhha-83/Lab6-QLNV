<?php 
    session_start();
    if (isset($_SESSION['user'])) {
        // Ket noi CSDL
        require("connect.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maNV = $_POST['maNV'];
            $query = "DELETE FROM nhanvien WHERE MANV = '$maNV'";
            $result = mysqli_query($dbc, $query);
            if(mysqli_affected_rows($dbc) == 1) {
                $_SESSION['thongbao'] = "Xóa thành công";
                header("location: dsNhanVien.php");
            }
        }
        else {
            header("location: 404.php");
        }
    } else {
        header("location: login.php");
    }
?>