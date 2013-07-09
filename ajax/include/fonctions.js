	//var loader = "ajax-loader.gif";
	//Debut de la fonction JQUERY
	$(document).ready(function () {

	$('#submit-button').click(function() {

	  // Recuperation du nom d'utilisateur
	  var username = $('#username').val();

  		// Si le nom d'utilisateur est vide on signale l'erreur
  		if (username.length < 1) {
    		$('#classic-use-response').html('<div><p style="color:red;"><strong>Le nom d\'utilisateur ne doit pas &ecirc;tre vide.</strong></p></div>');
    		$('#username').focus();
    		// Sortie de la fonction, on ne va pas plus loin
    		return false;
  		}

  		// Si on arrive ici c'est que le nom d'utilisateur est fourni
  		// On va donc signaler que nous sommes en train de faire quelque chose
  		$('#classic-use-response').html('').html('&nbsp;Chargement...');

  		// Maintenant nous pouvons commencer l'envoi des donnees
  		$.ajax({
    		url: 'register_username.php',
    		type: 'POST',
    		data: {
      		username: username
    		},
    		error: function(jqXHR, textStatus, errorThrown) {
      		// En cas d'erreur, on le signale
      		$('#classic-use-response').html('<div class="error">Une erreur est survenue lors de la requête.</div>');
    		},
    		success: function(data, textStatus, jqXHR) {
      		// Succes. On affiche un message de confirmation
      		$('#classic-use-response').html('<div><p style="color:orange;"><strong>Le nom d\'utilisateur enregistr&eacute; en session est <i>'+username+'</i></strong></p></div>');
    		}
  		});
	});
		
	$('#reset-button').click(function() {

	  // Recuperation du nom d'utilisateur
	  var username = '';

  		// On va donc signaler que nous sommes en train de faire quelque chose
  		$('#classic-use-response').html('&nbsp;Chargement...');
			// Maintenant nous pouvons commencer l'envoi des données
  			$.ajax({
    			url: 'register_username.php',
    			type: 'POST',
    			data: {
      			username: username
    			},
    			error: function(jqXHR, textStatus, errorThrown) {
   	   			// En cas d'erreur, on le signale
   	   			$('#classic-use-response').html('<div>Une erreur est survenue lors de la requête.</div>');
   	 			},
   	 			success: function(data, textStatus, jqXHR) {
 					$('#classic-use-response').html('<div><p style="color:red;"><strong>Variable de session r&eacute;initialis&eacute;e...</strong></p></div>');	
  	 			
   	 				setTimeout(function() { //Cela permet de faire une pause de 2000 millisecondes avant de continuer
						// Succes. On affiche un message de confirmation
 	   					$('#classic-use-response').html('<div><p style="color:red;"><strong></strong></p></div>');
 	   				
 	   				}, 1000);
				}
	  		});
		
 		

	});
	
	//Fin de la fonction JQUERY
	});

