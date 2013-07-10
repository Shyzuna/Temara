<?php

require_once(realpath(__DIR__.'/ConnexionBDD.class.php'));

/*
* Classe gérant les intéractions avec la table 'lieu' de la BDD
*/

class LieuTable
{
	// renvoie les coordonnees de l'adresse passée en paramètre, si celle-ci n'est pas enregistrée, alors renvoie null
	public static function getCoordonnees ($adresse)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT coordonnees FROM lieu WHERE adresse=?');
			$stmt->bindValue(1,$adresse,PDO::PARAM_STR);
			$stmt->execute();
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête LieuTable::getCoordonnees</strong> :<br />' . $ex->getMessage();
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['coordonnees'];
	}
	
	// Ajoute un couple (adresse,coordonnées) passés en paramètre dans la table lieu
	public static function addCoordonnees ($adresse,$coordonnees)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO lieu(adresse,coordonnees) VALUES(?,?)');
			$stmt->bindValue(1,$adresse,PDO::PARAM_STR);
			$stmt->bindValue(2,$coordonnees,PDO::PARAM_STR);
			$stmt->execute();
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête LieuTable::addCoordonnees</strong> :<br />' . $ex->getMessage();
		}
	}
}
?>