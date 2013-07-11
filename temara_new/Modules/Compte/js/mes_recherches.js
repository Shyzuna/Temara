// Supprime la sélection demandée via une requête Ajax
$('.delete-fiche').click(function(){
	var idFiche = parseInt($(this).parents('.fiche').attr('id').substr(6,$(this).parents('.fiche').attr('id').length-6));
	(function(idFiche){
		$.ajax({
			type: 'POST',
			url: 'supprime_fiche_recherche.php',
			data: {'idFiche' : idFiche },
			success: function() {
				$('.fiche[id="fiche-'+idFiche+'"]').detach();
			}
		});
	})(idFiche);
});