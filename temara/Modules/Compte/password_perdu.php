<?php
session_start();

require_once('Compte.class.php');
require_once('CompteTable.class.php');
require_once('Password.class.php');
require_once('envoi_mail_password_perdu.php');

if (!(isset($_SESSION['compte'])))
{
	$erreurMail = "";
	$mail = "";
	
	if (isset($_POST['mail']))
	{
		if ($_POST['mail'] != '')
			$mail = htmlentities($_POST['mail']);
		
		if ($_POST['mail'] != '' && strlen($_POST['mail'] <= 50) && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL))
		{
			if (CompteTable::mailExists($mail))
			{
				$password = Password::generatePassword();
				CompteTable::setPassword($mail,$password);
				envoiMailPasswordPerdu($mail,$password);
			}
			else
				$erreurMail = '<br /><span class="erreur_form">Cette adresse n\'est reliée à aucun compte sur ce site.</span>';
		}
		else
		{
			if ($_POST['mail'] == '')
				$erreurMail = '<br /><span class="erreur_form">Veuillez saisir votre adresse mail. Celle-ci sera votre identifiant permettant de vous connecter</span>';
			else if (CompteTable::mailExists($mail))
				$erreurMail = '<br /><span class="erreur_form">Ce mail est déjà utilisé par un autre utilisateur</span>';
			else if (strlen($_POST['mail']) > 50)
				$erreurMail = '<br /><span class="erreur_form">La longueur de votre adresse mail ne doit pas excéder 50 caractères</span>';
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
  
  <!-- jQuery UI -->
  <link rel="stylesheet" href="../../library/jqueryUI/jquery-ui-1.10.2.custom.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" type="text/css" href="../../css/index.css">
  <link rel="stylesheet" type="text/css" href="../../css/media-queries.css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="../../css/indexIE8.css">
  <![endif]-->
  
  <noscript>
	<link rel="stylesheet" type="text/css" href="../../css/indexNoJS.css" />
  </noscript>
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
			
			<h2>Récupération du mot de passe</h2>
			
			<div class="cadre">
				<p class="explication">
					Veuillez indiquer l'adresse e-mail vous servant d'identifiant sur ce site, un mail contenant votre nouveau mot de passe vous sera envoyé.
				</p>
				
				<form class="form-horizontal" method="post">
					<div class="control-group">
						<div class="control-label section_description">E-mail</div>
						<div class="controls">
							<input type="email" maxlength="50" name="mail" required value="<?php echo $mail;?>" />
							<?php echo $erreurMail;?>
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Récupérer mon mot de passe</button>
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
	header('Location: ../../index.php');