<?php

// Envoie un mail de demande d'activation de compte au destinataire dont l'adresse mail est passée en paramètre
function envoiMailCreationCompte ($mail,$password)
{
	$objet = "Création de compte sur www.agence-temara.com";
	$message = 'Bonjour,<br /><br />
				Vous avez créé un compte sur notre site http://localhost:8080/temara .<br />
				Vos identifiants sont les suivants :<br /><br />
				E-mail : '.$mail.'<br />
				Mot de passe : '.$password.'<br /><br />
				Nous vous remercions de la confiance que vous nous accordez.<br /><br />
				Le service d\'alerte email';
	
	$headers = "MIME-Version: 1.0 \n";
	$headers .= "Content-type: text/html; charset=utf-8 \n";
	$headers .= "X-Mailer: PHP\n";
	
	ini_set('sendmail_from','agence-temara@test.fr');
	
	mail($mail,$objet,$message,$headers);
}

?>