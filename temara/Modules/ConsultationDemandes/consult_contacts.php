<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('../Contact/Contact.class.php');
require_once('../Contact/ContactTable.class.php');
require_once('../Compte/Compte.class.php');

if (isset($_SESSION['compte']) && unserialize($_SESSION['compte'])->levelUser == 1)
{

$demandes = ContactTable::getContacts();

// Renvoie la chaine représentant la civilité de la personne selon le chiffre passé en paramètre
// 1 <-> M. / 2 <-> Mme / 3 <-> Mlle
function civilite ($chiffreCivilite)
{
	if ($chiffreCivilite == 1)
		return 'M.';
	else if ($chiffreCivilite == 2)
		return 'MMe';
	else
		return 'Mlle';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  <!-- jQuery UI -->
  <link rel="stylesheet" href="../../library/jqueryUI/jquery-ui-1.10.2.custom.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="../../css/index.css">
  <link href="../../css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/consultations.css">
  
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
</head>
<body>
	<div id="corps">
		<?php include('../../header.php'); ?>
		
		<?php include('../../nav.php'); ?>
		
		<div id="ensemble">
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			require_once('../../lien_connexion.php');
			?>
			
			<h2>Consultation des demandes des clients <img class="loader" src="../../images/loader.gif" alt="loader" /></h2>
			
			<div id="menu_admin">
				<ul>
					<li><a href="consult_demandes_infos.php">Demandes d'informations</a></li>
					<li><a href="consult_estimations.php">Demandes d'estimation et de mise en vente</a></li>
					<li><a href="consult_contacts.php" class="page_admin_actuelle">Demandes d'aide à la recherche</a></li>
				</ul>
			</div>
			
			<div class="cadre">
				<table class="table">
					<thead>
						<tr>
							<th><input type="checkbox" /></th>
							<th>Date</th>
							<th>Nom</th>
							<th>Téléphone</th>
							<th>Mail</th>
							<th></th>
						</tr>
					</thead>
					
					<tbody>
						<?php
						foreach ($demandes as $demande)
						{
							if ($demande->lu)
								echo '<tr class="mouse_hand" id="demande-'.$demande->id.'">';
							else
								echo '<tr class="non_lu mouse_hand" id="demande-'.$demande->id.'">';
							
							echo '<td><input type="checkbox" value="'.$demande->id.'" /></td>';
							
							if (date('d/m/Y') == date('d/m/Y',strtotime($demande->dateEnvoi)))
								echo '<td class="clickable">'.date('G:i',strtotime($demande->dateEnvoi)).'</td>';
							else
								echo '<td class="clickable">'.date('d/m/Y',strtotime($demande->dateEnvoi)).'</td>';
							
							echo '<td class="clickable">'.civilite($demande->civilite).' '.strtoupper($demande->nom).' '.ucfirst(strtolower($demande->prenom)).'</td>';
							
							echo '<td class="clickable">'.$demande->telephone.'</td>';
							
							echo '<td class="clickable">'.$demande->mail.'</td>';
							
							echo '<td><a href="mailto:'.$demande->mail.'"><i class="icon-envelope"></i></a></td>';
							
							echo '</tr>';
							
							echo '<tr class="commentaire" id="commentaire-'.$demande->id.'"><td></td><td colspan="5"><div>';
							
							echo '<strong>Recherche : '.$demande->typeBien.' en ';
							echo ($demande->etat == 1) ? 'vente' : 'location';
							echo '</strong><br />';
							
							echo '<span class="section_description">Budget : </span>';
							if ($demande->budgetMin != null && $demande->budgetMax != null)
								echo ' Entre '.$demande->budgetMin.' € et '.$demande->budgetMax.' €';
							else if ($demande->budgetMin != null )
								echo ' > '.$demande->budgetMin.' €';
							else if ($demande->budgetMax != null)
								echo ' < '.$demande->budgetMax.' €';
							echo '<br />';
							
							echo '<span class="section_description">Surface :</span>';
							if ($demande->surfaceMin != null && $demande->surfaceMax != null)
								echo ' Entre '.$demande->surfaceMin.' m² et '.$demande->surfaceMax.' m²';
							else if ($demande->surfaceMin != null)
								echo ' > '.$demande->surfaceMin.' m²';
							else if ($demande->surfaceMax != null)
								echo ' < '.$demande->surfaceMax.' m²';
							echo '<br />';
							
							echo '<span class="section_description">Nombre de pièces :</span>';
							if ($demande->nbPiecesMin != null && $demande->nbPiecesMax != null)
								echo ' Entre '.$demande->nbPiecesMin.' et '.$demande->nbPiecesMax.' pièces';
							else if ($demande->nbPiecesMin != null)
								echo ' + de '.$demande->nbPiecesMin.' pièces';
							else if ($demande->nbPiecesMax != null)
								echo ' - de '.$demande->nbPiecesMax.' pièces';
							echo '<br />';
							
							echo '<span class="section_description">Remarques :</span> <span class="commentaire_client">'.$demande->remarques.'</span>';
							
							echo '</div></td></tr>';
						}
						?>
					</tbody>
				</table>
				
				<button class="btn button_delete">Supprimer la sélection</button>
				<button class="btn button_non_lu">Marquer comme non lu</button>
				<button class="btn button_lu">Marquer comme lu</button>
			</div>
		</div>
	</div>
	
	<?php
	require_once('../../modal_connexion.php');
	?>
		
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- jQuery UI -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="../../library/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/loader_ajax.js"></script>
	<script type="text/javascript" src="js/consultations.js"></script>
	<script type="text/javascript" src="js/fonctions_consult_contacts.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
</body>
</html>

<?php
}
else
	header('Location: ../../index.php');
?>