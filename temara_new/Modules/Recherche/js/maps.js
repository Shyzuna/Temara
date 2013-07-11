var map;
var markerCentre;
var markerRayon;
var cercle;
var infoWindow = new google.maps.InfoWindow({
	maxWidth: 500,
	disableAutoPan: true,
});
var rayon = 250;
var iconeMaison = {url: "images/icone_maison.png"};
var boundsPicardie = new google.maps.LatLngBounds(new google.maps.LatLng(48.837212, 1.3796628000000055),new google.maps.LatLng(50.3663219, 4.255678900000021));
var somme = new google.maps.LatLng(49.914518,2.270709);
var animationJouee = false;   // true si l'animation des markers de cercle a déjà été jouée
var angle = 90;   // L'angle entre le marker de centre et le marker de rayon, initialement 90 degrés
var centreMap;
var idBiensDejaAffiches = new Array();   // Tableau des id des biens ayant déjà été affichés au moins une fois pour éviter de les recharger à nouveau lors de leur sélection

// renvoie l'objet LatLng contenant les coordonnées du lieu dont la chaine est passée en paramètre, et enregistre ces coordonnées dans la BDD
// callback : fonction à appeler au retour de geocode (car c'est une fonction asynchrone)
// callback : function(coordonnees,zoom,status)
function coordonneesLieu (lieu, callback)
{
	var geocoder = new google.maps.Geocoder();
	// On délimite la recherche à la Picardie
	geocoder.geocode({address: lieu,region:'FR',bounds:boundsPicardie},function(results,status){
		if (status == google.maps.GeocoderStatus.OK)
		{
			var coordonnees = results[0].geometry.location;
			saveCoordonnees(lieu,getChaineCoordonnees(coordonnees));
			callback(coordonnees,13,status);
		}
		else if (status == google.maps.GeocoderStatus.ZERO_RESULTS)
		{
			// Si la ville demandée n'existe pas, on centre la carte sur l'ensemble de la Picardie et avec un zoom plus petit
			callback(somme,9,status);
		}
		else
			alert('Une erreur est survenue : '+status+'.\n\nVeuillez recharger la page');
	});
}

// Initialise la map ainsi que les markers associés, les événements pouvant se produire etc...
function initMap (coordonnees,zoom,status)
{
	/*
	* Map, markers et cercle
	*/
	
	var mapOptions = {
		zoom: zoom,
		center: coordonnees,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		streetViewControl: false,
		mapTypeControl: false
	}
  
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	centreMap = map.getCenter();
  
	markerCentre = new google.maps.Marker({
		position: coordonnees,
		map: map,
		draggable: true,
		clickable: false,
	});	
	
	cercle = new google.maps.Circle({
		map: map,
		center: coordonnees,
		radius: rayon,
		fillColor: "red",
		clickable: false,
	});
	
	markerRayon = new google.maps.Marker({
		map: map,
		position: google.maps.geometry.spherical.computeOffset(markerCentre.getPosition(),cercle.getRadius(),90),
		draggable: true,
		clickable: false,
	});
	
	if (status == google.maps.GeocoderStatus.ZERO_RESULTS)
	{
		markerCentre.setVisible(false);
		markerRayon.setVisible(false);
		cercle.setVisible(false);
	}
	else
	{
		startAnimationMarkers();
		animationJouee = true;
	}
	
	/*
	* Affichage des biens
	*/
	
	if (biens.length > 0)
		afficheBiens();
	else if (formEnvoye)
		alert('Aucun bien ne correspond à votre recherche.');	
	
	/*
	* Evénements
	*/
	
	// Si le marker du centre est déplacé, alors le cercle et le marker de rayon sont déplacés avec
	google.maps.event.addListener(markerCentre,'position_changed',function(){
		cercle.setCenter(this.getPosition());
		markerRayon.setPosition(calculePositionMarkerRayon());
	});
	
	// Lors du déplacement du marker du centre, les biens s'affichent ou se cachent selon si elles sont contenues ou non dans le cercle
	google.maps.event.addListener(markerCentre,'drag',function(){
		afficheOuCacheBiens();
	});
	
	// On change le rayon du cercle en même temps que l'on déplace le marker du rayon, et les biens sont affichées si elles sont dans le cercles, sinon elles sont cachées
	google.maps.event.addListener(markerRayon,"drag",function(){
		var newRadius = google.maps.geometry.spherical.computeDistanceBetween(markerCentre.getPosition(),this.getPosition());
		cercle.setRadius(newRadius);
		afficheOuCacheBiens();		
	});
	
	// Lorsque l'utilisateur déplace/ferme un marker ou infowindow, les markers arrêtent leur animation, et la bulle du marker de centre est enlevée
	google.maps.event.addListener(markerRayon,"drag",function(){
		if (markerCentre.getAnimation() != null)
			stopAnimationMarkers();
	});
	google.maps.event.addListener(markerRayon,"dragstart",function(){
		if (markerCentre.getAnimation() != null)
			stopAnimationMarkers();
	});
	google.maps.event.addListener(markerCentre,"dragstart",function(){
		if (markerCentre.getAnimation() != null)
			stopAnimationMarkers();
		// On mémorise l'angle entre le marker de centre et le marker de rayon
		angle = google.maps.geometry.spherical.computeHeading(markerCentre.getPosition(),markerRayon.getPosition());
	});
	google.maps.event.addListener(infoWindow,"content_changed",function(){
		if (markerCentre.getAnimation() != null)
			stopAnimationMarkers();
	});
	google.maps.event.addListener(infoWindow,"closeclick",function(){
		if (markerCentre.getAnimation() != null)
			stopAnimationMarkers();
	});
	
	// Permet de garder le centrage de la map lors du redimensionnement de la fenêtre
	google.maps.event.addListener(map,"idle",function(){
		centreMap = map.getCenter()
	});
	google.maps.event.addDomListener(window, 'resize', function() {
		map.setCenter(centreMap);
	});
	
	// Evite, lors d'un événement 'drag' d'un marker sur une surface tactile, que la map ne se déplace en même temps que celui-ci
	google.maps.event.addListener(markerCentre,'dragstart',function(){
		map.setOptions({draggable:false});
	});
	google.maps.event.addListener(markerCentre,'dragend',function(){
		map.setOptions({draggable:true});
	});
	google.maps.event.addListener(markerRayon,'dragstart',function(){
		map.setOptions({draggable:false});
	});
	google.maps.event.addListener(markerRayon,'dragend',function(){
		map.setOptions({draggable:true});
	});
}

