<?php

/*
* La classe gérant la connexion à la base de données.
* Patron de conception Singleton utilisé pour éviter d'avoir plusieurs instances de connexion à la base.
*/
class ConnexionBDD
{
	private static $connexion = null;
	
	private function ConnexionBDD () {}
	
	public static function getInstance ()
	{
		if (is_null(self::$connexion))
		{
			$connexion = new PDO('mysql:host=localhost;dbname=temara','root','');
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$connexion->exec("SET CHARACTER SET utf8");
		}
		
		return $connexion;
	}
}

?>