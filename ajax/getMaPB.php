<?php
    include '../connect.php';
    $maPB = $_POST['n'];
    $strSQL = "SELECT * FROM phongban WHERE MAPHONG = '$maPB'";
    $result = mysqli_query($dbc, $strSQL);
    $count = mysqli_num_rows($result);
    echo $count;
?>