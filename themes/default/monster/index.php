<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Monstres</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form class="search-form" method="get">
	<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
	<p>
		<label for="monster_id">ID de monstre :</label>
		<input type="text" name="monster_id" id="monster_id" value="<?php echo htmlspecialchars($params->get('monster_id') ?: '') ?>" />
		...
		<label for="name">Nom :</label>
		<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($params->get('name') ?: '') ?>" />
		...
		<label for="mvp">MVP:</label>
		<select name="mvp" id="mvp">
			<option value="all"<?php if (!($mvpParam=strtolower($params->get('mvp') ?: '')) || $mvpParam == 'all') echo ' selected="selected"' ?>>Tous</option>
			<option value="yes"<?php if ($mvpParam == 'yes') echo ' selected="selected"' ?>>Oui</option>
			<option value="no"<?php if ($mvpParam == 'no') echo ' selected="selected"' ?>>Non</option>
		</select>
	</p>
	<p>
		<label for="size">Taille :</label>
		<select name="size">
			<option value="-1"<?php if (($size=$params->get('size')) === '-1') echo ' selected="selected"' ?>>
				Toutes
			</option>
			<?php foreach (Flux::config('MonsterSizes')->toArray() as $sizeId => $sizeName): ?>
				<option value="<?php echo $sizeId ?>"<?php if (($size=$params->get('size')) === strval($sizeId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($sizeName) ?>
				</option>
			<?php endforeach ?>
		</select>
		...
		<label for="race">Race :</label>
		<select name="race">
			<option value="-1"<?php if (($race=$params->get('race')) === '-1') echo ' selected="selected"' ?>>
				Toutes
			</option>
			<?php foreach (Flux::config('MonsterRaces')->toArray() as $raceId => $raceName): ?>
				<option value="<?php echo $raceId ?>"<?php if (($race=$params->get('race')) === strval($raceId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($raceName) ?>
				</option>
			<?php endforeach ?>
		</select>
		...
		<label for="element">Elément :</label>
		<select name="element">
			<option value="-1"<?php if (($element=$params->get('element')) === '-1') echo ' selected="selected"' ?>>
				Tous
			</option>
			<?php foreach (Flux::config('Elements')->toArray() as $elementId => $elementName): ?>
				<option value="<?php echo $elementId ?>"<?php if (($element=$params->get('element')) === strval($elementId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($elementName) ?>
				</option>
				<?php for ($elementLevel = 1; $elementLevel <= 4; $elementLevel++): ?>
					<option value="<?php echo $elementId ?>-<?php echo $elementLevel ?>"<?php if (($element=$params->get('element')) === ($elementId . '-' . $elementLevel)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($elementName . " (niv. $elementLevel)") ?>
					</option>
				<?php endfor ?>
			<?php endforeach ?>
		</select>
	</p>
	<p>
		<label for="custom">Personnalisé :</label>
		<select name="custom" id="custom">
			<option value=""<?php if (!($custom=$params->get('custom'))) echo ' selected="selected"' ?>>Tous</option>
			<option value="yes"<?php if ($custom == 'yes') echo ' selected="selected"' ?>>Oui</option>
			<option value="no"<?php if ($custom == 'no') echo ' selected="selected"' ?>>Non</option>
		</select>
		
		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($monsters): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('monster_id', 'ID de monstre') ?></th>
		<th><?php echo $paginator->sortableColumn('name_japanese', 'Nom kRO') ?></th>
		<th><?php echo $paginator->sortableColumn('name_english', 'Nom iRO') ?></th>
		<th><?php echo $paginator->sortableColumn('level', 'Niveau') ?></th>
		<th><?php echo $paginator->sortableColumn('hp', 'HP') ?></th>
		<th><?php echo $paginator->sortableColumn('size', 'Taille') ?></th>
		<th><?php echo $paginator->sortableColumn('race', 'Race') ?></th>
		<th>Elément</th>
		<th><?php echo $paginator->sortableColumn('base_exp', 'Base EXP') ?></th>
		<th><?php echo $paginator->sortableColumn('job_exp', 'Job EXP') ?></th>
		<th><?php echo $paginator->sortableColumn('origin_table', 'Personnalisé') ?></th>
	</tr>
	<?php foreach ($monsters as $monster): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('monster', 'view')): ?>
				<?php echo $this->linkToMonster($monster->monster_id, $monster->monster_id) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($monster->monster_id) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($monster->mvp_exp): ?>
			<span class="mvp">MVP!</span>
			<?php endif ?>
			<?php echo htmlspecialchars($monster->name_japanese) ?>
		</td>
		<td><?php echo htmlspecialchars($monster->name_english) ?></td>
		<td><?php echo number_format($monster->level) ?></td>
		<td><?php echo number_format($monster->hp) ?></td>
		<td>
			<?php if ($size=Flux::monsterSizeName($monster->size)): ?>
				<?php echo htmlspecialchars($size) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($race=Flux::monsterRaceName($monster->race)): ?>
				<?php echo htmlspecialchars($race) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
		<td><?php echo Flux::elementName($monster->element) ?> (niv. <?php echo floor($monster->element_level) ?>)</td>
		<td><?php echo number_format($monster->base_exp * $server->expRates['Base'] / 100) ?></td>
		<td><?php echo number_format($monster->job_exp * $server->expRates['Job'] / 100) ?></td>
		<td>
			<?php if (preg_match('/mob_db2$/', $monster->origin_table)): ?>
				Oui
			<?php else: ?>
				Non
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucun monstre trouvé. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
