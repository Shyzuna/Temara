<?php
session_start();

require_once('../../ConnexionBDD.class.php');
require_once('../../BienTable.class.php');
require_once('../../Bien.class.php');
require_once('../Compte/Compte.class.php');
require_once('DemandeInfos.class.php');
require_once('DemandeInfosTable.class.php');

if (isset($_GET['id']))
{
	$bien = BienTable::obtientBien($_GET['id']);
	
	if ($bien != null)
	{
		// Permet de rediriger l'utilisateur à la page qu'il a consulté avant, en gardant l'id du bien qu'il était en train de consulter
		if (isset($_SESSION['provenanceDemandeInfos']))
			$pageSource = $_SESSION['provenanceDemandeInfos'];
		else if (isset($bien->pourInvestisseur) && $bien->pourInvestisseur)
			$pageSource = '/temara/Modules/Recherche/maps.php?investisseur=true';
		else
			$pageSource = '/temara/Modules/Recherche/maps.php';
		
		// On ajoute l'id du bien demandé dans l'URL de la page où l'on va rediriger l'utilisateur
		if (strpos($pageSource,"?") === false)
			$pageSource .= '?id='.$_GET['id'];
		else
		{
			if (strpos($pageSource,'id=') === false)
				$pageSource .= '&id='.$_GET['id'];
			else
			{
				$debutId = strpos($pageSource,'id=') + 3;
				if (strpos($pageSource,'&',$debutId) === false)
					$finId = strlen($pageSource)-1;
				else
					$finId = strpos($pageSource,'&',$debutId);
				$pageSource = substr_replace($pageSource,$_GET['id'],$debutId,$finId-$debutId+1);
			}
		}
		
		$erreurCivilite = "";
		$erreurNom = "";
		$erreurPrenom = "";
		$erreurTelephone = "";
		$erreurMail = "";
		
		if (isset($_SESSION['compte']))
		{
			$compte = unserialize($_SESSION['compte']);
			$civilite = $compte->civilite;
			$nom = $compte->nom;
			$prenom = $compte->prenom;
			$telephone = $compte->telephone;
			$mail = $compte->mail;
		}
		else
		{
			$civilite = 0;
			$nom = "";
			$prenom = "";
			$telephone = "";
			$mail = "";
		}
		$commentaire = "";
		
		$formEnvoye = false;
		
		/* 
		* Vérification et enregistrement des données du formulaire
		*/
		if (isset($_POST['civilite']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['mail']) && isset($_POST['commentaire']))
		{
			if ($_POST['civilite'] >= 1 && $_POST['civilite'] <= 3)
				$civilite = $_POST['civilite'];
			if ($_POST['nom'] != '')
				$nom = htmlentities($_POST['nom']);
			if ($_POST['prenom'] != '')
				$prenom = htmlentities($_POST['prenom']);
			if ($_POST['telephone'] != '')
				$telephone = htmlentities($_POST['telephone']);
			if ($_POST['mail'] != '')
				$mail = htmlentities($_POST['mail']);
			if ($_POST['commentaire'] != '')
				$commentaire = htmlentities($_POST['commentaire']);
					
			// Si les champs sont bien remplis
			if ($_POST['nom'] != '' && $_POST['prenom'] != '' && $_POST['telephone'] != '' && preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone) 
			&& ($_POST['civilite'] >= 1 && $_POST['civilite'] <= 3) && $_POST['mail'] != '' && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL))
			{
				$demandeVisite = (isset($_POST['demandeVisite'])) ? 1 : 0;
				
				if(!empty($commentaire))
				{
					$commentaire="Il souhaite préciser :\n".$commentaire;
				}
				else
				{
					$commentaire="";
				}
				
				$message="Renseignements sur ".$bien."\n\nDe".$civilite." ".$prenom." ".$nom."\nTel : ".$telephone."  Mail : ".$mail."\n\n".$commentaire."";
				
				$desti = "isabelle.tempez@temara.fr";
				$sujet = "Question de ".$civilite." ".$nom."";
				mail($desti,$sujet,$message);
				
				$demandeInfos = DemandeInfosTable::addDemandeInfos($bien->id,$_POST['civilite'],$nom,$prenom,$telephone,$mail,nl2br($commentaire),$demandeVisite);
				$formEnvoye = true;
			}
			else
			{
				// Messages d'erreur
				if ($_POST['civilite'] < 1 || $_POST['civilite'] > 3)
					$erreurCivilite = '<br /><span class="erreur_form">Veuillez choisir une civilité</span>';
				if ($_POST['nom'] == '')
					$erreurNom = '<br /><span class="erreur_form">Veuillez saisir votre nom</span>';
				if ($_POST['prenom'] == '')
					$erreurPrenom = '<br /><span class="erreur_form">Veuillez saisir votre prénom</span>';
				if ($_POST['telephone'] == '')
					$erreurTelephone = '<br /><span class="erreur_form">Veuillez saisir votre numéro de téléphone</span>';
				else if (!(preg_match("^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}^",$telephone)))
					$erreurTelephone = '<br /><span class="erreur_form">Le numéro saisi est invalide</span>';
				if ($_POST['mail'] == '')
					$erreurMail = '<br /><span class="erreur_form">Veuillez saisir votre adresse mail</span>';
				else if (!(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)))
					$erreurMail = '<br /><span class="erreur_form">L\'adresse mail saisie est invalide</span>';
			}
		}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>TEMARA</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../../library/bootstrap/css/bootstrap.min.css" />
  
  <link rel="stylesheet" href="../../css/index.css">
  <link href="../../css/media-queries.css" rel="stylesheet" type="text/css">
  <link href="../../css/form-media-queries.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 8]>
	<link rel="stylesheet" href="../../css/indexIE8.css">
  <![endif]-->
  <!--[if lte IE 9]>
	<link rel="stylesheet" href="../../css/degradesIE.css">
  <![endif]-->
  
  <style> a.btn { text-decoration: none; } </style>
