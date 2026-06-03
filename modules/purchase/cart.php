<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

if ($server->cart->isEmpty()) {
	$session->setMessageData('Votre panier est actuellement vide.');
	$this->redirect($this->url('purchase'));
}

$title = 'Panier';

require_once 'Flux/ItemShop.php';
$items = $server->cart->getCartItems();
?>
