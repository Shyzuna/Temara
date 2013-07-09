<?php

// Envoie un mail de rappel des identifiants passés en paramètres
function envoiMailPasswordPerdu ($mail,$password)
{
	$objet = "Récupération d'un nouveau mot de passe";
	$message = 'Bonjour,<br />
				Vos nouveaux identifiants sur notre site http://localhost:8080/temara sont les suivants :<br /><br />
				E-mail : '.$mail.'<br />
				Mot de passe : '.$password.'<br /><br />
				Le service d\'alerte email';
				
	$headers = "MIME-Version: 1.0 \n";
	$headers .= "Content-type: text/html; charset=utf-8 \n";
	$headers .= "X-Mailer: PHP\n";
				
	ini_set('sendmail_from','agence-temara@test.fr');
	
	mail($mail,$objet,$message,$headers);
}

?>