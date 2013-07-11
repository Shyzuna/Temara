<?php

/*
* Classe définissant une demande d'estimation ou de mise en vente d'un bien
*/

class Estimation
{
	public $id;
	public $typeBien;   // Maison, Appartement etc...
	public $etat;   	// 1 <-> A vendre / 2 <-> A louer
	public $nbPieces;
	public $surface;
	public $adresse;	// adresse (numéro ou/et rue) ou quartier
	public $codePostal;
	public $ville;
	public $description;
	public $civilite;	// 1 <-> M. / 2 <-> Mme / 3 <-> Mlle
	public $nom;
	public $prenom;
	public $telephone;
	public $mail;
	public $commentaire;
	public $lu;
	public $dateEnvoi;
	
	public function Estimation ($id,$typeBien,$etat,$nbPieces,$surface,$adresse,$codePostal,$ville,$description,$civilite,$nom,$prenom,$telephone,$mail,$commentaire,$lu,$dateEnvoi)
	{
		$this->id = $id;
		$this->typeBien = $typeBien;
		$this->etat = $etat;
		$this->nbPieces = $nbPieces;
		$this->surface = $surface;
		$this->adresse = $adresse;
		$this->codePostal = $codePostal;
		$this->ville = $ville;
		$this->description = $description;
		$this->civilite = $civilite;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->telephone = $telephone;
		$this->mail = $mail;
		$this->commentaire = $commentaire;
		$this->lu = $lu;
		$this->dateEnvoi = $dateEnvoi;
	}
}

?>