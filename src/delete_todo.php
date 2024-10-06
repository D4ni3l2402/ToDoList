<?php
include("./database.php");

if(isset($_GET['todoid'])) {
    $todoId = $_GET['todoid'];

    $sql = "DELETE FROM todos WHERE todoid = $todoId";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Fehler beim Löschen des Todos: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Todo-ID nicht gefunden.";
}
?>
