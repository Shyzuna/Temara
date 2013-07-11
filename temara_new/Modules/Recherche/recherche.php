<?php
session_start();

require_once('../../BienTable.class.php');
require_once('../../ConnexionBDD.class.php');
	
$tabVilles = BienTable::getVilles();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>TEMARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <!-- jQuery UI -->
  <link rel="stylesheet" href="../../library/jqueryUI/jquery-ui-1.10.2.custom.min.css" />
  
  <link rel="stylesheet" href="../../css/index.css" />
  <link href="../../css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/recherche.css" rel="stylesheet" type="text/css">
  <link href="css/recherche-media-queries.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
</head>
<body>
	<div id="corps">
		<?php 
		include('../../header.php');
		include('../../nav.php');
		?>
		
		<div id="ensemble">
		
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			//require_once('../../lien_connexion.php');
			?>
			
			<h2><?php if (isset($_GET['investisseur']) && $_GET['investisseur'] == 'true') echo 'Spécial Investisseurs - ';?>Recherche d'un bien</h2>
			
			<div class="cadre">
				<form method="post" class="form-horizontal" action="maps.php<?php if (isset($_GET['investisseur']) && $_GET['investisseur'] == 'true') echo '?investisseur=true';?>">
					
					<div class="control-group">
						<div class="control-label section_description">Type d'annonce</div>
						<div class="controls">
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeAnnonce[]" value="1" />Vente
							</div>
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeAnnonce[]" value="2" />Location
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Type de bien</div>
						<div class="controls">
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeBien[]" value="1" />Maison
							</div>
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeBien[]" value="2" />Appartement
							</div>
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeBien[]" value="3" />Terrain
							</div>
							<div class="checkbox inline">
								<input type="checkbox" checked="checked" name="typeBien[]" value="4" />Garage
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Budget</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="budgetMin" placeholder="Min" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="budgetMax" placeHolder="Max" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Surface</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="surfaceMin" placeholder="Min" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" name="surfaceMax" placeholder="Max" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nombre de pièces</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<input type="number" min="0" name="nbPiecesMin" placeholder="Min" />
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<input type="number" min="0" name="nbPiecesMax" placeholder="Max" />
								</div>
							</div>
						</div>
					</div>
				
					<div class="control-group">
						<div class="control-label section_description">Ville / Code postal</div>
						<div class="controls">
							<input type="text" placeholder="Ville" name="ville" class="not-input-append" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Référence</div>
						<div class="controls">
							<input type="text" name="reference" placeholder="ex: 14750 MC" class="not-input-append" />
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large">Rechercher</button>
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
	<!-- jQuery PlaceHolder-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="../../library/jquery.placeholder.min.js"></script>
		<script type="text/javascript">$('input').placeholder();</script>
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		// Permet l'auto-complétion
		var tabVilles = <?php echo json_encode($tabVilles); ?>;
		$('input[name="ville"]').autocomplete({
			source: tabVilles,
			autoFocus: true,
			delay: 100
		});
		$(window).resize(function(){$('input[name="ville"]').autocomplete("close");});
	</script>
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
</body>
</html>