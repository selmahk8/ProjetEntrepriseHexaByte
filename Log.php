<?php
if(count($_POST)>0) {
session_start();

$servername = "localhost:8889";
$database = "HexaByte";
$username = "root";
$password = "root";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("échec de la connexion : " . mysqli_connect_error());
}else
{
    echo "Connexion à la BD réussie,";
}

$result = mysqli_query($conn,"SELECT username, password FROM Logs WHERE username='" . $_POST['username'] . "' and password = '". $_POST['pass']."'");

$row =  $result->fetch_row();


if(!empty($row)) {
$_SESSION["username"] = $row['0'];
$_SESSION["pass"] = $row['1'];
$_SESSION['msg']="Connexion à votre compte avec succès";

header("Location: HexaStats.php");
} else {

$_SESSION['msg']="Invalid Username or Password!";
header("Location: Login.php");
}

}

?>
