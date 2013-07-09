<?php
if (!(isset($_SESSION)))
	session_start();

require_once(__DIR__.'/SelectionClientTable.class.php');

header('Content-type:text/HTML;charset=UTF-8');

// Ajoute le bien dont l'id a été envoyée par la méthode POST à la sélection du client. L'enregistre dans la BDD et dans la variable de session du compte
if (isset($_SESSION['compte']) && isset($_POST['id']) && is_numeric($_POST['id']))
{
	$compte = unserialize($_SESSION['compte']);
	SelectionClientTable::addSelection($compte->mail,$_POST['id']);
	$compte->addIdSelection($_POST['id']);
	$_SESSION['compte'] = serialize($compte);
}

?>