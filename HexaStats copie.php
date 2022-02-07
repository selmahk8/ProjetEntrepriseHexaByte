<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
session_start();
print_r($_SESSION);
?>
<center>
<h1>Welcome <?php echo $_SESSION["username"]; ?></h1> 
<button onclick="location.href = 'Login.php';"> Logout</button>
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

//RECOMMANDATION
$data = mysqli_query($conn,"SELECT DISTINCT recommandation as label, (count(*)/".$row1['0'].")*100 as y FROM client group by recommandation");
while ($row = $data->fetch_assoc()) {
    $dataRecommandation [] =  $row;
}

//EXPERIENCE
$data = mysqli_query($conn,"SELECT DISTINCT experience as label, (count(*)/".$row1['0'].")*100 as y FROM client group by experience");
while ($row = $data->fetch_assoc()) {
    $dataExperience [] =  $row;
}

//EVALUATION
$data = mysqli_query($conn,"SELECT DISTINCT evaluation as label, (count(*)/".$row1['0'].")*100 as y FROM client group by evaluation");
while ($row = $data->fetch_assoc()) {
    $dataEvaluation [] =  $row;
}

//SERVICE
$data = mysqli_query($conn,"SELECT DISTINCT servicee as label, (count(*)/".$row1['0'].")*100 as y FROM client group by servicee");
while ($row = $data->fetch_assoc()) {
    $dataService [] =  $row;
}

//PRIX
$data = mysqli_query($conn,"SELECT DISTINCT prix as label, (count(*)/".$row1['0'].")*100 as y FROM client group by prix");
while ($row = $data->fetch_assoc()) {
    $dataPrix [] =  $row;
}

?>



<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
/* chartRecommandation  */
var chart = new CanvasJS.Chart("chartRecommandation", {
	animationEnabled: true,
	title: {
		text: "Statistique de recommandation"
	},
	subtitles: [{
		text: "2022 (en %)"
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


/* chartExperience  */
var chart = new CanvasJS.Chart("chartExperience", {
	animationEnabled: true,
	title: {
		text: "Statistique Experience"
	},
	subtitles: [{
		text: "2022 (en %)"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataExperience, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
/* fin chartExperience */


/* chartEvaluation */
var chart = new CanvasJS.Chart("chartEvaluation", {
	animationEnabled: true,
	title: {
		text: "Statistique Evaluation"
	},
	subtitles: [{
		text: "2022 (en %)"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataEvaluation, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
/* fin chartEvaluation */


/* chartService */
var chart = new CanvasJS.Chart("chartService", {
	animationEnabled: true,
	title: {
		text: "Statistique Service"
	},
	subtitles: [{
		text: "2022 (en %)"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataService, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
/* fin chartService */


/* chartPrix */
var chart = new CanvasJS.Chart("chartPrix", {
	animationEnabled: true,
	title: {
		text: "Statistique Prix"
	},
	subtitles: [{
		text: "2022 (en %)"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPrix, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
/* fin chartPrix */

 
}
</script>
</head>
<body>


<table>

   <tbody>
    <tr style="height: 2000px; height: 600px">
    <td><div id="chartRecommandation" style="height: 600px; width: 600px;"></div></td>
    <td><div id="chartExperience" style="height: 600px; width: 600px;"></div></td>

    </tr>
    <tr>
    <td><div id="chartEvaluation" style="height: 600px; width: 600px;"></div></td>
    <td><div id="chartService" style="height: 600px; width: 600px;"></div></td>
	</tr>
	
	<tr>
    <td><div id="chartPrix" style="height: 600px; width: 600px;"></div></td>	
	</tr>

  </tbody>
</table>

<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
</body>
</html>             









<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>page eval</title>
</head>
<body>



</body>