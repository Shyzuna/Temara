<?php
$path = __DIR__;
require_once(realpath($path.'/../../ConnexionBDD.class.php'));
require_once(realpath($path.'/SelectionClientTable.class.php'));

/*
* Classe définissant un Compte utilisateur
*/

class Compte
{
	public $mail;
	public $levelUser;  // 0 -> "simple" utilisateur, 1 -> admin
	public $civilite;
	public $nom;        // 1 <-> M. / 2 <-> Mme / 3 <-> Mlle
	public $prenom;
	public $adresse;
	public $codePostal;
	public $ville;
	public $telephone;
	public $tabIdSelections;   // le tableau des id des biens sélectionnés
	
	public function Compte ($mail,$levelUser,$civilite,$nom,$prenom,$adresse,$codePostal,$ville,$telephone)
	{
		$this->mail = $mail;
		$this->levelUser = $levelUser;
		$this->civilite = $civilite;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->adresse = $adresse;
		$this->codePostal = $codePostal;
		$this->ville = $ville;
		$this->telephone = $telephone;
		$this->tabIdSelections = SelectionClientTable::getIdSelectionsClient($mail);
	}
	
	// Ajoute le bien, dont l'id est passé en paramètre, au tableau des sélections
	public function addIdSelection ($id)
	{
		$this->tabIdSelections[] = $id;
	}
	
	// Supprime le bien, dont l'id est passé en paramètre, du tableau des sélections
	public function deleteIdSelection ($id)
	{
		foreach ($this->tabIdSelections as $key => $val)
		{
			if ($val == $id)
				unset($this->tabIdSelections[$key]);
		}
	}
}

?>