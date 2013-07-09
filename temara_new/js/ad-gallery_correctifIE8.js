// Si IE <= 8, corrige le défaut d'opacité de ad-back et ad-forward
function corrigeGalleryIE()
{
	if  (!$.support.leadingWhitespace)
	{
		$('.ad-back').attr("style","");
		$('.ad-forward').attr("style","");
		$('.ad-back').mouseover(function(){
			$('.ad-back').attr("style","");
		});
		$('.ad-back').mouseleave(function(){
			$('.ad-back').attr("style","");
		});
		$('.ad-forward').mouseover(function(){
			$('.ad-forward').attr("style","");
		});
		$('.ad-forward').mouseleave(function(){
			$('.ad-forward').attr("style","");
		});
	}
}