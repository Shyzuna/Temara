<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('FicheRecherche.class.php');
require_once('FicheRechercheTable.class.php');

if (isset($_SESSION['compte']) && isset($_GET['idFiche']))
{
$compte = unserialize($_SESSION['compte']);
$fiche = FicheRechercheTable::getFiche($_GET['idFiche']);

if ($fiche != null && $compte->mail == $fiche->mailCompte)
{

$formModification = true; // pour ne pas afficher le champ nom dans le formulaire

$erreurPrix = '';
$erreurSurface = '';
$erreurNbPieces = '';

$typeAnnonceTab = $fiche->typeAnnonceTab;
$typeBienTab = $fiche->typeBienTab;
$prixMin = $fiche->budgetMin;
$prixMax = $fiche->budgetMax;
$surfaceMin = $fiche->surfaceMin;
$surfaceMax = $fiche->surfaceMax;
$nbPiecesMin = $fiche->nbPiecesMin;
$nbPiecesMax = $fiche->nbPiecesMax;
$ville = $fiche->ville;
$investisseur = $fiche->investisseur;

// Si le formulaire a été envoyé et si les champs ont bien été remplis, alors on crée la fiche et on redirige l'utilisateur
if (isset($_POST['budgetMin']) && isset($_POST['budgetMax']) && isset($_POST['surfaceMin']) && isset($_POST['surfaceMax'])
	&& isset($_POST['nbPiecesMin']) && isset($_POST['nbPiecesMax']) && isset($_POST['ville']))
{
	$typeAnnonceTab = (isset($_POST['typeAnnonce']) && is_array($_POST['typeAnnonce'])) ? $_POST['typeAnnonce'] : array();
	$typeBienTab = (isset($_POST['typeBien']) && is_array($_POST['typeBien'])) ? $_POST['typeBien'] : array();
	$prixMin = (isset($_POST['budgetMin']) && is_numeric($_POST['budgetMin'])) ? htmlentities($_POST['budgetMin']) : null;
	$prixMax = (isset($_POST['budgetMax']) && is_numeric($_POST['budgetMax'])) ? htmlentities($_POST['budgetMax']) : null;
	$surfaceMin = (isset($_POST['surfaceMin']) && is_numeric($_POST['surfaceMin'])) ? htmlentities($_POST['surfaceMin']) : null;
	$surfaceMax = (isset($_POST['surfaceMax']) && is_numeric($_POST['surfaceMax'])) ? htmlentities($_POST['surfaceMax']) : null;
	$nbPiecesMin = (isset($_POST['nbPiecesMin']) && is_numeric($_POST['nbPiecesMin'])) ? htmlentities($_POST['nbPiecesMin']) : null;
	$nbPiecesMax = (isset($_POST['nbPiecesMax']) && is_numeric($_POST['nbPiecesMax'])) ? htmlentities($_POST['nbPiecesMax']) : null;
	$ville = (isset($_POST['ville'])) ? htmlentities($_POST['ville']) : '';
	$investisseur = (isset($_POST['investisseur'])) ? 1 : 0;

	if (($_POST['budgetMin'] == null || is_numeric($_POST['budgetMin'])) && ($_POST['budgetMax'] == null || is_numeric($_POST['budgetMax'])) && ($_POST['budgetMin'] == null || $_POST['budgetMax'] == null || $_POST['budgetMin'] <= $_POST['budgetMax'])
		&& ($_POST['surfaceMin'] == null || is_numeric($_POST['surfaceMin'])) && ($_POST['surfaceMax'] == null || is_numeric($_POST['surfaceMax'])) && ($_POST['surfaceMin'] == null || $_POST['surfaceMax'] == null || $_POST['surfaceMin'] <= $_POST['surfaceMax'])
		&& ($_POST['nbPiecesMin'] == null || is_numeric($_POST['nbPiecesMin'])) && ($_POST['nbPiecesMax'] == null || is_numeric($_POST['nbPiecesMax'])) && ($_POST['nbPiecesMin'] == null || $_POST['nbPiecesMax'] == null || $_POST['nbPiecesMin'] <= $_POST['nbPiecesMax']))
	{
		FicheRechercheTable::updateFiche($fiche->id,$fiche->nom,$typeAnnonceTab,$typeBienTab,$prixMin,$prixMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$ville,$investisseur);
		$_SESSION['ficheModifiee'] = true;
		header('Location: mes_recherches.php');
	}
	
	// Messages d'erreur
	if (($_POST['budgetMin'] != null && !(is_numeric($_POST['budgetMin'] ))) || ($_POST['budgetMax']  != null && !(is_numeric($_POST['budgetMax'] ))))
		$erreurPrix = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
	else if ($_POST['budgetMin']  != null && $_POST['budgetMax']  != null && ($_POST['budgetMin']  > $_POST['budgetMax'] ))
		$erreurPrix = '<br /><span class="erreur_form">Le budget minimum doit être inférieur au budget maximum</span>';
		
	if (($_POST['surfaceMin']  != null && !(is_numeric($_POST['surfaceMin'] ))) || ($_POST['surfaceMax']  != null && !(is_numeric($_POST['surfaceMax'] ))))
		$erreurSurface = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
	else if ($_POST['surfaceMin']  != null && $_POST['surfaceMax']  != null && ($_POST['surfaceMin'] > $_POST['surfaceMax']))
		$erreurSurface = '<br /><span class="erreur_form">La surface minimum doit être inférieur à la surface maximum</span>';
		
	if (($_POST['nbPiecesMin'] != null && !(is_numeric($_POST['nbPiecesMin']))) || ($_POST['nbPiecesMax'] != null && !(is_numeric($_POST['nbPiecesMax']))))
		$erreurNbPieces = '<br /><span class="erreur_form">Veuillez entrer un nombre</span>';
	else if ($_POST['nbPiecesMin'] != null && $_POST['nbPiecesMax'] != null && ($_POST['nbPiecesMin'] > $_POST['nbPiecesMax']))
		$erreurNbPieces = '<br /><span class="erreur_form">Le nombre de pièces minimum doit être inférieur au nombre de pièces maximum</span>';
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
  <link href="../Recherche/css/recherche.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../../css/form-media-queries.css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="css/nav_compte.css">
  
  <style> a.btn { text-decoration: none; } </style>
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
			
				<h4>Modification de la fiche : "<?php echo $fiche->nom; ?>"</h4>
				
				<?php include('form_fiche_recherche.php'); ?>
				
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
}
else
	header('Location: ../../index.php');