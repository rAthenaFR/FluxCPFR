<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Consultation de monstre</h2>
<?php if ($monster): ?>
<h3>
	#<?php echo $monster->monster_id ?>: <?php echo htmlspecialchars($monster->name_english) ?>
	<?php if ($monster->mvp_exp): ?>
		<span class="mvp">(MVP)</span>
	<?php endif ?>
</h3>
<table class="vertical-table">
	<tr>
		<th>ID de monstre</th>
		<td><?php echo $monster->monster_id ?></td>
		<?php if ($image=$this->monsterImage($monster->monster_id)): ?>
		<td rowspan="12" style="width:150px; text-align: center; vertical-alignment: middle">
			<img src="<?php echo $image ?>" />
		</td>
		<?php endif ?>
		<th>Sprite</th>
		<td><?php echo htmlspecialchars($monster->sprite) ?></td>
	</tr>
	<tr>
		<th>Nom kRO</th>
		<td><?php echo htmlspecialchars($monster->name_japanese) ?></td>
		<th>Personnalisé</th>
		<td>
			<?php if (preg_match('/mob_db2$/', $monster->origin_table)): ?>
				Oui
			<?php else: ?>
				Non
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Nom iRO</th>
		<td><?php echo htmlspecialchars($monster->name_english) ?></td>
		<th>HP</th>
		<td><?php echo number_format($monster->hp) ?></td>
	</tr>
	<tr>
		<th>Taille</th>
		<td>
			<?php if ($size=Flux::monsterSizeName($monster->size)): ?>
				<?php echo htmlspecialchars($size) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
		<th>SP</th>
		<td><?php echo number_format($monster->sp) ?></td>
	</tr>
	<tr>
		<th>Race</th>
		<td>
			<?php if ($race=Flux::monsterRaceName($monster->race)): ?>
				<?php echo htmlspecialchars($race) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>	
		</td>
		<th>Niveau</th>
		<td><?php echo number_format($monster->level) ?></td>
	</tr>
	<tr>
		<th>Elément</th>
		<td><?php echo Flux::elementName($monster->element) ?> (niv. <?php echo floor($monster->element_level) ?>)</td>
		<th>Vitesse</th>
		<td><?php echo number_format($monster->walk_speed) ?></td>
	</tr>
	<tr>
		<th>Expérience</th>
		<td><?php echo number_format($monster->base_exp) ?></td>
		<th>Attaque</th>
		<td><?php echo number_format($monster->attack) ?>~<?php echo number_format($monster->attack2) ?></td>
	</tr>
	<tr>
		<th>Expérience job</th>
		<td><?php echo number_format($monster->job_exp) ?></td>
		<th>Défense</th>
		<td><?php echo number_format($monster->defense) ?></td>
	</tr>
	<tr>
		<th>Expérience MVP</th>
		<td><?php echo number_format($monster->mvp_exp) ?></td>
		<th>Défense magique</th>
		<td><?php echo number_format($monster->magic_defense) ?></td>
	</tr>
	<tr>
		<th>Délai d’attaque</th>
		<td><?php echo number_format($monster->attack_delay) ?> ms</td>
		<th>Portée d’attaque</th>
		<td><?php echo number_format($monster->attack_range) ?></td>
	</tr>
	<tr>
		<th>Animation d’attaque</th>
		<td><?php echo number_format($monster->attack_motion) ?> ms</td>
		<th>Portée des sorts</th>
		<td><?php echo number_format($monster->skill_range) ?></td>
	</tr>
	<tr>
		<th>Animation de délai</th>
		<td><?php echo number_format($monster->damage_motion) ?> ms</td>
		<th>Portée de vision</th>
		<td><?php echo number_format($monster->chase_range) ?></td>
	</tr>
	<tr>
		<th>Modes du monstre</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<ul class="monster-mode">
			<?php foreach ($this->monsterMode($modes, $monster->ai) as $mode): ?>
				<li><?php echo htmlspecialchars($mode) ?></li>
			<?php endforeach ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>Stats du monstre</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<table class="character-stats">
				<tr>
					<td><span class="stat-name">STR</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->strength) ?></span></td>
					<td><span class="stat-name">AGI</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->agility) ?></span></td>
					<td><span class="stat-name">VIT</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->vitality) ?></span></td>
				</tr>
				<tr>
					<td><span class="stat-name">INT</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->intelligence) ?></span></td>
					<td><span class="stat-name">DEX</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->dexterity) ?></span></td>
					<td><span class="stat-name">LUK</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$monster->luck) ?></span></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<h3>Drops d’objets de <?php echo htmlspecialchars($monster->name_english) ?></h3>
