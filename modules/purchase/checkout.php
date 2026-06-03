<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$title = 'Validation du panier';

if ($server->cart->isEmpty()) {
	$session->setMessageData('Votre panier est actuellement vide.');
	$this->redirect($this->url('purchase'));
}
elseif (!$server->cart->hasFunds()) {
	$session->setMessageData('Votre solde est insuffisant pour effectuer cet achat.');
	$this->redirect($this->url('purchase'));
}

$items = $server->cart->getCartItems();

if (count($_POST) && $params->get('process')) {
	$redeemTable = Flux::config('FluxTables.RedemptionTable');
	$creditTable = Flux::config('FluxTables.CreditsTable');
	$deduct      = 0;
	
	$sql  = "INSERT INTO {$server->charMapDatabase}.$redeemTable ";
	$sql .= "(nameid, quantity, cost, account_id, char_id, redeemed, redemption_date, purchase_date, credits_before, credits_after) ";
	$sql .= "VALUES (?, ?, ?, ?, NULL, 0, NULL, NOW(), ?, ?)";
	$sth  = $server->connection->getStatement($sql);
	
	$balance = $session->account->balance;
	
	foreach ($items as $item) {
		$creditsAfter = $balance - $item->shop_item_cost;
		
		$res = $sth->execute(array(
			$item->shop_item_nameid,
			$item->shop_item_qty,
			$item->shop_item_cost,
			$session->account->account_id,
			$balance,
			$creditsAfter
		));
		
		if ($res) {
			$deduct  += $item->shop_item_cost;
			$balance -= $item->shop_item_cost;
		}
	}
	
	$session->loginServer->depositCredits($session->account->account_id, -$deduct);
	
	if ($res) {
		if (!$deduct) {
			$server->cart->clear();
			$session->setMessageData('Echec de l’achat des objets de votre panier.');
		}
		elseif ($deduct != $server->cart->getTotal()) {
			$server->cart->clear();
			$session->setMessageData('Certains objets ont ete achetes, mais d’autres ont echoue. Les credits non utilises sont conserves.');
		}
		else {
			$server->cart->clear();
			$session->setMessageData('Les objets ont ete achetes. Vous pouvez les recuperer en jeu via le PNJ de recompense.');
		}
	}
	else {
		$session->setMessageData('L’achat a echoue. Contactez un administrateur.');
	}
	
	$this->redirect();
}
?>
