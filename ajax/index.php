<html>
<head>
	<meta charset="utf-8">
	<title>jQuery Exemple ajax</title>
	<script src="include/jquery.js"></script>
	<script src="include/fonctions.js"></script>
</head>
<body>
<?php
error_reporting(0);
session_start();
?>
<fieldset>
  <legend>Entrez vos informations</legend>
  <div id="classic-use-response">
    <?php if (!empty($_SESSION['username'])){  ?>
      <p style="color:orange;">
      	<strong>Le nom d'utilisateur enregistré en session est <i><? echo $_SESSION['username']; ?></i>.</strong>
      </p>
    <?php } else { ?>
      <p style="color:red;"><strong></strong></p>
    
    <?php } ?>

  </div>

  <div>
    <label for="username">Nom de l'utilisateur </label>
    <input type="text" id="username" placeholder="Nom de l'utilisateur" title="Veuillez saisir ici le nom de l'utilisateur" />
    <br/><br/>
    <button id="submit-button" style="cursor: pointer" title="Cliquez ici pour valider le nom de l'utilisateur">Valider</button>
    <button id="reset-button" style="cursor: pointer" title="Cliquez ici pour réinitialiser la variable">Réinitialiser variable</button>

  </div>
</fieldset>
</body>
</html>
