 <html>
 <body bgcolor="#B0E2FD">
 <?php
 require ("class.phpmailer.php");

function fetch_suivi_rel2($table, $id_srv, $id_client){
      global $dblink;
      $data = array();
	  $query = "SELECT suivi_rel_".$table." from com_srv".$id_srv." where id_client = '".$id_client."'";
	  $rec = mysql_query($query, $dblink) or die("ne pas exécuter la requête");
	  
	  while($res = mysql_fetch_assoc($rec)){
	         $temp = $res['suivi_rel_'.$table.''];
	         if(!empty($temp)){
			 $temp = explode("@", $temp);
			 $i = 0;
			 for($i = 0; $i < count($temp); $i++){
			      $data[$i] = explode(",", $temp[$i]);
			      $data[$i][0] = date("Y-m-d", (double)$data[$i][0]);
			      if(isset($data[$i][1])){
			           $res2 = mysql_query("select * from users where id = ".$data[$i][1],$dblink);
			      if($res2 != false){
		   	           while($users = mysql_fetch_assoc($res2))
			                $data[$i][1] = $users['nom'];
			      }
			                switch($data[$i][2]){
			                      case 'B8B8FE':
				                        $data[$i][2] = $table." -> -7 jours";
					       	            break;
				                  case 'B9FDBB':
				                        $data[$i][2] = $table." -> -30 jours";
						                break;
				                  case 'FFDC93':
				                        $data[$i][2] = $table." -> +7 jours";
						                break;
				                  case 'FF9F9F':
			       	                    $data[$i][2] = $table." -> +30 jours";
						                break;
								  case 'FFFFFF':
								        $data[$i][2] = $table." -> date fin contrat non valable";
			                }
			     }
				 else
				     $data = "Ce client n'a pas encore été relancé dans ce service";
			}
			}
	  }
	  
	  return $data;
}


 //--------------------------------------------------------------------------------------------------------------
                    // il ne faut pas déranger les clients, une fois par semaine c'est suffisant
//--------------------------------------------------------------------------------------------------------------						

function dont_disturb2($id_cl, $id_srv, $tr){
     $hist = fetch_suivi_rel2($tr, $id_srv, $id_cl);
	 if((is_array($hist)) && (count($hist) > 0)){
	 $temp = $hist[count($hist)-1][0];
	 $last_msg = mktime(0, 0, 0, substr($temp, 5, 2), substr($temp, 8, 2), substr($temp, 0, 4));
	 $time = time();
	 if($time - $last_msg > (60*60*24*7)) return (true);
	 else return (false);
	 }
	 else return(true);
}

//--------------------------------------------------------------------------------------------------------------
                                          //traitement de l'envoi de mail
