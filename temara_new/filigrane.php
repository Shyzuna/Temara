<?php
header ("Content-type: image/jpeg");
//on teste si une image est passée en paramètre
if(isset($_GET['image'])){
//On applique le FILIGRANE

$size = getimagesize($_GET['image']);
$filigrane = "TEMARA";
$font = "images/arial.ttf"; // Police utilisée pour écrire le filigrane
$t; // Taille de la police
$x; // abscisse
$y; // ordonnée
if ($size[0] > $size[1])
{
	$t = $size[0] / 8.5;
	$x = $size[0] / 3 - $t;
	$y = $size[1] / 2 + $t;
}
else
{
	$t = $size[1] / 8.5;
	$x = ($size[0] / 4) - $t;
	$y = $size[1] / 2 + $t;
}

$image=imagecreatefromjpeg($_GET['image']);
$couleur_text = imagecolorallocatealpha($image, 218, 165, 32, 30);

// On applique le texte à l'image
imagettftext($image, $t, 0, $x, $y, $couleur_text, $font, $filigrane);

// L'image s'affiche
imagejpeg($image);

//On supprime l'image pour libérer la mémoire
imagedestroy($image);

}
?>
