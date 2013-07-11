<form method="post" class="form-horizontal">

	<?php if (! isset($formModification))
	{
	?>
	<div class="control-group">
		<div class="control-label section_description">Nom de la recherche*</div>
		<div class="controls">
			<input type="text" name="nomRecherche" required class="not-input-append" value="<?php echo $nomRecherche;?>" />
			<?php echo $erreurNomRecherche; ?>
		</div>
	</div>
	<?php
	}
	?>

	<div class="control-group">
		<div class="control-label section_description">Type d'annonce</div>
		<div class="controls">
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('1',$typeAnnonceTab)) echo 'checked="checked"';?> name="typeAnnonce[]" value="1" />Vente
			</div>
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('2',$typeAnnonceTab)) echo 'checked="checked"';?> name="typeAnnonce[]" value="2" />Location
			</div>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Type de bien</div>
		<div class="controls">
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('1',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="1" />Maison
			</div>
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('2',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="2" />Appartement
			</div>
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('3',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="3" />Terrain
			</div>
			<div class="checkbox inline">
				<input type="checkbox" <?php if (in_array('4',$typeBienTab)) echo 'checked="checked"';?> name="typeBien[]" value="4" />Garage
			</div>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Budget</div>
		<div class="controls">
			<div class="control-group">
				<div class="controls">
					<div class="input-append">
						<input type="text" name="budgetMin" placeholder="Min" value="<?php echo $prixMin;?>" />
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<div class="input-append">
						<input type="text" name="budgetMax" placeHolder="Max" value="<?php echo $prixMax;?>" />
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
			<?php echo $erreurPrix; ?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Surface</div>
		<div class="controls">
			<div class="control-group">
				<div class="controls">
					<div class="input-append">
						<input type="text" name="surfaceMin" placeholder="Min" value="<?php echo $surfaceMin;?>" />
						<span class="add-on">m²</span>
					</div>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<div class="input-append">
						<input type="text" name="surfaceMax" placeholder="Max" value="<?php echo $surfaceMax;?>" />
						<span class="add-on">m²</span>
					</div>
				</div>
			</div>
			<?php echo $erreurSurface; ?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Nombre de pièces</div>
		<div class="controls">
			<div class="control-group">
				<div class="controls">
					<input type="number" min="0" name="nbPiecesMin" placeholder="Min" value="<?php echo $nbPiecesMin;?>" />
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<input type="number" min="0" name="nbPiecesMax" placeholder="Max" value="<?php echo $nbPiecesMax;?>" />
				</div>
			</div>
			<?php echo $erreurNbPieces; ?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Ville / Code postal</div>
		<div class="controls">
			<input type="text" placeholder="Ville" name="ville" class="not-input-append" value="<?php echo $ville;?>" />
		</div>
	</div>

	<div class="control-group">
		<div class="control-label section_description">Investisseur</div>
		<div class="controls">
			<input type="checkbox" name="investisseur" <?php if ($investisseur != null && $investisseur == 1) echo 'checked';?> />
		</div>
	</div>

	<div class="control-group">
		<div class="controls boutons_form">
			<button type="submit" class="btn btn-large btn-primary">Valider</button>
			<a href="mes_recherches.php" class="btn btn-large">Annuler</a>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<span class="indication_form">(*) Champs obligatoires</span>
		</div>
	</div>
</form>