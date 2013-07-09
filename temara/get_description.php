<?php
header('Content-type: text/HTML; charset=UTF-8');

require_once('ConnexionBDD.class.php');
require_once('BienTable.class.php');

$id = $_GET['id'];
$bien = BienTable::obtientBien($id);

if ($bien != null)
	echo $bien->html;

?>