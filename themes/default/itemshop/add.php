<?php
if (!defined('FLUX_ROOT')) exit;
?>
<h2>Boutique d’objets</h2>
<h3>Ajouter un objet à la boutique</h3>
<?php if ($item): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" enctype="multipart/form-data">
<?php if (!$stackable): ?>
<input type="hidden" name="qty" value="1" />
<?php endif ?>
<table class="vertical-table">
	<tr>
		<th>ID d’objet</th>
		<td><?php echo $this->linkToItem($item->item_id, $item->item_id) ?></td>
	</tr>
	<tr>
		<th>Nom</th>
		<td><?php echo htmlspecialchars($item->item_name) ?></td>
	</tr>
	<tr>
		<th><label for="category">Catégorie</label></th>
		<td>
			<select name="category" id="category">
				<option value="none"<?php if (is_null($category) || strtolower($category) == 'none') echo ' selected="selected"' ?>><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></option>
				<?php foreach ($categories as $categoryID => $cat): ?>
					<option value="<?php echo (int)$categoryID ?>"<?php if ($category === (string)$categoryID) echo ' selected="selected"' ?>><?php echo htmlspecialchars($cat) ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="cost">Crédits</label></th>
		<td><input type="text" class="short" name="cost" id="cost" value="<?php echo htmlspecialchars($params->get('cost') ?: '') ?>" /></td>
	</tr>
	<?php if ($stackable): ?>
	<tr>
		<th><label for="qty">Quantité</label></th>
		<td><input type="text" class="short" name="qty" id="qty" value="<?php echo htmlspecialchars($params->get('qty') ?: '') ?>" /></td>
	</tr>
	<?php endif ?>
	<tr>
		<th><label for="info">Info</label></th>
		<td>
			<textarea name="info" id="info"><?php echo htmlspecialchars($params->get('info') ?: '') ?></textarea>
		</td>
	</tr>
	<tr>
		<th><label for="image">Image</label></th>
		<td>
			<input type="file" name="image" id="image" />
			<label>Essayer d’utiliser l’image existante de l’objet ? <input type="checkbox" name="use_existing" value="1"<?php if ($params->get('use_existing')) echo ' checked="checked"' ?> /></label>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" value="Ajouter" />
		</td>
	</tr>
</table>
</form>
<?php else: ?>
<p>Impossible d’ajouter un objet inconnu à la boutique. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
