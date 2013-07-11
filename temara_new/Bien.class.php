<?php
if (!(isset($_SESSION)))
	session_start();

require_once(realpath(__DIR__.'/ConnexionBDD.class.php'));
require_once(realpath(__DIR__.'/redimension_image.php'));
require_once(realpath(__DIR__.'/Photo.class.php'));
require_once(realpath(__DIR__.'/PhotoTable.class.php'));
require_once(realpath(__DIR__.'/Modules/Recherche/LieuTable.class.php'));
require_once(realpath(__DIR__.'/Modules/Compte/Compte.class.php'));

class Bien
{
	public $id;
	public $reference;
	public $codePostalPublic;
	public $villePublique;
	public $lieuPublic;
	public $quartier;
	public $prix;
	public $titre;
	public $description;
	public $dateCreation;
	public $typeGeneral; // ( 1 Maison / 2 Appartement / 3 Terrain / 4 Garage)
	public $typeAnnonce; // ( 1 Vente / 2 Location )
	public $codeAgence; // 80TEMAAM  <--> Agence d'Amiens  /  80TEMACO  <-->  Agence de Corbie
	public $pourInvestisseur;
	public $pourInvestisseurPotentiel;
	public $surface;
	public $nombrePieces;
	public $nombreChambres;
	public $reception;
	public $nombreEtages;
	public $terrain;
	public $jardin;
	public $exposition;
	public $chauffage;
	public $eau;
	public $gaz;
	public $electricite;
	public $assainissement;
	public $tabPhotos;
	public $coordonnees;
	public $surfaceTerrasse;
	public $interphone;
	public $etage;
	public $ascenseur;
	public $surfaceConstructible;
	public $facade;
	
	public $html;
	
	public function Bien ($id,$reference,$codePostal,$ville,$lieuPublic,$quartier,$prix,$titre,$description,$dateCreation,$typeGeneral,$typeAnnonce,$codeAgence,$pourInvestisseur,$pourInvestisseurPotentiel,
							$surface,$nombrePieces,$nombreChambres,$reception,$nombreEtages,$terrain,$jardin,$exposition,$chauffage,$eau,$gaz,$electricite,$assainissement,
							$surfaceTerrasse,$interphone,$etage,$ascenseur,$surfaceConstructible,$facade)
	{
		$this->id = $id;
		$this->reference = $reference;
		$this->codePostalPublic = $codePostal;
		$this->villePublique = $ville;
		$this->lieuPublic = $lieuPublic;
		$this->quartier = $quartier;
		$this->prix = $prix;
		$this->titre = $titre;
		$this->description = $description;
		$this->dateCreation = $dateCreation;
		$this->typeGeneral = $typeGeneral;
		$this->typeAnnonce = $typeAnnonce;
		$this->codeAgence = $codeAgence;
		$this->pourInvestisseur = $pourInvestisseur;
		$this->pourInvestisseurPotentiel = $pourInvestisseurPotentiel;
		$this->surface = $surface;
		$this->nombrePieces = $nombrePieces;
		$this->nombreChambres = $nombreChambres;
		$this->reception = $reception;
		$this->nombreEtages = $nombreEtages;
		$this->terrain = $terrain;
		$this->jardin = $jardin;
		$this->exposition = $exposition;
		$this->chauffage = $chauffage;
		$this->eau = $eau;
		$this->gaz = $gaz;
		$this->electricite = $electricite;
		$this->assainissement = $assainissement;
		$this->surfaceTerrasse = $surfaceTerrasse;
		$this->interphone = $interphone;
		$this->etage = $etage;
		$this->ascenseur = $ascenseur;
		$this->surfaceConstructible = $surfaceConstructible;
		$this->facade = $facade;
		
		$this->tabPhotos = PhotoTable::getPhotosAPublier($id);
		$this->coordonnees = LieuTable::getCoordonnees($lieuPublic);
		$this->html = Bien::getHTML();
	}

