<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired('Veuillez vous connecter pour ajouter des objets au panier.');

require_once 'Flux/ItemShop.php';

$id   = $params->get('id');
$shop = new Flux_ItemShop($server);
$item = $shop->getItem($id);

if ($item) {
	$server->cart->add($item);
	$session->setMessageData("{$item->shop_item_name} a ete ajoute au panier.");
}
else {
	$session->setMessageData("Impossible d'ajouter cet objet au panier.");
}

$action = $params->get('cart') ? 'cart' : 'index';
$this->redirect($this->url('purchase', $action));
?>
