<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Consultation de personnage</h2>
<?php if ($char): ?>
<h3>Informations du personnage <?php echo htmlspecialchars($char->char_name) ?></h3>
<table class="vertical-table">
	<tr>
		<?php if ($image=$this->jobImage($char->gender, $char->char_class)): ?>
			<td rowspan="11" style="width: 150px; text-align: center; vertical-alignment: middle">
				<img src="<?php echo $image ?>" />
			</td>
		<?php endif ?>
		<th>ID de personnage</th>
		<td colspan="2"><?php echo htmlspecialchars($char->char_id) ?></td>
		<th>ID de compte</th>
		<td>
			<?php if ($auth->allowedToSeeAccountID): ?>
				<?php echo htmlspecialchars($char->char_account_id) ?>
			<?php else: ?>
				<span class="not-applicable">Non applicable</span>
			<?php endif ?>
		</td>
		<th>Emplacement personnage</th>
		<td><?php echo number_format($char->char_num+1) ?></td>
	</tr>
	<tr>
		<th>Personnage</th>
		<td colspan="2"><?php echo htmlspecialchars($char->char_name) ?></td>
		<th>Compte</th>
		<td>
			<?php if ($isMine): ?>
				<a href="<?php echo $this->url('account', 'view') ?>"><?php echo htmlspecialchars($char->userid) ?></a>
			<?php else: ?>
				<?php echo $this->linkToAccount($char->char_account_id, $char->userid) ?>
			<?php endif ?>
		</td>
		<th>Classe job</th>
		<td>
			<?php if ($job=$this->jobClassText($char->char_class)): ?>
				<?php echo htmlspecialchars($job) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Niveau base</th>
		<td colspan="2"><?php echo number_format((int)$char->char_base_level) ?></td>
		<th>Expérience base</th>
		<td><?php echo number_format($char->char_base_exp) ?></td>
		<th>Partenaire</th>
		<td>
			<?php if ($char->partner_name): ?>
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($char->partner_id, $char->partner_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($char->partner_name) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Niveau job</th>
		<td colspan="2"><?php echo number_format((int)$char->char_job_level) ?></td>
		<th>Expérience job</th>
		<td><?php echo number_format($char->char_job_exp) ?></td>
		<th>Enfant</th>
		<td>
			<?php if ($char->child_name): ?>
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($char->child_id, $char->child_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($char->child_name) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>PV actuels</th>
		<td colspan="2"><?php echo number_format((int)$char->char_hp) ?></td>
		<th>PV max</th>
		<td><?php echo number_format((int)$char->char_max_hp) ?></td>
		<th>Mère</th>
		<td>
			<?php if ($char->mother_name): ?>
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($char->mother_id, $char->mother_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($char->mother_name) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>SP actuels</th>
		<td colspan="2"><?php echo number_format((int)$char->char_sp) ?></td>
		<th>SP max</th>
		<td><?php echo number_format((int)$char->char_max_sp) ?></td>
		<th>Père</th>
		<td>
			<?php if ($char->father_name): ?>
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($char->father_id, $char->father_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($char->father_name) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Zeny</th>
		<td colspan="2"><?php echo number_format((int)$char->char_zeny) ?></td>
		<th>Points de statut</th>
		<td><?php echo number_format((int)$char->char_status_point) ?></td>
		<th>Points de compétence</th>
		<td><?php echo number_format((int)$char->char_skill_point) ?></td>
	</tr>
	<tr>
		<th>Nom de guilde</th>
			<?php if ($char->guild_name): ?>
				<?php if ($char->emblem): ?>
				<td><img src="<?php echo $this->emblem($char->guild_id) ?>" /></td>
				<?php endif ?>
				<td<?php if (!$char->emblem) echo ' colspan="2"' ?>>
					<?php if ($auth->actionAllowed('guild', 'view')): ?>
						<?php echo $this->linkToGuild($char->guild_id, $char->guild_name) ?>
					<?php else: ?>
						<?php echo htmlspecialchars($char->guild_name) ?>
					<?php endif ?>
				</td>
			<?php else: ?>	
				<td colspan="2"><span class="not-applicable">Aucune</span></td>
			<?php endif ?>
		<th>Position de guilde</th>
		<td>
			<?php if ($char->guild_position): ?>
				<?php echo htmlspecialchars($char->guild_position) ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
		<th>Niveau de taxe</th>
		<td><?php echo number_format($char->guild_tax) ?>%</td>
	</tr>
	<tr>
		<th>Nom du groupe</th>
		<td colspan="2">
			<?php if ($char->party_name): ?>
				<?php echo htmlspecialchars($char->party_name) ?>
			<?php else: ?>	
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
		<th>Chef de groupe</th>
		<td>
			<?php if ($char->party_leader_name): ?>
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($char->party_leader_id, $char->party_leader_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($char->party_leader_name) ?>
				<?php endif ?>
			<?php else: ?>	
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
		<th>Familier</th>
		<td>
			<?php if ($char->pet_name): ?>
				<?php echo htmlspecialchars($char->pet_name) ?>
				(<?php echo htmlspecialchars($char->pet_mob_name) ?>)
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Nombre de morts</th>
		<td colspan="2"><?php echo number_format((int)$char->death_count) ?></td>
		<th>Statut en ligne</th>
		<td>
			<?php if ($char->char_online): ?>
				<span class="online">En ligne</span>
			<?php else: ?>
				<span class="offline">Hors ligne</span>
			<?php endif ?>
		</td>
		<th>Homunculus</th>
		<td>
			<?php if ($char->homun_name): ?>
				<?php echo htmlspecialchars($char->homun_name) ?>
				(<?php echo htmlspecialchars($this->homunClassText($char->homun_class)) ?>)
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Stats du personnage</th>
		<td colspan="6">
			<table class="character-stats">
				<tr>
					<td><span class="stat-name">STR</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_str) ?></span></td>
					<td><span class="stat-name">AGI</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_agi) ?></span></td>
					<td><span class="stat-name">VIT</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_vit) ?></span></td>
				</tr>
				<tr>
					<td><span class="stat-name">INT</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_int) ?></span></td>
					<td><span class="stat-name">DEX</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_dex) ?></span></td>
					<td><span class="stat-name">LUK</span></td>
					<td><span class="stat-value"><?php echo number_format((int)$char->char_luk) ?></span></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php if ($char->party_name): ?>
