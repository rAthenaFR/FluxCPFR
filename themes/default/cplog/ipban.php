<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Bannissements IP</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="ip">Adresse IP :</label>
		<input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($params->get('ip') ?: '') ?>" />
		...
		<label for="banned_by">Banni par :</label>
		<input type="text" name="banned_by" id="banned_by" value="<?php echo htmlspecialchars($params->get('banned_by') ?: '') ?>" />
		...
		<label for="ban_type">Type de bannissement :</label>
		<select name="ban_type" id="ban_type">
			<option value=""<?php if (!($ban_type=$params->get('ban_type'))) echo ' selected="selected"' ?>><?php echo htmlspecialchars(Flux::message('AllLabel')) ?></option>
			<option value="unban"<?php if ($ban_type == 'unban') echo ' selected="selected"' ?>>Unban</option>
			<option value="ban"<?php if ($ban_type == 'ban') echo ' selected="selected"' ?>>Bannissement</option>
		</select>
	</p>
	<p>
		<label for="use_ban">Date de bannissement :</label>
		<input type="checkbox" name="use_ban" id="use_ban"<?php if ($params->get('use_ban')) echo ' checked="checked"' ?> />
		<?php echo $this->dateTimeField('ban') ?>
		...
		<label for="use_ban_until">Banni jusqu’au :</label>
		<input type="checkbox" name="use_ban_until" id="use_ban_until"<?php if ($params->get('use_ban_until')) echo ' checked="checked"' ?> />
		<?php echo $this->dateTimeField('ban_until') ?>
	</p>
	<p>
		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($ipbans): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('ip', 'Adresse IP') ?></th>
		<th><?php echo $paginator->sortableColumn('banned_by', 'Banni par') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_type', 'Type') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_date', 'Date de bannissement') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_until', 'Banni jusqu’au') ?></th>
		<th>Motif</th>
	</tr>
	<?php foreach ($ipbans as $ipban): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('last_ip' => $ipban->ip_address), $ipban->ip_address) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($ipban->ip_address) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($ipban->banned_by, $ipban->userid) ?>
			<?php else: ?>
				<?php echo $ipban->banned_by ?>
			<?php endif ?>
		</td>
		<td>
			<?php if (!$ipban->ban_type): ?>
				Unban
			<?php elseif ($ipban->ban_type == 1): ?>
				<span class="account-state state-banned">Bannissement</span>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_date <= '1000-01-01 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ipban->ban_date) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_until <= '1000-01-01 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ipban->ban_until) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_reason == ''): ?>
				<span class="not-applicable">Aucun</span>
			<?php else: ?>
				<?php echo htmlspecialchars($ipban->ban_reason) ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucun log trouvé. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
