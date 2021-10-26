<?php 
    session_start();
    if (isset($_SESSION['user'])) {
        // Ket noi CSDL
        require("connect.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maPB = $_POST['maPB'];
            $query = "DELETE FROM phongban WHERE MAPHONG = '$maPB'";
            $result = mysqli_query($dbc, $query);
            if(mysqli_affected_rows($dbc) == 1) {
                $_SESSION['thongbao'] = "Xóa thành công";
                header("location: dsPhongBan.php");
            }
        }
        else {
            header("location: 404.php");
        }
    } else {
        header("location: login.php");
    }
?>