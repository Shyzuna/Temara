<?php
header('Content-type: text/HTML; charset=UTF-8');

require_once('../../ConnexionBDD.class.php');
require_once('LieuTable.class.php');

if (isset($_POST['adresse']) && isset($_POST['coordonnees']))
	LieuTable::addCoordonnees($_POST['adresse'],$_POST['coordonnees']);
?>