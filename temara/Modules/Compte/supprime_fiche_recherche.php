<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('FicheRecherche.class.php');
require_once('FicheRechercheTable.class.php');
require_once('Compte.class.php');


if (isset($_SESSION['compte']) && isset($_POST['idFiche']) && is_numeric($_POST['idFiche']))
{
	$compte = unserialize($_SESSION['compte']);
	$fiche = FicheRechercheTable::getFiche($_POST['idFiche']);
	
	if ($fiche != null && $compte->mail == $fiche->mailCompte)
		FicheRechercheTable::deleteFiche($fiche->id);
	else
		header('Location: ../../index.php');
}
else
	header('Location: ../../index.php');