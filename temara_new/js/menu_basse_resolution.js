/*
* Pour les petites/moyennes résolutions, cache ou réaffiche le menu selon si l'utilisateur clique sur le bouton.
* Utile pour utiliser moins de place en hauteur pour les petites résolutions, et ainsi éviter à l'utilisateur de devoir faire un long scroll.
*/

function toggleMenu ()
{
	$('#nav').toggle("blind",500,function(){
		if ($('#map_canvas').length > 0)
			resizeMap();
	});
	$('.bouton_menu i').toggleClass('icon-chevron-up');
	$('.bouton_menu i').toggleClass('icon-chevron-down');
}

if ($(window).width() <= 799)
	$('#nav').hide();

if ('ontouchstart' in document.documentElement)
	document.getElementsByClassName('bouton_menu')[0].addEventListener('touchstart',toggleMenu);
else
	$('.bouton_menu').click(toggleMenu);

$(window).resize(function(){
	if ($(window).width() > 799)
		$('#nav').show();
});