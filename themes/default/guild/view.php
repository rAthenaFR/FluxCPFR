<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Consultation de guilde</h2>
<?php if ($guild): ?>
<h3>Informations de la guilde « <?php echo htmlspecialchars($guild->name) ?> »</h3>
<table class="vertical-table">
	<tr>
		<th>ID de guilde</th>
		<td><?php echo htmlspecialchars($guild->guild_id) ?></td>
		<th>Nom de guilde</th>
		<td><?php echo htmlspecialchars($guild->name) ?></td>
		<th>ID de l’emblème</th>
		<td><?php echo number_format($guild->emblem) ?></td>
		<td><img src="<?php echo $this->emblem($guild->guild_id) ?>" /></td>
	</tr>
	<tr>
		<th>ID du chef</th>
		<td><?php echo htmlspecialchars($guild->char_id) ?></td>
		<th>Nom du chef</th>
		<td>
			<?php if ($auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($guild->char_id, $guild->guild_master) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($guild->guild_master) ?>
			<?php endif ?>
		</td>
		<th>Niveau de guilde</th>
		<td colspan="2"><?php echo number_format($guild->guild_lv) ?></td>
	</tr>
	<tr>
		<th>Membres en ligne</th>
		<td><?php echo number_format($guild->connect_member) ?></td>
		<th>Capacité</th>
		<td><?php echo number_format($guild->max_member) ?></td>
		<th>Niveau moyen</th>
		<td colspan="2"><?php echo number_format($guild->average_lv) ?></td>
	</tr>
	<tr>
		<th>EXP de guilde</th>
		<td><?php echo number_format($guild->exp) ?></td>
		<th>EXP avant niveau suivant</th>
		<td><?php echo number_format($guild->next_exp) ?></td>
		<th>Point de compétence</th>
		<td colspan="2"><?php echo number_format($guild->skill_point) ?></td>
	</tr>
	<tr>
		<th>Annonce de guilde 1</th>
		<td colspan="6">
			<?php if (trim($guild->mes1)): ?>
				<?php echo htmlspecialchars($guild->mes1) ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Annonce de guilde 2</th>
		<td colspan="6">
			<?php if (trim($guild->mes2)): ?>
				<?php echo htmlspecialchars($guild->mes2) ?></td>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
</table>
<h3>Alliances de « <?php echo htmlspecialchars($guild->name) ?> »</h3>
<?php if ($alliances): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> possède <?php echo count($alliances) ?> alliance(s).</p>
	<table class="vertical-table">
		<tr>
			<th>ID de guilde</th>
			<th>Nom de guilde</th>
		</tr>
		<?php foreach ($alliances AS $alliance): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewGuild): ?>
					<?php echo $this->linkToGuild($alliance->alliance_id, $alliance->alliance_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($alliance->alliance_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($alliance->name) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucune alliance pour cette guilde.</p>
<?php endif ?>
<h3>Oppositions de « <?php echo htmlspecialchars($guild->name) ?> »</h3>
<?php if ($oppositions): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> possède <?php echo count($oppositions) ?> opposition(s).</p>
	<table class="vertical-table">
		<tr>
			<th>ID de guilde</th>
			<th>Nom de guilde</th>
		</tr>
		<?php foreach ($oppositions AS $opposition): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewGuild): ?>
					<?php echo $this->linkToGuild($opposition->alliance_id, $opposition->alliance_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($opposition->alliance_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($opposition->name) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucune opposition pour cette guilde.</p>
<?php endif ?>
<h3>Membres de la guilde « <?php echo htmlspecialchars($guild->name) ?> »</h3>
<?php if ($members): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> possède <?php echo count($members) ?> membre(s).</p>
	<table class="vertical-table">
		<tr>
			<th>Nom</th>
			<th>Classe</th>
			<th>Niveau base</th>
			<th>Niveau job</th>
			<th>EXP Devotion</th>
			<th>ID de position</th>
			<th>Nom de position</th>
			<th>Droits de guilde</th>
			<th>Taxe</th>
			<th>Dernière connexion</th>
		</tr>
		<?php foreach ($members AS $member): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($member->char_id, $member->name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($member->name) ?>
				<?php endif ?>
			</td>
			<td>
				<?php if ($job=$this->jobClassText($member->class)): ?>
					<?php echo htmlspecialchars($job) ?>
				<?php else: ?>
					<span class="not-applicable">Inconnu</span>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($member->base_level) ?></td>
			<td><?php echo htmlspecialchars($member->job_level) ?></td>
			<td><?php echo number_format($member->devotion) ?></td>
			<td><?php echo htmlspecialchars($member->position) ?></td>
			<td><?php echo htmlspecialchars($member->position_name) ?></td>
			<td>
				<?php if ($member->mode == 17): ?>
					<?php echo htmlspecialchars("Inviter/Expulser") ?>
				<?php elseif ($member->mode == 16): ?>
					<?php echo htmlspecialchars("Expulser") ?>
				<?php elseif ($member->mode == 1): ?>
					<?php echo htmlspecialchars("Inviter") ?>
				<?php elseif ($member->mode == 0): ?>
					<span class="not-applicable">Aucun</span>
				<?php else: ?>
					<span class="not-applicable">Inconnu</span>
				<?php endif ?>
			</td>
			<td><?php echo number_format($member->guild_tax) ?>%</td>
			<td><?php echo htmlspecialchars($member->lastlogin) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucun membre dans cette guilde.</p>
<?php endif ?>
<h3>Expulsions de membres de « <?php echo htmlspecialchars($guild->name) ?> »</h3>
<?php if ($expulsions): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> possède <?php echo count($expulsions) ?> expulsion(s) de membre.</p>
	<table class="vertical-table">
		<tr>
			<th>ID de compte</th>
			<th>Nom du personnage</th>
			<th>Motif d’expulsion</th>
		</tr>
		<?php foreach ($expulsions AS $expulsion): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewAccount): ?>
					<?php echo $this->linkToAccount($expulsion->account_id, $expulsion->account_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($expulsion->account_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($expulsion->name) ?></td>
			<td>
			<?php if($expulsion->mes): ?>
				<?php echo htmlspecialchars($expulsion->mes) ?>
			<?php else: ?>
				<span class="not-applicable">Aucun</span>
			<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Aucune expulsion de membre pour cette guilde.</p>
<?php endif ?>
<?php if (!Flux::config('GStorageLeaderOnly') || $amOwner || $auth->allowedToViewGuild): ?>
	<h3>Objets du stockage de guilde de « <?php echo htmlspecialchars($guild->name) ?> »</h3>
	<?php if (Flux::config('GStorageLeaderOnly')): ?>
		<p>Note : les objets du stockage de guilde ne sont visibles que par vous, le chef de guilde.</p>
	<?php endif ?>
	<?php if ($items): ?>
		<p><?php echo htmlspecialchars($guild->name) ?> possède <?php echo count($items) ?> objet(s) dans le stockage de guilde.</p>
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
			<?php foreach ($items AS $item): ?>
			<?php $icon = $this->iconImage($item->nameid) ?>
			<tr>
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
		<p>Aucun objet dans le stockage de cette guilde.</p>
	<?php endif ?>
<?php endif ?>
<?php else: ?>
<p>Cette guilde est introuvable. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
