<?php
// redimensionne l'image $filename aux dimensions $width et $height
function redimensionneImage ($filename, $width, $height)
{
	// Cacul des nouvelles dimensions
	list($width_orig, $height_orig) = getimagesize($filename);

	$ratio_orig = $width_orig/$height_orig;

	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}

	// Redimensionnement
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	// Affichage
	imagejpeg($image_p, null, 100);
}
?>