<?php
session_start();

// Permet de rediriger l'utilisateur vers la page précédemment consultée après avoir été sur demande_infos.php
$_SESSION['provenanceDemandeInfos'] = $_SERVER['REQUEST_URI'];

require_once('BienTable.class.php');
require_once('ConnexionBDD.class.php');

$biens = BienTable::obtientNouveautes();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  <!-- jQuery UI -->
  <link rel="stylesheet" href="library/jqueryUI/jquery-ui-1.10.2.custom.min.css" />
  <!-- AD Gallery -->
  <link rel="stylesheet" href="library/ADGallery/jquery.ad-gallery.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="css/index.css">
  <link href="css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="css/form-media-queries.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="css/degradesIE.css">
  <![endif]-->
  
  <link href="css/print-bien.css" rel="stylesheet" media="print">
</head>
<body>
	<div id="corps">
		<?php include('header.php'); ?>
		
		<?php include('nav.php'); ?>
		
		<div id="ensemble">
			<?php include('message_rouge.php'); ?>
			
			<?php
			//require_once('lien_connexion.php');
			?>
			
			<h2>Nos nouveautés <img class="loader" src="images/loader.gif" alt="loader" /></h2>
			
			<!-- display:none pour pouvoir ensuite n'afficher cette partie que si javaScript est activé -->
			<div id="tabs" style="display:none;">
				<ul>
					<li><a href="#tabs-1">Ventes</a></li>
					<li><a href="#tabs-2">Locations</a></li>
				</ul>
			
				<div class="ad-gallery" id="tabs-1">
					<div class="ad-nav">
						<div class="ad-thumbs">
							<ul class="ad-thumb-list">
								<?php
								$nbVentes = 0;
								foreach ($biens as $bien)
								{
									if ($bien->typeAnnonce == '1')
									{
										echo '<li><a>';
										echo $bien->affichePhotoPrincipale();
										echo '</a></li>';
										$nbVentes++;
									}								
								}
								if ($nbVentes == 0)
									echo '<p><strong>Pas de nouveautés</strong></p>';
								?>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="ad-gallery" id="tabs-2">
					<div class="ad-nav">
						<div class="ad-thumbs">
							<ul class="ad-thumb-list">
								<?php
								$nbLocations = 0;
								foreach ($biens as $bien)
								{
									if ($bien->typeAnnonce == '2')
									{
										echo '<li><a>';
										echo $bien->affichePhotoPrincipale();
										echo '</a></li>';
										$nbLocations++;
									}
								}
								
								if ($nbLocations == 0)
									echo '<p><strong>Pas de nouveautés</strong></p>';
								?>
							</ul>
						</div>
					</div>
				</div>
				
			</div>
			
			<div id="selection_bien">
				<?php
				foreach ($biens as $bien)
					echo $bien->html;
				?>
			</div>
		</div>
		
		<?php
			include("foot.php");
		?>
	</div>
	
	
	<?php
	require_once('modal_connexion.php');
	?>
	
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- AD Gallery -->
	<script src="library/ADGallery/jquery.ad-gallery-modifie.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="library/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/afficher_description.js"></script>
	<script type="text/javascript" src="js/protection_photos.js"></script>
	<script type="text/javascript" src="js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="js/ad-gallery_tabs.js"></script>
	<script type="text/javascript" src="js/ad-gallery_correctifIE8.js"></script>
	<script type="text/javascript" src="js/loader_ajax.js"></script>
	<script type="text/javascript" src="js/print-bien.js"></script>
	<script type="text/javascript" src="js/connexion.js"></script>
	<script type="text/javascript" src="Modules/Compte/js/selection_client.js"></script>
	
    <script type="text/javascript">
		$(document).ready(function(){
			// Affichage javaScript
			$("#ensemble #tabs").show();	
			
			// Activation des "tabs" de jQuery UI
			if ('ontouchstart' in document.documentElement)
			{
				$("#tabs").tabs({event: ""});
				$("#tabs > ul > li").each(function(){
					this.addEventListener("touchstart",function(){
						var tabSelect = $(this).attr("aria-controls");
						$('#tabs').tabs("option","active",parseInt(tabSelect.substr(tabSelect.length-1,1))-1);
					});
				})
			}
			else
				$("#tabs").tabs();
			
			// Activation AD Gallery pour les #tabs
			initADGallery();
			corrigeGalleryIE();
		});
		
	</script>
	<!--[if lt IE 9]>
		<script src="library/respond.min.js"></script>
		<script type="text/javascript" src="js/nav_correctifIE8.js"></script>
	<![endif]-->
	
	<?php
	if (isset($_GET['id']) && is_numeric($_GET['id']))
		echo '<script type="text/javascript">afficheDescription('.$_GET['id'].');</script>';
		
	
	?>
</body>
</html>