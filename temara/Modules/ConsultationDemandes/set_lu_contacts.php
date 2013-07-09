<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('../Contact/ContactTable.class.php');
require_once('../Compte/Compte.class.php');

header('Content-type: text/HTML; charset=UTF-8');

if (isset($_SESSION['compte']) && unserialize($_SESSION['compte'])->levelUser == 1)
{
	/*
	* Met le champ 'lu' à 0 ou 1 des demandes de contact dont les id ont été précisés
	*/

	if (isset($_POST['idTab']) && isset($_POST['lu']) && is_array($_POST['idTab']) && is_numeric($_POST['lu']) && ($_POST['lu'] == 0 || $_POST['lu'] == 1))
		ContactTable::setLu($_POST['idTab'],$_POST['lu']);

}
else
	header('Location: ../../index.php');
?>