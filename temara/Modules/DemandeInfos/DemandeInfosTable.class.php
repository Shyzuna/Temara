<?php
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));
require_once(realpath(__DIR__.'/../../Bien.class.php'));
require_once(realpath(__DIR__.'/../../BienTable.class.php'));
require_once(realpath(__DIR__.'/DemandeInfos.class.php'));

/*
* Classe gérant les intéractions avec la table 'demande_infos' de la BDD
*/

class DemandeInfosTable
{
	// Transforme une ligne d'un résultat de requête de la table en un objet DemandeInfos
	public static function enDemandeInfos ($ligne)
	{
		$bien = BienTable::obtientBien($ligne['idBien']);
		return (new DemandeInfos($ligne['id'],$bien,$ligne['civilite'],$ligne['nom'],$ligne['prenom'],$ligne['telephone'],$ligne['mail'],
			$ligne['commentaire'],$ligne['demandeVisite'],$ligne['lu'],$ligne['dateEnvoi']));
	}
	
	// Transforme le résultat d'une requête SELECT en un tableau d'objets DemandeInfos
	public static function enTabDemandeInfos ($query)
	{
		$res = array();
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = DemandeInfosTable::enDemandeInfos($ligne);
		}
		return $res;
	}
	
	// Ajoute une ligne à la table
	public static function addDemandeInfos ($idBien,$civilite,$nom,$prenom,$telephone,$mail,$commentaire,$demandeVisite)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO demande_infos(idBien,civilite,nom,prenom,telephone,mail,commentaire,demandeVisite)
												VALUES(:idBien,:civilite,:nom,:prenom,:telephone,:mail,:commentaire,:demandeVisite)');
			$stmt->execute(array(':idBien' => $idBien,':civilite' => $civilite,':nom' => $nom,':prenom' => $prenom,':telephone' => $telephone, 
			':mail' => $mail,':commentaire' => $commentaire,':demandeVisite' => $demandeVisite));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête DemandeInfosTable::addDemandeInfos</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime les lignes de la table dont les id sont passés en paramètre
	// @param idTab: tableau des id à supprimer ou simple id
	public static function deleteDemandesInfos ($idTab)
	{
		try
		{
			if (is_array($idTab) && count($idTab) > 0)
			{
				$query = 'DELETE FROM demande_infos WHERE ';
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
				$stmt = ConnexionBDD::getInstance()->prepare("DELETE FROM demande_infos WHERE id=:id");
				$stmt->bindValue(':id', $idTab, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête DemandeInfosTable::deleteDemandesInfos</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie l'ensemble des demandes d'informations des clients
	public static function getDemandesInfos ()
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare("SELECT * FROM demande_infos ORDER BY dateEnvoi DESC");
			$stmt->execute();
			return DemandeInfosTable::enTabDemandeInfos($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête DemandeInfosTable::getDemandesInfos</strong> :<br />' . $ex->getMessage();
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
				$query = 'UPDATE demande_infos SET lu=? WHERE ';
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
				$stmt = ConnexionBDD::getInstance()->prepare("UPDATE demande_infos SET lu=:lu WHERE id=:id");
				$stmt->execute(array(':lu' => $lu, ':id' => $idTab));
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête DemandeInfosTable::setLu</strong> :<br />' . $ex->getMessage();
		}
	}
}

?>