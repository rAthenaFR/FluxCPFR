<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Horaires War of Emperium</h2>
<?php if ($woeTimes): ?>
<p>Voici les horaires WoE pour <?php echo htmlspecialchars($session->loginAthenaGroup->serverName) ?>.</p>
<p>Ces horaires peuvent changer à tout moment.</p>
<table class="woe-table">
	<tr>
		<th>Serveurs</th>
		<th colspan="3">Horaires War of Emperium</th>
	</tr>
	<?php foreach ($woeTimes as $serverName => $times): ?>
	<tr>
		<td class="server" rowspan="<?php echo count($times) ?>">
			<?php echo htmlspecialchars($serverName)  ?>
		</td>
		<?php foreach ($times as $time): ?>
		<td class="time">
			<?php echo htmlspecialchars($time['startingDay']) ?>
			@ <?php echo htmlspecialchars($time['startingHour']) ?>
		</td>
		<td>~</td>
		<td class="time">
			<?php echo htmlspecialchars($time['endingDay']) ?>
			@ <?php echo htmlspecialchars($time['endingHour']) ?>
		</td>
	</tr>
	<tr>
		<?php endforeach ?>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Aucun horaire WoE n’est planifié.</p>
<?php endif ?>
