<?php
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));
require_once(realpath(__DIR__.'/Estimation.class.php'));

/*
* Classe gérant les intéractions avec la table 'estimation' de la BDD
*/

class EstimationTable
{
	// Transforme une ligne d'un résultat de requête de la table en un objet Estimation
	public static function enEstimation ($ligne)
	{
		return (new Estimation($ligne['id'],$ligne['typeBien'],$ligne['etat'],$ligne['nbPieces'],$ligne['surface'],$ligne['adresse'],$ligne['codePostal'],
			$ligne['ville'],$ligne['description'],$ligne['civilite'],$ligne['nom'],$ligne['prenom'],$ligne['telephone'],$ligne['mail'],$ligne['commentaire'],
			$ligne['lu'],$ligne['dateEnvoi']));
	}
	
	// Transforme le résultat d'une requête SELECT en un tableau d'objets Estimation
	public static function enTabEstimations ($query)
	{
		$res = array();
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = EstimationTable::enEstimation($ligne);
		}
		return $res;
	}
	
	// Ajoute une ligne à la table
	public static function addEstimation ($typeBien,$etat,$nbPieces,$surface,$adresse,$codePostal,$ville,$description,$civilite,$nom,$prenom,$telephone,$mail,$commentaire)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO estimation(typeBien,etat,nbPieces,surface,adresse,codePostal,ville,description,
						civilite,nom,prenom,telephone,mail,commentaire) VALUES(:typeBien,:etat,:nbPieces,:surface,:adresse,:codePostal,:ville,
						:description,:civilite,:nom,:prenom,:telephone,:mail,:commentaire)');
												
			$stmt->execute(array(':typeBien' => $typeBien,':etat' => $etat,':nbPieces' => $nbPieces,':surface' => $surface,':adresse' => $adresse,':codePostal' => $codePostal,
						':ville' => $ville,':description' => $description,':civilite' => $civilite,':nom' => $nom,':prenom' => $prenom,':telephone' => $telephone,
						':mail' => $mail,':commentaire' => $commentaire));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête EstimationTable::addEstimation</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime les lignes de la table dont les id sont passés en paramètre
	// @param idTab: tableau des id à supprimer ou simple id
	public static function deleteEstimations ($idTab)
	{
		try
		{
			if (is_array($idTab) && count($idTab) > 0)
			{
				$query = 'DELETE FROM estimation WHERE ';
				for ($i = 0; $i < count($idTab); $i++)
				{
					if ($i > 0)
						$query .= ' OR ';
					$query .= 'id=?';
				}
				$stmt = ConnexionBDD::getInstance()->prepare($query);
				
				for ($i = 0; $i < count($idTab); $i++)
				{
					$stmt->bindValue($i+1,$idTab[$i],PDO::PARAM_INT);
				}
				$stmt->execute();
			}
			else if (is_numeric($idTab))
			{
				$stmt = ConnexionBDD::getInstance()->prepare("DELETE FROM estimation WHERE id=:id");
				$stmt->bindValue(':id', $idTab, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête EstimationTable::deleteEstimations</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie l'ensemble des demandes d'estimation des clients
	public static function getEstimations ()
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare("SELECT * FROM estimation ORDER BY dateEnvoi DESC");
			$stmt->execute();
			return EstimationTable::enTabEstimations($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête EstimationTable::getEstimations</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Met la colonne 'lu' à 0 ou 1 des demandes dont les id sont passés en paramètre
	// @param idTab: tableau des id à supprimer ou simple id
	public static function setLu ($idTab,$lu)
	{
		try
		{
			if (is_array($idTab) && count($idTab) > 0)
			{
				$query = 'UPDATE estimation SET lu=? WHERE ';
				for ($i = 0; $i < count($idTab); $i++)
				{
					if ($i > 0)
						$query .= ' OR ';
					$query .= 'id=?';
				}
				$stmt = ConnexionBDD::getInstance()->prepare($query);
				$stmt->bindValue(1,$lu,PDO::PARAM_INT);
				for ($i = 0; $i < count($idTab); $i++)
				{
					$stmt->bindValue($i+2,$idTab[$i],PDO::PARAM_INT);
				}
				$stmt->execute();
			}
			else if (is_numeric($idTab))
			{
				$stmt = ConnexionBDD::getInstance()->prepare("UPDATE estimation SET lu=:lu WHERE id=:id");
				$stmt->execute(array(':lu' => $lu, ':id' => $idTab));
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête EstmationTable::setLu</strong> :<br />' . $ex->getMessage();
		}
	}
}

?>