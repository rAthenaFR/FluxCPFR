<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Classement des homonculus</h2>
<h3>
	Les <?php echo number_format($limit=(int)Flux::config('HomunRankingLimit')) ?> meilleurs homonculus
	<?php if (!is_null($homunClass)): ?>
	(<?php echo htmlspecialchars($className=$this->homunClassText($homunClass)) ?>)
	<?php endif ?>
	sur <?php echo htmlspecialchars($server->serverName) ?>
</h3>
<?php if ($homuns): ?>
<form action="" method="get" class="search-form2">
	<?php echo $this->moduleActionFormInputs('ranking', 'homunculus') ?>
	<p>
		<label for="homunclass">Filtrer par classe :</label>
		<select name="homunclass" id="homunclass">
			<option value=""<?php if (is_null($homunClass)) echo 'selected="selected"' ?>>Toutes</option>
		<?php foreach ($classes as $homunClassIndex => $homunClassName): ?>
			<option value="<?php echo $homunClassIndex ?>"
				<?php if (!is_null($homunClass) && $homunClass == $homunClassIndex) echo ' selected="selected"' ?>>
				<?php echo htmlspecialchars($homunClassName) ?>
			</option>
		<?php endforeach ?>
		</select>
		
		<input type="submit" value="Filtrer" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<table class="horizontal-table">
	<tr>
		<th>Rang</th>
		<th>Homunculus</th>
		<th>Nom du propriétaire</th>
		<th>Intimité</th>
		<th>Niveau</th>
		<th>Expérience</th>
	</tr>
	<?php $topRankType = !is_null($homunClass) ? $className : 'homonculus' ?>
	<?php for ($i = 0; $i < $limit; ++$i): ?>
	<tr<?php if (!isset($homuns[$i])) echo ' class="empty-row"'; if ($i === 0) echo ' class="top-ranked" title="<strong>'.htmlspecialchars($homuns[$i]->homun_name).'</strong> est en tête du classement '.$topRankType.' !"' ?>>
		<td align="right"><?php echo number_format($i + 1) ?></td>
		<?php if (isset($homuns[$i])): ?>
		<td><strong><?php echo htmlspecialchars($homuns[$i]->homun_name) ?></strong></td>
		<td><strong>
			<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($homuns[$i]->owner, $homuns[$i]->owner_name) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($homuns[$i]->owner_name) ?>
			<?php endif ?>
		</strong></td>
		<td><?php echo number_format($homuns[$i]->intimacy) ?></td>
		<td><?php echo number_format($homuns[$i]->level) ?></td>
		<td><?php echo number_format($homuns[$i]->exp) ?></td>
		<?php else: ?>
		<td colspan="8"></td>
		<?php endif ?>
	</tr>
	<?php endfor ?>
</table>
<?php else: ?>
<p>Aucun homonculus. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
