var idToAddSelection = -1; // id du bien à ajouter à la sélection. -1 si aucun demandé

/*
* Connecte l'utilisateur lorsqu'il clique sur le bouton de connexion du modal, et affiche d'erreur si ses identifiants sont erronés
* Redirige également l'utilisateur si l'authentification a réussi
*/
function connexion()
{
	$.ajax({
		type: "POST",
		url: "http://localhost:8080/temara/Modules/Compte/connexion.php",
		data: {
			mail: $('#modal input[name="mail"]').val(),
			password: $('#modal input[name="password"]').val()
		},
		success: function(data){
			// Si data n'est pas null, c'est qu'un message d'erreur a été envoyé
			if (data.length == 0)
			{
				if (idToAddSelection >= 0)
				{
					ajouteBienSelection(idToAddSelection,function(){
						window.location.href = "http://localhost:8080/temara/Modules/Compte/view_selections.php";
					});
				}
				else
					window.location.href = "http://localhost:8080/temara/Modules/Compte/view_selections.php";
			}
			else
			{
				if ($('#modal .rouge').length == 0)
					$('.modal-body').append('<span class="rouge ">'+data+'</span>');
				else if ($('#modal .rouge').length != 0 && $('#modal .rouge').html() != data)
				{
					$('#modal .rouge').detach();
					$('.modal-body').append('<span class="rouge ">'+data+'</span>');
				}
			}
		}
	});
}

$(document).on('click','.button_connect',function(){
	connexion();
});
$("#modal input").keypress(function(event) {
    if (event.which == 13)
        connexion();
});


// Redirige vers deconnexion.php lors du clic sur le bouton de déconnexion
$('button.deconnexion').click(function(){
	window.location = "http://localhost:8080/temara/Modules/Compte/deconnexion.php";
});


// Supprime l'éventuel message d'erreur lors de la fermeture du modal
$('#modal').on('hidden',function(){
	$('#modal .rouge').detach();
});


// Focus sur le premier champ lors de l'ouverture du modal
$('#modal').on('shown',function(){
	$('#modal input[name="mail"]').focus();
});


if ($('.connexion').length > 0)
{
	$(document).on('click','.etoile',function(){
		idToAddSelection = parseInt($(this).parents('div.html_bien').attr('id').substr(5,$(this).parents('div.html_bien').attr('id').length-5));
	});
	
	$('#modal').on('hidden',function(){
		idToAddSelection = -1;
	});
}