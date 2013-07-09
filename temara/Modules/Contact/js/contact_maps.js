function initMaps()
{
	/*
	* TEMARA AMIENS
	*/

	var mapAmiensOptions = {
		zoom: 14,
		center: new google.maps.LatLng(49.898562,2.284637),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	  
	var mapAmiens = new google.maps.Map(document.getElementById("map_amiens"), mapAmiensOptions);
	
	mapAmiens.panBy(40,-80);
	
	var infoAmiens = new google.maps.InfoWindow({
		content: ' 73 rue Jules Barni<br />'
							+'80000 AMIENS<br />'
							+'Tél: 03.22.97.97.27<br /> '
							+'Fax: 03.22.97.90.81<br /> '
							+'<a href="mailto:agence.amiens@temara.fr">agence.amiens@temara.fr</a>'
	});
	
	var markerAmiens = new google.maps.Marker({
		map: mapAmiens,
		position: mapAmiens.getCenter(),
		clickable: false
	});

	infoAmiens.open(mapAmiens,markerAmiens);
	
	
	/*
	* TEMARA CORBIE
	*/

	var mapCorbieOptions = {
		zoom: 14,
		center: new google.maps.LatLng(49.908217,2.511935),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	  
	var mapCorbie = new google.maps.Map(document.getElementById("map_corbie"), mapCorbieOptions);
	
	mapCorbie.panBy(40,-80);
	
	var infoCorbie = new google.maps.InfoWindow({
		content: '18 rue Marcellin Truquin<br /> '
					+'80800 CORBIE<br /> '
					+'Tél: 03.22.96.87.52<br /> '
					+'Fax: 03.22.96.82.31<br /> '
					+'<a href="mailto:agence.corbie@temara.fr">agence.corbie@temara.fr</a>'
	});
	
	var markerCorbie = new google.maps.Marker({
		map: mapCorbie,
		position: mapCorbie.getCenter(),
		clickable: false
	});

	infoCorbie.open(mapCorbie,markerCorbie);
}