<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('CompteTable.class.php');
require_once('envoi_mail_creation_compte.php');

if (!(isset($_SESSION['compte'])))
{

$erreurMail = "";
$erreurPassword = "";
$erreurCivilite = "";
$erreurCodePostal = "";
$erreurTelephone = "";

$mail = "";
$civilite = "";
$nom = "";
$prenom = "";
$adresse = "";
$codePostal = "";
$ville = "";
$telephone = "";

/*
* Vérification et enregistrement des données du formulaire
*/
if (isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['civilite']) && isset($_POST['nom']) 
	&& isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['codePostal']) && isset($_POST['ville']) && isset($_POST['telephone']))
{
	if ($_POST['mail'] != '')
		$mail = htmlentities($_POST['mail']);
	if ($_POST['nom'] != '')
		$nom = htmlentities($_POST['nom']);
	if ($_POST['prenom'] != '')
		$prenom = htmlentities($_POST['prenom']);
	if ($_POST['adresse'] != '')
		$adresse = htmlentities($_POST['adresse']);
	if ($_POST['codePostal'] != '')
		$codePostal = htmlentities($_POST['codePostal']);
	if ($_POST['ville'] != '')
		$ville = htmlentities($_POST['ville']);
	if ($_POST['telephone'] != '')
		$telephone = htmlentities($_POST['telephone']);
	if ($_POST['password'] != '')
		$password = htmlentities($_POST['password']);
			
	// Si les champs sont bien remplis, création du compte, création d'une variable de session contenant le compte et envoi d'un mail
	if ($_POST['mail'] != '' && strlen($_POST['mail'] <= 50) && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) && (strlen($_POST['password']) >= 5) && ($_POST['password'] == $_POST['password_confirm']) 
		&& ($_POST['civilite'] >= 0 && $_POST['civilite'] <= 3) && ($_POST['telephone'] == "" ^ preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)) 
		&& ($_POST['codePostal'] == '' || strlen($_POST['codePostal']) == 5) && ($_POST['codePostal'] == "" ^ is_numeric($_POST['codePostal'])))
	{	
		try
		{
			$compte = CompteTable::addCompte($mail,$password,0,$_POST['civilite'],$nom,$prenom,$adresse,$codePostal,$ville,$telephone);
			$_SESSION['compte'] = serialize($compte);
			envoiMailCreationCompte($mail,$password);
			
			$_SESSION['compteCree'] = true;
			header('Location: view_selections.php');
		}
		catch (Exception $ex)
		{
			$erreurMail = '<br /><span class="erreur_form">'.$ex->getMessage().'</span>';
		}
	}
	else
	{
		// Messages d'erreur
		if (strlen($_POST['password']) < 5)
			$erreurPassword = '<br /><span class="erreur_form">Votre mot de passe doit contenir au moins 5 caractères</span>';
		else if ($_POST['password'] != $_POST['password_confirm'])
			$erreurPassword = '<br /><span class="erreur_form">Les mots de passe entrés ne sont pas identiques</span>';
		if ($_POST['civilite'] < 0 || $_POST['civilite'] > 3)
			$erreurCivilite = '<br /><span class="erreur_form">Veuillez choisir une civilité</span>';
		if ($_POST['mail'] == '')
			$erreurMail = '<br /><span class="erreur_form">Veuillez saisir votre adresse mail. Celle-ci sera votre identifiant permettant de vous connecter</span>';
		else if (CompteTable::mailExists($mail))
			$erreurMail = '<br /><span class="erreur_form">Ce mail est déjà utilisé par un autre utilisateur</span>';
		else if (strlen($_POST['mail']) > 50)
			$erreurMail = '<br /><span class="erreur_form">La longueur de votre adresse mail ne doit pas excéder 50 caractères</span>';
		else if (!(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)))
			$erreurMail = '<br /><span class="erreur_form">L\'adresse mail saisie est invalide</span>';
		if ($_POST['telephone'] != "" && !(preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)))
			$erreurTelephone = '<br /><span class="erreur_form">Veuillez saisir un numéro de téléphone valide</span>';
		if ((strlen($_POST['codePostal']) != 0 && strlen($_POST['codePostal']) != 5) || ($_POST['codePostal'] != "" && !(is_numeric($_POST['codePostal']))))
			$erreurCodePostal = '<br /><span class="erreur_form">Veuillez saisir un code postal valide</span>';
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
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  
  <style>
	h4
	{
		font-size: 1.3em;
		font-weight: bold;
		font-family: Verdana;
		color: rgb(71, 122, 94);
	}
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
			
			<h2>Création de compte</h2>
			
			<div class="cadre">
				
				<form class="form-horizontal" method="post">
				
					<h4>Vos identifiants</h4>
					
					<div class="control-group">
						<div class="control-label section_description">E-mail*</div>
						<div class="controls">
							<input type="email" maxlength="50" name="mail" required value="<?php echo $mail;?>" />
							<?php echo $erreurMail;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Mot de passe*</div>
						<div class="controls">
							<input type="password" name="password" required pattern=".{5,}" />
							<?php echo $erreurPassword;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Confirmez votre mot de passe*</div>
						<div class="controls">
							<input type="password" name="password_confirm" required pattern=".{5,}" />
						</div>
					</div>
					
					<h4>Vos informations personnelles</h4>
					
					<div class="control-group">
						<div class="control-label section_description">Civilité</div>
						<div class="controls">
							<select required="required" name="civilite">
								<option value="0" <?php if (isset($_POST['civilite']) && $_POST['civilite'] == 0) echo 'selected="selected"';?>></option>
								<option value="1" <?php if (isset($_POST['civilite']) && $_POST['civilite'] == 1) echo 'selected="selected"';?>>M.</option>
								<option value="2" <?php if (isset($_POST['civilite']) && $_POST['civilite'] == 2) echo 'selected="selected"';?>>Mme</option>
								<option value="3" <?php if (isset($_POST['civilite']) && $_POST['civilite'] == 3) echo 'selected="selected"';?>>Mlle</option>
							</select>
							<?php echo $erreurCivilite;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nom</div>
						<div class="controls">
							<input type="text" maxlength="30" name="nom" value="<?php echo $nom;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Prénom</div>
						<div class="controls">
							<input type="text" maxlength="30" name="prenom" value="<?php echo $prenom;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Adresse</div>
						<div class="controls">
							<input type="text" name="adresse" value="<?php echo $adresse;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Code postal</div>
						<div class="controls">
							<input type="text" maxlength="5" name="codePostal" value="<?php echo $codePostal;?>" pattern="[0-9]{5}" />
							<?php echo $erreurCodePostal; ?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Ville</div>
						<div class="controls">
							<input type="text" maxlength="30" name="ville" value="<?php echo $ville;?>" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Téléphone</div>
						<div class="controls">
							<input type="text" maxlength="25" name="telephone" value="<?php echo $telephone;?>" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" />
							<?php echo $erreurTelephone; ?>
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
	
	<?php
	require_once('../../modal_connexion.php');
	?>
	
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
	header('Location: mon_compte.php');