<?php

/*
* Classe définissant un Contact, c'est-à-dire une demande de contact envoyée par un utilisateur dans le formulaire de contact.php
*/

class Contact
{
	public $id;
	public $civilite;    // (1 <-> M. / 2 <-> Mme / 3 <-> Mlle)
	public $nom;
	public $prenom;
	public $telephone;
	public $mail;
	public $typeBien;
	public $etat;		// (1 <-> A vendre / 2 <-> A louer)
	public $budgetMin;
	public $budgetMax;
	public $surfaceMin;
	public $surfaceMax;
	public $nbPiecesMin;
	public $nbPiecesMax;
	public $remarques;
	public $lu;         // 1 si l'agence a lu la demande, sinon 0
	public $dateEnvoi;
	
	public function Contact ($id,$civilite,$nom,$prenom,$telephone,$mail,$typeBien,$etat,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,
								$nbPiecesMax,$remarques,$lu,$dateEnvoi)
	{
		$this->id = $id;
		$this->civilite = $civilite;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->telephone = $telephone;
		$this->mail = $mail;
		$this->typeBien = $typeBien;
		$this->etat = $etat;
		$this->budgetMin = $budgetMin;
		$this->budgetMax = $budgetMax;
		$this->surfaceMin = $surfaceMin;
		$this->surfaceMax = $surfaceMax;
		$this->nbPiecesMin = $nbPiecesMin;
		$this->nbPiecesMax = $nbPiecesMax;
		$this->remarques = $remarques;
		$this->lu = $lu;
		$this->dateEnvoi = $dateEnvoi;
	}
}

?>