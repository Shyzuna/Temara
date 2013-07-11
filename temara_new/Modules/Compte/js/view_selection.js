// Affiche le bien sélectionné en bas de la page, et scroll la page vers le bas
$('.selection').click(function(){
	var idBien = parseInt($(this).attr('id').substr(10,$(this).attr('id').length-10));
	afficheDescription(idBien);
	$('body,html').animate({ scrollTop: $('div:visible > .description').offset().top }, 400);
});


// Supprime de la sélection le bien sur lequel l'utilisateur a cliqué sur la croix en haut à droite
$('.close').click(function(event){
	event.stopPropagation(); // Permet d'arrêter l'événement du clic sur '.selection'

	var idBien = parseInt($(this).parents('.selection').attr('id').substr(10,$(this).parents('.selection').attr('id').length-10));
	(function(idBien){
		supprimeBienSelection(idBien,function(){
			$('.selection[id="selection-'+idBien+'"]').detach();
			$('#selection_bien div[id="bien-'+idBien+'"]').detach();
		});
	})(idBien);
});