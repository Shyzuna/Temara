<?php
session_start();
$_SESSION['provenanceDemandeInfos'] = $_SERVER['REQUEST_URI'];

require_once('../../BienTable.class.php');
require_once('../../ConnexionBDD.class.php');
	
$tabVilles = BienTable::getVilles();

$typeAnnonceTab = (isset($_POST['typeAnnonce']) && is_array($_POST['typeAnnonce'])) ? $_POST['typeAnnonce'] : array();
$typeBienTab = (isset($_POST['typeBien']) && is_array($_POST['typeBien'])) ? $_POST['typeBien'] : array();
$prixMin = (isset($_POST['budgetMin']) && is_numeric($_POST['budgetMin'])) ? htmlentities($_POST['budgetMin']) : '';
$prixMax = (isset($_POST['budgetMax']) && is_numeric($_POST['budgetMax'])) ? htmlentities($_POST['budgetMax']) : '';
$surfaceMin = (isset($_POST['surfaceMin']) && is_numeric($_POST['surfaceMin'])) ? htmlentities($_POST['surfaceMin']) : '';
$surfaceMax = (isset($_POST['surfaceMax']) && is_numeric($_POST['surfaceMax'])) ? htmlentities($_POST['surfaceMax']) : '';
$nbPiecesMin = (isset($_POST['nbPiecesMin']) && is_numeric($_POST['nbPiecesMin'])) ? htmlentities($_POST['nbPiecesMin']) : '';
$nbPiecesMax = (isset($_POST['nbPiecesMax']) && is_numeric($_POST['nbPiecesMax'])) ? htmlentities($_POST['nbPiecesMax']) : '';
$ville = (isset($_POST['ville'])) ? htmlentities($_POST['ville']) : '';
$reference = (isset($_POST['reference'])) ? htmlentities($_POST['reference']) : '';

if ($reference == "" && count($_POST) > 0)
{
	if (isset($_GET['investisseur']) && $_GET['investisseur'] == 'true')
		$biensTrouves = BienTable::rechercheBiens($typeAnnonceTab,$typeBienTab,$prixMin,$prixMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,true);
	else
		$biensTrouves = BienTable::rechercheBiens($typeAnnonceTab,$typeBienTab,$prixMin,$prixMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,false);
}
else
{
	$biensTrouves = array();
	$bien = BienTable::getBien($reference);
	if ($bien != null)
		$biensTrouves[] = $bien;
}
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
  <!-- AD Gallery -->
  <link rel="stylesheet" href="../../library/ADGallery/jquery.ad-gallery.css" />
  
  <link rel="stylesheet" href="../../css/index.css" />
  <link rel="stylesheet" href="css/maps.css" />
  <link href="../../css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="../../css/print-bien.css" rel="stylesheet" type="text/css" media="print">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/maps-media-queries.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
