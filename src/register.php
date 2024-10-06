<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Register | Todo List</title>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Registrieren</h1>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="input-container">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-input" placeholder="Benutzername" required>
                </div>

                <div class="input-container">
                    <label for="email">E-Mail:</label>
                    <input type="email" name="email" class="form-input" placeholder="E-Mail" required>
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
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                
                    // Überprüfen, ob Benutzername oder E-Mail bereits vorhanden sind
                    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
                    $result = mysqli_query($conn, $check_query);
                    if (mysqli_num_rows($result) > 0) {
                        // Benutzername oder E-Mail bereits vorhanden
                        echo "Benutzername oder E-Mail bereits vergeben";
                        exit();
                    }
                
                    if (!empty($username) && !empty($password) && !empty($email)) {
                        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                
                        if (mysqli_query($conn, $sql)) {
                            echo "Registration successful!";
                            $userId = mysqli_insert_id($conn); // Die ID des zuletzt eingefügten Datensatzes (Benutzer)
                            $_SESSION['user_id'] = $userId;
                            $_SESSION['username'] = $username;
                            header("Location: ../index.php");
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    } else {
                        echo "Benutzername, E-Mail oder Passwort fehlen";
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