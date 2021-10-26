<?php
    include '../connect.php';
    $maLNV = $_POST['n'];
    $strSQL = "SELECT * FROM loainv WHERE MALOAINV = '$maLNV'";
    $result = mysqli_query($dbc, $strSQL);
    $count = mysqli_num_rows($result);
    echo $count;
?>