var tabRecherches = new Array();
var index = 0; // le numéro dans le tableau de la recherche actuellement consultée par l'utilisateur

/*
* Evénements
*/

if ('ontouchstart' in document.documentElement)
{
	document.getElementsByTagName('form')[0].getElementsByTagName('button')[0].addEventListener('touchstart',function(){updateMapRecherche(); nouvelleRecherche(); });
	document.getElementsByClassName('precedent')[0].addEventListener('touchstart',recherchePrecedente);
	document.getElementsByClassName('suivant')[0].addEventListener('touchstart',rechercheSuivante);
}
else
{
	$("form button").click(nouvelleRecherche);
	$(".precedent").click(recherchePrecedente);
	$(".suivant").click(rechercheSuivante);
}

// On enregistre les données du formulaire de la recherche actuellement consultée par l'utilisateur avant que celui-ci ne quitte la page.
$(window).unload(saveLastSearch);

// Désactivation du bouton du formulaire pendant recherche
$(document).ajaxStart(function(){
	if ($('#modal').css('display') == 'none')
		$('.cadre form button').attr('disabled','');
}).ajaxStop(function(){
	$('.cadre form button').removeAttr('disabled');
});


/*
* Fonctions
*/

// Affiche la précédente recherche
function recherchePrecedente ()
{
	if (index > 0)
	{
		updateMapRecherche();
		index--;
		afficheRecherche(index);
		if (index == 0)
			$('.precedent').addClass('disabled');
		if (tabRecherches.length >= 2)
			$('.suivant').removeClass('disabled');
	}
}

// Affiche la recherche suivante dans l'historique
function rechercheSuivante ()
{
	if (index < tabRecherches.length - 1)
	{
		updateMapRecherche();
		index++;
		afficheRecherche(index);
		if (index == tabRecherches.length - 1)
			$('.suivant').addClass('disabled');
		if (tabRecherches.length >= 2)
			$('.precedent').removeClass('disabled');
	}
}

// Ajoute un enregistrement dans le tableau des recherches
// Chacune des recherches est sauvegardée dès sa création (lors du clic sur le bouton du formulaire)
function nouvelleRecherche()
{
	var rechercheSaved = getLastSearch();
	
	if (formEnvoye || rechercheSaved == null || tabRecherches.length > 0)
	{
		if (tabRecherches.length > 0)
			updateMapRecherche();
		
		var recherche = {};
		
		var typeAnnonceTab = new Array();
		$('input[name="typeAnnonce[]"]:checked').each(function(){
			typeAnnonceTab.push($(this).val())
		});
		
		var typeBienTab = new Array();
		$('input[name="typeBien[]"]:checked').each(function(){
			typeBienTab.push($(this).val())
		});
		
		// On enregistre les données contenues dans le formulaire, les données de la map, et les biens trouvés par cette recherche
		recherche.typeAnnonceTab = typeAnnonceTab;
		recherche.typeBienTab = typeBienTab;
		recherche.prixMin = $('input[name="budgetMin"]').val();
		recherche.prixMax = $('input[name="budgetMax"]').val();
		recherche.surfaceMin = $('input[name="surfaceMin"]').val();
		recherche.surfaceMax = $('input[name="surfaceMax"]').val();
		recherche.nbPiecesMin = $('input[name="nbPiecesMin"]').val();
		recherche.nbPiecesMax = $('input[name="nbPiecesMax"]').val();
		recherche.ville = $('input[name="ville"]').val();
		recherche.reference = $('input[name="reference"]').val();
		
		if (tabRecherches.length > 0)
		{
			actualiseMap(function(){
				recherche.tabBiens = new Array();
				for (i in biens)
					recherche.tabBiens.push(biens[i]);
				tabRecherches.push(recherche);
				
				index = tabRecherches.length - 1;
				
				if (tabRecherches.length >= 2)
					$('.precedent').removeClass('disabled');
				$('.suivant').addClass('disabled');
			});
		}
		else
		{
			recherche.tabBiens = new Array();
			for (i in biens)
				recherche.tabBiens.push(biens[i]);
			tabRecherches.push(recherche);
			
			if (idGET != null)
			{
				for (i in biens)
				{
					if (biens[i].id == idGET)
						afficheDescriptionBien(biens[i]);
				}
			}
		}
	}
	else
	{
		/*
		* Cas où l'utilisateur est arrivé sur la page sans passer par recherche.php, et où une recherche a été enregistrée dans Web Storage
		*/
		
		$('input[name="typeAnnonce[]"]').each(function(){
		if ($.inArray($(this).val(),rechercheSaved.typeAnnonceTab) >= 0)
			$(this).prop("checked",true);
		else
			$(this).prop("checked",false);
		});
		$('input[name="typeBien[]"]').each(function(){
			if ($.inArray($(this).val(),rechercheSaved.typeBienTab) >= 0)
				$(this).prop("checked",true);
			else
				$(this).prop("checked",false);
		});
		$('input[name="budgetMin"]').val(rechercheSaved.prixMin);
		$('input[name="budgetMax"]').val(rechercheSaved.prixMax);
		$('input[name="surfaceMin"]').val(rechercheSaved.surfaceMin);
		$('input[name="surfaceMax"]').val(rechercheSaved.surfaceMax);
		$('input[name="nbPiecesMin"]').val(rechercheSaved.nbPiecesMin);
		$('input[name="nbPiecesMax"]').val(rechercheSaved.nbPiecesMax);
		$('input[name="ville"]').val(rechercheSaved.ville);
		$('input[name="reference"]').val(rechercheSaved.reference);
		
		actualiseMap(function(){
			rechercheSaved.tabBiens = new Array();
			for (i in biens)
				rechercheSaved.tabBiens.push(biens[i]);
			tabRecherches.push(rechercheSaved);
			
			getMapLastSearch();
			
			if (cercle.getVisible())
				afficheOuCacheBiens();
			
			if (idGET != null)
			{
				for (i in biens)
				{
					if (biens[i].id == idGET)
						afficheDescriptionBien(biens[i]);
				}
			}
			
			index = tabRecherches.length - 1;
		});
	}
}

