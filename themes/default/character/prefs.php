<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Préférences</h2>
<?php if ($char): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<h3>Préférences du personnage « <?php echo ($charName=htmlspecialchars($char->name))  ?> » sur <?php echo htmlspecialchars($server->serverName) ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="charprefs" value="1" />
	<table class="generic-form-table">
		<tr>
			<th><label for="hide_from_whos_online">Masquer le personnage de « Qui est en ligne »</label></th>
			<td><input type="checkbox" name="hide_from_whos_online" id="hide_from_whos_online"<?php if ($hideFromWhosOnline) echo ' checked="checked"' ?> /></td>
			<td><p>Masque entièrement <?php echo $charName ?> sur la page « Qui est en ligne ».</p></td>
		</tr>
		<tr>
			<th><label for="hide_map_from_whos_online">Masquer la carte actuelle de « Qui est en ligne »</label></th>
			<td><input type="checkbox" name="hide_map_from_whos_online" id="hide_map_from_whos_online"<?php if ($hideMapFromWhosOnline) echo ' checked="checked"' ?> /></td>
			<td><p>Masque la position actuelle de <?php echo $charName ?> sur la page « Qui est en ligne ».</p></td>
		</tr>
		<?php if ($auth->allowedToHideFromZenyRank): ?>
		<tr>
			<th><label for="hide_from_zeny_ranking">Masquer le personnage du classement Zeny</label></th>
			<td><input type="checkbox" name="hide_from_zeny_ranking" id="hide_from_zeny_ranking"<?php if ($hideFromZenyRanking) echo ' checked="checked"' ?> /></td>
			<td><p>Masque <?php echo $charName ?> sur la page du classement Zeny.</p></td>
		</tr>
		<?php endif ?>
		<tr>
			<td align="right"><p><input type="submit" value="Modifier les préférences" /></p></td>
			<td colspan="2"></td>
		</tr>
	</table>
</form>
<?php else: ?>
<p>Ce personnage est introuvable. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