<h3>Autres membres du groupe <?php echo htmlspecialchars($char->party_name) ?></h3>
	<?php if ($partyMembers): ?>
		<p><?php echo htmlspecialchars($char->party_name) ?> possède <?php echo count($partyMembers) ?> autre(s) membre(s) en plus de <?php echo htmlspecialchars($char->char_name) ?>.</p>
		<table class="vertical-table">
			<tr>
				<th>Nom du personnage</th>
				<th>Classe job</th>
				<th>Niveau base</th>
				<th>Niveau job</th>
				<th colspan="2">Guilde</th>
				<th>Statut</th>
			</tr>
			<?php foreach ($partyMembers as $partyMember): ?>
			<tr>
				<td align="right">
					<?php if ($auth->allowedToViewCharacter): ?>
						<?php echo $this->linkToCharacter($partyMember->char_id, $partyMember->name) ?>
					<?php else: ?>
						<?php echo htmlspecialchars($partyMember->name) ?>
					<?php endif ?>
				</td>
				<td>
					<?php if ($job=$this->jobClassText($partyMember->class)): ?>
						<?php echo htmlspecialchars($job) ?>
					<?php else: ?>
						<span class="not-applicable">Inconnu</span>
					<?php endif ?>
				</td>
				<td><?php echo number_format((int)$partyMember->base_level) ?></td>
				<td><?php echo number_format((int)$partyMember->job_level) ?></td>
				<?php if ($partyMember->guild_name): ?>
					<?php if ($partyMember->emblem): ?>
						<td width="24"><img src="<?php echo $this->emblem($partyMember->guild_id) ?>" /></td>
						<td>
							<?php if (($auth->actionAllowed('guild', 'view') && $partyMember->guild_id == $char->guild_id) || $auth->allowedToViewGuild): ?>
								<?php echo $this->linkToGuild($partyMember->guild_id, $partyMember->guild_name) ?>
							<?php else: ?>
								<?php echo htmlspecialchars($partyMember->guild_name) ?>
							<?php endif ?>
						</td>
					<?php else: ?>
						<td colspan="2">
							<?php if (($auth->actionAllowed('guild', 'view') && $partyMember->guild_id == $char->guild_id) || $auth->allowedToViewGuild): ?>
								<?php echo $this->linkToGuild($partyMember->guild_id, $partyMember->guild_name) ?>
							<?php else: ?>
								<?php echo htmlspecialchars($partyMember->guild_name) ?>
							<?php endif ?>
						</td>
					<?php endif ?>
				<?php else: ?>	
					<td colspan="2" align="center"><span class="not-applicable">Aucune</span></td>
				<?php endif ?>
				<td>
					<?php if ($partyMember->online): ?>
						<span class="online">En ligne</span>
					<?php else: ?>
						<span class="offline">Hors ligne</span>
					<?php endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	<?php else: ?>
		<p>Il n’y a aucun autre membre dans ce groupe.</p>
	<?php endif ?>