</head>
<body>

	<div id="corps">
		<?php include('../../header.php'); ?>
		
		<?php include('../../nav.php'); ?>
		
		<div id="ensemble">
			<?php include('../../message_rouge.php'); ?>
			
			<?php
			// require_once('../../lien_connexion.php');
			?>
			
			<h2>Demande d'informations : "<?php echo $bien->titre;?>"</h2>
			
			<div class="cadre">
			
				<?php
				if ($formEnvoye == false)
				{
				?>
					<form class="form-horizontal" method="post">
						<div class="control-group">
							<div class="control-label section_description">Civilité*</div>
							<div class="controls">
								<select name="civilite">
									<option value="1" <?php if ($civilite == 1) echo 'selected="selected"';?>>M.</option>
									<option value="2" <?php if ($civilite == 2) echo 'selected="selected"';?>>Mme</option>
									<option value="3" <?php if ($civilite == 3) echo 'selected="selected"';?>>Mlle</option>
								</select>
								<?php echo $erreurCivilite; ?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Nom*</div>
							<div class="controls">
								<input type="text" maxlength="30" name="nom" required="required" value="<?php echo $nom;?>" />
								<?php echo $erreurNom; ?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Prénom*</div>
							<div class="controls">
								<input type="text" maxlength="30" name="prenom" required="required" value="<?php echo $prenom;?>" />
								<?php echo $erreurPrenom; ?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Téléphone*</div>
							<div class="controls">
								<input type="text" maxlength="25" name="telephone" required="required" value="<?php echo $telephone;?>" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" />
								<?php echo $erreurTelephone; ?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">E-mail*</div>
							<div class="controls">
								<input type="email" maxlength="50" name="mail" required="required" value="<?php echo $mail;?>" />
								<?php echo $erreurMail; ?>
							</div>
						</div>
						
						<div class="control-group">
							<div class="control-label section_description">Commentaire / Questions</div>
							<div class="controls">
								<textarea rows="5" name="commentaire"><?php echo $commentaire;?></textarea>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<div class="checkbox">
									<input type="checkbox" name="demandeVisite" <?php if (isset($_POST['demandeVisite'])) echo 'checked="checked"';?> /> <strong>Je souhaite visiter ce bien</strong>
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn btn-large">Envoyer</button>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<span class="indication_form">(*) Champs obligatoires</span>
							</div>
						</div>
					</form>
				<?php
				}
				else
				{
				?>
				<div class="confirm_form_envoye">
					<p>Votre demande d'informations a bien été envoyée</p>
					<p><a href="http://localhost<?php echo $pageSource;?>" class="btn btn-large">Retour à l'annonce</a></p>
				</div>
				<?php
				}
				?>
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
	
	<!--[if lt IE 9]>
		<script src="../../library/respond.min.js"></script>
		<script type="text/javascript" src="../../js/nav_correctifIE8.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../../js/menu_basse_resolution.js"></script>
	<script type="text/javascript" src="../../js/connexion.js"></script>
</body>
</html>

<?php
	}
	else
		header('Location: ../../index.php');
}
else
	header('Location: ../../index.php');