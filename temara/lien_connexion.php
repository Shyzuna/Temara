<?php
require_once(realpath(__DIR__.'/Modules/Compte/Compte.class.php'));

if (!(isset($_SESSION['compte'])))
	echo '<button class="btn btn-success connexion" data-toggle="modal" href="#modal">Se connecter</button>';
else
	echo '<button class="btn btn-danger deconnexion">Déconnexion</button>';
	
if (isset($_SESSION['compte']) && unserialize($_SESSION['compte'])->levelUser == 1)
	echo '<a href="http://localhost:8080/temara/Modules/ConsultationDemandes/consult_demandes_infos.php">Administration</a>';
?>