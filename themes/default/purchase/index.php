<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Boutique</h2>
<p>Les objets de cette boutique s’achetent avec les <span class="keyword">credits internes</span> de votre compte, jamais avec de l’argent reel.</p>
<h2>Boutique d’objets - <span class="shop-server-name"><?php echo htmlspecialchars($server->serverName) ?></span></h2>
<p class="action">
	<a href="<?php echo $this->url('purchase', 'index') ?>"<?php if (is_null($category)) echo ' class="current-shop-category"' ?>>
		<?php echo htmlspecialchars(Flux::message('AllLabel')) ?> (<?php echo number_format($total) ?>)
	</a>
<?php foreach ($categories as $catID => $catName): ?>
	/
	<a href="<?php echo $this->url('purchase', 'index', array('category' => $catID)) ?>"<?php if (!is_null($category) && $category === (string)$catID) echo ' class="current-shop-category"' ?>>
		<?php echo htmlspecialchars($catName) ?> (<?php echo number_format($categoryCount[$catID]) ?>)
	</a>
<?php endforeach ?>
</p>
<?php if ($categoryName): ?>
<h3>Categorie : <?php echo htmlspecialchars($categoryName) ?></h3>
<?php endif ?>
<?php if ($items): ?>
<?php if ($session->isLoggedIn()): ?>
	<?php if ($cartItems=$server->cart->getCartItemNames()): ?><p class="cart-items-text">Objets dans votre panier : <span class="cart-item-name"><?php echo implode('</span>, <span class="cart-item-name">', array_map('htmlspecialchars', $cartItems)) ?></span>.</p><?php endif ?>
	<p class="cart-info-text">Votre panier contient <span class="cart-item-count"><?php echo number_format(count($cartItems)) ?></span> objet(s).</p>
	<p class="cart-total-text">Sous-total actuel : <span class="cart-sub-total"><?php echo number_format($server->cart->getTotal()) ?></span> credit(s).</p>
<?php endif ?>
<?php echo $paginator->infoText() ?>
<table class="shop-table">
	<?php foreach ($items as $item): ?>
	<tr>
		<td class="shop-item-image">
		<?php if (($item->shop_item_use_existing && ($image=$this->itemImage($item->shop_item_nameid))) || ($image=$this->shopItemImage($item->shop_item_id))): ?>
			<img src="<?php echo $image ?>?nocache=<?php echo rand() ?>" />
		<?php endif ?>
		</td>
		<td>
			<h4 class="shop-item-name">
				<?php if ($item->shop_item_qty > 1): ?>
				<span class="qty"><?php echo number_format($item->shop_item_qty) ?>x</span>
				<?php endif ?>
				<?php echo $this->linkToItem($item->shop_item_nameid, $item->shop_item_name) ?>
			</h4>
			<p class="shop-item-info"><?php echo $item->shop_item_info ?></p>
			<p class="shop-item-action">
				<?php if ($auth->actionAllowed('item', 'view')): ?>
				<?php echo $this->linkToItem($item->shop_item_nameid, 'Voir l’objet') ?>
				<?php endif ?>
				<?php if ($auth->allowedToEditShopItem): ?>
				/ <a href="<?php echo $this->url('itemshop', 'edit', array('id' => $item->shop_item_id)) ?>">Modifier</a>
				<?php endif ?>
				<?php if ($auth->allowedToDeleteShopItem): ?>
				/ <a href="<?php echo $this->url('itemshop', 'delete', array('id' => $item->shop_item_id)) ?>"
					onclick="return confirm('Voulez-vous vraiment retirer cet objet de la boutique ?')">Supprimer</a>
				<?php endif ?>
			</p>
		</td>
		<td class="shop-item-cost-qty">
			<p><span class="cost"><?php echo number_format($item->shop_item_cost) ?></span> credit(s).</p>
			<p class="shop-item-action">
				<?php if ($auth->actionAllowed('purchase', 'add')): ?>
				<a href="<?php echo $this->url('purchase', 'add', array('id' => $item->shop_item_id)) ?>"><strong>Ajouter au panier</strong></a>
				<?php endif ?>
			</p>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Aucun objet n’est actuellement en vente.</p>
<?php endif ?>
