<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('CompteTable.class.php');

if (isset($_SESSION['compte']))
{

$compte = unserialize($_SESSION['compte']);

$messageSucces = "";
$messageErreur = "";

$erreurCivilite = "";
$erreurCodePostal = "";
$erreurTelephone = "";
$erreurOldPassword = "";
$erreurNewPassword = "";
$erreurPassword = "";

if (isset($_POST['civilite']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['codePostal']) && isset($_POST['ville']) && isset($_POST['telephone']))
{
	/*
	* Modifications de données du profil
	*/
	
	if ($_POST['civilite'] >= 0 && $_POST['civilite'] <= 3)
		$compte->civilite = $_POST['civilite'];
	else
		$erreurCivilite = '<br /><span class="erreur_form">Veuillez choisir une civilité</span>';
	$compte->nom = htmlentities($_POST['nom']);
	$compte->prenom = htmlentities($_POST['prenom']);
	$compte->adresse = htmlentities($_POST['adresse']);
	if (($_POST['codePostal'] == '' || strlen($_POST['codePostal']) == 5) && ($_POST['codePostal'] == "" ^ is_numeric($_POST['codePostal'])))
		$compte->codePostal = htmlentities($_POST['codePostal']);
	else
		$erreurCodePostal = '<br /><span class="erreur_form">Veuillez saisir un code postal valide</span>';
	$compte->ville = htmlentities($_POST['ville']);
	if ($_POST['telephone'] == '' || preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$_POST['telephone']))
		$compte->telephone = htmlentities($_POST['telephone']);
	else
		$erreurTelephone = '<br /><span class="erreur_form">Veuillez saisir un numéro de téléphone valide</span>';
	
	// Mis à jour du compte et de la variable de session associée
	CompteTable::updateCompte($compte->mail,$compte->civilite,$compte->nom,$compte->prenom,$compte->adresse,$compte->codePostal,$compte->ville,$compte->telephone);
	$_SESSION['compte'] = serialize($compte);
	
	if ($erreurCivilite == "" && $erreurCodePostal == "" && $erreurTelephone == "")
		$messageSucces = '<span class="confirm_form_envoye">Vos modifications ont bien été pris en compte</span>';
	else
		$messageErreur = '<span class="confirm_form_envoye erreur">Un des champs n\'a pas été correctement rempli</span>';
}
else if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_confirm']))
{
	/*
	* Changement de mot de passe
	*/
	
	if (CompteTable::verifyPassword($compte->mail,$_POST['old_password']))
	{
		if (strlen($_POST['new_password']) >= 5 && $_POST['new_password'] == $_POST['new_password_confirm'])
		{
			CompteTable::setPassword($compte->mail,$_POST['new_password']);
			$messageSucces = '<span class="confirm_form_envoye">Votre mot de passe a bien été modifié</span>';
		}
		else
		{
			$messageErreur = '<span class="confirm_form_envoye erreur">Un des champs n\'a pas été correctement rempli</span>';
			if (strlen($_POST['new_password']) < 5)
				$erreurNewPassword = '<br /><span class="erreur_form">Votre mot de passe doit contenir au moins 5 caractères</span>';
			else if ($_POST['new_password'] != $_POST['new_password_confirm'])
				$erreurNewPassword = '<br /><span class="erreur_form">Les mots de passe entrés ne sont pas identiques</span>';
		}
	}
	else
	{
		$erreurOldPassword = '<br /><span class="erreur_form">Mot de passe incorrect</span>';
		$messageErreur = '<span class="confirm_form_envoye erreur">Un des champs n\'a pas été correctement rempli</span>';
	}
}
else if (isset($_POST['password']))
{
	/*
	* Suppression du compte
	*/
	
	if (CompteTable::verifyPassword($compte->mail,$_POST['password']))
	{
		CompteTable::deleteCompte($compte->mail);
		unset($_SESSION['compte']);
		$_SESSION['compteSupprime'] = true;
		header('Location: compte_supprime.php');
	}
	else
	{
		$erreurPassword = '<br /><span class="erreur_form">Mot de passe incorrect</span>';
		$messageErreur = '<span class="confirm_form_envoye erreur">Un des champs n\'a pas été correctement rempli</span>';	
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  
  <!-- jQuery UI -->
  <link rel="stylesheet" href="../../library/jqueryUI/jquery-ui-1.10.2.custom.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" type="text/css" href="../../css/index.css">
  <link rel="stylesheet" type="text/css" href="../../css/media-queries.css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/nav_compte.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  
  <style>
  .confirm_form_envoye.erreur { color: red; }
  </style>
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
			
			<h2>Mon compte</h2>
			
			<div id="nav_compte">
				<ul class="nav nav-pills">
					<li class="not_active"><a href="view_selections.php">Ma sélection</a></li>
					<li class="not_active"><a href="mes_recherches.php">Mes fiches de recherches</a></li>
					<li class="active"><a href="parametres_compte.php">Mes paramètres</a></li>
				</ul>
			</div>
			
			<div class="cadre">
				
				<?php echo $messageSucces; ?>
				<?php echo $messageErreur; ?>
				
				<h4>Modifier mon profil</h4>
				
				<form class="form-horizontal" method="post">
				
					<div class="control-group">
						<div class="control-label section_description">Civilité</div>
						<div class="controls">
							<select name="civilite">
								<option value="0" <?php if ($compte->civilite == 0) echo 'selected="selected"';?>></option>
								<option value="1" <?php if ($compte->civilite == 1) echo 'selected="selected"';?>>M.</option>
								<option value="2" <?php if ($compte->civilite == 2) echo 'selected="selected"';?>>Mme</option>
								<option value="3" <?php if ($compte->civilite == 3) echo 'selected="selected"';?>>Mlle</option>
							</select>
							<?php echo $erreurCivilite;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nom</div>
						<div class="controls">
							<input type="text" maxlength="30" name="nom" value="<?php echo $compte->nom;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Prénom</div>
						<div class="controls">
							<input type="text" maxlength="30" name="prenom" value="<?php echo $compte->prenom;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Adresse</div>
						<div class="controls">
							<input type="text" name="adresse" value="<?php echo $compte->adresse;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Code postal</div>
						<div class="controls">
							<input type="text" maxlength="5" name="codePostal" value="<?php echo $compte->codePostal;?>" pattern="[0-9]{5}" />
							<?php echo $erreurCodePostal; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Ville</div>
						<div class="controls">
							<input type="text" maxlength="30" name="ville" value="<?php echo $compte->ville;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Téléphone</div>
						<div class="controls">
							<input type="text" maxlength="25" name="telephone" value="<?php echo $compte->telephone;?>" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" />
							<?php echo $erreurTelephone; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Envoyer</button>
						</div>
					</div>
				</form>
				
				<h4>Changer mon mot de passe</h4>
				
				<form class="form-horizontal" method="post">
				
					<div class="control-group">
						<div class="control-label section_description">Ancien mot de passe</div>
						<div class="controls">
							<input type="password" name="old_password" required pattern=".{5,}" />
							<?php echo $erreurOldPassword; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nouveau mot de passe</div>
						<div class="controls">
							<input type="password" name="new_password" required pattern=".{5,}" />
							<?php echo $erreurNewPassword; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Confirmez votre nouveau mot de passe</div>
						<div class="controls">
							<input type="password" name="new_password_confirm" required pattern=".{5,}" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Envoyer</button>
						</div>
					</div>
				</form>
				
				<h4>Supprimer mon compte</h4>
				
				<form class="form-horizontal" method="post">
				
					<div class="control-group">
						<div class="control-label section_description">Mot de passe</div>
						<div class="controls">
							<input type="password" name="password" required pattern=".{5,}" />
							<?php echo $erreurPassword; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Supprimer définitivement mon compte</button>
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
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
</body>
</html>

<?php
}
else
	header('Location: ../../index.php');