<?php endif ?>
<h3>Amis de <?php echo htmlspecialchars($char->char_name) ?></h3>
<?php if ($friends): ?>
	<p><?php echo htmlspecialchars($char->char_name) ?> possède <?php echo count($friends) ?> ami(s).</p>
	<table class="vertical-table">
		<tr>
			<th>Nom du personnage</th>
			<th>Classe job</th>
			<th>Niveau base</th>
			<th>Niveau job</th>
			<th colspan="2">Guilde</th>
			<th>Statut</th>
		</tr>
		<?php foreach ($friends as $friend): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($friend->char_id, $friend->name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($friend->name) ?>
				<?php endif ?>
			</td>
			<td>
				<?php if ($job=$this->jobClassText($friend->class)): ?>
					<?php echo htmlspecialchars($job) ?>
				<?php else: ?>
					<span class="not-applicable">Inconnu</span>
				<?php endif ?>
			</td>
			<td><?php echo number_format((int)$friend->base_level) ?></td>
			<td><?php echo number_format((int)$friend->job_level) ?></td>
			<?php if ($friend->guild_name): ?>
				<?php if ($friend->emblem): ?>
				<td><img src="<?php echo $this->emblem($friend->guild_id) ?>" /></td>
				<?php endif ?>
				<td<?php if (!$friend->emblem) echo ' colspan="2"' ?>>
					<?php if (($auth->actionAllowed('guild', 'view') && $friend->guild_id == $char->guild_id) || $auth->allowedToViewGuild): ?>
						<?php echo $this->linkToGuild($friend->guild_id, $friend->guild_name) ?>
					<?php else: ?>
						<?php echo htmlspecialchars($friend->guild_name) ?>
					<?php endif ?>
				</td>
			<?php else: ?>	
				<td colspan="2"><span class="not-applicable">Aucune</span></td>
			<?php endif ?>
			<td>
				<?php if ($friend->online): ?>
					<span class="online">En ligne</span>
				<?php else: ?>
					<span class="offline">Hors ligne</span>
				<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p><?php echo htmlspecialchars($char->char_name) ?> n’a aucun ami.</p>
<?php endif ?>

<h3>Inventaire de <?php echo htmlspecialchars($char->char_name) ?></h3>
<?php if ($items): ?>
	<p><?php echo htmlspecialchars($char->char_name) ?> possède <?php echo count($items) ?> objet(s) dans son inventaire.</p>
	<table class="vertical-table">
		<tr>
			<th>ID d’objet</th>
			<th colspan="2">Nom</th>
			<th>Quantité</th>
			<th>Identifié</th>
			<th>Cassé</th>
			<th>Slot 1</th>
			<th>Slot 2</th>
			<th>Slot 3</th>
			<th>Slot 4</th>
			<?php if($server->isRenewal): ?>
				<th><?php echo htmlspecialchars(Flux::message('ItemRandOptionsLabel')) ?></th>
			<?php endif ?>
			<th>Extra</th>
		</tr>
		<?php foreach ($items AS $item): ?>
		<?php $icon = $this->iconImage($item->nameid) ?>
		<tr<?php if ($item->equip) echo ' class="equipped"' ?>>
			<td align="right"><?php echo $this->linkToItem($item->nameid, $item->nameid) ?></td>
			<?php if ($icon): ?>
				<td><img src="<?php echo htmlspecialchars($icon) ?>" /></td>
			<?php endif ?>
			<td<?php if (!$icon) echo ' colspan="2"' ?><?php if ($item->cardsOver) echo ' class="overslotted' . $item->cardsOver . '"'; else echo ' class="normalslotted"' ?>>
				<?php if ($item->refine > 0): ?>
					+<?php echo htmlspecialchars($item->refine) ?>
				<?php endif ?>
				<?php if ($item->card0 == 255 && intval($item->card1/1280) > 0): ?>
                    <?php $itemcard1 = intval($item->card1/1280); ?>
					<?php for ($i = 0; $i < $itemcard1; $i++): ?>
						Très
					<?php endfor ?>
					Puissant
				<?php endif ?>
				<?php if ($item->card0 == 254 || $item->card0 == 255): ?>
					<?php if ($item->char_name): ?>
						<?php if ($auth->actionAllowed('character', 'view') && ($isMine || (!$isMine && $auth->allowedToViewCharacter))): ?>
							<?php echo $this->linkToCharacter($item->char_id, $item->char_name, $session->serverName) . ' : ' ?>
						<?php else: ?>
							<?php echo htmlspecialchars($item->char_name . ' : ') ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span> :
					<?php endif ?>
				<?php endif ?>
				<?php if ($item->card0 == 255 && array_key_exists($item->card1%1280, $itemAttributes)): ?>
					<?php echo htmlspecialchars($itemAttributes[$item->card1%1280]) ?>
				<?php endif ?>
				<?php if ($item->name_english): ?>
					<span class="item_name"><?php echo htmlspecialchars($item->name_english) ?></span>
				<?php else: ?>
					<span class="not-applicable">Objet inconnu</span>
				<?php endif ?>
				<?php if ($item->slots): ?>
					<?php echo htmlspecialchars(' [' . $item->slots . ']') ?>
				<?php endif ?>
			</td>
			<td><?php echo number_format($item->amount) ?></td>
			<td>
				<?php if ($item->identify): ?>
					<span class="identified yes">Oui</span>
				<?php else: ?>
					<span class="identified no">Non</span>
				<?php endif ?>
			</td>
			<td>
				<?php if ($item->attribute): ?>
					<span class="broken yes">Oui</span>
				<?php else: ?>
					<span class="broken no">Non</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($item->card0 && ($item->type == $type_list['armor'] || $item->type == $type_list['weapon']) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
					<?php if (!empty($cards[$item->card0])): ?>
						<?php echo $this->linkToItem($item->card0, $cards[$item->card0]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($item->card0, $item->card0) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($item->card1 && ($item->type == $type_list['armor'] || $item->type == $type_list['weapon']) && $item->card0 != 255 && $item->card0 != -256): ?>
					<?php if (!empty($cards[$item->card1])): ?>
						<?php echo $this->linkToItem($item->card1, $cards[$item->card1]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($item->card1, $item->card1) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($item->card2 && ($item->type == $type_list['armor'] || $item->type == $type_list['weapon']) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
					<?php if (!empty($cards[$item->card2])): ?>
						<?php echo $this->linkToItem($item->card2, $cards[$item->card2]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($item->card2, $item->card2) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($item->card3 && ($item->type == $type_list['armor'] || $item->type == $type_list['weapon']) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
					<?php if (!empty($cards[$item->card3])): ?>
						<?php echo $this->linkToItem($item->card3, $cards[$item->card3]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($item->card3, $item->card3) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<?php if($server->isRenewal): ?>
				<td>
					<?php if($item->rndopt): ?>
						<ul>
							<?php foreach($item->rndopt as $rndopt) echo "<li>".$this->itemRandOption($rndopt[0], $rndopt[1])."</li>"; ?>
						</ul>
					<?php else: ?>
						<span class="not-applicable">Aucun</span>
					<?php endif ?>
				</td>
			<?php endif ?>
			<td>
			<?php if($item->bound == 1):?>
				Lié au compte
			<?php elseif($item->bound == 2):?>
				Lié à la guilde
			<?php elseif($item->bound == 3):?>
				Lié au groupe
			<?php elseif($item->bound == 4):?>
				Lié au personnage
			<?php else:?>
					<span class="not-applicable">Aucun</span>
			<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucun objet dans l’inventaire de ce personnage.</p>
<?php endif ?>

<h3>Inventaire du chariot de <?php echo htmlspecialchars($char->char_name) ?></h3>
<?php if ($cart_items): ?>
	<p><?php echo htmlspecialchars($char->char_name) ?> possède <?php echo count($cart_items) ?> objet(s) dans son chariot.</p>
	<table class="vertical-table">
		<tr>
			<th>ID d’objet</th>
			<th colspan="2">Nom</th>
			<th>Quantité</th>
			<th>Identifié</th>
			<th>Cassé</th>
			<th>Slot 1</th>
			<th>Slot 2</th>
			<th>Slot 3</th>
			<th>Slot 4</th>
			<?php if($server->isRenewal): ?>
				<th><?php echo htmlspecialchars(Flux::message('ItemRandOptionsLabel')) ?></th>
			<?php endif ?>
			<th>Extra</th>
			</th>
		</tr>
		<?php foreach ($cart_items AS $cart_item): ?>
		<?php $icon = $this->iconImage($cart_item->nameid) ?>
		<tr>
			<td align="right"><?php echo $this->linkToItem($cart_item->nameid, $cart_item->nameid) ?></td>
			<?php if ($icon): ?>
			<td><img src="<?php echo htmlspecialchars($icon) ?>" /></td>
			<?php endif ?>
			<td<?php if (!$icon) echo ' colspan="2"' ?><?php if ($item->cardsOver) echo ' class="overslotted' . $item->cardsOver . '"'; else echo ' class="normalslotted"' ?>>
				<?php if ($cart_item->refine > 0): ?>
					+<?php echo htmlspecialchars($cart_item->refine) ?>
				<?php endif ?>
				<?php if ($cart_item->card0 == 255 && intval($cart_item->card1/1280) > 0): ?>
                    <?php $itemcard1 = intval($cart_item->card1/1280); ?>
					<?php for ($i = 0; $i < $itemcard1; $i++): ?>
						Très
					<?php endfor ?>
					Puissant
				<?php endif ?>
				<?php if ($cart_item->card0 == 254 || $cart_item->card0 == 255): ?>
					<?php if ($cart_item->char_name): ?>
						<?php if ($auth->actionAllowed('character', 'view') && ($isMine || (!$isMine && $auth->allowedToViewCharacter))): ?>
							<?php echo $this->linkToCharacter($cart_item->char_id, $cart_item->char_name, $session->serverName) . ' : ' ?>
						<?php else: ?>
							<?php echo htmlspecialchars($cart_item->char_name . ' : ') ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span> :
					<?php endif ?>
				<?php endif ?>
				<?php if ($item->card0 == 255 && array_key_exists($item->card1%1280, $itemAttributes)): ?>
					<?php echo htmlspecialchars($itemAttributes[$item->card1%1280]) ?>
				<?php endif ?>
				<?php if ($cart_item->name_english): ?>
					<span class="item_name"><?php echo htmlspecialchars($cart_item->name_english) ?></span>
				<?php else: ?>
					<span class="not-applicable">Objet inconnu</span>
				<?php endif ?>
				<?php if ($cart_item->slots): ?>
					<?php echo htmlspecialchars(' [' . $cart_item->slots . ']') ?>
				<?php endif ?>
			</td>
			<td><?php echo number_format($cart_item->amount) ?></td>
			<td>
				<?php if ($cart_item->identify): ?>
					<span class="identified yes">Oui</span>
				<?php else: ?>
					<span class="identified no">Non</span>
				<?php endif ?>
			</td>
			<td>
				<?php if ($cart_item->attribute): ?>
					<span class="broken yes">Oui</span>
				<?php else: ?>
					<span class="broken no">Non</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($cart_item->card0 && ($cart_item->type == $type_list['armor'] || $cart_item->type == $type_list['weapon']) && $cart_item->card0 != 254 && $cart_item->card0 != 255 && $cart_item->card0 != -256): ?>
					<?php if (!empty($cart_cards[$cart_item->card0])): ?>
						<?php echo $this->linkToItem($cart_item->card0, $cart_cards[$cart_item->card0]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($cart_item->card0, $cart_item->card0) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($cart_item->card1 && ($cart_item->type == $type_list['armor'] || $cart_item->type == $type_list['weapon']) && $cart_item->card0 != 255 && $cart_item->card0 != -256): ?>
					<?php if (!empty($cart_cards[$cart_item->card1])): ?>
						<?php echo $this->linkToItem($cart_item->card1, $cart_cards[$cart_item->card1]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($cart_item->card1, $cart_item->card1) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($cart_item->card2 && ($cart_item->type == $type_list['armor'] || $cart_item->type == $type_list['weapon']) && $cart_item->card0 != 254 && $cart_item->card0 != 255 && $cart_item->card0 != -256): ?>
					<?php if (!empty($cart_cards[$cart_item->card2])): ?>
						<?php echo $this->linkToItem($cart_item->card2, $cart_cards[$cart_item->card2]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($cart_item->card2, $cart_item->card2) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<td>
				<?php if($cart_item->card3 && ($cart_item->type == $type_list['armor'] || $cart_item->type == $type_list['weapon']) && $cart_item->card0 != 254 && $cart_item->card0 != 255 && $cart_item->card0 != -256): ?>
					<?php if (!empty($cart_cards[$cart_item->card3])): ?>
						<?php echo $this->linkToItem($cart_item->card3, $cart_cards[$cart_item->card3]) ?>
					<?php else: ?>
						<?php echo $this->linkToItem($cart_item->card3, $cart_item->card3) ?>
					<?php endif ?>
				<?php else: ?>
					<span class="not-applicable">Aucun</span>
				<?php endif ?>
			</td>
			<?php if($server->isRenewal): ?>
				<td>
					<?php if($cart_item->rndopt): ?>
						<ul>
							<?php foreach($cart_item->rndopt as $rndopt) echo "<li>".$this->itemRandOption($rndopt[0], $rndopt[1])."</li>"; ?>
						</ul>
					<?php else: ?>
						<span class="not-applicable">Aucun</span>
					<?php endif ?>
				</td>
			<?php endif ?>
			<td>
			<?php if($cart_item->bound == 1):?>
				Lié au compte
			<?php elseif($cart_item->bound == 2):?>
				Lié à la guilde
			<?php elseif($cart_item->bound == 3):?>
				Lié au groupe
			<?php elseif($cart_item->bound == 4):?>
				Lié au personnage
			<?php else:?>
					<span class="not-applicable">Aucun</span>
			<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucun objet dans le chariot de ce personnage.</p>
<?php endif ?>

<?php else: ?>
<p>Ce personnage est introuvable. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
