<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Consultation d’objet</h2>
<?php if ($item): ?>
<?php $icon = $this->iconImage($item->item_id); ?>
<h3>
	<?php if ($icon): ?><img src="<?php echo $icon ?>" /><?php endif ?>
	#<?php echo htmlspecialchars($item->item_id) ?>: <?php echo htmlspecialchars($item->name) ?>
</h3>
<table class="vertical-table">
	<tr>
		<th>ID d’objet</th>
		<td><?php echo htmlspecialchars($item->item_id) ?></td>
		<?php if ($image=$this->itemImage($item->item_id)): ?>
		<td rowspan="<?php echo ($server->isRenewal)?9:8 ?>" style="width: 150px; text-align: center; vertical-alignment: middle">
			<img src="<?php echo $image ?>" />
		</td>
		<?php endif ?>
		<th>En vente</th>
		<td>
			<?php if ($item->cost): ?>
				<span class="for-sale yes">
					Oui
				</span>
			<?php else: ?>
				<span class="for-sale no">
					Non
				</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Identifiant</th>
		<td><?php echo htmlspecialchars($item->identifier) ?></td>
		<th>Prix en crédits</th>
		<td>
			<?php if ($item->cost): ?>
				<?php echo number_format((int)$item->cost) ?>
			<?php else: ?>
				<span class="not-applicable">Non vendu</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Nom</th>
		<td><?php echo htmlspecialchars($item->name) ?></td>
		<th>Type</th>
		<td><?php echo $this->itemTypeText($item->type) ?><?php if($item->subtype) echo ' - '.$this->itemSubTypeText($item->type, $item->subtype) ?></td>
	</tr>
	<tr>
		<th>Achat PNJ</th>
		<td><?php echo number_format((int)$item->price_buy) ?></td>
		<th>Poids</th>
		<td><?php echo round($item->weight, 1) ?></td>
	</tr>
	<tr>
		<th>Vente PNJ</th>
		<td>
			<?php if (is_null($item->price_sell) && $item->price_buy): ?>
				<?php echo number_format(floor($item->price_buy / 2)) ?>
			<?php else: ?>
				<?php echo number_format((int)$item->price_sell) ?>
			<?php endif ?>
		</td>
		<th>Niveau d’arme</th>
		<td><?php echo number_format((int)$item->weapon_level) ?></td>
	</tr>
	<tr>
		<th>Portée</th>
		<td><?php echo number_format((int)$item->range) ?></td>
		<th>Défense</th>
		<td><?php echo number_format((int)$item->defense) ?></td>
	</tr>
	<tr>
		<th>Slots</th>
		<td><?php echo number_format((int)$item->slots) ?></td>
		<th>Raffinable</th>
		<td>
			<?php if ($item->refineable): ?>
				Oui
			<?php else: ?>
				Non
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Attaque</th>
		<td><?php echo number_format((int)$item->attack) ?></td>
		<th>Niveau min. d’équipement</th>
		<td>
			<?php if ($item->equip_level_min == 0): ?>
				<span class="not-applicable">Aucun</span>
			<?php else: ?>
				<?php echo number_format((int)$item->equip_level_min) ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<?php if($server->isRenewal): ?>
			<th>MATK</th>
			<td><?php echo number_format((int)$item->magic_attack) ?></td>
		<?php endif ?>
		<th>Niveau max. d’équipement</th>
		<td colspan="<?php echo $image ? 0 : 3 ?>">
			<?php if ($item->equip_level_max == 0): ?>
				<span class="not-applicable">Aucun</span>
			<?php else: ?>
				<?php echo number_format((int)$item->equip_level_max) ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Emplacements d’équipement</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($equip_locations=$this->equipLocations($equip_locs)): ?>
				<?php echo $equip_locations ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Groupes équipables</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->equipUpper($upper)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->equipUpper($upper))) ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Jobs équipables</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->equippableJobs($jobs)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->equippableJobs($jobs))) ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Genre équipable</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($item->gender == 'Female'): ?>
				Féminin
			<?php elseif ($item->gender == 'Male'): ?>
				Masculin
			<?php elseif ($item->gender == 'Both' || $item->gender == NULL): ?>
				Les deux
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Restriction d’échange</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->tradeRestrictions($restrictions)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->tradeRestrictions($restrictions))) ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
	<?php if (($isCustom && $auth->allowedToSeeItemDb2Scripts) || (!$isCustom && $auth->allowedToSeeItemDbScripts)): ?>
	<tr>
		<th>Script d’utilisation</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script d’équipement</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->equip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script de déséquipement</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->unequip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
    <?php if(Flux::config('ShowItemDesc')):?>
	<tr>
		<th>Description</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if($item->itemdesc): ?>
                <?php echo $item->itemdesc ?>
            <?php else: ?>
                <span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
    <?php endif ?>
    
</table>
<?php if ($itemDrops): ?>
<h3><?php echo htmlspecialchars($item->name) ?> : obtenu sur</h3>
<table class="vertical-table">
	<tr>
		<th>ID de monstre</th>
		<th>Nom du monstre</th>
		<th>Chance de drop de <?php echo htmlspecialchars($item->name) ?></th>
		<th>Peut être volé</th>
		<th>Niveau du monstre</th>
		<th>Race du monstre</th>
		<th>Elément du monstre</th>
	</tr>
	<?php foreach ($itemDrops as $itemDrop): ?>
	<tr class="item-drop-<?php echo $itemDrop['type'] ?>">
		<td align="right">
			<?php if ($auth->actionAllowed('monster', 'view')): ?>
				<?php echo $this->linkToMonster($itemDrop['monster_id'], $itemDrop['monster_id']) ?>
			<?php else: ?>
				<?php echo $itemDrop['monster_id'] ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($itemDrop['type'] == 'mvp'): ?>
				<span class="mvp">MVP!</span>
			<?php endif ?>
			<?php echo htmlspecialchars($itemDrop['monster_name']) ?>
		</td>
		<td><strong><?php echo $itemDrop['drop_rate'] ?>%</strong></td>
		<td><strong><?php echo htmlspecialchars(Flux::message($itemDrop['drop_steal'])) ?></strong></td>
		<td><?php echo number_format($itemDrop['monster_level']) ?></td>
		<td><?php echo Flux::monsterRaceName($itemDrop['monster_race']) ?></td>
		<td>
			Niveau <?php echo floor($itemDrop['monster_ele_lv']) ?>
			<em><?php echo Flux::elementName($itemDrop['monster_element']) ?></em>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif ?>

<?php else: ?>
<p>Cet objet est introuvable. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
