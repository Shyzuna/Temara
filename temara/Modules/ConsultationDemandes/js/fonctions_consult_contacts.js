// Envoie une requête Ajax pour sauvegarder le fait que les demandes ont bien été lues et supprime la classe non_lue des lignes du tableau correspondantes
// @param idTab: le tableau des id des demandes à marquer comme lues
function demandesLues(idTab)
{
	for (id in idTab)
		$('tr[id="demande-'+idTab[id]+'"]').removeClass('non_lu');
	$.ajax({
		type: 'POST',
		url: 'set_lu_contacts.php',
		data: { idTab: idTab, lu: 1}
	});
}

// Envoie une requête Ajax pour les demandes précisées comme non lues et ajoute la classe non_lue aux lignes du tableau correspondantes
// @param idTab: le tableau des id des demandes à marquer comme non lues
function demandesNonLues(idTab)
{
	for (id in idTab)
		$('tr[id="demande-'+idTab[id]+'"]').addClass('non_lu');
	$.ajax({
		type: 'POST',
		url: 'set_lu_contacts.php',
		data: { idTab: idTab, lu: 0}
	});
}

// Envoie une requête Ajax pour supprimer les demandes dont les id sont passés en paramètre
// Supprime les noeuds corresponds dans la page
function supprimeDemandes (idTab)
{
	$.ajax({
		type: "POST",
		url: "delete_contacts.php",
		data: { idDemandesTab: idTab },
		success: function(){
			$('td input:checked').parent().parent().each(function(){
				$(this).detach();
				$('.commentaire[id="commentaire'+parseInt($(this).attr('id').substr(8,$(this).attr('id').length-8))+'"]').detach();
			});
		}
	});
}