<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('../Contact/Contact.class.php');
require_once('../Contact/ContactTable.class.php');
require_once('../Compte/Compte.class.php');
	
header('Content-type: text/HTML; charset=UTF-8');
	
if (isset($_SESSION['compte']) && unserialize($_SESSION['compte'])->levelUser == 1)
{
	/*
	* Supprime les demandes de contact de la BDD dont les id sont présents dans $_POST['idDemandesTab']
	*/

	if (isset($_POST['idDemandesTab']) && is_array($_POST['idDemandesTab']))
		ContactTable::deleteContacts($_POST['idDemandesTab']);
}
else
	header('Location: ../../index.php');
?>