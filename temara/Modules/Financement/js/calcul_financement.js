// active ou désactive le bouton de calcul selon si les champs sont correctement remplis ou non
$(document).ready(function(){
	$('form[name="form_calcul"] input').keyup(function(eventObject) 
	{
		// Si ce n'est pas la touche Entrée qui a été apuyée
		if (eventObject.keyCode != 13)
		{
			// On vérifie que chaque champ entré est bien un entier
			if (((isNaN(parseInt($('input[name="duree"]').val()))==false) && (isNaN(parseInt($('input[name="taux"]').val()))==false)) && ((isNaN(parseInt($('input[name="montant"]').val()))==false) ^ (isNaN(parseInt($('input[name="mensualite"]').val()))==false)))
				if ((($('input[name="montant"]').val()) != "") ^ (($('input[name="mensualite"]').val()) != ""))
				{
					$('form[name="form_calcul"] button').removeClass('disabled');
				}
				else
				{
					$('form[name="form_calcul"] button').addClass('disabled');
					
				}
			else
				$('form[name="form_calcul"] button').addClass('disabled');
				
			// On désactive l'éventuel contour vert s'il y a déjà eu un premier calcul
			if ($('.control-group:nth-of-type(4)').hasClass("success"))
				$('.control-group:nth-of-type(4)').removeClass("success");
			else if ($('.control-group:nth-of-type(3)').hasClass("success"))
				$('.control-group:nth-of-type(3)').removeClass("success");
		}
	});
	
	if ('ontouchstart' in document.documentElement)
		document.getElementsByTagName('form')[0].getElementsByTagName('button')[0].addEventListener('touchstart',calcul);
	else
		$('form button').click(calcul);
});

// fait le calcul du financement
function calcul(){
	if ($('form[name="form_calcul"] button').hasClass('disabled') == false)
	{
		var obj=document.form_calcul;
		var C=obj.montant.value;
		var t=obj.taux.value;
		var m=obj.mensualite.value;
		var n=obj.duree.value;
		var temp=0;
		var msg="";		
		t=t.replace(",",".");
		C=C.replace(",",".");
		m=m.replace(",",".");
		n=n.replace(",",".");
		
		if(msg==""){
			if(C!=""){
				taux=t/1200;
				duree=n*12;
				temp=1+taux;
				temp=Math.pow(temp, -duree);
				temp=1-temp;
				temp=taux/temp;
				temp=C*temp;
				temp=Math.round(temp*100)/100;
				obj.mensualite.value=temp;
				$('.control-group:nth-of-type(4)').addClass("success");
			}else{
				taux=t/1200;
				duree=n*12;
				temp=1+taux;
				temp=Math.pow(temp, -duree);
				temp=1-temp;
				temp=temp/taux;
				temp=m*temp;
				temp=Math.round(temp*100)/100;
				obj.montant.value=temp;
				$('.control-group:nth-of-type(3)').addClass("success");
			}
		}
	}
}