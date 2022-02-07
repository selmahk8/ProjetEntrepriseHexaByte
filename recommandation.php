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

$data1 = mysqli_query($conn,"SELECT  count(*) as nb FROM client");
$row1 = $data1->fetch_row();


//RECOMMANDATION
$data = mysqli_query($conn,"SELECT DISTINCT recommandation as label, (count(*)/".$row1['0'].")*100 as y FROM client group by recommandation");
while ($row = $data->fetch_assoc()) {
    $dataRecommandation [] =  $row;
}

print_r($dataRecommandation);

?>


<!DOCTYPE html>
<html>
<head>
<script>
window.onload = function() {

/* chartRecommandation  */
var chart = new CanvasJS.Chart("chartRecommandation", {
	animationEnabled: true,
	title: {
		text: "Statistique Recommandation"
	},
	subtitles: [{
		text: "(en %)"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataRecommandation, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
/* fin chartRecommandation */

}



</script>
</head>
<body>

<center>
<table>

   <tbody>
    <tr style="height: 2000px; height: 600px">
    <td><div id="chartRecommandation" style="height: 600px; width: 600px;"></div></td>
  </tbody>

</table>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</center>
</head>
</html>