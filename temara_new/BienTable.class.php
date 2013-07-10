<?php
require_once('ConnexionBDD.class.php');
require_once('Bien.class.php');

/*
* Classe gérant les intéractions avec la table 'bien' de la BDD
*/

class BienTable
{
	// Transforme une ligne d'un résultat de requête de la table en un objet Bien
	public static function enBien ($ligne)
	{
		return (new Bien($ligne['id'],$ligne['reference'],$ligne['codePostalPublic'],$ligne['villePublique'],$ligne['lieuPublic'],$ligne['quartier'],$ligne['prix'],$ligne['titre'],
		$ligne['description'],$ligne['dateCreation'],$ligne['typeGeneral'],$ligne['typeAnnonce'],$ligne['codeAgence'],$ligne['pourInvestisseur'],$ligne['pourInvestisseurPotentiel'],$ligne['surface'],$ligne['nombrePieces'],
		$ligne['nombreChambres'],$ligne['reception'],$ligne['nombreEtages'],$ligne['terrain'],$ligne['jardin'],$ligne['exposition'],$ligne['chauffage'],
		$ligne['eau'],$ligne['gaz'],$ligne['electricite'],$ligne['assainissement'],$ligne['surfaceTerrasse'],$ligne['interphone'],$ligne['etage'],
		$ligne['ascenseur'],$ligne['surfaceConstructible'],$ligne['facade']));
	}
	
