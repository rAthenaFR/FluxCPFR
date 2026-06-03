<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Statistiques des cartes</h2>
<?php if ($maps): ?>
<?php $playerTotal = 0; foreach ($maps as $map) $playerTotal += $map->player_count ?>
<p>Cette page indique combien de joueurs en ligne sont présents sur chaque carte active.</p>
<p><strong><?php echo number_format($playerTotal) ?></strong> joueur(s) en ligne trouvé(s)
réparti(s) sur <strong><?php echo number_format(count($maps)) ?></strong> carte(s).</p>
<div class="generic-form-div">
	<table class="generic-form-table">
		<?php foreach ($maps as $map): ?>
		<tr>
			<td align="right"><p class="important"><strong><?php echo htmlspecialchars(basename($map->map_name, '.gat')) ?></strong></p></td>
			<td><p><strong><em><?php echo number_format($map->player_count) ?></em></strong> joueur(s)</p></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
<?php else: ?>
<p>Aucun joueur trouvé sur les cartes. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
