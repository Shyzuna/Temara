<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  
  <title>TEMARA</title>
   <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/index.css">
  <link href="css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/contact.css">
  
  <link href="css/print-bien.css" rel="stylesheet" media="print">
</head>
<body onload="initMaps()">

	<div id="corps">
		<?php include('header.php'); ?>
		<?php include('nav.php'); ?>
		
		<div id="ensemble">
			<?php //include('message_rouge.php'); ?>
			
			<?php
			//require_once('lien_connexion.php');
			?>
			
			<center><h2>Site Bientôt Disponible</h2></center>
			
			<div>
				
				<div id="agences">
					<div class="coordonnees_agence">
						<h4>Temara Amiens</h4>
						<div id="map_amiens"></div>
						<span class="horaires_agence">
							Notre agence vous accueille sans rendez-vous<br />
							du mardi au vendredi, de 9h à 12h et de 14h à 18h,<br /> 
							le samedi de 10h à 12h et de 14h à 17h<br /> 
							(permanence téléphonique jusque 19h, 18h le samedi).<br /> 
							Sur rendez-vous en dehors de ces jours et horaires.<br />
						</span>
					</div>
					
					<div class="coordonnees_agence">
						<h4>Temara Corbie</h4>
						<div id="map_corbie"></div>
						<span class="horaires_agence">
							Notre agence est ouverte :<br />
							du mardi au vendredi,<br /> 
							de 9h à 12h et de 14h à 19h<br /> 
							le samedi de 9h à 12h et de 14h à 18h<br />
						</span>
					</div>
				</div>
				
				<p class="explication">
					Vous êtes à la recherche d'une maison, d'un appartement en location ?
					Nous vous proposons de vous aider dans votre démarche.
					Pour cela, remplissez et retournez-nous le formulaire ci-après.
				</p>
				
				<hr/>
				
				<center class="mention">
					Transactions sur immeubles & fonds de commerce - Carte professionnelle n°117 délivrée par la Préfecture de la Somme <br /> 
					Dans un souci de protection de notre clientèle, il n'est reçu aucun fonds, en dehors des honoraires <br />
					Garantie financière de 30 000 € : QBE - 12 place Vendôme - 75001 Paris <br />
					Siège social : 73 rue Jules Barni - 80000 AMIENS - FRANCE <br />
					SARL au capital de 7 622,45 € - 352 420 640 RCS AMIENS
				</center>
				

	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- API Google Maps -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
	<script type="text/javascript" src="js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="js/connexion.js"></script>
	<script type="text/javascript" src="js/contact_maps.js"></script>
</body>
</html>