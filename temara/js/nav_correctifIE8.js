/*
* Permet de corriger le fait que sous IE <= 8, la hauteur de chaque li du nav n'est pas égale pour des résolutions moyennes mais > 736px.
* Pour cela, au rechargement et au redimensionnement de la fenêtre on regarde quelle est la hauteur la plus élevée de tous les li, puis on applique
* cette même hauteur à tous les autres.
*/

$(window).load(egaliseHauteursNav);
$(window).resize(egaliseHauteursNav);

function egaliseHauteursNav()
{
	if ($(window).width() > 736)
	{
		$('#nav li').height('auto');
		$('#nav a').height('auto');
		var maxHeight = 0;
		$('#nav a').each(function(){
			if ($(this).height() > maxHeight)
				maxHeight = $(this).height();
		});
		$('#nav li').height(maxHeight);
		$('#nav a').height(maxHeight);
	}
	else
	{
		$('#nav li').height(40);
		$('#nav a').height(40);
	}
}