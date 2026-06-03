<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Exporter les emblèmes de guilde</h2>
<p>Sélectionnez les serveurs dont vous voulez exporter les emblèmes de guilde dans une archive ZIP.</p>
<form action="<?php echo $this->url ?>" method="post">
	<input type="hidden" name="post" value="1" />
	<?php foreach ($serverNames as $serverName): ?>
	<p class="emblem-server"><label>
		&raquo;
		<input type="checkbox" name="server[]" checked="checked" value="<?php echo htmlspecialchars($serverName) ?>" />
		<span><?php echo htmlspecialchars($serverName) ?></span>
	</label></p>
	<?php endforeach ?>
	<button type="submit" class="submit_button">Exporter</button>
</form>
