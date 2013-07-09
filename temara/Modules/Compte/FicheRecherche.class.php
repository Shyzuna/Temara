<?php

/*
* Classe de définition d'une fiche de recherche. Une fiche de recherche permet à un utilisateur doté d'un compte de sauvegarder ses critères 
* de recherche.
*/

class FicheRecherche
{
	public $id;
	public $nom;
	public $mailCompte;
	public $typeAnnonceTab;  // Tableau d'entiers ( 1 <-> Vente , 2 <-> Location )
	public $typeBienTab;     // Tableau d'entiers ( 1 <-> Maison , 2 <-> Appartement , 3 <-> Terrain , 4 <-> Garage )
	public $budgetMin;
	public $budgetMax;
	public $surfaceMin;
	public $surfaceMax;
	public $nbPiecesMin;
	public $nbPiecesMax;
	public $ville;
	public $investisseur;   // 1 <-> investisseur
	
	public function FicheRecherche ($id,$nom,$mailCompte,$typeAnnonceTab,$typeBienTab,$budgetMin,$budgetMax,$surfaceMin,$surfaceMax,$nbPiecesMin,$nbPiecesMax,$ville,$investisseur)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->mailCompte = $mailCompte;
		$this->typeAnnonceTab = $typeAnnonceTab;
		$this->typeBienTab = $typeBienTab;
		$this->budgetMin = $budgetMin;
		$this->budgetMax = $budgetMax;
		$this->surfaceMin = $surfaceMin;
		$this->surfaceMax = $surfaceMax;
		$this->nbPiecesMin = $nbPiecesMin;
		$this->nbPiecesMax = $nbPiecesMax;
		$this->ville = $ville;
		$this->investisseur = $investisseur;
	}
}

?>