<?php
    include '../connect.php';
    $maNV = $_POST['n'];
    $strSQL = "SELECT * FROM nhanvien WHERE MANV = '$maNV'";
    $result = mysqli_query($dbc, $strSQL);
    $count = mysqli_num_rows($result);
    echo $count;
?>