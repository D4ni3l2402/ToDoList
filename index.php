<?php
session_start();
include("./src/database.php");


function displayTodos($conn, $userId)
{
    $sql = "SELECT * FROM todos WHERE userid='$userId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $todoClass = ($row['completed'] == 1) ? 'class="finished"' : ''; 
            $checkClass = ($row['completed'] == 1) ? 'uncheck' : 'check'; // Bestimmen Sie die Klasse für den <a>-Tag
            $iconClass = ($row['completed'] == 1) ? 'fa-xmark' : 'fa-check';

            echo
            '<li ' . $todoClass . '>
                <span>' . $row['task'] . '</span>
                <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?todoid=' . $row['todoid'] . '" class="edit-form" method="post">
                    <input type="text" class="edit-input" name="edit">
                    <button type="submit" name="save-change" class="save-edit"> <i class="fa-solid fa-pencil edit"></i></button>
                </form>
                <div class="action-btns">
                    <a href="./src/checked_todo.php?todoid=' . $row['todoid'] . '" class="' . $checkClass . '"><i class="fa-solid ' . $iconClass .'"></i></a>
                    <i class="fa-solid fa-pencil edit"></i>
                    <a href="./src/delete_todo.php?todoid=' . $row['todoid'] . '" class="delete-link"><i class="fa-solid fa-trash-can delete"></i></a>
                </div>
                <div class="exit-edit">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </li>';
        }
    } else {
        echo '<li>Keine Todos vorhanden</li>';
    }
    mysqli_close($conn);
}

// mysqli_close($conn);

//Add Todo
if (isset($_POST["add-todo"])) {
    $todo = htmlspecialchars($_POST['todo']);

    if (!empty($todo)) {
        if (isset($_SESSION["user_id"])) {
            $userId = $_SESSION["user_id"];
            $sql = "INSERT INTO todos (userid, task, completed) VALUES ('$userId', '$todo', false)";

            if (mysqli_query($conn, $sql)) {
                // Nach erfolgreichem Hinzufügen, Todos neu anzeigen
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<h3> Du musst angemeldet sein</h3>";
        }
    } else {
        echo "<h3>Das Eingabefeld ist leer</h3>";
        
    }
    // mysqli_close($conn);

}

//Edit Todo
if(isset($_POST["save-change"])){
    if(isset($_POST["edit"])){
        $editedTask = mysqli_real_escape_string($conn, $_POST["edit"]);
        $todoId = $_GET["todoid"];

        $sql = "UPDATE todos SET task='$editedTask' WHERE todoid='$todoId'";
        if(mysqli_query($conn, $sql)){
            echo "Erfolg geändert";
            header("Location: " . $_SERVER["PHP_SELF"]);
                exit();
        }
        
    }
}






?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Todo List</title>
</head>

<body>
    <div class="container">
        <header>
            <a href="index.php" class="logo">Todo List</a>
            <nav>
                <ul>
                    <?php
                    if (!isset($_SESSION['user_id'])) {
                        echo '<li><a href="./src/login.php">Anmelden</a></li>
                        <li><a href="./src/register.php">Registrieren</a></li>';
                    } else {
                        $username = $_SESSION["username"];

                        echo '<li><a href="#">Willkommen ' . $username . '</a></li>
                        <li><a href="./src/logout.php">Abmelden</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>

        <section class="todo-container">
            <h1>Todo List</h1>
            <form action="" class="search">
                <input type="text" name="search" class="search" placeholder="Suche Todo's...">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </form>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="add">
                <input type="text" name="todo" class="add-input" placeholder="Todo hinzufügen...">
                <button type="submit" name="add-todo" class="add-btn">Hinzufügen</button>
            </form>



            <div class="todos">
                <ul class="list-group">
                    <!-- <li>
                        <span>Waschmachine machen</span>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="edit-form" method="post">
                            <input type="text" class="edit-input" name="edit">
                            <button type="submit" name="save-change" class="save-edit"> <i class="fa-solid fa-pencil edit"></i></button>
                        </form>

                        <div class="action-btns">
                            <i class="fa-solid fa-pencil edit"></i>
                            <i class="fa-solid fa-trash-can delete"></i>

                        </div>

                        <div class="exit-edit">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </li>

                    <li>
                        <span>dfdfddf</span>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="edit-form" method="post">
                            <input type="text" class="edit-input" name="edit">
                            <button type="submit" name="save-change" class="save-edit"> <i class="fa-solid fa-pencil edit"></i></button>
                        </form>

                        <div class="action-btns">
                            <i class="fa-solid fa-pencil edit"></i>
                            <i class="fa-solid fa-trash-can delete"></i>

                        </div>

                        <div class="exit-edit">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </li> -->

                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id'];
                        displayTodos($conn, $userId);
                    } else {
                        echo '<li>Bitte anmelden!</li>';
                    }


                    ?>

                    <!-- <li><span>Waschmachine machen</span> <i class="fa-solid fa-pencil"></i> <i class="fa-solid fa-trash-can"></i></li> -->

                </ul>
            </div>


        </section>

        <form action=""></form>


    </div>
    <script src="script.js"></script>
    
</body>

</html>