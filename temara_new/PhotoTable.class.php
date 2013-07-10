<?php
require_once('ConnexionBDD.class.php');
require_once('Photo.class.php');

class PhotoTable
{
	// renvoie un tableau d'objets Photo à publier du bien dont l'id est passé en paramètre
	public static function getPhotosAPublier ($idBien)
	{
		$query = null;
		try
		{
			$query = ConnexionBDD::getInstance()->query('SELECT numeroImage,nomImage,description FROM photo WHERE idBien='.$idBien.' AND publierSurInternet=1');
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête PhotoTable::getPhotosAPublier</strong> :<br />' . $ex->getMessage();
		}
		$res = array();
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = new Photo($ligne['numeroImage'],$ligne['nomImage'],$ligne['description']);
		}
		return $res;
	}
}
?>