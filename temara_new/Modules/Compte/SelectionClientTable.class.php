<?php
require_once(realpath(__DIR__.'/../../Bien.class.php'));
require_once(realpath(__DIR__.'/../../BienTable.class.php'));
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));

/*
* Classe gérant les intéractions avec la table selection_client de la BDD.
* Cette table permet d'enregistrer les biens que les clients ont enregistrés à leur sélection
*/

class SelectionClientTable
{
	// Ajoute une ligne à la table
	public static function addSelection ($mailCompte,$idBien)
	{
		try
		{
			if (!(SelectionClientTable::selectionExists($mailCompte,$idBien)))
			{
				$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO selection_client(mailCompte,idBien) VALUES (:mailCompte,:idBien)');
				$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
				$stmt->bindValue(':idBien',$idBien,PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête SelectionClientTable::addSelection</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime la ligne de la table dont le mail et l'id du bien sont passés en paramètre
	public static function deleteSelection ($mailCompte,$idBien)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('DELETE FROM selection_client WHERE mailCompte=:mailCompte AND idBien=:idBien');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->bindValue(':idBien',$idBien,PDO::PARAM_INT);
			$stmt->execute();
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête SelectionClientTable::deleteSelection</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Retourne le tableau d'objets Bien sélectionnés par un client dont le mail est passé en paramètre
	public static function getSelectionsClient ($mailCompte)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT idBien FROM selection_client WHERE mailCompte=:mailCompte');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->execute();
			$arraySelect = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$res = array();
			foreach ($arraySelect as $ligne)
				$res[] = BienTable::obtientBien($ligne['idBien']);
			return $res;
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête SelectionClientTable::getSelectionsClient</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Retourne le tableau des id des biens sélectionnés par un client dont le mail est passé en paramètre
	public static function getIdSelectionsClient ($mailCompte)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT idBien FROM selection_client WHERE mailCompte=:mailCompte');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->execute();
			$res = array();
			$arraySelect = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($arraySelect as $ligne)
				$res[] = $ligne['idBien'];
			return $res;
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête SelectionClientTable::getIdSelectionsClient</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie true si le couple (mailCompte,idBien) existe déjà dans la table, sinon false
	public static function selectionExists ($mailCompte,$idBien)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM selection_client WHERE mailCompte=:mailCompte AND idBien=:idBien');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->bindValue(':idBien',$idBien,PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->rowCount() == 1;
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête SelectionClientTable::selectionExists</strong> :<br />' . $ex->getMessage();
		}
	}
}

?>