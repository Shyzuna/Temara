<?php
header('Content-type: text/HTML; charset=UTF-8');

require_once('ConnexionBDD.class.php');
require_once('.BienTable.class.php');
require_once('Bien.class.php');

$typeAnnonceTab = (isset($_POST['typeAnnonce']) && is_array($_POST['typeAnnonce'])) ? $_POST['typeAnnonce'] : array();
$typeBienTab = (isset($_POST['typeBien']) && is_array($_POST['typeBien'])) ? $_POST['typeBien'] : array();
$prixMin = (isset($_POST['budgetMin']) && is_numeric($_POST['budgetMin'])) ? $_POST['budgetMin'] : '';
$prixMax = (isset($_POST['budgetMax']) && is_numeric($_POST['budgetMax'])) ? $_POST['budgetMax'] : '';
$surfaceMin = (isset($_POST['surfaceMin']) && is_numeric($_POST['surfaceMin'])) ? $_POST['surfaceMin'] : '';
$surfaceMax = (isset($_POST['surfaceMax']) && is_numeric($_POST['surfaceMax'])) ? $_POST['surfaceMax'] : '';
$nbPiecesMin = (isset($_POST['nbPiecesMin']) && is_numeric($_POST['nbPiecesMin'])) ? $_POST['nbPiecesMin'] : '';
$nbPiecesMax = (isset($_POST['nbPiecesMax']) && is_numeric($_POST['nbPiecesMax'])) ? $_POST['nbPiecesMax'] : '';
$reference = (isset($_POST['reference'])) ? $_POST['reference'] : '';

if ($reference == "")
{
	if (isset($_POST['investisseur']) && $_POST['investisseur'] == 'true')
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

echo json_encode($biensTrouves);

?>