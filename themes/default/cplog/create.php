<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Créations de comptes</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Rechercher...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="use_login_after">Date d’inscription entre :</label>
		<input type="checkbox" name="use_login_after" id="use_login_after"<?php if ($params->get('use_login_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('login_after') ?>
		<label for="use_login_before">&mdash;</label>
		<input type="checkbox" name="use_login_before" id="use_login_before"<?php if ($params->get('use_login_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('login_before') ?>
		<?php if ($auth->allowedToSearchCpLoginLogPw): ?>
		...
		<label for="password">Mot de passe :</label>
		<input type="text" name="password" id="password" value="<?php echo htmlspecialchars($params->get('password') ?: '') ?>" />
		<?php endif ?>
	</p>
	<p>
		<label for="account_id">ID de compte :</label>
		<input type="text" name="account_id" id="account_id" value="<?php echo htmlspecialchars($params->get('account_id') ?: '') ?>" />
		...
		<label for="username">Nom d’utilisateur :</label>
		<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($params->get('username') ?: '') ?>" />
		...
		<label for="ip">Adresse IP :</label>
		<input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($params->get('ip') ?: '') ?>" />
		...
		
		
		<input type="submit" value="Rechercher" />
		<input type="button" value="Réinitialiser" onclick="reload()" />
	</p>
</form>
<?php if ($logins): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('account_id', 'ID de compte') ?></th>
		<th><?php echo $paginator->sortableColumn('user_id', 'Nom d’utilisateur') ?></th>
		<?php if (($showPassword=Flux::config('CpLoginLogShowPassword')) && ($seePassword=$auth->allowedToSeeCpLoginLogPass)): ?>
		<th><?php echo $paginator->sortableColumn('user_pass', 'Mot de passe') ?></th>
		<?php endif ?>
		<th><?php echo $paginator->sortableColumn('reg_ip', 'Adresse IP') ?></th>
		<th><?php echo $paginator->sortableColumn('reg_date', 'Date d’inscription') ?></th>

	</tr>
	<?php foreach ($logins as $login): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($login->account_id, $login->account_id) ?>
			<?php else: ?>
				<?php echo $login->account_id ?>
			<?php endif ?>
		</td>
		<td><?php echo htmlspecialchars($login->userid) ?></td>
		<?php if ($showPassword && $seePassword): ?>
		<td><?php echo htmlspecialchars($login->user_pass) ?></td>
		<?php endif ?>
		<td>
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('reg_ip' => $login->reg_ip), $login->reg_ip) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($login->reg_ip) ?>
			<?php endif ?>
		</td>
		<td><?php echo $this->formatDateTime($login->reg_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucun log trouvé. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
