/*
* Permet la mise en page lors d'une demande d'impression de l'utilisateur
*/

function beforePrintBien()
{
	$('#ensemble').append('<div id="photos_print"></div>');
	$('div:visible > .photos .ad-gallery .ad-thumbs .ad-thumb-list img').each(function(){
		$('#photos_print').append($(this).clone());
	});
	$('#photos_print img').width(180).height(140);
}

function afterPrintBien()
{
	$('#photos_print').detach();
}

// si IE <= 8
if (!$.support.leadingWhitespace)
{
	window.attachEvent('onbeforeprint',beforePrintBien);
	window.attachEvent('onafterprint',afterPrintBien);
}
else
{
	if (window.matchMedia) 
	{
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function(mql){
			if (mql.matches)
				beforePrintBien();
			else 
				afterPrintBien();
		});
	}

	window.onbeforeprint = beforePrintBien;
	window.onafterprint = afterPrintBien;
}