// Affiche la recherche contenue dans le tableau à l'index i
// Affiche les données de cette recherche dans le formulaire, et affiche les données de la map de cette recherche
function afficheRecherche (index)
{
	$('input[name="typeAnnonce[]"]').each(function(){
		if ($.inArray($(this).val(),tabRecherches[index].typeAnnonceTab) >= 0)
			$(this).prop("checked",true);
		else
			$(this).prop("checked",false);
	});
	$('input[name="typeBien[]"]').each(function(){
		if ($.inArray($(this).val(),tabRecherches[index].typeBienTab) >= 0)
			$(this).prop("checked",true);
		else
			$(this).prop("checked",false);
	});
	$('input[name="budgetMin"]').val(tabRecherches[index].prixMin);
	$('input[name="budgetMax"]').val(tabRecherches[index].prixMax);
	$('input[name="surfaceMin"]').val(tabRecherches[index].surfaceMin);
	$('input[name="surfaceMax"]').val(tabRecherches[index].surfaceMax);
	$('input[name="nbPiecesMin"]').val(tabRecherches[index].nbPiecesMin);
	$('input[name="nbPiecesMax"]').val(tabRecherches[index].nbPiecesMax);
	$('input[name="ville"]').val(tabRecherches[index].ville);
	$('input[name="reference"]').val(tabRecherches[index].reference);
	
	map.setCenter(tabRecherches[index].centreMap);
	map.setZoom(tabRecherches[index].zoom);
	if (tabRecherches[index].cercleVisible)
	{
		markerCentre.setPosition(tabRecherches[index].positionMarkerCentre);
		markerRayon.setPosition(tabRecherches[index].positionMarkerRayon);
		cercle.setCenter(tabRecherches[index].positionMarkerCentre);
		cercle.setRadius(google.maps.geometry.spherical.computeDistanceBetween(markerCentre.getPosition(),markerRayon.getPosition()));
		cercle.setVisible(true);
		markerCentre.setVisible(true);
		markerRayon.setVisible(true);
	}
	else
	{
		cercle.setVisible(false);
		markerCentre.setVisible(false);
		markerRayon.setVisible(false);
	}
	
	for (i in biens)
		biens[i].marker.setMap(null);
	biens.splice(0,biens.length);
	for (i in tabRecherches[index].tabBiens)
		biens.push(tabRecherches[index].tabBiens[i]);
	afficheBiens();
}

// Met à jour les données de la map de la recherche courante
function updateMapRecherche ()
{
	tabRecherches[index].centreMap = map.getCenter();
	tabRecherches[index].zoom = map.getZoom();
	tabRecherches[index].cercleVisible = cercle.getVisible();
	tabRecherches[index].positionMarkerCentre = markerCentre.getPosition();
	tabRecherches[index].positionMarkerRayon = markerRayon.getPosition();
}

