<?php
session_start();
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
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  <style>
  .control-group.success .control-label { opacity: 1;}
  </style>
</head>
<body>

	<div id="corps">
		<?php include('../../header.php'); ?>
		
		<?php include('../../nav.php'); ?>
		
		<div id="ensemble">
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			//require_once('../../lien_connexion.php');
			?>
			
			<h2>Calcul du financement</h2>
			
			<div class="cadre">
				<form class="form-horizontal" name="form_calcul">
					<p class="explication">Renseignez les champs suivants :</p>
					<div class="control-group">
					    <!--[if lte IE 8]>
						<label class="control-label section_description">Durée de l'emprunt (en années)</label>
					    <![endif]-->  
						
					    <!--[if (!IE) | (gte IE 9)]><!-->
						<div class="control-label section_description">Durée de l'emprunt</div>
					    <!--<![endif]-->
						
						<div class="controls">
							<input type="text" name="duree" placeholder="Nombre d'années" />
						</div>
					</div>
					<div class="control-group">
						<div class="control-label section_description">Taux d'intérêt annuel</div>
						<div class="controls">
							<input type="text" name="taux" placeholder="ex: 2.41"/>
						</div>
					</div>
					
					<p class="explication">Laissez vide le champ que vous souhaitez calculer, et remplissez l'autre :</p>
					<div class="control-group">
						<div class="control-label section_description">Montant de l'emprunt</div>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="montant" />
								<span class="add-on">€</span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label section_description">Remboursement mensuel</div>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="mensualite" />
								<span class="add-on">€</span>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-large disabled">Calculer</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>
		
	<?php
		include("../../foot.php");
	?>	
	</div>
	
	<?php
	// require_once('../../modal_connexion.php');
	?>
	
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	<!-- jQuery PlaceHolder-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="../../library/jquery.placeholder.min.js"></script>
		<script type="text/javascript">$('input').placeholder();</script>
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
	
	<script type="text/javascript" src="js/calcul_financement.js"></script>
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<!--<script type="text/javascript" src="../../js/connexion.js"></script>-->
	<script type="text/javascript" src="../../library/jquery.placeholder.min.js"></script>
	<script type="text/javascript">
		$('form').submit(function(){return false;});
	</script>
</body>
</html>