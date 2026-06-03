<?php
if (!defined('FLUX_ROOT')) exit; 

$this->loginRequired();

$title = 'Ajouter un objet à la boutique';

require_once 'Flux/TemporaryTable.php';
require_once 'Flux/ItemShop.php';

$itemID = $params->get('id');

$category   = null;
$categories = Flux::config('ShopCategories')->toArray();

if($server->isRenewal) {
	$fromTables = array("{$server->charMapDatabase}.item_db_re", "{$server->charMapDatabase}.item_db2_re");
} else {
	$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
}
$tableName = "{$server->charMapDatabase}.items";
$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);
$shopTable = Flux::config('FluxTables.ItemShopTable');

$col = "id AS item_id, name_english AS item_name, type";
$sql = "SELECT $col FROM $tableName WHERE items.id = ?";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($itemID));
$item = $sth->fetch();

$stackable = false;
if ($item && Flux::isStackableItemType($item->type)) {
	$stackable = true;
}

if ($item && count($_POST)) {
	$maxCost     = (int)Flux::config('ItemShopMaxCost');
	$maxQty      = (int)Flux::config('ItemShopMaxQuantity');
	$category    = $params->get('category');
	$shop        = new Flux_ItemShop($server);
	$cost        = (int)$params->get('cost');
	$quantity    = (int)$params->get('qty');
	$info        = trim(htmlspecialchars($params->get('info')));
	$image       = $files->get('image');
	$useExisting = (int)$params->get('use_existing');
	
	if (!$cost) {
		$errorMessage = 'Vous devez saisir un coût en crédits supérieur à zéro.';
	}
	elseif ($cost > $maxCost) {
		$errorMessage = "Le coût en crédits ne doit pas dépasser $maxCost.";
	}
	elseif (!$quantity) {
		$errorMessage = 'Vous devez saisir une quantité supérieure à zéro.';
	}
	elseif ($quantity > 1 && !$stackable) {
		$errorMessage = 'Cet objet n’est pas empilable. La quantité doit être 1.';
	}
	elseif ($quantity > $maxQty) {
		$errorMessage = "La quantité de l’objet ne doit pas dépasser $maxQty.";
	}
	elseif (!$info) {
		$errorMessage = 'Vous devez saisir un texte d’information.';
	}
	else {
		if ($id=$shop->add($itemID, $category, $cost, $quantity, $info, $useExisting)) {
			$message = 'L’objet a bien été ajouté à la boutique';
			if ($image && $image->get('size') && !$shop->uploadShopItemImage($id, $image)) {
				$message .= ', mais l’image n’a pas pu être envoyée. Vous pouvez réessayer en modifiant l’objet.';
			}
			else {
				$message .= '.';
			}
			$session->setMessageData($message);
			$this->redirect($this->url('purchase'));	
		}
		else {
			$errorMessage = 'Impossible d’ajouter l’objet à la boutique.';
		}
	}
}

if (!$stackable) {
	$params->set('qty', 1);
}
?>
