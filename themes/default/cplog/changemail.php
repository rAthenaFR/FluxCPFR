<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Changements d’e-mail</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="use_request_after">Date de demande entre :</label>
		<input type="checkbox" name="use_request_after" id="use_request_after"<?php if ($params->get('use_request_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('request_after') ?>
		<label for="use_request_before">&mdash;</label>
		<input type="checkbox" name="use_request_before" id="use_request_before"<?php if ($params->get('use_request_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('request_before') ?>
	</p>
	<p>
		<label for="use_change_after">Date de changement entre :</label>
		<input type="checkbox" name="use_change_after" id="use_change_after"<?php if ($params->get('use_change_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('change_after') ?>
		<label for="use_change_before">&mdash;</label>
		<input type="checkbox" name="use_change_before" id="use_change_before"<?php if ($params->get('use_change_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('change_before') ?>
	</p>
	<p>
		<label for="account_id">ID de compte :</label>
		<input type="text" name="account_id" id="account_id" value="<?php echo htmlspecialchars($params->get('account_id') ?: '') ?>" />
		...
		<label for="username">Nom d’utilisateur :</label>
		<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($params->get('username') ?: '') ?>" />
		...
		<label for="request_ip">IP de demande :</label>
		<input type="text" name="request_ip" id="request_ip" value="<?php echo htmlspecialchars($params->get('request_ip') ?: '') ?>" />
		...
		<label for="change_ip">IP de changement :</label>
		<input type="text" name="change_ip" id="change_ip" value="<?php echo htmlspecialchars($params->get('change_ip') ?: '') ?>" />
	</p>
	<p>
		<label for="old_email">Ancien e-mail :</label>
		<input type="text" name="old_email" id="old_email" value="<?php echo htmlspecialchars($params->get('old_email') ?: '') ?>" />
		...
		<label for="new_email">Nouvel e-mail :</label>
		<input type="text" name="new_email" id="new_email" value="<?php echo htmlspecialchars($params->get('new_email') ?: '') ?>" />
		
		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($changes): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('log.account_id', 'ID de compte') ?></th>
		<th><?php echo $paginator->sortableColumn('userid', 'Nom d’utilisateur') ?></th>
		<th><?php echo $paginator->sortableColumn('old_email', 'Ancien e-mail') ?></th>
		<th><?php echo $paginator->sortableColumn('new_email', 'Nouvel e-mail') ?></th>
		<th><?php echo $paginator->sortableColumn('request_date', 'Date de demande') ?></th>
		<th><?php echo $paginator->sortableColumn('request_ip', 'IP de demande') ?></th>
		<th><?php echo $paginator->sortableColumn('change_date', 'Date de changement') ?></th>
		<th><?php echo $paginator->sortableColumn('change_ip', 'IP de changement') ?></th>
	</tr>
	<?php foreach ($changes as $change): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'view')): ?>
				<?php echo $this->linkToAccount($change->account_id, $change->account_id) ?>
			<?php else: ?>
				<?php echo $change->account_id ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($change->userid): ?>
				<?php echo htmlspecialchars($change->userid) ?>
			<?php else: ?>
				<span class="not-applicable">Inconnu</span>
			<?php endif ?>
		</td>
		<td>
		<?php if ($auth->actionAllowed('account', 'index')): ?>
			<?php echo $this->linkToAccountSearch(array('email' => $change->old_email), $change->old_email) ?>
		<?php else: ?>
			<?php echo htmlspecialchars($change->old_email) ?>
		<?php endif ?>
		</td>
		<td>
		<?php if ($auth->actionAllowed('account', 'index')): ?>
			<?php echo $this->linkToAccountSearch(array('email' => $change->new_email), $change->new_email) ?>
		<?php else: ?>
			<?php echo htmlspecialchars($change->new_email) ?>
		<?php endif ?>
		</td>
		<td><?php echo $this->formatDateTime($change->request_date) ?></td>
		<td>
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('last_ip' => $change->request_ip), $change->request_ip) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($change->request_ip) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($change->change_date): ?>
				<?php echo $this->formatDateTime($change->change_date) ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($change->change_ip): ?>
				<?php if ($auth->actionAllowed('account', 'index')): ?>
					<?php echo $this->linkToAccountSearch(array('last_ip' => $change->change_ip), $change->change_ip) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($change->change_ip) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Aucune</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucun changement d’e-mail trouvé. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
