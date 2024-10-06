<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $name = "todo";
    $conn;



    try {
        $conn = mysqli_connect($server, $user, $password, $name);
        // echo "Connect";
    } catch (mysqli_sql_exception){
        echo "Error :(";
    }

    return $conn;
?>