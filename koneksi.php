<?php
    //Konek ke Database
    $host='localhost';
    $user='root';
    $pass='';
    $db='dakota';
    $conn= mysqli_connect($host, $user, $pass, $db);

    if($conn){
        //echo "koneksi Berhasil";
    }

    mysqli_select_db($conn, $db);
?>