	// Transforme le résultat d'une requête en tableau d'objets Bien
	public static function enTabBiens ($query)
	{
		$res = array();
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = BienTable::enBien($ligne);
		}
		return $res;
	}
	
	public static function supprimeBien ($bien)
	{
		try
		{
			ConnexionBDD::getInstance()->exec('DELETE FROM bien WHERE id='.$bien->id.'');
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::supprimeBien</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// retourne l'objet bien dont l'id est passé en paramètre
	public static function obtientBien ($id)
	{
		$query = null;
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM bien WHERE id=?');
			$stmt->bindValue(1,$id,PDO::PARAM_INT);
			$stmt->execute();
			$query = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::obtientBien</strong> :<br />' . $ex->getMessage();
		}
		if ($query != null)
			return BienTable::enBien($query);
		else
			return null;
	}
	
	// Retourne l'objet bien dont la référence est passée en paramètre
	public static function getBien ($reference)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM bien WHERE reference=:reference');
			$stmt->bindValue(':reference',$reference,PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount() > 0)
			{
				$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
				return BienTable::enBien($ligne);
			}
			else
				return null;
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::getBien</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// retourne les derniers biens ajoutés il y a moins de 10 jours
	public static function obtientNouveautes ()
	{
		$query = null;
		try
		{
			$query = ConnexionBDD::getInstance()->query('SELECT * FROM bien WHERE dateCreation > DATE_SUB(now(), INTERVAL 10 DAY) ORDER BY dateCreation DESC');
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::obtientNouveautes</strong> :<br />' . $ex->getMessage();
		}
		return BienTable::enTabBiens($query);
	}
	
	// Retourne le tableau des villes présentes dans la base de données.
	public static function getVilles()
	{
		$query = null;
		try
		{
			$query = ConnexionBDD::getInstance()->query('SELECT DISTINCT villePublique FROM bien');
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::getVilles</strong> :<br />' . $ex->getMessage();
		}
		$res = null;
		if ($query != null)
		{
			foreach ($query as $ligne)
				$res[] = $ligne['villePublique'];
		}
		return $res;
	}
	
	// rajoute 'AND ' à la chaine si $i > 0, sinon incrémente $i et ajoute 'WHERE '
	private static function ajouteAndWhere (&$i, &$chaine)
	{
		if ($i == 0)
		{
			$chaine = ' WHERE ' . $chaine;
			$i++;
		}
		else
			$chaine = ' AND ' . $chaine;
	}
	
	// renvoie le tableau des biens satisfaisant les conditions passées en paramètre
	// @param $typeAnnonce et $typeBien : tableaux contenant les numéros des types correspondants
	// @param $specialInvestisseurs : booleen
	// @return un tableau des objets Bien satisfaisant toutes les conditions données
	public static function rechercheBiens($typeAnnonceTab,$typeBienTab,$prixMin,$prixMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$specialInvestisseurs)
	{
		$i = 0;
		
		$typeAnnonceSQL = ''; 
		$j = 0;
		foreach ($typeAnnonceTab as $t)
		{
			$s = 'typeAnnonce=?';
			if ($j == 0)
			{
				$s = '(' . $s;
				BienTable::ajouteAndWhere($i,$s);
				$j++;
			}
			else
				$s = ' OR ' . $s;
			$typeAnnonceSQL .= $s;
		}
		if ($j != 0)
			$typeAnnonceSQL .= ')';
			
		$typeBienSQL = ''; 
		$j = 0;
		foreach ($typeBienTab as $t)
		{
			$s = 'typeGeneral=?';
			if ($j == 0)
			{
				$s = '(' . $s;
				BienTable::ajouteAndWhere($i,$s);
				$j++;
			}
			else
				$s = ' OR ' . $s;
			$typeBienSQL .= $s;
		}
		if ($j != 0)
			$typeBienSQL .= ')';
			
		$prixMinSQL = '';
		if ($prixMin != "")
		{
			$prixMinSQL = 'prix>=?';
			BienTable::ajouteAndWhere($i,$prixMinSQL);
		}
			
		$prixMaxSQL = '';
		if ($prixMax != "")
		{
			$prixMaxSQL = 'prix<=?';
			BienTable::ajouteAndWhere($i,$prixMaxSQL);
		}
		
		$surfaceMinSQL = '';
		if ($surfaceMin != "")
		{
			$surfaceMinSQL = 'surface>=?';
			BienTable::ajouteAndWhere($i,$surfaceMinSQL);
		}
			
		$surfaceMaxSQL = '';
		if ($surfaceMax != "")
		{
			$surfaceMaxSQL = 'surface<=?';
			BienTable::ajouteAndWhere($i,$surfaceMaxSQL);
		}
		
		$nbPiecesMinSQL = '';
		if ($nbPiecesMin != "")
		{
			$nbPiecesMinSQL = 'nombrePieces>=?';
			BienTable::ajouteAndWhere($i,$nbPiecesMinSQL);
		}
			
		$nbPiecesMaxSQL = '';
		if ($nbPiecesMax != "")
		{
			$nbPiecesMaxSQL = 'nombrePieces<=?';
			BienTable::ajouteAndWhere($i,$nbPiecesMaxSQL);
		}
		
		$investisseurSQL = '';
		if ($specialInvestisseurs)
		{
			$investisseurSQL = '(pourInvestisseur=? OR pourInvestisseurPotentiel=?)';
			BienTable::ajouteAndWhere($i,$investisseurSQL);
		}
		else
		{
			$investisseurSQL = '(pourInvestisseur IS NULL OR pourInvestisseur=?)';
			BienTable::ajouteAndWhere($i,$investisseurSQL);
		}
		
		$query = null;
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM bien'.$typeAnnonceSQL.$typeBienSQL.$prixMinSQL.$prixMaxSQL.$surfaceMinSQL.$surfaceMaxSQL.$nbPiecesMinSQL.$nbPiecesMaxSQL.$investisseurSQL.'');
			
			$i = 1;
			foreach ($typeAnnonceTab as $t)
			{
				$stmt->bindValue($i,$t,PDO::PARAM_STR);
				$i++;
			}
			foreach ($typeBienTab as $t)
			{
				$stmt->bindValue($i,$t,PDO::PARAM_STR);
				$i++;
			}
			if ($prixMinSQL != '')
			{
				$stmt->bindValue($i,$prixMin,PDO::PARAM_INT);
				$i++;
			}
			if ($prixMaxSQL != '')
			{
				$stmt->bindValue($i,$prixMax,PDO::PARAM_INT);
				$i++;
			}
			if ($surfaceMinSQL != '')
			{
				$stmt->bindValue($i,$surfaceMin,PDO::PARAM_STR);
				$i++;
			}
			if ($surfaceMaxSQL != '')
			{
				$stmt->bindValue($i,$surfaceMax,PDO::PARAM_STR);
				$i++;
			}
			if ($nbPiecesMinSQL != '')
			{
				$stmt->bindValue($i,$nbPiecesMin,PDO::PARAM_INT);
				$i++;
			}
			if ($nbPiecesMaxSQL != '')
			{
				$stmt->bindValue($i,$nbPiecesMax,PDO::PARAM_INT);
				$i++;
			}
			if ($specialInvestisseurs)
			{
				$stmt->bindValue($i,1,PDO::PARAM_INT);
				$i++;
				$stmt->bindValue($i,1,PDO::PARAM_INT);
				$i++;
			}
			else
			{
				$stmt->bindValue($i,0,PDO::PARAM_INT);
				$i++;
			}
			
			$stmt->execute();
			$query = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête BienTable::rechercheBiens :</strong><br />' . $ex->getMessage();
		}
		
		return BienTable::enTabBiens($query);
	}
}

?>