	// Renvoie la chaine permettant d'afficher l'ensemble des photos
	public function affichePhotos ()
	{
		$res = "";
		if (count($this->tabPhotos) > 0)
		{
			foreach ($this->tabPhotos as $photo)
			{
				// On vérifie que la photo existe bien
				// $emplacementPossible1 : pour index.php
				// $emplacementPossible2 : pour maps.php
				$emplacementPossible1 = 'images/biens/'.$photo->nomImage.'.jpg';
				$emplacementPossible2 = '../../images/biens/'.$photo->nomImage.'.jpg';
				$exists = file_exists($emplacementPossible1) || file_exists($emplacementPossible2);
				
				if ($exists)
				{
					$res .= '<li><a href="http://localhost:8080/temara/filigrane.php?image=images/biens/'.$photo->nomImage.'.jpg">';
					$res .= '<img class="photo_bien" src="http://localhost:8080/temara/filigrane.php?image=images/biens/'.$photo->nomImage.'.jpg" alt="'.$photo->description.'"/>';
					$res .= '</a></li>';
				}
			}
		}
		else
			$res .= '<p style="text-align:center;"><strong>Pas de photo disponible pour ce bien</strong></p>';
		return $res;
	}
	
	// Renvoie la chaîne permettant d'afficher la photo principale du bien
	public function affichePhotoPrincipale ()
	{
		// On vérifie que la photo existe bien
		if (isset($this->tabPhotos[0]))
		{
			$emplacementPossible1 = 'images/biens/'.$this->tabPhotos[0]->nomImage.'.jpg';
			$emplacementPossible2 = '../../images/biens/'.$this->tabPhotos[0]->nomImage.'.jpg';
			$exists = file_exists($emplacementPossible1) || file_exists($emplacementPossible2);
		}
		else
			$exists = false;
		
		$res = "";
		if ($exists)
			$res .= '<img class="photo_bien" id="photo-'.$this->id.'" src="http://localhost:8080/temara/filigrane.php?image=images/biens/'.$this->tabPhotos[0]->nomImage.'.jpg" alt="photo bien" />';
		else
			$res .= '<img class="photo_bien" id="photo-'.$this->id.'" src="http://localhost:8080/temara/images/image-defaut.jpg" alt="photo bien" />';
		return $res;
	}
	
