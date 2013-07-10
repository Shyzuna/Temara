<?php
header('Content-type: text/HTML; charset=UTF-8');

require_once('ConnexionBDD.class.php');
require_once('LieuTable.class.php');

$adresse = LieuTable::getCoordonnees($_POST['adresse']);

if ($adresse != null)
	echo $adresse;
else
	echo "null";
?>