//--------------------------------------------------------------------------------------------------------------
function dispatchRequest($form){
global $dblink;
if(isset($form['action']) && $form['action'] == "mail"){
      $mail = new PHPmailer();
      $mail->IsSMTP();
      $mail->Host = 'smtp.hexabyte.tn';
      $mail->From = "info@hexabyte.tn";
      $mail->FromName = 'Hexabyte';
      $mail->AddAddress($form['email']);
      $mail->AddReplyTo("info@hexabyte.tn");
      $mail->Subject = 'Notice de Paiement';
      $mail->IsHTML(true);
      $frm['id_service'] = $form['id_service'];
      $frm['id_client'] = $form['id_client'];
      $frm['status'] = $form['status'];
      $frm['id_cl_srv'] = $form['id_cl_srv'];
      if($form['email'] == "nomail@hexabyte.tn"){
             $body = "code client : ".$form['id_client']."<br>";
	         $body .= "il n'existe pas une adresse email valide pour ce client !";
	         $mail->Body = $body;
             if(!$mail->Send()) echo $mail->ErrorInfo;
             else{
                    echo "<br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 
cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Envoi de Mail</font></b></td></tr></div>";
                    echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>message envoyé avec succès à l'adresse :<br>$form[email]</p></font></b></td></tr></table>";
             }
       }

       elseif($form['email'] == "nocell@hexabyte.tn"){
              $body = "code client : ".$form['id_client']."<br>";
	          $body .= "il n'existe pas un numéro de téléphone portable valide pour ce client !";
	          $mail->Body = $body;
              if(!$mail->Send()) echo $mail->ErrorInfo;
              else{
                     echo "<br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 
cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Envoi de Mail</font></b></td></tr></div>";
                     echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>message envoyé avec succès à l'adresse :<br>$form[email]</p></font></b></td></tr></table>";
              }
        }

		elseif($form['email'] == "2bprinted@hexabyte.tn"){
			  $body = sendNotice($frm);
			  $mail->AddAttachment("/var/www/intranet/relance/relance/notices/notice.pdf","notice de paiement.pdf");
              $mail->Body = $body;	
              if(!$mail->Send()) echo $mail->ErrorInfo;
              else{
			         echo "<br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 
cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Envoi de Mail</font></b></td></tr></div>";
                     echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>message envoyé avec succès à l'adresse :<br>$form[email]</p></font></b></td></tr></table>";
			  }
		}
		else{
			  if(dont_disturb2($form['id_client'], $form['id_service'], 'mail')){
			         $body = sendNotice($frm);
                     $mail->AddAttachment("/var/www/intranet/relance/relance/notices/notice.pdf","notice de paiement.pdf");
                     $mail->Body = $body;

                     if(!$mail->Send()) echo $mail->ErrorInfo;
                     else{
                           echo "<br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Envoi de Mail</font></b></td></tr></div>";
                           echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>message envoyé avec succès à l'adresse :<br>$form[email]</p></font></b></td></tr></table>";

//on devrai aussi laisser une trace pour chaque client dans la table correspondant à chaque service
                           $query = "select id, suivi_rel_mail from com_srv".$form['id_service']." where id_client = ".$form['id_client'];
                           $rec = @mysql_query($query, $dblink) or die('Relance ne peut pas récupérer les informations sur le service');
                           while ($res = mysql_fetch_array($rec)){
                                 if($res['suivi_rel_mail'] == NULL)
	                                  $ins = time().",".$form['userid'].",".$form['status'];
                                 else
                                      $ins = $res['suivi_rel_mail']."@".time().",".$form['userid'].",".$form['status'];
                           }
                           $querySuivi = "UPDATE com_srv".$form['id_service']." SET suivi_rel_mail = '".$ins."' where id_client = ".$form['id_client'];
						   $resSuivi = @mysql_query($querySuivi,$dblink) or die('Relance ne peut pas récupérer les informations sur le suivi du service');
                     }
               }
               else{
                     echo "<br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 
cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Envoi de SMS</font></b></td></tr></div>";
                     echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>Un message a déja été envoyé au client depuis moin d'une semaine.<br>Vous ne pouvez pas lui envoyer un autre message maintenant !</p></font></b></td></tr></table>"; 
               }
       }
$mail->SmtpClose();
unset($mail);
}

//--------------------------------------------------------------------------------------------------------------
                                                //traitement de l'impression
//--------------------------------------------------------------------------------------------------------------
if(isset($form['action']) && $form['action'] == "print"){
echo '<script language="javascript">';
echo 'window.opener.window.print();';
echo '</script>';
echo "<br><br><div align=\"center\"><table border=1 style=\"BORDER-COLLAPSE: collapse\" borderColor=#000000 
cellSpacing=0 cellPadding=3 border=1><tr><td bgcolor=\"#336699\" align=\"left\"><b><font size=2 color=\"#FFFFFF\">Impression</font></b></td></tr></div>";
echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><b><font color=\"black\"><p>Requète d'impression envoyée.</p></font></b></td></tr></table>";
}
}
?>
</body>
</html>