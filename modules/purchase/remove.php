<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$num = $params->get('num');
if (!is_null($num)) {
	if ($num instanceOf Flux_Config) {
		$num = $num->toArray();
	}
	
	$nRemoved = $server->cart->deleteByItemNum($num);
	if ($nRemoved) {
		if (!$server->cart->isEmpty()) {
			$session->setMessageData("$nRemoved objet(s) retire(s) du panier.");
			$this->redirect($this->url('purchase', 'cart'));
		}
		else {
			$session->setMessageData("$nRemoved objet(s) retire(s) du panier. Votre panier est maintenant vide.");
		}
	}
	else {
		$session->setMessageData("Aucun objet a retirer du panier.");
	}
	
	$this->redirect($this->url('purchase'));
}

$session->setMessageData('Aucun objet n’a ete retire du panier, car aucune selection n’a ete faite.');
$this->redirect($this->url('purchase', 'cart'));
?>
