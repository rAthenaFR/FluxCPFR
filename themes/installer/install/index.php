<?php if (!$session->installerAuth): ?>
	<?php $success = TRUE; ?>
	<h3>Verification des prerequis</h3>

	<p>Avant de continuer l'installation, les prerequis ci-dessous doivent etre respectes.</p>

	<h4>Prerequis de base</h4>
	<table class="table">
		<tr><td style="width:20%;">Version PHP</td><td>
			<?php if ( version_compare( PHP_VERSION, $minimumVersionCheck['php']['required'] ) >= 0 ): ?>
				<span class="text-success"><?php echo PHP_VERSION ?></span>
			<?php else: $success = FALSE; ?>
				<span class="text-danger">La version de PHP n'est pas compatible. PHP <?php echo $minimumVersionCheck['php']['required']; ?> ou plus recent est requis (<?php echo $requirements['php']['recommended']; ?> ou plus recent recommande). Contactez votre hebergeur ou votre administrateur systeme pour demander une mise a niveau.</span>
			<?php endif ?>
		</td><td><?php echo $minimumVersionCheck['php']['required'] ?> requis</td><td><?php echo $minimumVersionCheck['php']['recommended'] ?> recommande</td></tr>
		<tr><td>Version MySQL</td><td>
			<?php if ( version_compare( $res->mysql_version, $minimumVersionCheck['mysql']['required'] ) >= 0 ): ?>
				<span class="text-success"><?php echo $res->mysql_version ?></span>
			<?php else: $success = FALSE; ?>
				<span class="text-danger">La version de MySQL n'est pas compatible. MySQL <?php echo $minimumVersionCheck['mysql']['required']; ?> ou plus recent est requis (<?php echo $requirements['mysql']['recommended']; ?> ou plus recent recommande). Contactez votre hebergeur ou votre administrateur systeme pour demander une mise a niveau.</span>
			<?php endif ?>
			</td><td><?php echo $minimumVersionCheck['mysql']['required'] ?> requis</td><td><?php echo $minimumVersionCheck['mysql']['recommended'] ?> recommande</td></tr>
	</table>
	<p class="pb-4">Ces prerequis sont le minimum necessaire pour executer FluxCP. Si l'un d'eux manque, FluxCP ne pourra pas fonctionner.</p>

	<h4>Extensions PHP</h4>
	<table class="table">
		<?php foreach($requiredExtensions as $requirement): ?>
			<tr><td style="width:20%;"><?php echo $requirement ?></td><td>
				<?php if ( extension_loaded($requirement) ): ?>
					<span class="text-success">Installee</span>
				<?php else: $success = FALSE; ?>
					<span class="text-danger">Non installee</span>
				<?php endif ?>
			</td></tr>
		<?php endforeach ?>
	</table>
	<p class="pb-4">Ces extensions PHP sont requises pour le bon fonctionnement de FluxCP. Certaines peuvent etre optionnelles selon la configuration, mais l'installateur les verifie toutes pour une installation propre.</p>

	<h4>Permissions des fichiers</h4>

	<table class="table">
		<?php foreach($permissionsChecks as $pathCheck => $pathDesc): ?>
			<?php $pathCheck = realpath($pathCheck); ?>
			<tr><td style="width:20%;"><?php echo $pathCheck ?></td><td>
				<?php if ( is_writable($pathCheck) ): ?>
					<span class="text-success"><?php echo $pathDesc ?> est accessible en ecriture</span>
				<?php else: $success = FALSE; ?>
					<span class="text-danger"><?php echo $pathDesc ?> n'est pas accessible en ecriture. Corrigez avec `chmod 0600 <?php echo $pathDesc ?>`</span>
				<?php endif ?>
			</td></tr>
		<?php endforeach ?>
	</table>
	<p class="pb-4">Ces permissions sont necessaires pour que FluxCP fonctionne correctement.</p>

	<?php if($success == TRUE): ?>
		<form action="<?php echo $this->url ?>" method="post" class="row g-3">
			<p>
				Saisissez le <em>mot de passe de l'installateur</em> pour continuer la mise a jour.
			</p>
			<div class="col-auto">
				<label for="installer_password">Mot de passe :</label>
			</div>
			<div class="col-auto">
				<input class="form-control" type="password" id="installer_password" name="installer_password" />
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-success">S'authentifier</button>
			</div>
		</form>
	<?php else: ?>
		<div class="alert alert-danger mb-5">
			<strong>Erreur :</strong> les prerequis pour executer FluxCP ne sont pas respectes. Corrigez les points ci-dessus puis reessayez.
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php if (isset($permissionError)): ?>
		<h2 class="error">Erreur de permissions MySQL</h2>
		<p>L'installateur a rencontre une erreur de permission pendant l'execution d'un schema SQL.</p>
		<p>Cela signifie generalement que l'utilisateur MySQL n'a pas les droits necessaires sur la base ou la table cible.</p>
		<table class="schema-info">
			<!--
			<tr>
				<th>Type de schema</th>
				<td><?php echo $permissionError->isLoginDbSchema() ? 'Base du serveur de connexion' : 'Base du serveur Char/Map' ?></td>
			</tr>
			<tr>
				<th>Fichier de schema</th>
				<td><?php echo htmlspecialchars(realpath($permissionError->schemaFile)) ?></td>
			</tr>
			-->
			<tr>
				<th>Serveur</th>
				<td>
					<?php echo htmlspecialchars($permissionError->mainServerName) ?>
					<?php if ($permissionError->charMapServerName): ?>
						(<?php echo htmlspecialchars($permissionError->charMapServerName) ?>)
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<th>Base de donnees</th>
				<td><?php echo htmlspecialchars($permissionError->databaseName) ?></td>
			</tr>
			<tr>
				<th>Erreur</th>
				<td><?php echo htmlspecialchars($permissionError->getMessage()) ?></td>
			</tr>
			<tr>
				<th>Requete SQL</th>
				<td><code><?php echo nl2br(htmlspecialchars($permissionError->query)) ?></code></td>
			</tr>
		</table>
		<h4 style="margin: 9px 0 0 0">La solution recommandee consiste a donner a l'utilisateur MySQL les droits necessaires pour executer la requete sur la base ou la table.</h4>
		<h4 style="margin: 4px 0 0 0">Executer la requete manuellement n'est pas supporte, car le suivi de version des schemas serait casse et l'installateur resterait actif.</h4>
	<?php else: ?>
	<div>
		<p class="menu">
			<a href="<?php echo $this->url($params->get('module'), null, array('logout' => 1)) ?>" onclick="return confirm('Voulez-vous vraiment vous deconnecter ?')">Deconnexion</a> |
			<a href="<?php echo $this->url($params->get('module'), null, array('update_all' => 1)) ?>" onclick="return confirm('Cette action modifiera votre base de donnees.\n\nVoulez-vous continuer l installation et les mises a jour Flux ?')"><strong>Tout installer ou mettre a jour</strong></a>
		</p>
		<p>"Tout installer ou mettre a jour" utilisera les identifiants MySQL deja configures pour chaque serveur.</p>
		<p>La liste ci-dessous indique les schemas installes et ceux qui doivent etre installes ou mis a jour.</p>
		<form action="<?php echo $this->urlWithQs ?>" method="post">
			<?php foreach ($installer->servers as $mainServerName => $mainServer): ?>
			<?php $servName = base64_encode($mainServerName) ?>
			<div class="row">
				<div class="col"><h3><?php echo htmlspecialchars($mainServerName) ?></h3></div>
			</div>
			<div class="row pb-2">
				<div class="col">Identifiants MySQL alternatifs</div>
			</div>
			<div class="row pb-2">
				<div class="col-6">
					<label for="username_<?php echo $servName ?>">Utilisateur MySQL</label>
				</div>
				<div class="col"><input class="form-control" type="text" name="username[<?php echo $servName ?>]" id="username_<?php echo $servName ?>" /></div>
			</div>
			<div class="row pb-3">
				<div class="col-6">
					<label for="password_<?php echo $servName ?>">Mot de passe MySQL</label>
				</div>
				<div class="col"><input class="form-control" type="password" name="password[<?php echo $servName ?>]" id="password_<?php echo $servName ?>" /></div>
			</div>
			<div class="row pb-5">
				<div class="col text-center">
					<button type="submit" name="update[<?php echo $servName ?>]" class="btn btn-success">
						Mettre a jour <strong><?php echo htmlspecialchars($mainServerName) ?></strong>
					</button>
				</div>
			</div>
			<div class="row">
				<table class="table">
				<tr>
					<th>Nom du schema</th>
					<th>Derniere version</th>
					<th>Version installee</th>
				</tr>
					<?php foreach ($mainServer->schemas as $schema): ?>
				<tr>
					<td>
						<span class="text-<?php echo ($schema->versionInstalled == $schema->latestVersion) ? 'success' : 'danger' ?>">
							<?php echo htmlspecialchars($schema->schemaInfo['name']) ?>
						</span>
					</td>
					<td>
						<?php if ($schema->latestVersion > $schema->versionInstalled): ?>
							<span class="schema-query" title="<?php echo htmlspecialchars(file_get_contents($schema->schemaInfo['files'][$schema->latestVersion])) ?>">
							<?php echo htmlspecialchars($schema->latestVersion) ?>
							</span>
						<?php else: ?>
							<?php echo htmlspecialchars($schema->latestVersion) ?>
						<?php endif ?>
					</td>
					<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Aucune</span>' ?></td>
				</tr>
					<?php endforeach ?>

					<?php foreach ($mainServer->charMapServers as $charMapServerName => $charMapServer): ?>
				<tr>
					<th colspan="3" class="pt-4"><h4><?php echo htmlspecialchars($charMapServerName) ?></h4></th>
				</tr>
				<tr>
					<th>Nom du schema</th>
					<th>Derniere version</th>
					<th>Version installee</th>
				</tr>
						<?php foreach ($charMapServer->schemas as $schema): ?>
				<tr>
					<td>
						<span class="text-<?php echo ($schema->versionInstalled == $schema->latestVersion) ? 'success' : 'danger' ?>">
							<?php echo htmlspecialchars($schema->schemaInfo['name']) ?>
						</span>
					</td>
					<td><?php echo htmlspecialchars($schema->latestVersion) ?></td>
					<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Aucune</span>' ?></td>
				</tr>
						<?php endforeach ?>

					<?php endforeach ?>
				<?php endforeach ?>
				</table>
			</div>
		</form>
		</div>
	<?php endif ?>
<?php endif ?>
