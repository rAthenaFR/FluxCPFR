<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Réinstaller les schémas de base de données</h2>
<p>Vous pouvez réinstaller les fichiers de schéma (*.sql) depuis cette interface. Si vous êtes absolument sûr de vouloir continuer, cliquez sur « Continuer ».</p>
<p><strong>Note :</strong> cette action peut créer des index en double sur vos tables MySQL, mais ils ne sont pas dangereux. Cette fonctionnalité reste très expérimentale.</p>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="reinstall" value="1" />
	<table class="generic-form-table">
		<tr>
			<td><p>Voulez-vous vraiment continuer ?</p></td>
		</tr>
		<tr>
			<td><input type="submit" value="Continuer" /></td>
		</tr>
	</table>
</form>