// Utilisation de Web Storage pour enregistrer les données du formulaire et de la map de la dernière recherche consultée de l'historique le temps de la session de l'utilisateur.
// Utilisation également de l'objet JSON pour pouvoir convertir les tableaux en des chaines sérialisées les représentant au format JSON.
// On sauvegarde 2 types recherches: celui des investisseurs et celui des non investisseurs.
function saveLastSearch ()
{
	if (!(investisseur))
	{
		sessionStorage.setItem('typeAnnonceTab',JSON.stringify(tabRecherches[index].typeAnnonceTab));
		sessionStorage.setItem('typeBienTab',JSON.stringify(tabRecherches[index].typeBienTab));
		sessionStorage.setItem('prixMin',tabRecherches[index].prixMin);
		sessionStorage.setItem('prixMax',tabRecherches[index].prixMax);
		sessionStorage.setItem('surfaceMin',tabRecherches[index].surfaceMin);
		sessionStorage.setItem('surfaceMax',tabRecherches[index].surfaceMax);
		sessionStorage.setItem('nbPiecesMin',tabRecherches[index].nbPiecesMin);
		sessionStorage.setItem('nbPiecesMax',tabRecherches[index].nbPiecesMax);
		sessionStorage.setItem('ville',tabRecherches[index].ville);
		sessionStorage.setItem('reference',tabRecherches[index].reference);
		
		sessionStorage.setItem('positionMarkerCentreLat',markerCentre.getPosition().lat());
		sessionStorage.setItem('positionMarkerCentreLng',markerCentre.getPosition().lng());
		sessionStorage.setItem('positionMarkerRayonLat',markerRayon.getPosition().lat());
		sessionStorage.setItem('positionMarkerRayonLng',markerRayon.getPosition().lng());
		sessionStorage.setItem('centreMapLat',map.getCenter().lat());
		sessionStorage.setItem('centreMapLng',map.getCenter().lng());
		sessionStorage.setItem('zoom',map.getZoom());
	}
	else
	{
		sessionStorage.setItem('typeAnnonceTabInvestisseurs',JSON.stringify(tabRecherches[index].typeAnnonceTab));
		sessionStorage.setItem('typeBienTabInvestisseurs',JSON.stringify(tabRecherches[index].typeBienTab));
		sessionStorage.setItem('prixMinInvestisseurs',tabRecherches[index].prixMin);
		sessionStorage.setItem('prixMaxInvestisseurs',tabRecherches[index].prixMax);
		sessionStorage.setItem('surfaceMinInvestisseurs',tabRecherches[index].surfaceMin);
		sessionStorage.setItem('surfaceMaxInvestisseurs',tabRecherches[index].surfaceMax);
		sessionStorage.setItem('nbPiecesMinInvestisseurs',tabRecherches[index].nbPiecesMin);
		sessionStorage.setItem('nbPiecesMaxInvestisseurs',tabRecherches[index].nbPiecesMax);
		sessionStorage.setItem('villeInvestisseurs',tabRecherches[index].ville);
		sessionStorage.setItem('referenceInvestisseurs',tabRecherches[index].reference);
		
		sessionStorage.setItem('positionMarkerCentreLatInvestisseurs',markerCentre.getPosition().lat());
		sessionStorage.setItem('positionMarkerCentreLngInvestisseurs',markerCentre.getPosition().lng());
		sessionStorage.setItem('positionMarkerRayonLatInvestisseurs',markerRayon.getPosition().lat());
		sessionStorage.setItem('positionMarkerRayonLngInvestisseurs',markerRayon.getPosition().lng());
		sessionStorage.setItem('centreMapLatInvestisseurs',map.getCenter().lat());
		sessionStorage.setItem('centreMapLngInvestisseurs',map.getCenter().lng());
		sessionStorage.setItem('zoomInvestisseurs',map.getZoom());
	}
}