<?php if ($itemDrops): ?>
<table class="vertical-table">
	<tr>
		<th>ID d’objet</th>
		<th colspan="2">Nom de l’objet</th>
		<th>Chance de drop</th>
		<th>Peut être volé</th>
	</tr>
	<?php $mvpDrops = 0; ?>
	<?php foreach ($itemDrops as $itemDrop): ?>
	<tr class="item-drop-<?php echo $itemDrop['type'] ?>"
		title="<strong><?php echo htmlspecialchars($itemDrop['name']) ?></strong> (<?php echo (float)$itemDrop['chance'] ?>%)">
		<td align="right">
			<?php if ($auth->actionAllowed('item', 'view')): ?>
				<?php echo $this->linkToItem($itemDrop['id'], $itemDrop['id']) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($itemDrop['id']) ?>
			<?php endif ?>
		</td>
		<?php if ($image=$this->iconImage($itemDrop['id'])): ?>
			<td><img src="<?php echo $image ?>" /></td>
			<td>
				<?php if ($itemDrop['type'] == 'mvp'): ?>
				<?php ++$mvpDrops; ?>
					<span class="mvp">MVP!</span>
				<?php endif ?>
				<?php echo htmlspecialchars($itemDrop['name']) ?>
			</td>
		<?php else: ?>
			<td colspan="2">
				<?php if ($itemDrop['type'] == 'mvp'): ?>
				<?php ++$mvpDrops; ?>
					<span class="mvp">MVP!</span>
				<?php endif ?>
				<?php echo htmlspecialchars($itemDrop['name']) ?>
			</td>
		<?php endif ?>
		<td><?php echo (float)$itemDrop['chance'] ?>%</td>
		<td><?php echo htmlspecialchars(Flux::message($itemDrop['nosteal'])) ?></td>
	</tr>
	<?php endforeach ?>
	<?php if ($mvpDrops > 1 && !$server->dropRates['MvpItemMode']): ?>
	<tr>
		<td colspan="<?php echo ($server->isRenewal) ? 6 : 5; ?>" align="center">
			<p><em>Note : un seul drop MVP sera attribué.</em></p>
		</td>
	</tr>
	<?php endif ?>
</table>
<?php else: ?>
<p>Aucun drop d’objet trouvé pour <?php echo htmlspecialchars($monster->name_english) ?>.</p>
<?php endif ?>

<h3>Compétences de « <?php echo htmlspecialchars($monster->name_english) ?> »</h3>
<?php if ($mobSkills): ?>
<table class="vertical-table">
	<tr>
		<th>Nom</th>
		<th>Niveau</th>
		<th>Etat</th>
		<th>Taux</th>
		<th>Temps d’incantation</th>
		<th>Délai</th>
		<th>Annulable</th>
		<th>Cible</th>
		<th>Condition</th>
		<th>Valeur</th>
	</tr>	
	<?php foreach ($mobSkills as $skill): ?>
	<tr>
		<td><?php echo htmlspecialchars($skill->INFO) ?></td>
		<td><?php echo htmlspecialchars($skill->SKILL_LV) ?></td>
		<td><?php echo htmlspecialchars(ucfirst($skill->STATE)) ?></td>
		<td><?php echo $skill->RATE/100 ?>%</td>
		<td><?php echo $skill->CASTTIME/1000 ?>s</td>
		<td><?php echo $skill->DELAY/1000 ?>s</td>
		<td><?php echo htmlspecialchars(ucfirst($skill->CANCELABLE)) ?></td>
		<td><?php echo htmlspecialchars(ucfirst($skill->TARGET)) ?></td>
		<td><em><?php echo htmlspecialchars($skill->CONDITION) ?></em></td>
		<td>
			<?php if (!is_null($skill->CONDITION_VALUE) && trim($skill->CONDITION_VALUE) !== ''): ?>
				<?php echo htmlspecialchars($skill->CONDITION_VALUE) ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Aucune compétence trouvée pour <?php echo htmlspecialchars($monster->name_english) ?>.</p>
<?php endif ?>

<?php else: ?>
<p>Ce monstre est introuvable. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
