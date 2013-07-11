<?php
	$littlepath = strrchr($_SERVER['REQUEST_URI'],'/');
	if ($littlepath != '/index.php' and  $littlepath != '/')
		$path = '../../';
	else
		$path = './';
?>

<div id="header">
	<img src="<?php echo $path."images/banniere_temara.png";?>" />
</div>

<script type="text/javascript">
	var CheminComplet=  document.location.href;
	var CheminRepertoire= CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
	alert(CheminRepertoire);
	var path = './';
	if (CheminRepertoire != 'index.php' && CheminRepertoire != '')
		path = '../../';
	
	document.getElementById("header").style.backgroundImage = 'url('+path+'images/fond_ban.png)';
</script>