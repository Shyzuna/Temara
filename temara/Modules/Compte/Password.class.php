<?php

/*
* Classe gérant le hachage et la vérification des mots de passe
*/

class Password
{
	/*
	* Renvoie une chaine représentant le mot de passe haché par l'algortihme Blowfish.
	* @param $password: le motde passe à hacher
	* @return une chaine représentant le mot de passe haché concaténé à un sel généré aléatoirement
	*/
	public static function hashPassword ($password)
	{
		$salt = Password::saltRandom();
		$passwordHashed = crypt($password,$salt);
		return $passwordHashed . $salt;
	}
	
	/*
	* Vérifie si $password correspond bien au mot de passe haché
	* @param $password: le mot de passe à vérifier (par exemple celui entré par l'utilisateur)
	* @param $passwordHashedWithSalt: le mot de passe haché, concaténé au sel ayant servi à le hacher, à comparer à $password
	* @return true si les mots de passe sont identiques, sinon false
	*/
	public static function verifyPassword ($password,$passwordHashedWithSalt)
	{
		$passwordHashed = substr($passwordHashedWithSalt,0,count($passwordHashedWithSalt)-30);
		$salt = substr($passwordHashedWithSalt,count($passwordHashedWithSalt)-30,29);
		if (crypt($password, $salt) == $passwordHashed)
			return true;
		else
			return false;
	}
	
	// Renvoie un mot de passe de 10 caractères généré aléatoirement et contenant des caractères alphanumériques
	public static function generatePassword ()
	{
		$caracteres = array();
		for ($i = 48; $i <= 57; $i++)
			$caracteres[] = chr($i);
		for ($i = 65; $i <= 90; $i++)
			$caracteres[] = chr($i);
		for ($i = 97; $i <= 122; $i++)
			$caracteres[] = chr($i);
		
		$res = '';
		for ($i = 1; $i <= 10; $i++)
			$res .= $caracteres[rand(0,count($caracteres)-1)];
		
		return $res;
	}
	
	// Renvoie un sel aléatoire de longueur 29 permettant d'utiliser l'algortihme Blowfish pour le hachage
	private static function saltRandom ()
	{
		// Les caractères doivent faire parti de l'alphabet "./0-9A-Za-z"
		$caracteres = array();
		for ($i = 46; $i <= 57; $i++)
			$caracteres[] = chr($i);
		for ($i = 65; $i <= 90; $i++)
			$caracteres[] = chr($i);
		for ($i = 97; $i <= 122; $i++)
			$caracteres[] = chr($i);
		
		$res = "";
		for ($i = 1; $i <= 22; $i++)
			$res .= $caracteres[rand(0,count($caracteres)-1)];
			
		return '$2y$10$'.$res;
	}
}

?>