<?php
include("./database.php");

if(isset($_GET["todoid"])){
    $todoId = $_GET['todoid'];

    $get_completed_sql = "SELECT completed FROM todos WHERE todoid='$todoId'";
    $result = mysqli_query($conn, $get_completed_sql);
    $row = mysqli_fetch_assoc($result);
    $completed = $row['completed'];
    $newCompleted = null;

    if($completed == 0){
        $newCompleted = 1;
    } else if($completed == 1) {
        $newCompleted = 0;
    }


    $sql = "UPDATE todos SET completed='$newCompleted' WHERE todoid='$todoId'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Fehler beim fertigen des Todos: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    
} else {
    echo "Todo-ID nicht gefunden.";

}


?>