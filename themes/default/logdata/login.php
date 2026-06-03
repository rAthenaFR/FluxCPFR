<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Connexions</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="use_log_after">Date entre :</label>
		<input type="checkbox" name="use_log_after" id="use_log_after"<?php if ($params->get('use_log_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('log_after') ?>
		<label for="use_log_before">&mdash;</label>
		<input type="checkbox" name="use_log_before" id="use_log_before"<?php if ($params->get('use_log_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('log_before') ?>
	</p>
	<p>
		<label for="ip">Adresse IP :</label>
		<input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($params->get('ip') ?: '') ?>" />
		...
		<label for="user">Nom d’utilisateur :</label>
		<input type="text" name="user" id="user" value="<?php echo htmlspecialchars($params->get('user') ?: '') ?>" />
		...
		<label for="log">Message du log :</label>
		<input type="text" name="log" id="log" value="<?php echo htmlspecialchars($params->get('log') ?: '') ?>" />
		...
		<label for="rcode">Réponse :</label>
		<input type="text" name="rcode" id="rcode" value="<?php echo htmlspecialchars($params->get('rcode') ?: '') ?>" />
		
		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($logins): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('time', 'Date/heure') ?></th>
		<th><?php echo $paginator->sortableColumn('ip', 'Adresse IP') ?></th>
		<th><?php echo $paginator->sortableColumn('user', 'Nom d’utilisateur') ?></th>
		<th><?php echo $paginator->sortableColumn('log', 'Message du log') ?></th>
		<th><?php echo $paginator->sortableColumn('rcode', 'Réponse') ?></th>
	</tr>
	<?php foreach ($logins as $login): ?>
	<tr>
		<td align="right"><?php echo htmlspecialchars($this->formatDateTime($login->time)) ?></td>
		<td>
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('last_ip' => $login->ip), $login->ip) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($login->ip) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($login->account_id && $auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($login->account_id, $login->user) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($login->user) ?>
			<?php endif ?>
		</td>
		<td><?php echo htmlspecialchars($login->log) ?></td>
		<td><?php echo htmlspecialchars($login->rcode) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>
	Aucune connexion trouvée.
	<a href="javascript:history.go(-1)">Retour</a>.
</p>
<?php endif ?>
