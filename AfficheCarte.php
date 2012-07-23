<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>test PHP</title>		
</head>		
	 <?php 
       define("MAPS_HOST", "maps.google.com");
 	 ?>
	 
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
    function initialiser() {
        var latlng = new google.maps.LatLng(46.779231, 6.659431);
        var options = { center: latlng, zoom: 11, mapTypeId: google.maps.MapTypeId.ROADMAP };
		var carte = new google.maps.Map(document.getElementById("carte"), options);
        var parcoursBus;
		//= [ new google.maps.LatLng(46.779231, 6.659431),
        //    new google.maps.LatLng(46.0, 6.0),
		//	  new google.maps.LatLng(46.1, 6.4)]
		//création des marqueurs
	    <?php 		
		    $db = mysql_connect('localhost', 'ville', 'test'); 
            mysql_select_db('test',$db);
            $sql = 'SELECT CODVILLE, NOMVILLE, IFNULL(LATTGPS,"&nbsp;") LATTGPS, IFNULL(LONGGPS,"&nbsp;") LONGGPS FROM villes';
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data = mysql_fetch_assoc($req))
            { 
                echo "var marqueur = new google.maps.Marker({ title: '".$data['NOMVILLE']."', draggable:true, clickable:true,raiseInDrag:true, position: new google.maps.LatLng(".$data['LATTGPS'].", ".$data['LONGGPS']."), map: carte});".chr(13).chr(10);							       	
			   // echo "parcoursBus = new google.maps.LatLng(".$data['LATTGPS'].", ".$data['LONGGPS'].");".chr(13).chr(10);
	        }       		  
            mysql_close();	
        ?>
 	    var traceParcoursBus = new google.maps.Polyline({
		    path: parcoursBus,//chemin du tracé
		    strokeColor: "#FF0000",//couleur du tracé
		    strokeOpacity: 1.0,//opacité du tracé
		    strokeWeight: 2//grosseur du tracé
	    });
		traceParcoursBus.setMap(carte);	
	}
	</script>	
	<body onload="initialiser()"	
        <div id="carte" style="width:80%; height:80%"></div>
    </body>
</html>