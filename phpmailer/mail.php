<html>
<head>
<title><?php if($_REQUEST['act'] == 'print') echo 'imprimer une notice de paiement' ?> <?php if($_REQUEST['act'] == 'mail') echo 'envoi notice de paiement par email' ?></title>
</head>
<script language="javascript">
function msg1(){
choice = confirm("Voulez-vous imprimer cette page?");
if(choice == true){
window.open('action.php?action=print','','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=no,resizable=no,width=300,height=150');
}
else{
window.close();
}
}

function msg2(){
choice = confirm("Voulez-vous envoyer cette page par email?");
if(choice == true){
window.open('action.php?action=mail&email=<?php echo $_REQUEST['email'] ?>&id_service=<?php echo $_REQUEST['id_service'] ?>&id_cl_srv=<?php echo $_REQUEST['id_cl_srv'] ?>&id_client=<?php echo $_REQUEST['id_client'] ?>&userid=<?php echo $_REQUEST['userid'] ?>&status=<?php echo $_REQUEST['status'] ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=150');
window.close();
}
else{
window.close();
}
}
</script>
<body <?php if($_REQUEST['act'] == 'print') echo 'onload="msg1()"' ?> <?php if($_REQUEST['act'] == 'mail') echo 'onload="msg2()"' ?> >
<p>
  <?php
require ("class.phpmailer.php");
include('90getpost.php');
include('../inc/bd_locale.php');
include('../inc/f_login.inc');

$form['id_service'] = $_REQUEST['id_service'];
$form['id_client'] = $_REQUEST['id_client'];
$form['status'] = $_REQUEST['status'];
$form['id_cl_srv'] = $_REQUEST['id_cl_srv'];
$body = "";
$buffer = GetURL("http://localhost/intranet/relance/relance/notices/pay_notice.php","POST",$form);
for($i=9; $i<count($buffer)-6; $i++){
    $body .= $buffer[$i];
}
//print_r($buffer);
echo $body;
?>
</body>
</html>
