<?php

require_once(realpath(__DIR__ .'/Contact.class.php'));
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));

/*
* Classe gérant l'intéraction avec la table 'contact' de la BDD
*/

class ContactTable
{
	// Transforme une ligne d'un résultat de requête de la table en un objet Contact
	public static function enContact ($ligne)
	{
		return (new Contact	($ligne['id'],$ligne['civilite'],$ligne['nom'],$ligne['prenom'],$ligne['telephone'],$ligne['mail'],
			$ligne['typeBien'],$ligne['etat'],$ligne['budgetMin'],$ligne['budgetMax'],$ligne['surfaceMin'],$ligne['surfaceMax'],$ligne['nbPiecesMin'],$ligne['nbPiecesMax'],
			$ligne['remarques'],$ligne['lu'],$ligne['dateEnvoi']));
	}
	
	// Transforme le résultat d'une requête SELECT en un tableau d'objets Contact
	public static function enTabContact ($query)
	{
		$res = array();
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = ContactTable::enContact($ligne);
		}
		return $res;
	}
	
	// Ajoute une ligne à la table
	public static function addContact ($civilite,$nom,$prenom,$telephone,$mail,$typeBien,$etat,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$remarques)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO contact(civilite,nom,prenom,telephone,mail,typeBien,etat,budgetMin,budgetMax,surfaceMin,surfaceMax,nbPiecesMin,nbPiecesMax,remarques)
												VALUES(:civilite,:nom,:prenom,:telephone,:mail,:typeBien,:etat,:budgetMin,:budgetMax,:surfaceMin,:surfaceMax,:nbPiecesMin,:nbPiecesMax,:remarques)');
			$stmt->bindValue(':civilite',$civilite,PDO::PARAM_INT);
			$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
			$stmt->bindValue(':prenom',$prenom,PDO::PARAM_STR);
			$stmt->bindValue(':telephone',$telephone,PDO::PARAM_STR);
			$stmt->bindValue(':mail',$mail,PDO::PARAM_STR);
			$stmt->bindValue(':typeBien',$typeBien,PDO::PARAM_STR);
			$stmt->bindValue(':etat',$etat,PDO::PARAM_INT);
			$stmt->bindValue(':budgetMin',$budgetMin,PDO::PARAM_INT);
			$stmt->bindValue(':budgetMax',$budgetMax,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMin',$surfaceMin,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMax',$surfaceMax,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMin',$nbPiecesMin,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMax',$nbPiecesMax,PDO::PARAM_INT);
			$stmt->bindValue(':remarques',$remarques,PDO::PARAM_STR);
			$stmt->execute();
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête ContactTable::addContact</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime les lignes de la table dont les id sont passés en paramètre
	// @param idTab: tableau des id à supprimer ou simple id
	public static function deleteContacts ($idTab)
	{
		try
		{
			if (is_array($idTab) && count($idTab) > 0)
			{
				$query = 'DELETE FROM contact WHERE ';
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
				$stmt = ConnexionBDD::getInstance()->prepare("DELETE FROM contact WHERE id=:id");
				$stmt->bindValue(':id', $idTab, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête ContactTable::deleteContacts</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie l'ensemble des demandes de contact des clients
	public static function getContacts ()
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare("SELECT * FROM contact ORDER BY dateEnvoi DESC");
			$stmt->execute();
			return ContactTable::enTabContact($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête ContactTable::getContacts</strong> :<br />' . $ex->getMessage();
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
				$query = 'UPDATE contact SET lu=? WHERE ';
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
				$stmt = ConnexionBDD::getInstance()->prepare("UPDATE contact SET lu=:lu WHERE id=:id");
				$stmt->execute(array(':lu' => $lu, ':id' => $idTab));
			}
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête ContactTable::setLu</strong> :<br />' . $ex->getMessage();
		}
	}
}

?>