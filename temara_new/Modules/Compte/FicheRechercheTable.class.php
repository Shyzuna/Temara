<?php

require_once(realpath(__DIR__.'/FicheRecherche.class.php'));
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));

/*
* Classe gérant l'interaction avec la table fiche_recherche de la BDD
*/

class FicheRechercheTable
{
	// Transforme une ligne d'un jeu de résultats de l'objet PDOStatement en un objet FicheRecherche et le renvoie
	public static function enFiche ($ligne)
	{
		return new FicheRecherche($ligne['id'],$ligne['nom'],$ligne['mailCompte'],unserialize($ligne['typeAnnonce']),unserialize($ligne['typeBien']),
			$ligne['budgetMin'],$ligne['budgetMax'],$ligne['surfaceMin'],$ligne['surfaceMax'],$ligne['nbPiecesMin'],$ligne['nbPiecesMax'],
			$ligne['ville'],$ligne['investisseur']);
	}
	
	/*
	* Ajoute une ligne à la table
	* @param typeBienTab et typeAnnonceTab : tableaux d'entiers
	*/
	public static function addFiche ($mailCompte,$nom,$typeAnnonceTab,$typeBienTab,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$ville,$investisseur)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO fiche_recherche(mailCompte,nom,typeAnnonce,typeBien,budgetMin,budgetMax,surfaceMin,surfaceMax,nbPiecesMin,nbPiecesMax,ville,investisseur)
											VALUES (:mailCompte,:nom,:typeAnnonce,:typeBien,:budgetMin,:budgetMax,:surfaceMin,:surfaceMax,:nbPiecesMin,:nbPiecesMax,:ville,:investisseur)');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
			$stmt->bindValue(':typeAnnonce',serialize($typeAnnonceTab),PDO::PARAM_STR);
			$stmt->bindValue(':typeBien',serialize($typeBienTab),PDO::PARAM_STR);
			$stmt->bindValue(':budgetMin',$budgetMin,PDO::PARAM_INT);
			$stmt->bindValue(':budgetMax',$budgetMax,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMin',$surfaceMin,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMax',$surfaceMax,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMin',$nbPiecesMin,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMax',$nbPiecesMax,PDO::PARAM_INT);
			$stmt->bindValue(':ville',$ville,PDO::PARAM_STR);
			$stmt->bindValue(':investisseur',$investisseur,PDO::PARAM_INT);
			
			$stmt->execute();
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::addFiche</strong> :<br />' . $ex->getMessage();
		}
	}
	
	/*
	* Met à jour la ligne de la table dont l'id est passé en paramètre
	* @param typeBienTab et typeAnnonceTab : tableaux d'entiers
	*/
	public static function updateFiche ($id,$nom,$typeAnnonceTab,$typeBienTab,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$ville,$investisseur)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('UPDATE fiche_recherche SET nom=:nom,typeAnnonce=:typeAnnonce,typeBien=:typeBien,budgetMin=:budgetMin,budgetMax=:budgetMax,
															surfaceMin=:surfaceMin,surfaceMax=:surfaceMax,nbPiecesMin=:nbPiecesMin,nbPiecesMax=:nbPiecesMax,ville=:ville,investisseur=:investisseur
															WHERE id=:id');
			$stmt->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
			$stmt->bindValue(':typeAnnonce',serialize($typeAnnonceTab),PDO::PARAM_STR);
			$stmt->bindValue(':typeBien',serialize($typeBienTab),PDO::PARAM_STR);
			$stmt->bindValue(':budgetMin',$budgetMin,PDO::PARAM_INT);
			$stmt->bindValue(':budgetMax',$budgetMax,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMin',$surfaceMin,PDO::PARAM_INT);
			$stmt->bindValue(':surfaceMax',$surfaceMax,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMin',$nbPiecesMin,PDO::PARAM_INT);
			$stmt->bindValue(':nbPiecesMax',$nbPiecesMax,PDO::PARAM_INT);
			$stmt->bindValue(':ville',$ville,PDO::PARAM_STR);
			$stmt->bindValue(':investisseur',$investisseur,PDO::PARAM_INT);
			
			$stmt->execute();
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::updateFiche</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime la ligne de la table dont l'id est passé en paramètre
	public static function deleteFiche ($id)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('DELETE FROM fiche_recherche WHERE id=:id');
			$stmt->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::deleteFiche</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Retourne l'objet FicheRecherche de la ligne dont l'id est passée en paramètre, et renvoie null si n'existe pas
	public static function getFiche ($id)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM fiche_recherche WHERE id=:id');
			$stmt->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			
			if ($stmt->rowCount() == 1)
			{
				$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
				return FicheRechercheTable::enFiche($ligne);
			}
			else
				return null;
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::getFiche</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie un tableau de fiches de recherche d'un utilisateur dont le mail est passé en paramètre
	public static function getFichesUser ($mailCompte)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM fiche_recherche WHERE mailCompte=:mailCompte');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->execute();
			
			$res = array();
			foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ligne)
				$res[] = FicheRechercheTable::enFiche($ligne);
			return $res;
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::getFichesUser</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie le nombre de fiches de recherches créées par l'utilisateur dont le mail est passé en paramètre
	public static function nbFiches ($mailCompte)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT COUNT(*) AS nb FROM fiche_recherche WHERE mailCompte=:mailCompte');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->execute();
			
			$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
			return $ligne['nb'];
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::nbFiches</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie true si le nom de la recherche a déjà été donnée à l'utilisateur dont le mail est passé en paramètre, sinon false
	public static function nomFicheExiste ($nom,$mailCompte)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT COUNT(*) AS nb FROM fiche_recherche WHERE mailCompte=:mailCompte AND nom=:nom');
			$stmt->bindValue(':mailCompte',$mailCompte,PDO::PARAM_STR);
			$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
			$stmt->execute();
			
			$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
			return $ligne['nb'] > 0;
		}
		catch (Exception $ex)
		{
			echo '<br /> <strong>Erreur requête FicheRechercheTable::nbFiches</strong> :<br />' . $ex->getMessage();
		}
	}
}

?>