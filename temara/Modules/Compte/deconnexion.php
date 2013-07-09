<?php
session_start();

header('Content-type: text/HTML; charset=UTF-8');

/*
* Détruit les variables de session de l'utilisateur et le renvoie à la page d'accueil
*/

session_destroy();
header('Location: ../../index.php');

?>