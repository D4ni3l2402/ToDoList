<?php
session_start();

// Session zerstören
session_destroy();

session_start();

$_SESSION['logout_successful'] = true;


// Weiterleitung zur Login-Seite
header("Location: login.php");
exit();
?>