</head>
<body onload="init()">
	<div id="corps">
		<?php 
		include('../../header.php');
		include('../../nav.php');
		?>
		
		<div id="ensemble">
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			require_once('../../lien_connexion.php');
			?>
			
			<h2><?php if (isset($_GET['investisseur']) && $_GET['investisseur'] == 'true') echo 'Spécial Investisseurs - ';?>Résultats de la recherche <img class="loader" src="../../images/loader.gif" alt="loader" /></h2>
			
			<div class="cadre">
				<button class="btn btn-small disabled precedent">Précédent</button>
				<button class="btn btn-small disabled suivant">Suivant</button>
				<form>
					<div class="sous_form">
						<div class="control-group">
							<div class="control-label section_description">Type d'annonce :</div>
							<div class="controls">
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('1',$typeAnnonceTab)) echo 'checked="checked"';?> name="typeAnnonce[]" value="1" />Vente
								</div>
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('2',$typeAnnonceTab)) echo 'checked="checked"';?> name="typeAnnonce[]" value="2" />Location
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Type de bien :</div>
							<div class="controls">
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('1',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="1" />Maison
								</div>
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('2',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="2" />Appartement
								</div>
								<br />
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('3',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="3" />Terrain
								</div>
								<div class="checkbox inline">
									<input type="checkbox" <?php if (in_array('4',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="4" />Garage
								</div>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Budget :</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" placeholder="Min" name="budgetMin" value="<?php echo $prixMin;?>" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" placeholder="Max" name="budgetMax" value="<?php echo $prixMax;?>" />
										<span class="add-on">€</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Surface :</div>
						<div class="controls">
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" placeholder="Min" name="surfaceMin" value="<?php echo $surfaceMin;?>" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
							
							<div class="control-group">
								<div class="controls">
									<div class="input-append">
										<input type="text" placeholder="Max" name="surfaceMax" value="<?php echo $surfaceMax;?>" />
										<span class="add-on">m²</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label section_description">Nombre de pièces :</div>
						<div class="controls controls_number">
							<div class="control-group without-input-append">
								<div class="controls">
									<input type="number" min="0" placeholder="Min" name="nbPiecesMin" value="<?php echo $nbPiecesMin;?>" />
								</div>
							</div>
							
							<div class="control-group without-input-append">
								<div class="controls">
									<input type="number" min="0" placeholder="Max" name="nbPiecesMax" value="<?php echo $nbPiecesMax;?>" />
								</div>
							</div>
						</div>
					</div>
					
					<div class="sous_form">
				
						<div class="control-group">
							<div class="control-label section_description">Ville / Code postal :</div>
							<div class="controls">
								<input type="text" name="ville" placeholder="Ville" value="<?php echo $ville;?>" />
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Référence :</div>
							<div class="controls">
								<input type="text" name="reference" placeholder="ex: 14750 MC" value="<?php echo $reference;?>" />
							</div>
						</div>
					
					</div>
					
					<button type="submit" class="btn btn-large">Nouvelle recherche</button>
					
				</form>
			</div>
			
			<div id="map_canvas">
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
	<!-- AD Gallery -->
	<script src="../../library/ADGallery/jquery.ad-gallery-modifie.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	<!-- jQuery PlaceHolder-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="../../library/jquery.placeholder.min.js"></script>
		<script type="text/javascript">$('input').placeholder();</script>
	<![endif]-->
	<!-- Respond.js -->
	<!--[if lt IE 9]><script src="../../library/respond.min.js"></script><![endif]-->
	
	
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
	
	<!-- API Google Maps -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&amp;sensor=false"></script>
	
	<script type="text/javascript">
		var biens = <?php if ($biensTrouves != null) echo json_encode($biensTrouves); else echo 'new Array()';?>;
		var investisseur = <?php if (isset($_GET['investisseur']) && $_GET['investisseur'] == 'true') echo 'true'; else echo 'false';?>;
		var formEnvoye = <?php if (count($_POST) > 0) echo 'true'; else echo 'false';?>;
		
		// Permet d'afficher l'éventuel bien dont l'id est passé dans $_GET['id']
		var idGET = null;
		<?php 
		if (isset($_GET['id']) && is_numeric($_GET['id']))
		{
		?>
			idGET = <?php echo $_GET['id'];?>;
		<?php
		}
		?>
		
		$('.cadre form').submit(function(){return false;});
		
		//Initialise la map avec la ville demandée
		function init()
		{
			chercheCoordonnees(<?php echo '\''.addslashes($ville).'\'';?>,function(coordonnees,zoom,status){
				initMap(coordonnees,zoom,status);
				nouvelleRecherche();
			});
		}
	</script>
	
	<script type="text/javascript" src="js/maps.js"></script>	
	<script type="text/javascript" src="../../js/protection_photos.js"></script>
	<script type="text/javascript" src="js/parcourir_recherches.js"></script>	
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="js/map_size.js"></script>
	<script type="text/javascript" src="../../js/ad-gallery_correctifIE8.js"></script>
	<script type="text/javascript" src="../../js/loader_ajax.js"></script>
	<script type="text/javascript" src="../../js/print-bien.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
	<script type="text/javascript" src="../Compte/js/selection_client.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="../../js/nav_correctifIE8.js"></script><![endif]-->
</body>
</html>