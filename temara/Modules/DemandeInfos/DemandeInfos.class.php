<?php

/*
* Classe définissant une demande d'informations d'un utilisateur au sujet d'un bien
*/

class DemandeInfos
{
	public $id;
	public $bien;
	public $civilite;	// (1 <-> M. / 2 <-> Mme / 3 <-> Mlle)
	public $nom;
	public $prenom;
	public $telephone;
	public $mail;
	public $commentaire;
	public $demandeVisite;
	public $lu;         // 1 si l'agence a lu la demande, sinon 0
	public $dateEnvoi;
	
	public function DemandeInfos ($id,$bien,$civilite,$nom,$prenom,$telephone,$mail,$commentaire,$demandeVisite,$lu,$dateEnvoi)
	{
		$this->id = $id;
		$this->bien = $bien;
		$this->civilite = $civilite;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->telephone = $telephone;
		$this->mail = $mail;
		$this->commentaire = $commentaire;
		$this->demandeVisite = $demandeVisite;
		$this->lu = $lu;
		$this->dateEnvoi = $dateEnvoi;
	}
}

?>