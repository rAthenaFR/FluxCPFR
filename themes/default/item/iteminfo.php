<?php if (!empty($errorMessage)): ?>
    <p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<?php if (!empty($successMessage)): ?>
    <p class="green"><?php echo htmlspecialchars($successMessage) ?></p>
<?php endif ?>

<h3>Configuration PHP</h3>
<p>Ces valeurs doivent être supérieures à la taille de votre fichier itemInfo.</p>
<table class="vertical-table">
	<tr>
		<th>Paramètres PHP</th><td>Valeur</td>
	</tr>
	<tr>
		<th>post_max_size</th><td><?php echo ini_get('post_max_size') ?></td>
	</tr>
	<tr>
		<th>upload_max_filesize</th><td><?php echo ini_get('upload_max_filesize') ?></td>
	</tr>
</table>
<p>ShowItemDesc est <?php if(Flux::config('ShowItemDesc')):?>activé<?php else: ?>désactivé<?php endif ?> dans votre fichier de configuration.</p>

<h3>Importer itemInfo.lua</h3>
<form class="forms" method="post" enctype="multipart/form-data">
    <input type="file" name="iteminfo"><br>
    <input class="btn" type="submit">
</form>

<h3>Nombre actuel</h3>
<p>La base contient actuellement <?php echo number_format($return->count) ?> descriptions d’objets.</p>
