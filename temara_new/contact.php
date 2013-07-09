
<?php

$erreurCivilite = "";
$erreurNom = "";
$erreurPrenom = "";
$erreurTelephone = "";
$erreurMail = "";
$erreurTypeBien = "";
$erreurEtat = "";
$erreurBudget = "";
$erreurSurface = "";
$erreurNbPieces = "";

if (isset($_SESSION['compte']))
{
	$compte = unserialize($_SESSION['compte']);
	$civilite = $compte->civilite;
	$nom = $compte->nom;
	$prenom = $compte->prenom;
	$telephone = $compte->telephone;
	$mail = $compte->mail;
}
else
{
	$civilite = 0;
	$nom = "";
	$prenom = "";
	$telephone = "";
	$mail = "";
}

$typeBien = "";
$etat = null;
$budgetMin = null;
$budgetMax = null;
$surfaceMin = null;
$surfaceMax = null;
$nbPiecesMin = null;
$nbPiecesMax = null;
$remarques = "";

$formEnvoye = false;

if (isset($_POST['civilite']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['mail']) && 
	isset($_POST['typeBien']) && isset($_POST['etat']) && isset($_POST['budgetMin']) && isset($_POST['budgetMax']) && isset($_POST['surfaceMin']) && isset($_POST['surfaceMax']) &&
	isset($_POST['nbPiecesMin']) && isset($_POST['nbPiecesMax']) && isset($_POST['remarques']))
{
	if ($_POST['civilite'] >= 1 && $_POST['civilite'] <= 3)
		$civilite = $_POST['civilite'];
	if ($_POST['nom'] != '')
		$nom = htmlentities($_POST['nom']);
	if ($_POST['prenom'] != '')
		$prenom = htmlentities($_POST['prenom']);
	if ($_POST['telephone'] != '')
		$telephone = htmlentities($_POST['telephone']);
	if ($_POST['mail'] != '')
		$mail = htmlentities($_POST['mail']);
	if ($_POST['typeBien'] == 'Maison' || $_POST['typeBien'] == 'Appartement' || $_POST['typeBien'] == 'Terrain' || $_POST['typeBien'] == 'Garage' || $_POST['typeBien'] == 'Local commercial' || $_POST['typeBien'] == 'Autre')
		$typeBien = $_POST['typeBien'];
	if ($_POST['etat'] == 1 || $_POST['etat'] == 2)
		$etat = $_POST['etat'];
	if ($_POST['budgetMin'] != '')
		$budgetMin = htmlentities($_POST['budgetMin']);
	if ($_POST['budgetMax'] != '')
		$budgetMax = htmlentities($_POST['budgetMax']);
	if ($_POST['surfaceMin'] != '')
		$surfaceMin = htmlentities($_POST['surfaceMin']);
	if ($_POST['surfaceMax'] != '')
		$surfaceMax = htmlentities($_POST['surfaceMax']);
	if ($_POST['nbPiecesMin'] != '')
		$nbPiecesMin = htmlentities($_POST['nbPiecesMin']);
	if ($_POST['nbPiecesMax'] != '')
		$nbPiecesMax = htmlentities($_POST['nbPiecesMax']);
	if ($_POST['remarques'] != '')
		$remarques = htmlentities($_POST['remarques']);
	
	// Si les champs sont bien remplis
	if (($civilite >= 1 && $civilite <= 3) && $nom != '' && $prenom != '' && $telephone != '' && (preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)) 
		&& $_POST['mail'] != '' && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) && $typeBien != "" && $etat != null
		&& ($budgetMin == null || is_numeric($budgetMin)) && ($budgetMax == null || is_numeric($budgetMax)) && ($budgetMin == null || $budgetMax == null || $budgetMin <= $budgetMax)
		&& ($surfaceMin == null || is_numeric($surfaceMin)) && ($surfaceMax == null || is_numeric($surfaceMax)) && ($surfaceMin == null || $surfaceMax == null || $surfaceMin <= $surfaceMax)
		&& ($nbPiecesMin == null || is_numeric($nbPiecesMin)) && ($nbPiecesMax == null || is_numeric($nbPiecesMax)) && ($nbPiecesMin == null || $nbPiecesMax == null || $nbPiecesMin <= $nbPiecesMax))
	{
		$message;
		$desti;
		$sujet;
		mail($desti,$sujet,$message);
		//ContactTable::addContact($civilite,$nom,$prenom,$telephone,$mail,$typeBien,$etat,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,nl2br($remarques));
		$formEnvoye = true;
	}
	else
	{
		// Messages d'erreur
		if ($_POST['civilite'] < 1 || $_POST['civilite'] > 3)
			$erreurCivilite = '<br /><span class="erreur_form">Veuillez choisir une civilité</span>';
		if ($_POST['nom'] == '')
			$erreurNom = '<br /><span class="erreur_form">Veuillez saisir votre nom</span>';
		if ($_POST['prenom'] == '')
			$erreurPrenom = '<br /><span class="erreur_form">Veuillez saisir votre prénom</span>';
		if ($_POST['telephone'] == '')
			$erreurTelephone = '<br /><span class="erreur_form">Veuillez saisir votre numéro de téléphone</span>';
		else if (!(preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)))
			$erreurTelephone = '<br /><span class="erreur_form">Le numéro saisi est invalide</span>';
		if ($_POST['mail'] == '')
			$erreurMail = '<br /><span class="erreur_form">Veuillez saisir votre adresse mail</span>';
		else if (!(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)))
			$erreurMail = '<br /><span class="erreur_form">L\'adresse mail saisie est invalide</span>';
			
		if (($budgetMin != null && !(is_numeric($budgetMin))) || ($budgetMax != null && !(is_numeric($budgetMax))))
			$erreurBudget = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
		else if ($budgetMin != null && $budgetMax != null && ($budgetMin > $budgetMax))
			$erreurBudget = '<br /><span class="erreur_form">Le budget minimum doit être inférieur au budget maximum</span>';
			
		if (($surfaceMin != null && !(is_numeric($surfaceMin))) || ($surfaceMax != null && !(is_numeric($surfaceMax))))
			$erreurSurface = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
		else if ($surfaceMin != null && $surfaceMax != null && ($surfaceMin > $surfaceMax))
			$erreurSurface = '<br /><span class="erreur_form">La surface minimum doit être inférieur à la surface maximum</span>';
			
		if (($nbPiecesMin != null && !(is_numeric($nbPiecesMin))) || ($nbPiecesMax != null && !(is_numeric($nbPiecesMax))))
			$erreurNbPieces = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
		else if ($nbPiecesMin != null && $nbPiecesMax != null && ($nbPiecesMin > $nbPiecesMax))
			$erreurNbPieces = '<br /><span class="erreur_form">Le nombre de pièces minimum doit être inférieur au nombre de pièces maximum</span>';
	}
}

?>

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

		
		<div id="ensemble">
				
				<span style="float:right;"><a href="index.php">Accueil</a></span>
				
				<h2>Nous contacter</h2>
				
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