// Crée l'ensemble des markers des biens, et calcule leurs coordonnées si nécessaire
function afficheBiens (callback)
{
	var coordonneesCalculees = 0;

	for (var i = 0; i < biens.length; i++)
	{
		// on ne calcule les coordonnées que si ça n'est pas déjà fait
		if (biens[i].coordonnees == null)
		{
			// Utilisation d'une closure où l'on capture la valeur de i (sinon la valeur est perdue le temps que la fonction asynchrone s'exécute)
			// fonction anonyme exécutée (car on a mis (i) à la fin)
			(function(index){
				chercheCoordonnees(biens[index].lieuPublic,function(coordonnees){
					creeMarkerBien(biens[index],coordonnees);
					coordonneesCalculees++;
					if (callback != null && coordonneesCalculees == biens.length)
						callback();
				});
			})(i);
		}
		else
		{
			creeMarkerBien(biens[i],getLatLng(biens[i].coordonnees));
			coordonneesCalculees++;
			if (callback != null && coordonneesCalculees == biens.length)
				callback();
		}
	}
}

// Crée et place le marker du bien passé en paramètre sur la map aux coordonnées demandées.
// Pour cela on ajoute une propriété marker à l'objet Bien contenant le marker associé au bien.
function creeMarkerBien (bien,coordonnees)
{
	bien.marker = new google.maps.Marker({
		map: map,
		position: coordonnees,
		icon: iconeMaison,
		animation: google.maps.Animation.DROP
	});
	
	// Le contenu qui sera affiché dans l'infoWindow lors du passage de la souris sur le bien
	bien.contentReduit = 
		'<h3>'+bien.titre+' - ' +bien.prix+' €</h3>'+
		bien.description
		;
	
	// Le contenu complet d'un bien, c'est-à-dire le descriptif + photos sous forme HTML
	bien.contentComplet = bien.html;
	
	// Cache le bien s'il n'est pas dans le cercle
	if (cercle.getVisible())
	{
		var distanceCentre = google.maps.geometry.spherical.computeDistanceBetween(markerCentre.getPosition(),bien.marker.getPosition());
		if (distanceCentre <= cercle.getRadius())
			bien.marker.setVisible(true);
		else
			bien.marker.setVisible(false);
	}
	
	if (!('ontouchstart' in document.documentElement))
	{
		// Lorsque la souris passe sur le marker d'un bien, une InfoWindow avec un modèle réduit de la description s'affiche
		google.maps.event.addListener(bien.marker,"mouseover",function(){
			infoWindow.setContent(bien.contentReduit);
			infoWindow.open(map,this);
			$(".photo_bien").bind("contextmenu",function(e){return false;});
		});
		
		// Fermeture de l'InfoWindow lorsque la souris quitte le marker
		google.maps.event.addListener(bien.marker,"mouseout",function(){
			infoWindow.close();
		});
	}
	
	// Affiche le bien sélectionné sous la map
	// Si un bien a déjà été sélectionné, on le réaffiche sans devoir recharger à nouveau les mêmes photos
	google.maps.event.addListener(bien.marker,"mousedown",function(){
		afficheDescriptionBien(bien);
	});
}

