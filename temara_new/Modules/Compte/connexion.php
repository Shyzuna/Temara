<?php
session_start();

header('Content-type: text/HTML; charset=UTF-8');

require_once('../../ConnexionBDD.class.php');
require_once('Compte.class.php');
require_once('CompteTable.class.php');

/*
* Crée un objet Compte stocké dans une variable de session si les identifiants passés par la méthode POST sont corrects, sinon envoie un message d'erreur.
*/

if (isset($_POST['mail']) && isset($_POST['password']))
{
	$mail = htmlentities($_POST['mail']);
	$password = htmlentities($_POST['password']);

	try
	{
		$compte = CompteTable::getCompte($mail,$password);
		$_SESSION['compte'] = serialize($compte);
	}
	catch (Exception $ex)
	{
		echo $ex->getMessage();
	}
}

?>