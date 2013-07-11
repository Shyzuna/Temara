// Met à jour la hauteur de la Google map et le corps selon la hauteur de la fenêtre et selon si le menu est déroulé ou non
function resizeMap ()
{
	var maxHeight;
	var windowWidth = $(window).width();
	var navHeight = ($('#nav').css('display') == 'none') ? 0 : 280;
	
	// redimensionnement de la map
	if (windowWidth > 799)
		maxHeight = 550;
	else if (windowWidth <= 799 && windowWidth > 430)
		maxHeight = 450;
	else
		maxHeight = 380;
	if (maxHeight > $(window).height())
		$("#map_canvas").height($(window).height()-30);
	else if (maxHeight < $(window).height())
		$("#map_canvas").height(maxHeight);

	// redimensionnement de body, #corps et #ensemble
	if (windowWidth > 799)
	{
		var descriptionBien;
		if ($('div:visible > .description').outerHeight(true) > $('div:visible > .photos').outerHeight(true))
			descriptionBien = $('div:visible > .description').outerHeight(true);
		else
			descriptionBien = $('div:visible > .photos').outerHeight(true);
		var formHeight = $('.cadre > form').parent().outerHeight(true);
		var buttonConnexionHeight;
		if ($('.connexion').length > 0)
			buttonConnexionHeight = $('.connexion').outerHeight(true);
		else
			buttonConnexionHeight = $('.deconnexion').outerHeight(true);
		
		var ensembleHeight = $('#ensemble h2').outerHeight(true) + formHeight + descriptionBien + buttonConnexionHeight;
		var corpsHeight = ensembleHeight + $('#header').outerHeight(true) + $('#nav').outerHeight(true) + 25;
		var bodyHeight = corpsHeight + 100;
		
		$('body').height("auto");
		$('#corps').height("auto");
		$('#ensemble').height(ensembleHeight);
	}
	else if (windowWidth <= 799)
	{
		var descriptionBien = $('div:visible > .description').outerHeight(true) + $('div:visible > .photos').outerHeight(true) + 50;
		
		var ensembleHeight = $('#ensemble h2').outerHeight(true) + $('#ensemble .cadre:first-of-type').outerHeight(true) + $('#map_canvas').outerHeight(true) + descriptionBien;
		var corpsHeight = ensembleHeight + $('#header').outerHeight(true) + $('.btn.bouton_menu').outerHeight(true) + 50;
		var bodyHeight = corpsHeight + 50;

		$('body').height(bodyHeight+navHeight);
		$('#corps').height(corpsHeight+navHeight);
		$('#ensemble').height(ensembleHeight+25);
	}
}

// La fonction est appelé au chargement et au redimensionnement de la fenêtre, et également lors de changements dans la structure du DOM.
$(document).ready(resizeMap);
$(window).resize(resizeMap);