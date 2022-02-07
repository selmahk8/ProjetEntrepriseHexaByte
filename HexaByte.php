<?php

//ini_set("allow_url_include", "1");
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$servername = "localhost:8889";
$database = "HexaByte";
$username = "root";
$password = "root";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);


// Check connection
if (!$conn) {
      die("échec de la connexion : " . mysqli_connect_error());
}
 
echo "Connexion réussie,";


// space between them for better look
// Insert into sql database
 
$sql = "INSERT INTO Client (nom, email, phone, address, contrat, recommandation, experience, evaluation, servicee, prix, feedback) VALUES ('".$_POST['nom']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['address']."', '".$_POST['contrat']."', '".$_POST['recommandation']."', '".$_POST['experience']."', '".$_POST['evaluation']."', '".$_POST['servicee']."', '".$_POST['prix']."', '".$_POST['feedback']."')";
if (mysqli_query($conn, $sql)) {
      echo  " Formulaire envoyé avec succès, ";
} else {
      echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);



//send email to admin

$path = "/Applications/MAMP/htdocs/phpmailer/class.phpmailer.php";

//here coller

require "$path";

//require 'Applications/MAMP/htdocs/phpmailer';

$mail = new PHPmailer();

$mail->IsSMTP();

$mail->IsHTML(true);

$mail->Host = 'host_here';

$mail->From = "from_email";

$mail->FromName = "Email_Object";

$mail->AddAddress('admin_email_here');

//$mail->AddReplyTo('reply_email_to');

//$mail->AddCC('add_New_email');

$mail->Subject="Formulaire client";

$body_mail="<html>
<head>
<style> h1 { color: #ff0000; } </style>
<style> h2 { color: #4169E1; } </style>
<style> h3 { color: #0CA449; } </style>
</head>

<body>
<h1>Coordonnées client:</h1>
<h2>nom : </h2>  <h3>".$_POST['nom']."</h3>
<h2>email :</h2> <h3>".$_POST['email']."</h3>
<h2>phone :</h2> <h3>".$_POST['phone']."</h3>
<h2>address :</h2> <h3>".$_POST['address']."</h3>

<h1>Réponses formulaire:</h1>
<h2>- Quelle est votre type de contrat ? :</h2>    <h3>".$_POST['contrat']."</h3>
<h2>1) Recommanderiez-vous Hexabyte à un(e) ami(e), collègue ou membre de votre famille ? :</h2>  <h3>".$_POST['recommandation']."</h3>
<h2>2) Êtes-vous globalement satisfait(e) de votre expérience avec HexaByte ? :</h2>      <h3>".$_POST['experience']."</h3>
<h2>3) Sur une échelle de 1 à 5, comment évaluez-vous la qualité de notre service ? :</h2>      <h3>".$_POST['evaluation']."</h3>
<h2>4) Le service est-il performant ? :</h2>      <h3>".$_POST['servicee']."</h3>
<h2>5) Le prix est-il justifié ? :</h2>   <h3>".$_POST['prix']."</h3>
<h2>6) Partagez nous votre feedback: :</h2> <h3>".$_POST['feedback']."</h3>
</body>
</html>";

$mail->Body=$body_mail;

//$mail->AddAttachment('a.txt');

if(!@$mail->Send()){

  echo $mail->ErrorInfo;
}

else{
  echo ' Mail envoyé avec succès';
}

sleep(5);

$mail->SmtpClose();

unset($mail);

?>
