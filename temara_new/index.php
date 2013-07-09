
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  <link rel="stylesheet" href="css/index.css">
  <link href="css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/form-media-queries.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/contact.css">
  
  <link href="css/print-bien.css" rel="stylesheet" media="print">
</head>
<body onload="initMaps()">

	<div id="corps">
		<?php include('header.php'); ?>

		
		<div id="ensemble">
			<?php //include('message_rouge.php'); ?>
			
			<?php
			//require_once('lien_connexion.php');
			?>
			
			<h2>Nous contacter</h2>
			
			<div class="cadre">
				
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
				
				<?php if ($formEnvoye) echo '<p class="confirm_form_envoye">Votre demande a été envoyée avec succès</p>'; ?>
					
				<form class="form-horizontal" method="post">
					
					<h4>Vos coordonnées</h4>
					
					<div class="control-group">
						<div class="control-label section_description">Civilité*</div>
						<div class="controls">
							<select name="civilite">
								<option value="1" <?php if ($civilite == 1) echo 'selected="selected"';?>>M.</option>
								<option value="2" <?php if ($civilite == 2) echo 'selected="selected"';?>>Mme</option>
								<option value="3" <?php if ($civilite == 3) echo 'selected="selected"';?>>Mlle</option>
							</select>
							<?php echo $erreurCivilite; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nom*</div>
						<div class="controls">
							<input type="text" class="champ_text" maxlength="30" name="nom" required="required" value="<?php echo $nom;?>" />
							<?php echo $erreurNom; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Prénom*</div>
						<div class="controls">
							<input type="text" class="champ_text" maxlength="30" name="prenom" required="required" value="<?php echo $prenom;?>" />
							<?php echo $erreurPrenom; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Téléphone*</div>
						<div class="controls">
							<input type="text" class="champ_text" maxlength="25" name="telephone" required="required" value="<?php echo $telephone;?>" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" />
							<?php echo $erreurTelephone; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">E-mail*</div>
						<div class="controls">
							<input type="email" class="champ_text" maxlength="50" name="mail" required="required" value="<?php echo $mail;?>" />
							<?php echo $erreurMail; ?>
						</div>
					</div>
					
					<h4>Votre recherche</h4>

					<div class="control-group">
						<div class="control-label section_description">Type de bien</div>
						<div class="controls">
							<select name="typeBien">
								<option value="Maison" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Maison') echo 'selected="selected"';?>>Maison</option>
								<option value="Appartement" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Appartement') echo 'selected="selected"';?>>Appartement</option>
								<option value="Terrain" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Terrain') echo 'selected="selected"';?>>Terrain</option>
								<option value="Garage" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Garage') echo 'selected="selected"';?>>Garage</option>
								<option value="Local commercial" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Local commercial') echo 'selected="selected"';?>>Local commercial</option>
								<option value="Autre" <?php if (isset($_POST['typeBien']) && $_POST['typeBien'] == 'Autre') echo 'selected="selected"';?>>Autre</option>
							</select>
							<?php echo $erreurTypeBien;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Etat du bien</div>
						<div class="controls">
							<div class="radio">
								<input type="radio" name="etat" value="1" <?php if (isset($_POST['etat']) && $_POST['etat'] == 1) echo 'checked="checked"'; else if (!(isset($_POST['etat']))) echo 'checked="checked"';?> />A vendre
							</div>
							<div class="radio">
								<input type="radio" name="etat" value="2" <?php if (isset($_POST['etat']) && $_POST['etat'] == 2) echo 'checked="checked"';?> />A louer
							</div>
							<?php echo $erreurEtat;?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label section_description">Budget</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="budgetMin" placeholder="Min" value="<?php echo $budgetMin;?>" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="budgetMax" placeHolder="Max" value="<?php echo $budgetMax;?>" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
							<?php echo $erreurBudget; ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label section_description">Surface</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="surfaceMin" placeholder="Min" value="<?php echo $surfaceMin;?>" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="surfaceMax" placeholder="Max" value="<?php echo $surfaceMax;?>" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
							<?php echo $erreurSurface; ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label section_description">Nombre de pièces</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<input type="number" min="0" name="nbPiecesMin" placeholder="Min" value="<?php echo $nbPiecesMin;?>" />
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<input type="number" min="0" name="nbPiecesMax" placeholder="Max" value="<?php echo $nbPiecesMax;?>" />
								</div>
							</div>
							<?php echo $erreurNbPieces; ?>
						</div>
					</div>
					
					<div class="control-group">
							<div class="control-label section_description">Remarques</div>
							<div class="controls">
								<textarea rows="5" name="remarques"><?php echo $remarques;?></textarea>
							</div>
						</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Envoyer</button>
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<span class="indication_form">(*) Champs obligatoires</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
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