// Affiche les biens présents dans le cercle, et cache les autres
function afficheOuCacheBiens ()
{
	for (var i = 0; i < biens.length; i++)
	{
		var distanceCentre = google.maps.geometry.spherical.computeDistanceBetween(markerCentre.getPosition(),biens[i].marker.getPosition());
		if (distanceCentre <= cercle.getRadius())
			biens[i].marker.setVisible(true);
		else
			biens[i].marker.setVisible(false);
	}
}

function affichePhotos (tabPhotos)
{
	var res = '';
	for (i in tabPhotos)
	{
		res += '<li><a href="../../filigrane.php?image=images/biens/'+tabPhotos[i].nomImage+'.jpg">';
		res += '<img class="photo_bien" onmousedown="return false" onmousemove="return false" src="../../filigrane.php?image=images/biens/'+tabPhotos[i].nomImage+'.jpg" alt="'+tabPhotos[i].description+'"/>';
		res += '</a></li>';
	}
	return res;
}

// Affiche la description du bien passé en paramètre
// Si un bien a déjà été sélectionné, on le réaffiche sans devoir recharger à nouveau les mêmes photos
function afficheDescriptionBien (bien)
{
	var idBienActuellementAffiche = -1;
	if ($('div:visible > .photos').length > 0)
		idBienActuellementAffiche = parseInt($('div:visible > .photos').parent().attr('id').substr(5,$('div:visible > .photos').parent().attr('id').length-5));
	
	if (idBienActuellementAffiche != bien.id)
	{
		if (idBienActuellementAffiche != null)
			$('div:visible > .photos').parent().hide();
		
		// On affiche à nouveau le contenu s'il a déjà été affiché, pour éviter de recharger les photos à nouveau
		if ($.inArray(bien.id,idBiensDejaAffiches) >= 0)
		{
			$('div[id="bien-'+bien.id+'"] > .photos').parent().show();
			resizeMap();
			$('body,html').animate({ scrollTop: $('div:visible > .description').offset().top }, 400);
		}
		else
		{
			$('#ensemble').append(bien.contentComplet);
			if ($('div[id="bien-'+bien.id+'"] .ad-gallery').length == 0)
				$('div[id="bien-'+bien.id+'"] .photos').css('height','auto');
			else
			{
				$('div[id="bien-'+bien.id+'"] .ad-gallery').adGallery({
					loader_image: '../../library/ADGallery/loader.gif',
					update_window_hash: false,
					effect: 'fade',
					callbacks : {
						afterImageVisible: function() {
							this.loading(false);
						}	
					}
				});
			}
			corrigeGalleryIE();
			resizeMap();
			idBiensDejaAffiches.push(bien.id);
			$('body,html').scrollTop($('div:visible > .description').offset().top);
		}
	}
	else
		$('body,html').animate({ scrollTop: $('div:visible > .description').offset().top }, 400);
}

// Renvoie la nouvelle position où doit être placé le marker de rayon
// La position renvoyée se trouve au même angle qu'avant d'avoir commencé à déplacer le marker de centre
function calculePositionMarkerRayon ()
{
	return google.maps.geometry.spherical.computeOffset(markerCentre.getPosition(),cercle.getRadius(),angle);
}

// Renvoie l'objet LatLng correspondant aux coordonnées passées sous forme de chaîne en paramètre
// exemple: "(49.2568,87.11587)"  =>  LatLng(49.2568,87.11587)
function getLatLng (chaineCoordonnees)
{
	chaineCoordonnees = chaineCoordonnees.substring(1,chaineCoordonnees.length - 1);
	var tab = chaineCoordonnees.split(new RegExp(","));
	return new google.maps.LatLng(tab[0],tab[1]);
}

// Renvoie la chaine correspondant correspondant à l'objet LatLng passé en paramètre
// exemple: LatLng(49.2568,87.11587)  =>  "(49.2568,87.11587)"
function getChaineCoordonnees (latlng)
{
	return '(' + latlng.lat() + ',' + latlng.lng() + ')';
}