// Renvoie l'objet Recherche dont les données du formulaire ont été sauvegardées via Web Storage.
// @return null si aucune donnée n'a été sauvegardée
function getLastSearch ()
{
	if (!(investisseur) && sessionStorage.getItem('typeAnnonceTab') != null && sessionStorage.getItem('typeBienTab') != null && sessionStorage.getItem('prixMin') != null && 
	   sessionStorage.getItem('prixMax') != null && sessionStorage.getItem('surfaceMin') != null && sessionStorage.getItem('surfaceMax') != null && 
	   sessionStorage.getItem('nbPiecesMin') != null && sessionStorage.getItem('nbPiecesMax') != null && sessionStorage.getItem('ville') != null && sessionStorage.getItem('reference') != null)
	{
		var recherche = {};
		recherche.typeAnnonceTab = JSON.parse(sessionStorage.getItem('typeAnnonceTab'));
		recherche.typeBienTab = JSON.parse(sessionStorage.getItem('typeBienTab'));
		recherche.prixMin = sessionStorage.getItem('prixMin');
		recherche.prixMax = sessionStorage.getItem('prixMax');
		recherche.surfaceMin = sessionStorage.getItem('surfaceMin');
		recherche.surfaceMax = sessionStorage.getItem('surfaceMax');
		recherche.nbPiecesMin = sessionStorage.getItem('nbPiecesMin');
		recherche.nbPiecesMax = sessionStorage.getItem('nbPiecesMax');
		recherche.ville = sessionStorage.getItem('ville');
		recherche.reference = sessionStorage.getItem('reference');
		return recherche;
	}
	else if (investisseur && sessionStorage.getItem('typeAnnonceTabInvestisseurs') != null && sessionStorage.getItem('typeBienTabInvestisseurs') != null && sessionStorage.getItem('prixMinInvestisseurs') != null && 
	   sessionStorage.getItem('prixMaxInvestisseurs') != null && sessionStorage.getItem('surfaceMinInvestisseurs') != null && sessionStorage.getItem('surfaceMaxInvestisseurs') != null && 
	   sessionStorage.getItem('nbPiecesMinInvestisseurs') != null && sessionStorage.getItem('nbPiecesMaxInvestisseurs') != null && sessionStorage.getItem('villeInvestisseurs') != null && sessionStorage.getItem('referenceInvestisseurs') != null)
	{
		var recherche = {};
		recherche.typeAnnonceTab = JSON.parse(sessionStorage.getItem('typeAnnonceTabInvestisseurs'));
		recherche.typeBienTab = JSON.parse(sessionStorage.getItem('typeBienTabInvestisseurs'));
		recherche.prixMin = sessionStorage.getItem('prixMinInvestisseurs');
		recherche.prixMax = sessionStorage.getItem('prixMaxInvestisseurs');
		recherche.surfaceMin = sessionStorage.getItem('surfaceMinInvestisseurs');
		recherche.surfaceMax = sessionStorage.getItem('surfaceMaxInvestisseurs');
		recherche.nbPiecesMin = sessionStorage.getItem('nbPiecesMinInvestisseurs');
		recherche.nbPiecesMax = sessionStorage.getItem('nbPiecesMaxInvestisseurs');
		recherche.ville = sessionStorage.getItem('villeInvestisseurs');
		recherche.reference = sessionStorage.getItem('referenceInvestisseurs');
		return recherche;
	}
	else
		return null;
}

// Remet l'état de la map (position des markers etc...) telle qu'elle était lors de la dernière recherche enregistrée
function getMapLastSearch ()
{
	if (!(investisseur) && sessionStorage.getItem('positionMarkerCentreLat') && sessionStorage.getItem('positionMarkerCentreLng')
		&& sessionStorage.getItem('positionMarkerRayonLat') && sessionStorage.getItem('positionMarkerRayonLng') && sessionStorage.getItem('centreMapLat')
		&& sessionStorage.getItem('centreMapLng') && sessionStorage.getItem('zoom'))
	{
		var positionMarkerCentre = new google.maps.LatLng(sessionStorage.getItem('positionMarkerCentreLat'),sessionStorage.getItem('positionMarkerCentreLng'));
		var positionMarkerRayon = new google.maps.LatLng(sessionStorage.getItem('positionMarkerRayonLat'),sessionStorage.getItem('positionMarkerRayonLng'));
		var centreMap = new google.maps.LatLng(sessionStorage.getItem('centreMapLat'),sessionStorage.getItem('centreMapLng'));
		var zoom = parseInt(sessionStorage.getItem('zoom'));
	}
	else if (investisseur && sessionStorage.getItem('positionMarkerCentreLatInvestisseurs') && sessionStorage.getItem('positionMarkerCentreLngInvestisseurs')
		&& sessionStorage.getItem('positionMarkerRayonLatInvestisseurs') && sessionStorage.getItem('positionMarkerRayonLngInvestisseurs') && sessionStorage.getItem('centreMapLatInvestisseurs')
		&& sessionStorage.getItem('centreMapLngInvestisseurs') && sessionStorage.getItem('zoomInvestisseurs'))
	{
		var positionMarkerCentre = new google.maps.LatLng(sessionStorage.getItem('positionMarkerCentreLatInvestisseurs'),sessionStorage.getItem('positionMarkerCentreLngInvestisseurs'));
		var positionMarkerRayon = new google.maps.LatLng(sessionStorage.getItem('positionMarkerRayonLatInvestisseurs'),sessionStorage.getItem('positionMarkerRayonLngInvestisseurs'));
		var newRadius = google.maps.geometry.spherical.computeDistanceBetween(positionMarkerCentre,positionMarkerRayon);
		var centreMap = new google.maps.LatLng(sessionStorage.getItem('centreMapLatInvestisseurs'),sessionStorage.getItem('centreMapLngInvestisseurs'));
		var zoom = parseInt(sessionStorage.getItem('zoomInvestisseurs'));
	}
	markerCentre.setPosition(positionMarkerCentre);
	markerRayon.setPosition(positionMarkerRayon);
	var newRadius = google.maps.geometry.spherical.computeDistanceBetween(positionMarkerCentre,positionMarkerRayon);
	cercle.setRadius(newRadius);
	map.setCenter(centreMap);
	map.setZoom(zoom);
}