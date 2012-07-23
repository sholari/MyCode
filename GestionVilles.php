<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>test PHP</title>		
</head>		
<body onload="initialiser()"		
  <?php 
  
     define("MAPS_HOST", "maps.google.com");

     function AfficheTableVilles(){
	     $db = mysql_connect('localhost', 'ville', 'test');                                                                   // on se connecte à MySQL
         mysql_select_db('test',$db);                                                                                         // on sélectionne la base
         $sql = 'SELECT CODVILLE, NOMVILLE, IFNULL(LATTGPS,"&nbsp;") LATTGPS, IFNULL(LONGGPS,"&nbsp;") LONGGPS FROM villes';  // on crée la requête SQL
         $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());                                       // on envoie la requête
		 
         // Affichage de l'entête du tableau	 
         echo "<H3>* Affichage de l'information de la table des Villes</H3>";	 
	     echo "<TABLE align ='center' BORDER='1'><CAPTION>Villes</CAPTION>";
         echo "<TR><TH>Identifiant</TH><TH>Nom</TH><TH>Lattitude</TH><TH>Longitude</TH></TR>";
	   	 //    
         while($data = mysql_fetch_assoc($req))
         {  		 
          echo "<TR><TD>".$data['CODVILLE']."</TD><TD>".$data['NOMVILLE']."</TD><TD>".$data['LATTGPS']."</TD><TD>".$data['LONGGPS']."</TD></TR>";
	     }       		  
         echo "</TABLE>";
         mysql_close();	                                                                                                      // on ferme la connexion à mysql
	 }	 
	 
	 function trouver_coordonnees($adresse)
	 {
         // initialisation
         $retour['latitude'] = 0;
         $retour['longitude'] = 0;
         $retour['erreur'] = "";     
       
	     // Initialize delay in geocode speed
         $delay = 0;
         $base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml";
         $geocode_pending = true;
         while ($geocode_pending)
		 {
             $request_url = $base_url . "&q=" . urlencode($adresse);
             $xml = simplexml_load_file($request_url) or die("url not loading");
             $status = $xml->Response->Status->code;
             if (strcmp($status, "200") == 0)
             {
                // Successful geocode
                $geocode_pending = false;
                $coordinates = $xml->Response->Placemark->Point->coordinates;
                //$coordinatesSplit = split(",", $coordinates);
                $coordinatesSplit = preg_split('[,]', $coordinates);
                $retour['latitude'] = mysql_real_escape_string($coordinatesSplit[1]);
                $retour['longitude'] = mysql_real_escape_string($coordinatesSplit[0]);
             } 
			 else if (strcmp($status, "620") == 0) 
			 {
                // sent geocodes too fast
                $delay += 100000;
             } 
			 else 
			 {			 
                // failure to geocode
                $geocode_pending = false;
                $retour['erreur'] .= "Address " . $adresse . " failed to geocoded. ";
                $retour['erreur'] .= "Received status " . $status . "<br>\n";
             }
             usleep($delay);
         }
         return $retour;
     }
	 
	 function MajGPSVilles()
	 {
	     $db = mysql_connect('localhost', 'ville', 'test');                                                                   // on se connecte à MySQL
         mysql_select_db('test',$db);                                                                                         // on sélectionne la base  
         $sql2 = 'SELECT CODVILLE, NOMVILLE FROM villes WHERE LATTGPS is null or LATTGPS is null';                            // on crée la requête SQL
         $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());                                    // on envoie la requête      	  
         while($data2 = mysql_fetch_assoc($req2))
         { 
		    $retour2= trouver_coordonnees(utf8_encode($data2['NOMVILLE']));
 		    echo "- Les Coordonnées GPS de ".$data2['NOMVILLE']." sont (".$retour2['latitude']. ",".$retour2['longitude'].").</br>";
		    $sql3 = "Update villes set LATTGPS = '".$retour2['latitude']."', LONGGPS = '".$retour2['longitude']."' WHERE CODVILLE = '".$data2['CODVILLE']."'";
		    $req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());                 	  	     
	     }       		          
         mysql_close();	                                                                                                      // on ferme la connexion à mysql
	 }	 	 
	 //	 
	 AfficheTableVilles();     
	 //
	 echo "<H3>* Récupération des Coordonnées GPS</H3>";	 
	 MajGPSVilles();
	 //
	 AfficheTableVilles();     	 	
	 //
	 ?>
	 
    </body>
</html>