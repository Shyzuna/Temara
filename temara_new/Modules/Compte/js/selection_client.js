/*
* Gère l'ajout et la suppression d'un bien à la sélection du client lors du clic sur l'étoile
*/

/*
* Si l'utilisateur est connecté, et si le bien dont l'id est passé en paramètre n'a pas encore été ajouté à la sélection, alors il est ajouté à celle-ci et inversement.
* Si l'utilisateur n'est pas connecté, alors le modal de connexion s'affiche
*/
$(document).on('click', '.etoile', function() {
	// Si l'utilisateur est connecté
	if ($('.deconnexion').length > 0)
	{
		if ($(this).hasClass('etoile-jaune'))
		{
			var etoile = $(this);
			(function(etoile){
				supprimeBienSelection(parseInt(etoile.parents('div.html_bien').attr('id').substr(5,etoile.parents('div.html_bien').attr('id').length-5)),function(){
					etoile.parent().append('<img class="etoile etoile-blanche" title="Ajouter ce bien à votre sélection" src="http://localhost:8080/temara/images/etoile-blanche.png" alt="Cliquer pour ajouter ce bien à votre sélection" />');
					etoile.detach();			
				});
			})(etoile);
		}
		else
		{
			var etoile = $(this);
			(function(etoile){
				ajouteBienSelection(parseInt(etoile.parents('div.html_bien').attr('id').substr(5,etoile.parents('div.html_bien').attr('id').length-5)),function(){
					etoile.parent().append('<img class="etoile etoile-jaune" title="Supprimer ce bien de votre sélection" src="http://localhost:8080/temara/images/etoile-jaune.png" alt="Bien déjà ajouté dans votre sélection sélection" />');
					etoile.detach();		
				});
			})(etoile);
		}
	}
	else
		$('#modal').modal('show');
});

// Envoie une requête Ajax permettant d'ajouter le bien, dont l'id est passé en paramètre, à la sélection du client
function ajouteBienSelection (id,callback)
{
	$.ajax({
		type: "POST",
		url: "http://localhost:8080/temara/Modules/Compte/ajoute_selection_client.php",
		data: {id: id},
		success: function(){
			callback();
		}
	});
}

// Envoie une requête Ajax permettant d'ajouter le(s) bien(s), dont le ou les id sont passés en paramètre, à la sélection du client
// @param id: entier ou tableau d'entiers
function supprimeBienSelection (id,callback)
{
	$.ajax({
		type: "POST",
		url: "http://localhost:8080/temara/Modules/Compte/supprime_selection_client.php",
		data: {id: id},
		success: function() {
			callback();
		}
	});
}