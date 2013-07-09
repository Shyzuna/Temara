<?php
session_start();

require_once('Estimation.class.php');
require_once('EstimationTable.class.php');
require_once('../Compte/Compte.class.php');

$erreurTypeBien = "";
$erreurEtat = "";
$erreurNbPieces = "";
$erreurSurface = "";
$erreurAdresse = "";
$erreurCodePostal = "";
$erreurVille = "";
$erreurCivilite = "";
$erreurNom = "";
$erreurPrenom = "";
$erreurTelephone = "";
$erreurMail = "";

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
	
$nbPieces = "";
$surface = "";
$adresse = "";
$codePostal = "";
$ville = "";
$description = "";
$commentaire = "";

$formEnvoye = false;

/*
* Vérification et enregistrement des données du formulaire
*/
if (isset($_POST['typeBien']) && isset($_POST['etat']) && isset($_POST['nbPieces']) && isset($_POST['surface']) && isset($_POST['adresse']) && isset($_POST['codePostal']) && isset($_POST['ville']) && isset($_POST['description'])
	&& isset($_POST['civilite']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['mail']) && isset($_POST['commentaire']))
{
	if ($_POST['civilite'] >= 1 && $_POST['civilite'] <= 3)
		$civilite = $_POST['civilite'];
	if ($_POST['nbPieces'] != '')
		$nbPieces = htmlentities($_POST['nbPieces']);
	if ($_POST['surface'] != '')
		$surface = htmlentities(str_replace(',','.',$_POST['surface']));
	if ($_POST['adresse'] != '')
		$adresse = htmlentities($_POST['adresse']);
	if ($_POST['codePostal'] != '')
		$codePostal = htmlentities($_POST['codePostal']);
	if ($_POST['ville'] != '')
		$ville = htmlentities($_POST['ville']);
	if ($_POST['description'] != '')
		$description = htmlentities($_POST['description']);
	if ($_POST['nom'] != '')
		$nom = htmlentities($_POST['nom']);
	if ($_POST['prenom'] != '')
		$prenom = htmlentities($_POST['prenom']);
	if ($_POST['telephone'] != '')
		$telephone = htmlentities($_POST['telephone']);
	if ($_POST['mail'] != '')
		$mail = htmlentities($_POST['mail']);
	if ($_POST['commentaire'] != '')
		$commentaire = htmlentities($_POST['commentaire']);
			
	// Si les champs sont bien remplis
	if (($_POST['typeBien'] == 'Maison' || $_POST['typeBien'] == 'Appartement' || $_POST['typeBien'] == 'Terrain' || $_POST['typeBien'] == 'Garage' || $_POST['typeBien'] == 'Local commercial' || $_POST['typeBien'] == 'Autre')
		&& ($_POST['etat'] >= 1 && $_POST['etat'] <= 2) && $_POST['nbPieces'] != '' && is_numeric($_POST['nbPieces']) && $_POST['surface'] != '' && is_numeric($surface)
		&& $_POST['adresse'] != '' && $_POST['codePostal'] != '' && strlen($_POST['codePostal']) == 5 && is_numeric($_POST['codePostal']) && $_POST['ville'] != ''
		&& $_POST['nom'] != '' && $_POST['prenom'] != '' && $_POST['telephone'] != '' && (preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)) 
		&& $_POST['mail'] != '' && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) && ($_POST['civilite'] >= 1 && $_POST['civilite'] <= 3))
	{	
		$demandeInfos = EstimationTable::addEstimation($_POST['typeBien'],$_POST['etat'],$nbPieces,$surface,$adresse,$codePostal,$ville,nl2br($description),
						$_POST['civilite'],$nom,$prenom,$telephone,$mail,nl2br($commentaire));
						
		$formEnvoye = true;
	}
	else
	{
		// Messages d'erreur
		if ($_POST['typeBien'] == "")
			$erreurTypeBien = '<br /><span class="erreur_form">Veuillez choisir le type de bien que vous souhaitez vendre ou louer</span>';
		if ($_POST['etat'] < 1 || $_POST['etat'] > 2)
			$erreurEtat = '<br /><span class="erreur_form">Souhaitez-vous vendre ou louer votre bien ?</span>';
		if ($_POST['nbPieces'] == '')
			$erreurNbPieces = '<br /><span class="erreur_form">Veuillez saisir le nombre de pièces de votre bien</span>';
		else if (!(is_numeric($_POST['nbPieces'])))
			$erreurNbPieces = '<br /><span class="erreur_form">Veuillez saisir un nombre entier</span>';
		if ($_POST['surface'] == '')
			$erreurSurface = '<br /><span class="erreur_form">Veuillez saisir la surface de votre bien</span>';
		else if (!(is_numeric($surface)))
			$erreurSurface = '<br /><span class="erreur_form">Veuillez saisir un nombre entier</span>';
		if ($_POST['adresse'] == '')
			$erreurAdresse = '<br /><span class="erreur_form">Veuillez saisir l\'adresse ou le quartier où se trouve votre bien</span>';
		if ($_POST['codePostal'] == '')
			$erreurCodePostal = '<br /><span class="erreur_form">Veuillez saisir le code postal de la ville où se trouve votre bien</span>';
		else if (strlen($_POST['codePostal']) != 5 || !(is_numeric($_POST['codePostal'])))
			$erreurCodePostal = '<br /><span class="erreur_form">Le code postal saisi est invalide</span>';
		if ($_POST['ville'] == '')
			$erreurVille = '<br /><span class="erreur_form">Veuillez saisir la ville où se trouve votre bien</span>';
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
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="../../css/index.css">
  <link href="../../css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/estimation.css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
</head>
<body>

	<div id="corps">
		<?php include('../../header.php'); ?>
		
		<?php include('../../nav.php'); ?>
		
		<div id="ensemble">
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			require_once('../../lien_connexion.php');
			?>
			
			<h2>Estimation et mise en vente</h2>
			
			<div class="cadre">
				<?php
				if (!($formEnvoye))
				{
				?>
					<p class="explication">
						Vous souhaitez vendre ou louer votre bien : maison, appartement, terrain, garage, local commercial... Confiez le nous !<br />
						Nous mettrons à votre disposition nos différents moyens de communication et notre savoir-faire afin de répondre au mieux à votre objectif.
					</p>
					
					<form class="form-horizontal" method="post">
						<h4>Votre bien</h4>
						
						<div class="control-group">
							<div class="control-label section_description">Type de bien*</div>
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
							<div class="control-label section_description">Etat du bien*</div>
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
							<div class="control-label section_description">Nombre de pièces*</div>
							<div class="controls">
								<input type="number" min="0" required="required" name="nbPieces" value="<?php echo $nbPieces;?>" />
								<?php echo $erreurNbPieces;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Surface habitable*</div>
							<div class="controls">
								<div class="input-append">
									<input type="text" required="required" name="surface" value="<?php echo $surface;?>" />
									<span class="add-on">m²</span>
								</div>
								<?php echo $erreurSurface;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Adresse / Quartier*</div>
							<div class="controls">
								<input type="text" maxlength="50" required="required" name="adresse" value="<?php echo $adresse;?>" />
								<?php echo $erreurAdresse;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Code postal*</div>
							<div class="controls">
								<input type="text" maxlength="5" required="required" name="codePostal" value="<?php echo $codePostal;?>" pattern="[0-9]{5}" />
								<?php echo $erreurCodePostal;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Ville*</div>
							<div class="controls">
								<input type="text" maxlength="30" required="required" name="ville" value="<?php echo $ville;?>" />
								<?php echo $erreurVille;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Notes / Description</div>
							<div class="controls">
								<textarea rows="5" name="description"><?php echo $description;?></textarea>
							</div>
						</div>
						
						<h4>Vos coordonnées</h4>
						
						<div class="control-group">
							<div class="control-label section_description">Civilité*</div>
							<div class="controls">
								<select name="civilite">
									<option value="1" <?php if ($civilite == 1) echo 'selected="selected"';?>>M.</option>
									<option value="2" <?php if ($civilite == 2) echo 'selected="selected"';?>>Mme</option>
									<option value="3" <?php if ($civilite == 3) echo 'selected="selected"';?>>Mlle</option>
								</select>
								<?php echo $erreurCivilite;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Nom*</div>
							<div class="controls">
								<input type="text" maxlength="30" required="required" name="nom" value="<?php echo $nom;?>" />
								<?php echo $erreurNom;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Prénom*</div>
							<div class="controls">
								<input type="text" maxlength="30" required="required" name="prenom" value="<?php echo $prenom;?>" />
								<?php echo $erreurPrenom;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Téléphone*</div>
							<div class="controls">
								<input type="text" maxlength="25" required="required" name="telephone" value="<?php echo $telephone;?>" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" />
								<?php echo $erreurTelephone;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">E-mail*</div>
							<div class="controls">
								<input type="email" maxlength="50" required="required" name="mail" value="<?php echo $mail;?>" />
								<?php echo $erreurMail;?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Commentaires éventuels</div>
							<div class="controls">
								<textarea rows="5" name="commentaire"><?php echo $commentaire;?></textarea>
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
				<?php
				}
				else
				{
				?>
					<div class="confirm_form_envoye">
						<p>Votre demande a bien été envoyée. Nous vous remercions de la confiance que vous nous accordez</p>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	
	<?php
	require_once('../../modal_connexion.php');
	?>
	
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
</body>
</html>