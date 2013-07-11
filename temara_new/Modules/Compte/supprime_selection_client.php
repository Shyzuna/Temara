<?php
if (!(isset($_SESSION)))
	session_start();

require_once(realpath(__DIR__.'/SelectionClientTable.class.php'));

header('Content-type:text/HTML;charset=UTF-8');

// Supprime la sélection dont l'id du bien concerné ont été envoyés par la méthode POST de la sélection du client. 
// Enregistre les modifications dans la BDD et dans la variable de session du compte.
if (isset($_SESSION['compte']) && isset($_POST['id']))
{
	$compte = unserialize($_SESSION['compte']);
	SelectionClientTable::deleteSelection($compte->mail,$_POST['id']);
	$compte->deleteIdSelection($_POST['id']);
	$_SESSION['compte'] = serialize($compte);
}
else
	header('Location: ../../index.php');

?>