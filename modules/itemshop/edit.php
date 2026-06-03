<?php
if (!defined('FLUX_ROOT')) exit; 

$this->loginRequired();

$title = 'Modifier un objet dans la boutique';

require_once 'Flux/TemporaryTable.php';
require_once 'Flux/ItemShop.php';

$stackable   = false;
$shopItemID  = $params->get('id');
$shop        = new Flux_ItemShop($server);
$categories  = Flux::config('ShopCategories')->toArray();
$item        = $shop->getItem($shopItemID);

if ($item) {
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

	$sth->execute(array($item->shop_item_nameid));
	$originalItem = $sth->fetch();

	if ($originalItem && Flux::isStackableItemType($originalItem->type)) {
		$stackable = true;
	}
	
	if (count($_POST)) {
		$maxCost     = (int)Flux::config('ItemShopMaxCost');
		$maxQty      = (int)Flux::config('ItemShopMaxQuantity');
		$category    = $params->get('category');
		$cost        = (int)$params->get('cost');
		$quantity    = (int)$params->get('qty');
		$info        = trim($params->get('info'));
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
			if ($shop->edit($shopItemID, $category, $cost, $quantity, $info, $useExisting)) {
				if ($image && $image->get('size') && !$shop->uploadShopItemImage($shopItemID, $image)) {
					$errorMessage = 'Impossible d’envoyer l’image.';
				}
				else {
					$session->setMessageData('L’objet a bien été modifié.');
					$this->redirect($this->url('purchase'));
				}
			}
			else {
				$errorMessage = 'Impossible de modifier l’objet.';
			}
		}
	}
	
	if (empty($category)) {
		$category = $item->shop_item_category;
	}
	if (empty($cost)) {
		$cost = $item->shop_item_cost;
	}
	if (empty($quantity)) {
		$quantity = $item->shop_item_qty;
	}
	if (empty($info)) {
		$info = $item->shop_item_info;
	}
}

if (!$stackable) {
	$params->set('qty', 1);
}
?>
