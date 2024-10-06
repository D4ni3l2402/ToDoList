<?php
session_start();

$showLogoutMessage = false;
if (isset($_SESSION['logout_successful'])) {
    $showLogoutMessage = true;
    // Löschen der Erfolgsmeldung, damit sie nur einmal angezeigt wird
    unset($_SESSION['logout_successful']);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Login | Todo List</title>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <?php
            if($showLogoutMessage == true){
                echo '<h3 style="text-align: center;">Erfolgreich abgemeldet</h3>';
            }
            ?>
            <h1>Login</h1>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="input-container">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-input" placeholder="Benutzername" required>
                </div>


                <div class="input-container">
                    <label for="password">Passwort:</label>
                    <input type="password" name="password" class="form-input" placeholder="Passwort" required>
                </div>


                <div class="input-container btn-action">
                    <input type="submit" name="submit" class="btn" value="Anmelden">
                    <a href="../index.php" class="btn">Zurück</a>

                </div>
                <?php
                include("./database.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Benutzereingaben validieren

                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // SQL-Abfrage, um Benutzer aus der Datenbank abzurufen
                    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
                    $result = mysqli_query($conn, $sql);

                    // Überprüfen, ob ein Benutzer mit den angegebenen Anmeldeinformationen gefunden wurde
                    if (mysqli_num_rows($result) == 1) {
                        // Anmeldung erfolgreich
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['user_id'] = $row['userid'];
                        $_SESSION['username'] = $row['username'];



                        header("Location: ../index.php"); 
                        exit();
                    } else {
                        // Anmeldung fehlgeschlagen
                        echo "Benutzername oder Passwort falsch";
                        exit();
                    }
                }


                mysqli_close($conn);
                ?>
            </form>
        </div>
    </div>
</body>


</html>