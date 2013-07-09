// Affiche ou cache les commentaires de clients sélectionnés
$('.clickable').click(function(){
	var id = parseInt($(this).parent().attr("id").substr(8,$(this).parent().attr("id").length-8));
	var idToHide = -1;
	if ($('.commentaire:visible').length > 0)
		idToHide = parseInt($('.commentaire:visible').attr('id').substr(12,$('.commentaire:visible').attr('id').length-12));
	var visible = $('.commentaire[id="commentaire-'+id+'"]').is(":visible");
	
	if (idToHide != id)
	{
		$('.commentaire[id="commentaire-'+idToHide+'"]').slideToggle(500);
		$('.commentaire[id="commentaire-'+idToHide+'"]').find('div').slideToggle(500);
	}
	
	$('.commentaire[id="commentaire-'+id+'"]').slideToggle(500);
	$('.commentaire[id="commentaire-'+id+'"]').find('div').slideToggle(500);
	
	if (!(visible) && $(this).parent().hasClass('non_lu'))
	{
		var idTab = new Array();
		idTab.push(id);
		demandesLues(idTab);
	}
});

// Coche toutes les checkbox si l'utilisateur coche celle du haut, et inversement
$('th input').change(function(){
	if ($(this).is(':checked'))
	{
		$('td input').each(function(){
			$(this).prop("checked",true);
		});
	}
	else
	{
		$('td input').each(function(){
			$(this).prop('checked',false);
		});
	}
});

// Supprime les demandes des clients sélectionnées
$('.button_delete').click(function(){
	if ($('td input:checked').length > 0)
	{
		if (confirm("Etes-vous sûr de vouloir supprimer ces messages ?"))
		{
			var tab = new Array();
			$('td input:checked').parent().parent().each(function(){
				tab.push(parseInt($(this).attr('id').substr(8,$(this).attr('id').length-8)));
			});
			
			supprimeDemandes(tab);
		}
	}
});

// Marque les demandes sélectionnées comme lues
$('.button_lu').click(function(){
	if ($('td input:checked').length > 0)
	{
		var idTab = new Array();
		$('td input:checked').parent().parent().each(function(){
			idTab.push(parseInt($(this).attr('id').substr(8,$(this).attr('id').length-8)));
		});
		demandesLues(idTab);
	}
});

// Marque les demandes sélectionnées comme non lues
$('.button_non_lu').click(function(){
	if ($('td input:checked').length > 0)
	{
		var idTab = new Array();
		$('td input:checked').parent().parent().each(function(){
			idTab.push(parseInt($(this).attr('id').substr(8,$(this).attr('id').length-8)));
		});
		demandesNonLues(idTab);
	}
});