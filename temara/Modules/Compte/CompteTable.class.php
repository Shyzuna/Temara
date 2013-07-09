<?php
require_once('Compte.class.php');
require_once('Password.class.php');
require_once(realpath(__DIR__.'/../../ConnexionBDD.class.php'));

/*
* Classe gérant les modifications de la table 'compte' de la BDD
*/

class CompteTable
{
	/*
	* Ajoute à la table un compte dont les identifiants et les informations sont passés en paramètre. Le mot de passe passé en paramètre sera haché.
	* @throws Exception: si le mail existe déjà
	* @return le compte nouvellement créé
	*/
	public static function addCompte ($mail,$password,$levelUser,$civilite,$nom,$prenom,$adresse,$codePostal,$ville,$telephone)
	{
		if (!(CompteTable::mailExists($mail)))
		{
			try
			{
				$stmt = ConnexionBDD::getInstance()->prepare('INSERT INTO compte(mail,password,levelUser,civilite,nom,prenom,adresse,codePostal,ville,telephone) 
					VALUES (:mail,:password,:levelUser,:civilite,:nom,:prenom,:adresse,:codePostal,:ville,:telephone)');
				$passwordHashed = Password::hashPassword($password);
				$stmt->bindValue(':mail',$mail,PDO::PARAM_STR);
				$stmt->bindValue(':password',$passwordHashed,PDO::PARAM_STR);
				$stmt->bindValue(':levelUser',$levelUser,PDO::PARAM_INT);
				$stmt->bindValue(':civilite',$civilite,PDO::PARAM_INT);
				$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
				$stmt->bindValue(':prenom',$prenom,PDO::PARAM_STR);
				$stmt->bindValue(':adresse',$adresse,PDO::PARAM_STR);
				$stmt->bindValue(':codePostal',$codePostal,PDO::PARAM_STR);
				$stmt->bindValue(':ville',$ville,PDO::PARAM_STR);
				$stmt->bindValue(':telephone',$telephone,PDO::PARAM_STR);
				$stmt->execute();
				
				return new Compte($mail,$levelUser,$civilite,$nom,$prenom,$adresse,$codePostal,$ville,$telephone);
			}
			catch (PDOException $ex)
			{
				echo '<br /> <strong>Erreur requête CompteTable::addCompte</strong> :<br />' . $ex->getMessage();
			}
		}
		else
			throw new Exception('Ce mail est déjà utilisé par un autre utilisateur');
	}
	
	// Renvoie le mot de passe du compte dont le mail est passé en paramètre
	public static function getPassword ($mail)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT password FROM compte WHERE mail=:mail');
			$stmt->execute(array(':mail' => $mail));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::getPassword</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Modifie le mot de passe du compte dont le mail est passé en paramètre
	public static function setPassword ($mail,$newPassword)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('UPDATE compte SET password=:password WHERE mail=:mail');
			$passwordHashed = Password::hashPassword($newPassword);
			$stmt->execute(array(':mail' => $mail,':password' => $passwordHashed));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::setPassword</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Renvoie true si le mot du passe du compte dont le mail est passé en paramètre, sinon false
	public static function verifyPassword ($mail,$password)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT password FROM compte WHERE mail=:mail');
			$stmt->bindValue(':mail',$mail,PDO::PARAM_STR);
			$stmt->execute();
			$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
			return Password::verifyPassword($password,$ligne['password']);
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::verifyPassword</strong> :<br />' . $ex->getMessage();
		}
	}
	
	// Supprime le compte dont le mail est passé en paramètre
	public static function deleteCompte ($mail)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('DELETE FROM compte WHERE mail=:mail');
			$stmt->execute(array(':mail' => $mail));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::deleteCompte</strong> :<br />' . $ex->getMessage();
		}
	}
	
	/*
	* Met à jour les paramètres du compte, autres que mail et mot de passe.
	* @param $mail: le mail du compte auquel on effectue les changements demandés.
	*/
	public static function updateCompte ($mail,$civilite,$nom,$prenom,$adresse,$codePostal,$ville,$telephone)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('UPDATE compte SET civilite=:civilite, nom=:nom, prenom=:prenom, adresse=:adresse,codePostal=:codePostal,
															ville=:ville, telephone=:telephone WHERE mail=:mail');
															
			$stmt->bindValue(':civilite',$civilite,PDO::PARAM_INT);
			$stmt->bindValue(':nom',$nom,PDO::PARAM_STR);
			$stmt->bindValue(':prenom',$prenom,PDO::PARAM_STR);
			$stmt->bindValue(':adresse',$adresse,PDO::PARAM_STR);
			$stmt->bindValue(':codePostal',$codePostal,PDO::PARAM_STR);
			$stmt->bindValue(':ville',$ville,PDO::PARAM_STR);
			$stmt->bindValue(':telephone',$telephone,PDO::PARAM_STR);
			$stmt->bindValue(':mail',$mail,PDO::PARAM_STR);
			
			$stmt->execute();
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::updateCompte</strong> :<br />' . $ex->getMessage();
		}
	}
	
	/*
	* Renvoie le compte dont le mail est passé en paramètre si le couple d'identifiants (mail,password) est vérifié.
	* @throws Exception: si le mot de passe est incorrect, ou si le mail n'existe pas, ou encore si le compte n'a pas été encore validé
	*/
	public static function getCompte ($mail,$password)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM compte WHERE mail=:mail');
			$stmt->execute(array(':mail' => $mail));
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::getCompte</strong> :<br />' . $ex->getMessage();
		}
		
		if ($stmt->rowCount() > 0)
		{
			$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
			if (Password::verifyPassword($password,$ligne['password']))
				return new Compte($mail,$ligne['levelUser'],$ligne['civilite'],$ligne['nom'],$ligne['prenom'],$ligne['adresse'],$ligne['codePostal'],$ligne['ville'],$ligne['telephone']);
			else
				throw new Exception('Votre mot de passe est invalide');
		}
		else
		{
			throw new Exception('Aucun compte n\'est relié à cette adresse mail');
		}
	}
	
	// Renvoie true si le mail passé en paramètre existe déjà dans la table, sinon false
	public static function mailExists ($mail)
	{
		try
		{
			$stmt = ConnexionBDD::getInstance()->prepare('SELECT * FROM compte WHERE mail=:mail');
			$stmt->execute(array(':mail' => $mail));
			if ($stmt->rowCount() == 1)
				return true;
			else
				return false;
		}
		catch (PDOException $ex)
		{
			echo '<br /> <strong>Erreur requête CompteTable::mailExists</strong> :<br />' . $ex->getMessage();
		}
	}
}