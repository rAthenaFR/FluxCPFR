<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Objets en attente</h2>
<?php if ($items): ?>
<p>Vous avez <?php echo number_format($total) ?> objet(s) en attente de recuperation.</p>
<table class="vertical-table">
	<tr>
		<th>Nom de l’objet</th>
		<th>Quantite</th>
		<th>Cout</th>
		<th>Solde avant</th>
		<th>Solde apres</th>
		<th>Date d’achat</th>
	</tr>
	<?php foreach ($items as $item): ?>
	<tr>
		<td align="right">
			<?php if ($item->item_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($item->nameid, $item->item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($item->nameid) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td><?php echo number_format($item->quantity) ?></td>
		<td><?php echo number_format($item->cost) ?></td>
		<td><?php echo number_format($item->credits_before) ?></td>
		<td><?php echo number_format($item->credits_after) ?></td>
		
		<td><?php echo $this->formatDateTime($item->purchase_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Vous n’avez actuellement aucun objet en attente de recuperation.
	Pour acheter un objet, rendez-vous dans la <a href="<?php echo $this->url('purchase') ?>">boutique</a>.</p>
<?php endif ?>
