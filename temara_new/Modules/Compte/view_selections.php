<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('CompteTable.class.php');
require_once('SelectionClientTable.class.php');
require_once('../../Bien.class.php');

if (isset($_SESSION['compte']))
{

// Permet de rediriger l'utilisateur vers la page précédemment consultée après avoir été sur demande_infos.php
$_SESSION['provenanceDemandeInfos'] = $_SERVER['REQUEST_URI'];

$compteCree = "";

// Si l'utilisateur vient de créer un compte
if (isset($_SESSION['compteCree']))
{
	$compteCree = '<span class="confirm_form_envoye">Votre compte a été créé avec succès.<br />Un mail contenant vos informations de connexion vous a été envoyé.</span>';
	unset($_SESSION['compteCree']);
}

$compte = unserialize($_SESSION['compte']);
$selections = SelectionClientTable::getSelectionsClient($compte->mail);

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
  <!-- AD Gallery -->
  <link rel="stylesheet" href="../../library/ADGallery/jquery.ad-gallery.css" />
  
  <link rel="stylesheet" type="text/css" href="../../css/index.css">
  <link rel="stylesheet" type="text/css" href="../../css/media-queries.css">
  <link rel="stylesheet" type="text/css" href="../../css/form-media-queries.css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="css/view_selections.css">
  <link rel="stylesheet" type="text/css" href="css/nav_compte.css">
  <link rel="stylesheet" type="text/css" href="../../css/print-bien.css" media="print">
  
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
			
			<h2>Mon compte <img class="loader" src="../../images/loader.gif" alt="loader" /></h2>
			
			<div id="nav_compte">
				<ul class="nav nav-pills">
					<li class="active"><a href="view_selections.php">Ma sélection</a></li>
					<li class="not_active"><a href="mes_recherches.php">Mes fiches de recherches</a></li>
					<li class="not_active"><a href="parametres_compte.php">Mes paramètres</a></li>
				</ul>
			</div>
			
			<div class="cadre">
			
				<?php echo $compteCree; ?>
				
				<h4>Ma sélection</h4>
				
				<p class="explication">
				Un bien vous intéresse ? Vous souhaitez le retrouver facilement ? Pour cela, il vous suffit de cliquer sur l'étoile se situant en bas de
				la description de ce bien afin qu'elle devienne jaune. Tous les biens qui vous intéressent seront ainsi regroupés sur cette page.
				</p>
				
				<?php
				foreach ($selections as $bien)
				{
					echo '<div class="selection" id="selection-'.$bien->id.'">';
					echo $bien->affichePhotoPrincipale();
					echo '<div class="description_selection">';
					echo $bien->titre . '<br />';
					echo $bien->prix . ' €';
					echo '</div>';
					echo '<button class="close" title="Supprimer de la sélection">&times;</button>';
					echo '</div>';
				}
				?>
				
			</div>
				
			<div id="selection_bien">
				<?php
				foreach ($selections as $bien)
					echo $bien->html;
				?>
			</div>
		</div>
		
	</div>
	
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	<!-- AD Gallery -->
	<script type="text/javascript" src="../../library/ADGallery/jquery.ad-gallery-modifie.js"></script>
	
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
	<script type="text/javascript" src="../../js/afficher_description.js"></script>
	<script type="text/javascript" src="../../js/protection_photos.js"></script>
	<script type="text/javascript" src="../../js/print-bien.js"></script>
	<script type="text/javascript" src="../../js/ad-gallery_correctifIE8.js"></script>
	<script type="text/javascript" src="../../js/loader_ajax.js"></script>
	<script type="text/javascript" src="js/selection_client.js"></script>
	<script type="text/javascript" src="js/view_selection.js"></script>
	
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