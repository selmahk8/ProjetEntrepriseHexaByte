<?php

//Added by Lotfi KDOUS 21-04-2006
function GetURL($url,$mode,$postparams=''){

    global $cookies, $lasturl;
   // D�claration du tableau de retour
    $data = array();
    // V�rification de la m�thode d'acc�s � la page (normal ou SSL)
    $path = explode('/',$url);
    if ($path[0] == 'https') {
        $prefix = 'ssl://';
        $port = 443; 

    } else {
        $prefix = '';
        $port = '80'; 
    }
    $fp = fsockopen($prefix.$path[2], $port, $errno, $errstr);
    if (!$fp) {
        die("$errstr ($errno)
        \n"); 
    }
    // S�paration du prefixe http:// pour d�finir le host et la page demand�e
    $host=$path[2];
    unset($path[0]);
    unset($path[1]);
    unset($path[2]);
    $path='/'.(implode('/',$path));
    // S�paration des fonctions selon le mode d'envoi
    if ($mode == 'POST') {
        // Cr�ation de la partie donn�es du formulaire POST
        $postv = '';
        if (is_array($postparams)) {
            foreach($postparams AS $name => $value ){
                $postv .= urlencode($name) . "=" . urlencode($value) . '&'; 
            }
            $postv = substr($postv, 0, -1);
            $lenght = strlen($postv); 
        }
        // Cr�ation de la requ�te
        $req = "POST $path HTTP/1.1\r\n";
        $req .= "Host: $host\r\n";
        $req .= "User-Agent: Mozilla/5.0\r\n";
        // Emulation du referer
        if ($lasturl) $req .= "Referer: $lasturl\r\n";
        // Cr�ation de la partie cookie de la requ�te
        if (count($cookies) > 0) {
            $req .= "Cookie: ";
            foreach ($cookies as $cookie_nom => $cookie_valeur) {
                $req .= $cookie_nom.'='.$cookie_valeur.'; '; 
            }
            $req = substr($req, 0, -2);
            $req .= "\r\n"; 
        }
        $req .= "Connection: close\r\n";
        $req .= "Content-type: application/x-www-form-urlencoded\r\n";
        $req .= "Content-Length: $lenght\r\n";
        $req .= "\r\n";
        $req .= $postv;
        // Fin de la requ�te 
    } elseif ($mode == 'GET') {
        // Cr�ation de la requ�te
        $req = "GET $path HTTP/1.1\r\n";
        $req .= "Host: $host\r\n";
        $req .= "User-Agent: Mozilla/5.0\r\n";
        // Emulation du referer
        if ($lasturl) $req .= "Referer: $lasturl\r\n";
        // Cr�ation de la partie cookie de la requ�te
        if (count($cookies) > 0) {
            $req .= "Cookie: ";
            foreach ($cookies as $cookie_nom => $cookie_valeur) {
                $req .= $cookie_nom.'='.$cookie_valeur.'; '; 
            }
            $req = substr($req, 0, -2);
            $req .= "\r\n"; 
        }
        $req .= "Connection: close\r\n";
        $req .= "\r\n";
        // Fin de la requ�te 
    }
    // Envoi de la requ�te au serveur
    fputs($fp, $req);
    // R�ception des donn�es
    while (!feof($fp)) {
        $line = fgets($fp, 64);
        // Si la ligne est une demande de cr�ation de cookie, stockage dans la variable globale $cookies
        if (substr($line,0,11) == 'Set-Cookie:') {
            $a = explode(';',substr($line,12));
            $b = explode('=',$a[0]);
            $cookies[$b[0]] = $b[1]; 
        }
        // Ajout de la ligne au tableau de retour $data
        array_push($data,$line); 
    }
    // Fermeture du socket
    fclose($fp);
    // Pr�paration du referer
    $lasturl = $url;
    // Retour des donn�es
    return $data; 
}

function array_pos($tableau, $needed) {
      for ($i=0; $i<sizeof($tableau);$i++){
      	if ($tableau[$i]==$needed) break;
      	}
      return $i;
}


function Return_Substrings($text, $sopener, $scloser)
               {
               $result = array();
               
               $noresult = substr_count($text, $sopener);
               $ncresult = substr_count($text, $scloser);
               
               if ($noresult < $ncresult)
                       $nresult = $noresult;
               else
                       $nresult = $ncresult;
       
               unset($noresult);
               unset($ncresult);
               
               for ($i=0;$i<$nresult;$i++) 
                       {
                       $pos = strpos($text, $sopener) + strlen($sopener);
               
                       $text = substr($text, $pos, strlen($text));
               
                       $pos = strpos($text, $scloser);
                       
                       $result[] = substr($text, 0, $pos);

                       $text = substr($text, $pos + strlen($scloser), strlen($text));
                       }
                       
               return $result;
               }



function IsNum($value){
if (preg_match("/^[[:digit:]]+$/", $value)) { 
	
   return true;
   
} else {
	
   	return false;
   	
	}
}

?>