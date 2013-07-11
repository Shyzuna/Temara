<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('FicheRecherche.class.php');
require_once('FicheRechercheTable.class.php');

if (isset($_SESSION['compte']))
{

$compte = unserialize($_SESSION['compte']);
$fiches = FicheRechercheTable::getFichesUser($compte->mail);

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
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="css/nav_compte.css">
  <link rel="stylesheet" type="text/css" href="css/mes_recherches.css">
  
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
					<li class="not_active"><a href="view_selections.php">Ma sélection</a></li>
					<li class="active"><a href="mes_recherches.php">Mes fiches de recherches</a></li>
					<li class="not_active"><a href="parametres_compte.php">Mes paramètres</a></li>
				</ul>
			</div>
			
			<div class="cadre">
			
				<?php
				if (isset($_SESSION['ficheCree']))
				{
					echo '<span class="confirm_form_envoye">Votre fiche a été créée avec succès</span>';
					unset($_SESSION['ficheCree']);
				}
				else if (isset($_SESSION['ficheModifiee']))
				{
					echo '<span class="confirm_form_envoye">La fiche a été modifiée avec succès</span>';
					unset($_SESSION['ficheModifiee']);
				}
				?>
			
				<h4>Mes fiches de recherches</h4>
				
				<p class="explication">
					Les fiches de recherches vous permettent de sauvegarder vos critères de recherches, et ainsi de pouvoir les réaliser plus rapidement.	
				</p>
				
				
				<?php
				foreach ($fiches as $fiche)
				{
					echo '<div class="fiche" id="fiche-'.$fiche->id.'">'; 
					
					echo '<h5>'.$fiche->nom.'</h5>';
					
					$i = 0;
					foreach ($fiche->typeAnnonceTab as $type)
					{
						if ($i > 0)
							echo ', ';
						else
							$i++;
						switch ($type)
						{
							case 1:
								echo 'Vente';
								break;
							case 2:
								echo 'Location';
								break;
						}
					}
					if ($i > 0)
						echo '<br />';
						
					$i = 0;
					foreach ($fiche->typeBienTab as $type)
					{
						if ($i > 0)
							echo ', ';
						else
							$i++;
						switch ($type)
						{
							case 1:
								echo 'Maison';
								break;
							case 2:
								echo 'Appartement';
								break;
							case 3:
								echo 'Terrain';
								break;
							case 4:
								echo 'Garage';
								break;
						}
					}
					if ($i > 0)
						echo '<br />';
					
					if ($fiche->budgetMin != null && $fiche->budgetMax != null)
						echo 'Entre '.$fiche->budgetMin.' € et '.$fiche->budgetMax.' €';
					else if ($fiche->budgetMin != null )
						echo '> '.$fiche->budgetMin.' €';
					else if ($fiche->budgetMax != null)
						echo '< '.$fiche->budgetMax.' €';
					if ($fiche->budgetMin != null || $fiche->budgetMax != null)
						echo '<br />';
					
					if ($fiche->surfaceMin != null && $fiche->surfaceMax != null)
						echo 'Entre '.$fiche->surfaceMin.' m² et '.$fiche->surfaceMax.' m²';
					else if ($fiche->surfaceMin != null)
						echo '> '.$fiche->surfaceMin.' m²';
					else if ($fiche->surfaceMax != null)
						echo '< '.$fiche->surfaceMax.' m²';
					if ($fiche->surfaceMin != null || $fiche->surfaceMax != null)
						echo '<br />';
					
					if ($fiche->nbPiecesMin != null && $fiche->nbPiecesMax != null)
						echo 'Entre '.$fiche->nbPiecesMin.' et '.$fiche->nbPiecesMax.' pièces';
					else if ($fiche->nbPiecesMin != null)
						echo '+ de '.$fiche->nbPiecesMin.' pièces';
					else if ($fiche->nbPiecesMax != null)
						echo '- de '.$fiche->nbPiecesMax.' pièces';
					if ($fiche->nbPiecesMin != null || $fiche->nbPiecesMax != null)
						echo '<br />';
					
					if ($fiche->ville != null)
						echo $fiche->ville;
						
					if ($fiche->investisseur != null && $fiche->investisseur == 1)
						echo 'Investisseur';
					
					echo '<div class="acions_fiche">';
					
					if ($fiche->investisseur != null && $fiche->investisseur == 1)
						echo '<form method="post" action="../Recherche/maps.php?investisseur=true">';
					else
						echo '<form method="post" action="../Recherche/maps.php">';
					foreach ($fiche->typeAnnonceTab as $type)
						echo '<input type="hidden" name="typeAnnonce[]" value="'.$type.'" />';
					foreach ($fiche->typeBienTab as $type)
						echo '<input type="hidden" name="typeBien[]" value="'.$type.'" />';
					echo '<input type="hidden" name="budgetMin" value="'.$fiche->budgetMin.'" />';
					echo '<input type="hidden" name="budgetMax" value="'.$fiche->budgetMax.'" />';
					echo '<input type="hidden" name="surfaceMin" value="'.$fiche->surfaceMin.'" />';
					echo '<input type="hidden" name="surfaceMax" value="'.$fiche->surfaceMax.'" />';
					echo '<input type="hidden" name="nbPiecesMin" value="'.$fiche->nbPiecesMin.'" />';
					echo '<input type="hidden" name="nbPiecesMax" value="'.$fiche->nbPiecesMax.'" />';
					echo '<input type="hidden" name="ville" value="'.$fiche->ville.'" />';
					echo '<input type="hidden" name="reference" value="" />';
					echo '<input type="image" src="../../images/loupe.png" title="Lancer la recherche" alt="Lancer la recherche" />';
					echo '</form>';
					
					echo '<a href="modifier_fiche_recherche.php?idFiche='.$fiche->id.'"><img src="../../images/modifier_form.png" alt="Modifier la fiche" title="Modifier la fiche" /></a>';
					
					echo '<img src="../../images/croix.png" class="delete-fiche" alt="Supprimer la fiche" title="Supprimer la fiche" />';
					
					echo '</div>';
					
					echo '</div>';
				}
				?>
				
				<p><a href="creer_fiche_recherche.php" class="btn btn-large">Nouvelle fiche</a></p>
				
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
	<script type="text/javascript" src="../../js/loader_ajax.js"></script>
	<script type="text/javascript" src="js/mes_recherches.js"></script>
	
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