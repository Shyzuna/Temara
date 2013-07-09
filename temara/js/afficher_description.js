var idBiensDejaAffiches = new Array();

// Affiche la description du bien sélectionné
function afficheDescription (idBien)
{
	changeBienSelectionne(idBien);
	
	if ($.inArray(idBien,idBiensDejaAffiches) < 0)
	{
		$('div[id="bien-'+idBien+'"] > .description').parent().find('.ad-gallery').adGallery({
			// options
			loader_image: 'http://localhost:8080/temara/library/ADGallery/loader.gif',
			update_window_hash: false, // sinon bug car garde le dernier numéro de photo consulté même par une autre AD Gallery
			effect: 'fade',
			callbacks : { 
				// This gets fired right after the new_image is fully visible
				afterImageVisible: function() {
					this.loading(false);
				}, 
			}
		});
		corrigeGalleryIE();
		idBiensDejaAffiches.push(idBien);
	}
}

// Cache le précédent bien affiché et affiche le nouveau dont l'id est passé en paramètre
function changeBienSelectionne (idBien)
{
	$('div:visible > .description').parent().hide();
	$('div[id="bien-'+idBien+'"] > .description').parent().show();
}