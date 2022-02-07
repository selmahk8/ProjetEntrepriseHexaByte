<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Statistiques</title>
	<link rel="stylesheet"  href="MenuStyle.css">
</head>

<body>
<div class="header">
	<nav>
		<ul class="menu">
			<li><a href="HexaStats.php">Page d'accueil</a></li>
			<li><a href="recommandation.php">Recommandation</a></li>
			<li><a href="experience.php">Expérience</a></li>
			<li><a href="evaluation.php">Évaluation</a></li>
			<li><a href="service.php">Service</a></li>
			<li><a href="prix.php">Prix</a></li>
		</ul>
		<form>
			<input type="search" name="q" placeholder="Rechercher">
		</form>
	</nav>
	<p align="right">
	<button onclick="location.href = 'Login.php';"> Log out</button>
	</p>
</div>
</body>


<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
session_start();
?>

<center>
<h1>Bienvenue <?php echo $_SESSION["username"]; ?></h1> 
</center>

<?php
$servername = "localhost:8889";
$database = "HexaByte";
$username = "root";
$password = "root";
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

$dataRecommandation = array();
$dataExperience = array();
$dataEvaluation = array();
$dataService = array();
$dataPrix = array();

$data1 = mysqli_query($conn,"SELECT  count(*) as nb FROM client");
$row1 = $data1->fetch_row();

?>



<!DOCTYPE HTML>
<!doctype html>
<html lang="fr">

<body>
<center>
<h2>Page Administrateur de consultation des statistiques du formulaire de satisfaction client</h2>

<img src="logohexabyte.jpg" alt="logo">
</center>

<fieldset>
<h2> Nombre de participation au questionnaire de satisfaction client:
<?php
$nclient= mysqli_query($conn,"SELECT COUNT(nom) FROM Client");
$row1 = $nclient->fetch_row();
echo $row1[0];
?>
</h2>
</fieldset>


</body>
</html>
