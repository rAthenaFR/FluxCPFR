<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Validation du panier</h2>
<p>Une fois la validation terminee, vos objets pourront etre recuperes en jeu via le <span class="keyword">PNJ de recompense</span>.</p>

<h3>Informations d'achat</h3>
<p class="cart-total-text">Sous-total actuel : <span class="cart-sub-total"><?php echo number_format($total=$server->cart->getTotal()) ?></span> credit(s).</p>
<p class="checkout-info-text">Solde restant apres cet achat : <span class="remaining-balance"><?php echo number_format($session->account->balance - $total) ?></span> credit(s).</p>
<p>Apres verification des objets ci-dessous, cliquez sur le bouton "Acheter les objets" pour valider.</p>
<p class="important">Note : ces objets sont recuperables uniquement sur le serveur <span class="server-name"><?php echo htmlspecialchars($server->serverName) ?></span>.</p>
<p>
	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module'), 'checkout') ?>
		<input type="hidden" name="process" value="1" />
		<button type="submit" onclick="return confirm('Voulez-vous vraiment acheter les objets ci-dessous ?')">
			<strong>Acheter les objets</strong>
		</button>
	</form>
</p>

<h3>Objets actuellement dans votre panier :</h3>
<p class="cart-info-text">Votre panier contient <span class="cart-item-count"><?php echo number_format(count($items)) ?></span> objet(s).</p>
<table class="vertical-table cart">
	<?php foreach ($items as $item): ?>
	<tr>
		<td>
			<h4>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($item->shop_item_nameid, $item->shop_item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($item->shop_item_nameid) ?>
				<?php endif ?>
			</h4>
			<?php if ($item->shop_item_qty > 1): ?>
			<p class="shop-item-qty">Quantite : <span class="qty"><?php echo number_format($item->shop_item_qty) ?></span></p>
			<?php endif ?>
			<p class="shop-item-cost"><span class="cost"><?php echo number_format($item->shop_item_cost) ?></span> credit(s)</p>
			<p><?php echo nl2br(htmlspecialchars($item->shop_item_info)) ?></p>
		</td>
	</tr>
	<?php endforeach ?>
</table>
