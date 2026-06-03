<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

require_once 'Flux/ItemShop.php';

if ($server->cart && $server->cart->clear()) {
	$session->setMessageData("Votre panier a ete vide.");
}
else {
	$session->setMessageData("Impossible de vider le panier. Il est peut-etre deja vide.");
}

$this->redirect($this->url('purchase'));
?>
