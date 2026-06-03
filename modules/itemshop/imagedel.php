<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$shopItemID = $params->get('id');

if (!$shopItemID) {
	$this->deny();
}

require_once 'Flux/ItemShop.php';

$shop = new Flux_ItemShop($server);
$shop->deleteShopItemImage($shopItemID);

$session->setMessageData('L’image de l’objet boutique a bien été supprimée.');
$this->redirect($this->referer);
?>
