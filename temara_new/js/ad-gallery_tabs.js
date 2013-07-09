function initADGallery()
{
	var gallery1;
	var gallery2;
	if ($("#tabs-1 li").length > 0)
		gallery1 = $('#tabs-1').adGallery({loader_image: 'library/ADGallery/loader.gif'});
	if ($("#tabs-2 li").length > 0)
		gallery2 = $('#tabs-2').adGallery({loader_image: 'library/ADGallery/loader.gif'});

	/*
	* On attribue l'événement click ou touchstart (selon le type de device) à toutes les photos des #tabs
	*/
	if ('ontouchstart' in document.documentElement)
	{
		$('#tabs .ad-thumb-list img').each(function(){
			this.addEventListener("touchstart",function(){
				afficheDescription(parseInt($(this).attr('id').substr(6,$(this).attr('id').length-6)));
			});
		});
	}
	else
	{
		$('#tabs .ad-thumb-list img').each(function(){
			$(this).click(function(){
				afficheDescription(parseInt($(this).attr('id').substr(6,$(this).attr('id').length-6)));
			});
		});
	}
	
	/* 
	* On modifie la largeur des listes de photos
	* La taille est égale à : nbPhotos * (largeurPhoto + padding-right)
	*/
	$(window).resize(function(){
		if ($('#tabs-1 .ad-thumb-list img').length > 0)
		{
			var tabPhotos1 = $('#tabs-1 .ad-thumb-list img');
			var paddingRight1 = $('#tabs-1 .ad-thumb-list li').css('padding-right');
			$('#tabs-1 .ad-thumb-list').width(tabPhotos1.length * (tabPhotos1.outerWidth() + parseInt(paddingRight1.substr(0,paddingRight1.length-2))));
		}
		
		if ($('#tabs-2 .ad-thumb-list img').length > 0)
		{
			var tabPhotos2 = $('#tabs-2 .ad-thumb-list img');
			var paddingRight2 = $('#tabs-2 .ad-thumb-list li').css('padding-right');
			$('#tabs-2 .ad-thumb-list').width(tabPhotos2.length * (tabPhotos2.outerWidth() + parseInt(paddingRight2.substr(0,paddingRight2.length-2))));
		}
	});
}