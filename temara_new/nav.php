<?php
	$littlepath = strrchr($_SERVER['REQUEST_URI'],'/');
	if ($littlepath != '/index.php' and  $littlepath != '/')
		$path = '../../';
	else
		$path = './';
?>

<div class="bouton_menu btn">Menu <i class="icon-chevron-up"></i></div>
<div id="nav">
	<ul>
		<li><a href="<?php echo $path.'index.php'; ?>" >Nouveautés</a></li>
		<li><a href="<?php echo $path.'Modules/Recherche/recherche.php'; ?>" >Nos biens</a></li>
		<li><a href="<?php echo $path.'Modules/Recherche/recherche.php?investisseur=true'; ?>">Spécial investisseurs</a></li>
		<li><a href="<?php echo $path.'Modules/Estimation/estimation.php'; ?>">Estimation et mise en vente</a></li>
		<li><a href="<?php echo $path.'Modules/Financement/financement.php'; ?>">Financement</a></li>
		<li><a href="<?php echo $path.'Modules/Contact/contact.php'; ?>">Nous contacter</a></li>
	</ul>
</div>