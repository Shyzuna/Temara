<?php
session_start();

if (isset($_SESSION['compteSupprime']))
{
	session_destroy();

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
			
			<h2>Suppression du compte</h2>
			
			<div class="cadre">
				<p class="confirm_form_envoye">Votre compte a définitivement été supprimé.</p>
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