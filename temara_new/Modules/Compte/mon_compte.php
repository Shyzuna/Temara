<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('CompteTable.class.php');

if (!(isset($_SESSION['compte'])))
{

$mail = "";
$erreur = "";

if (isset($_POST['mail']) && isset($_POST['password']))
{
	$mail = htmlentities($_POST['mail']);
	$password = htmlentities($_POST['password']);

	try
	{
		$compte = CompteTable::getCompte($mail,$password);
		$_SESSION['compte'] = serialize($compte);
		header('Location: view_selections.php');
	}
	catch (Exception $ex)
	{
		$erreur = '<br /><span class="erreur_form">'.$ex->getMessage().'</span>';
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
  <link rel="stylesheet" type="text/css" href="css/mon_compte.css">
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
			
			<h2>Mon compte</h2>
			
			<div class="cadre">
				<div class="div_connexion">
					<h4>Se connecter</h4>
					
					<form class="form-horizontal" method="post">
						<div class="control-group">
							<div class="control-label section_description">E-mail*</div>
							<div class="controls">
								<input type="email" name="mail" required value="<?php echo $mail; ?>" />
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Mot de passe*</div>
							<div class="controls">
								<input type="password" name="password" required pattern=".{5,}" /><br />
								<a href="password_perdu.php">J'ai perdu mon mot de passe</a>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn btn-large">Se connecter</button>
								<?php echo $erreur; ?>
							</div>
						</div>
					</form>	
					
				</div>
				
				<div class="div_creation_compte">
					<h4>Créer un compte</h4>
					
					<p class="explication">Vous souhaitez enregistrer vos critères de recherche ?<br />
					Vous aimeriez garder en mémoire les biens qui vous intéressent ?<br /><br />

					Il suffit de vous créer un compte personnel.<br />
					Vous pourrez ensuite le consulter aussi souvent que vous le souhaiterez. 
					</p>
					
					<button class="btn btn-large">S'inscrire</button>
				</div>
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
	
	<script type="text/javascript">
	$('.div_creation_compte button').click(function(){ window.location.href = "creation_compte.php"; });
	</script>
</body>
</html>

<?php
}
else
	header('Location: view_selections.php');