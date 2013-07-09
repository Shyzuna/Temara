$(document).ready(function(){		
	// Interdit de faire clic droit sur les photos
	$(document).on('contextmenu','.ad-gallery img, .photo_bien',function(){return false;});
	
	// Empêche de glisser/déplacer des photos
	$(document).on('mousedown','.ad-gallery img, .photo_bien',function(){return false;});
	$(document).on('mousemove','.ad-gallery img, .photo_bien',function(){return false;});
	
});