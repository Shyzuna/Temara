<div id="modal" class="modal hide fade">
	 <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>Authentification <img class="loader" src="http://localhost:8080/temara/images/loader.gif" alt="loader" /></h3>
	</div>
	
	<div class="modal-body">
		<h4>Entrez vos identifiants :</h4>
		<form class="form-horizontal">	
			<div class="control-group">
				<div class="control-label section_description">E-mail</div>
				<div class="controls">
					<input type="text" name="mail" />
				</div>
			</div>
					
			<div class="control-group">
				<div class="control-label section_description">Mot de passe</div>
				<div class="controls">
					<input type="password" name="password" /><br />
					<a href="http://localhost:8080/temara/Modules/Compte/password_perdu.php">J'ai perdu mon mot de passe</a>
				</div>
			</div>
			
			<button type="button" class="btn btn-primary button_connect">Se connecter</button>
		</form>
		
		<p>Vous souhaitez vous inscrire ? Rendez-vous <a href="http://localhost:8080/temara/Modules/Compte/creation_compte.php">ici</a>
	</div>
	
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn">Fermer</button>
		<button type="button" class="btn btn-primary button_connect">Se connecter</button>
	</div>
</div>