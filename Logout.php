<?php
session_start(); //to ensure you are using same session
session_destroy($_SESSION); //destroy the session
header("location:Login.php"); //to redirect back to "Login.php" after logging out
exit();
?>