	// Renvoie la chaîne permettant la mise en forme du bien en 2 cadres: photos et descriptif
	public function getHTML()
	{
		$res = '<div id="bien-'.$this->id.'" class="html_bien">';
		
		$res .= '<div class="description cadre">';
		$res .= '<h4>'.$this->titre.'<br />';
		$res .= $this->villePublique.'</h4>';
		$res .= '<p class="description_right prix">'.$this->prix.' €</p>';
		$res .= '<p><span class="section_description">Référence :</span> '.$this->reference.'</p>';
		$res .= '<p><span class="section_description">Description :</span> '.$this->description.'</p>';
		
		$res .= '<p class="details">';
		if (isset($this->surface) && $this->surface != "")
			$res .= Bien::detailHTML('Surface',$this->surface,'m²');
		if (isset($nombrePieces) && $nombrePieces != 0)
			$res .= Bien::detailHTML('Nombre de pièces',$this->nombrePieces);
		if (isset($this->nombreChambres) && $this->nombreChambres != 0)
			$res .= Bien::detailHTML('Nombre de chambres',$this->nombreChambres);
		if (isset($this->nombreEtages) && $this->nombreEtages != 0)
			$res .= Bien::detailHTML('Nombre d\'étages',$this->nombreEtages);
		if (isset($this->reception) && $this->reception != "")
			$res .= Bien::detailHTML('Réception',$this->reception,'m²');
		if (isset($this->terrain) && $this->terrain != "")
			$res .= Bien::detailHTML('Terrain',$this->terrain,'m²');
		if (isset($this->jardin) && $this->jardin != "")
			$res .= Bien::detailHTML('Jardin',$this->jardin,'m²');
		if (isset($this->surfaceTerrasse) && $this->surfaceTerrasse != "")
			$res .= Bien::detailHTML('Terrasse',$this->surfaceTerrasse,'m²');
		if (isset($this->exposition) && $this->exposition != "")
			$res .= Bien::detailHTML('Exposition',$this->exposition);
		if (isset($this->chauffage) && $this->chauffage != "")
			$res .= Bien::detailHTML('Chauffage',$this->chauffage);
		if (isset($this->eau))
		{
			if ($this->eau == 0)
				$res .= Bien::detailHTML('Eau','Non');
			else
				$res .= Bien::detailHTML('Eau','Oui');
		}
		if (isset($this->gaz))
		{
			if ($this->gaz == 0)
				$res .= Bien::detailHTML('Gaz','Non');
			else
				$res .= Bien::detailHTML('Gaz','Oui');
		}
		if (isset($this->electricite))
		{
			if ($this->electricite == 0)
				$res .= Bien::detailHTML('Electricité','Non');
			else
				$res .= Bien::detailHTML('Electricité','Oui');
		}
		if (isset($this->assainissement))
		{
			if ($this->assainissement == 0)
				$res .= Bien::detailHTML('Assainissement','Non');
			else
				$res .= Bien::detailHTML('Assainissement','Oui');
		}
		if (isset($this->interphone))
		{
			if ($this->interphone == 0)
				$res .= Bien::detailHTML('Interphone','Non');
			else
				$res .= Bien::detailHTML('Interphone','Oui');
		}
		if (isset($this->ascenseur))
		{
			if ($this->ascenseur == 0)
				$res .= Bien::detailHTML('Ascenseur','Non');
			else
				$res .= Bien::detailHTML('Ascenseur','Oui');
		}
		if (isset($this->etage))
		{
			if ($this->etage == 0)
				$res .= Bien::detailHTML('Etage','Non');
			else
				$res .= Bien::detailHTML('Etage','Oui');
		}
		if (isset($this->surfaceConvertible) && $this->surfaceConvertible != "")
			$res .= Bien::detailHTML('Surface convertible',$this->surfaceConvertible,'m²');
		if (isset($this->facade) && $this->facade != "")
			$res .= Bien::detailHTML('Largeur façade',$this->surface,'m');
		$res .= '</p>';
		
		$res .= '<p class="description_right agence">';
		if ($this->codeAgence == '80TEMACO')
			$res .= '<strong>TEMARA Corbie</strong><br />18 rue Marcelin Truquin<br />80800 Corbie<br />03.22.96.87.52';
		else if ($this->codeAgence == '80TEMAAM')
			$res .= '<strong>TEMARA Amiens</strong><br />73 rue Jules Barni<br />80000 Amiens<br />03.22.97.97.27';
		$res .= '</p>';
		
		$res .= '<div class="icones_description">';
		
		$res .= '<a href="http://localhost:8080/temara/Modules/DemandeInfos/demande_informations.php?id='.$this->id.'"><img src="http://localhost:8080/temara/images/point-interrogation.png" alt="question" title="Questions/Demande de visite" /></a>';
		$res .= '<a media="print" class="btn-print" onclick="window.print()"><img src="http://localhost:8080/temara/images/imprimante.png" alt="Imprimer" title="Imprimer cette fiche" /></a>';
		
		$res .= '<form action="http://localhost:8080/temara/Modules/Recherche/maps.php" method="post" class="form_icon_map">';
		$res .= '<input type="hidden" name="reference" value="'.$this->reference.'" />';
		$res .= '<input type="image" src="http://localhost:8080/temara/images/marker.png" title="Voir la situation géographique" alt="Voir la situation géographique" />';
		$res .= '</form>';
		
		if (isset($_SESSION['compte']))
			$compte = unserialize($_SESSION['compte']);
		
		if (isset($_SESSION['compte']) && in_array($this->id,$compte->tabIdSelections))
			$res .= '<img class="etoile etoile-jaune" title="Supprimer ce bien de votre sélection" src="http://localhost:8080/temara/images/etoile-jaune.png" alt="Supprimer ce bien de votre sélection" />';
		else
			$res .= '<img class="etoile etoile-blanche" title="Ajouter ce bien à votre sélection" src="http://localhost:8080/temara/images/etoile-blanche.png" alt="Cliquer pour ajouter ce bien à votre sélection" />';
		
		$res .= '</div>';
		
		$res .= '</div>';
		
		
		$res .= '<div class="photos cadre">';
		if (count($this->tabPhotos) > 0)
		{
			$res .= '<div class="ad-gallery">';
			$res .= '<div class="ad-image-wrapper" onmousedown="return false" onmousemove="return false"></div>';
			$res .= '<div class="ad-nav">';
			$res .= '<div class="ad-thumbs">';
			$res .= '<ul class="ad-thumb-list">';
		}
		$res .= $this->affichePhotos();
		if (count($this->tabPhotos) > 0)
		{
			$res .= '</ul>';
			$res .= '</div>';
			$res .= '</div>';
			$res .= '</div>';
		}
		$res .= '</div>';
		$res .= '</div>';
		
		return $res;
	}
	
	// Renvoie le code HTML du détail dont le titre, la valeur, et l'éventuelle unité sont passés en paramètre.
	// @param $titre: le "nom" du détail, ce qui est à gauche de la valeur de celui-ci
	// @param $unite: l'unité à afficher après la valeur du détail (facultatif)
	private static function detailHTML ($titre,$valeur,$unite = "")
	{
		return '<span class="section_description">'.$titre.' : </span>'.$valeur.' '.$unite.'<br />';
	}
}

?>