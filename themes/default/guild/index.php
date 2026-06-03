<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Guildes</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
	<p>
		<label for="id">ID de guilde :</label>
		<input type="text" name="id" id="id" value="<?php echo htmlspecialchars($params->get('id') ?: '') ?>" />
		...
		<label for="guild_name">Nom de guilde :</label>
		<input type="text" name="guild_name" id="guild_name" value="<?php echo htmlspecialchars($params->get('guild_name') ?: '') ?>" />
		...
		<label for="char_id">ID du chef :</label>
		<input type="text" name="char_id" id="char_id" value="<?php echo htmlspecialchars($params->get('char_id') ?: '') ?>" />
		...
		<label for="master">Nom du chef :</label>
		<input type="text" name="master" id="master" value="<?php echo htmlspecialchars($params->get('master') ?: '') ?>" />
	</p>
	<p>
		<label for="guild_level">Niveau de guilde :</label>
		<select name="guild_level_op">
			<option value="eq"<?php if (($guild_level_op=$params->get('guild_level_op')) == 'eq') echo ' selected="selected"' ?>>est égal à</option>
			<option value="gt"<?php if ($guild_level_op == 'gt') echo ' selected="selected"' ?>>est supérieur à</option>
			<option value="lt"<?php if ($guild_level_op == 'lt') echo ' selected="selected"' ?>>est inférieur à</option>
		</select>
		<input type="text" name="guild_level" id="guild_level" value="<?php echo htmlspecialchars($params->get('guild_level') ?: '') ?>" />
		...
		<label for="connect_member">Membres en ligne :</label>
		<select name="connect_member_op">
			<option value="eq"<?php if (($connect_member_op=$params->get('connect_member_op')) == 'eq') echo ' selected="selected"' ?>>est égal à</option>
			<option value="gt"<?php if ($connect_member_op == 'gt') echo ' selected="selected"' ?>>est supérieur à</option>
			<option value="lt"<?php if ($connect_member_op == 'lt') echo ' selected="selected"' ?>>est inférieur à</option>
		</select>
		<input type="text" name="connect_member" id="connect_member" value="<?php echo htmlspecialchars($params->get('connect_member') ?: '') ?>" />
		...
		<label for="max_member">Capacité :</label>
		<select name="max_member_op">
			<option value="eq"<?php if (($max_member_op=$params->get('max_member_op')) == 'eq') echo ' selected="selected"' ?>>est égal à</option>
			<option value="gt"<?php if ($max_member_op == 'gt') echo ' selected="selected"' ?>>est supérieur à</option>
			<option value="lt"<?php if ($max_member_op == 'lt') echo ' selected="selected"' ?>>est inférieur à</option>
		</select>
		<input type="text" name="max_member" id="max_member" value="<?php echo htmlspecialchars($params->get('max_member') ?: '') ?>" />
	</p>
	<p>
		<label for="average_lv">Niveau moyen :</label>
		<select name="average_lv_op">
			<option value="eq"<?php if (($average_lv_op=$params->get('average_lv_op')) == 'eq') echo ' selected="selected"' ?>>est égal à</option>
			<option value="gt"<?php if ($average_lv_op == 'gt') echo ' selected="selected"' ?>>est supérieur à</option>
			<option value="lt"<?php if ($average_lv_op == 'lt') echo ' selected="selected"' ?>>est inférieur à</option>
		</select>
		<input type="text" name="average_lv" id="average_lv" value="<?php echo htmlspecialchars($params->get('average_lv') ?: '') ?>" />

		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($guilds): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('guild.guild_id', 'ID de guilde') ?></th>
		<th colspan="2"><?php echo $paginator->sortableColumn('guildName', 'Nom de guilde') ?></th>
		<th><?php echo $paginator->sortableColumn('charID', 'ID du chef') ?></th>
		<th><?php echo $paginator->sortableColumn('charName', 'Nom du chef') ?></th>
		<th><?php echo $paginator->sortableColumn('guildLevel', 'Niveau de guilde') ?></th>
		<th><?php echo $paginator->sortableColumn('connectMem', 'Membres en ligne') ?></th>
		<th><?php echo $paginator->sortableColumn('maxMem', 'Capacité') ?></th>
		<th><?php echo $paginator->sortableColumn('avgLevel', 'Niveau moyen') ?></th>
	</tr>
	<?php foreach ($guilds as $guild): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('guild', 'view') && $auth->allowedToViewGuild): ?>
				<?php echo $this->linkToGuild($guild->guild_id, $guild->guild_id) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($guild->guild_id) ?>
			<?php endif ?>
		</td>
		<?php if ($guild->emblem): ?>
		<td width="24"><img src="<?php echo $this->emblem($guild->guild_id) ?>" /></td>
		<td><?php echo htmlspecialchars($guild->guildName) ?></td>
		<?php else: ?>
		<td colspan="2"><?php echo htmlspecialchars($guild->guildName) ?></td>
		<?php endif ?>
		<td>
			<?php if ($auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($guild->charID, $guild->charID) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($guild->charID) ?>
			<?php endif ?>
		</td>
		<td><?php echo htmlspecialchars($guild->charName) ?></td>
		<td><?php echo number_format($guild->guildLevel) ?></td>
		<td><?php echo number_format($guild->connectMem) ?></td>
		<td><?php echo number_format($guild->maxMem) ?></td>
		<td><?php echo number_format($guild->avgLevel) ?></td>
		
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucune guilde trouvée. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