// Enregistre le lieu et ses coordonnées passés en paramètre dans la base de données
function saveCoordonnees (adresse,coordonnees)
{
	$.ajax({
		type: "POST",
		url: "save_coordonnees.php",
		data: {
			'adresse': adresse,
			'coordonnees': coordonnees
		}
	});
}

// Cherche l'adresse passée en paramètre dans la base de données, et la calcule si elle n'est pas trouvée. Exécute ensuite la fonction passée en paramètre
// callback: function (coordonnees,zoom,status)
function chercheCoordonnees (adresse,callback)
{
	if (adresse != "")
	{
		$.ajax({
			type: "POST",
			url: "get_coordonnees.php",
			data: {
				'adresse': adresse
			},
			success: function(data) {
				if (data != 'null')
					callback(getLatLng(data),13,google.maps.GeocoderStatus.OK);
				else
				{
					coordonneesLieu(adresse,function(coordonnees,zoom,status){
						callback(coordonnees,zoom,status);
					});
				}
			}
		});
	}
	else
		callback(somme,9,google.maps.GeocoderStatus.ZERO_RESULTS);
}

// Démarre l'animation des markers de cercle, et ouvre l'infoWIndow du marker de centre. L'animation dure 3 secondes.
function startAnimationMarkers ()
{
	infoWindow.setContent('Bougez-nous !');
	infoWindow.open(map,markerCentre);
	markerCentre.setAnimation(google.maps.Animation.BOUNCE);
	markerRayon.setAnimation(google.maps.Animation.BOUNCE);
	setTimeout(function(){stopAnimationMarkers();},6000);
}

// Arrête l'animation des markers de cercle, et ferme l'infoWindow du marker de centre
function stopAnimationMarkers ()
{
	markerCentre.setAnimation(null);
	markerRayon.setAnimation(null);
	infoWindow.close();
}

// On rafraichit la liste des biens grâce à une requête Ajax, puis on centre la carte sur le lieu demandé
// callback : function()
function actualiseMap (callback)
{
	var typeAnnonceTab = new Array();
	$('input[name="typeAnnonce[]"]:checked').each(function(){
		typeAnnonceTab.push($(this).val())
	});
	
	var typeBienTab = new Array();
	$('input[name="typeBien[]"]:checked').each(function(){
		typeBienTab.push($(this).val())
	});
	
	$.ajax({
		type: "POST",
		url: "recherche_biens.php",
		data: {
			'typeAnnonce[]': typeAnnonceTab,
			'typeBien[]': typeBienTab,
			'budgetMin': $('input[name="budgetMin"]').val(),
			'budgetMax': $('input[name="budgetMax"]').val(),
			'surfaceMin': $('input[name="surfaceMin"]').val(),
			'surfaceMax': $('input[name="surfaceMax"]').val(),
			'nbPiecesMin': $('input[name="nbPiecesMin"]').val(),
			'nbPiecesMax': $('input[name="nbPiecesMax"]').val(),
			'reference': $('input[name="reference"]').val(),
			'investisseur' : investisseur
		},
		dataType: 'json',
		success: function(data){
			if (data.length == 0)
				alert('Aucun bien ne correspond à votre recherche.');
			// On recentre la map et le cercle (et les markers allant avec) au lieu demandé par l'utilisateur
			// Les markers sont affichés ou non suivant si l'utisateur a rentré un lieu existant ou non (ou une chaine vide)
			chercheCoordonnees($('input[name="ville"]').val(),function(coordonnees,zoom,status){
				map.setCenter(coordonnees);
				map.setZoom(zoom);
				
				if (status == google.maps.GeocoderStatus.OK)
				{
					cercle.setCenter(coordonnees);
					markerCentre.setPosition(coordonnees);					
					markerCentre.setVisible(true);
					angle = 90;
					cercle.setRadius(rayon);
					cercle.setVisible(true);
					markerRayon.setPosition(calculePositionMarkerRayon());
					markerRayon.setVisible(true);
					if (! animationJouee)
					{
						startAnimationMarkers();
						animationJouee = true;
					}
				}
				else
				{
					if (markerCentre.getAnimation() != null)
						stopAnimationMarkers();
					markerCentre.setVisible(false);
					markerRayon.setVisible(false);
					cercle.setVisible(false);
				}
				
				// On supprime les markers des biens recherchés précédemment, puis on vide le tableau des biens précédent
				for (i in biens)
					biens[i].marker.setMap(null);
				biens.splice(0,biens.length);
				// Ajout des biens trouvés dans le tableau biens, puis création de chaque marker et InfoWindow
				for (i in data)
					biens.push(data[i]);
				
				afficheBiens(callback);
			});
		}
	});
}