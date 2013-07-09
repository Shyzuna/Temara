/*
* Affiche un loader de chargement lors d'une requête Ajax
*/

$(document).ajaxStart(function(){
		$('.loader').show();
}).ajaxStop(function(){
		$('.loader').hide();
});