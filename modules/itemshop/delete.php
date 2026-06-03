<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

if (!$auth->allowedToDeleteShopItem) {
	$this->deny();
}

require_once 'Flux/ItemShop.php';

$shop       = new Flux_ItemShop($server);
$shopItemID = $params->get('id');
$deleted    = $shopItemID ? $shop->delete($shopItemID) : false;

if ($deleted) {
	$session->setMessageData('L’objet a bien été supprimé de la boutique.');
	$this->redirect($this->url('purchase'));
}
?>
