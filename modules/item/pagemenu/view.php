<?php
$pageMenu = array();
if ($auth->actionAllowed('itemshop', 'add') && $auth->allowedToAddShopItem) {
	if ($item->cost) {
		$pageMenu['Ajouter à nouveau à la boutique'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
	else {
		$pageMenu['Ajouter à la boutique'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
}
return $pageMenu;
?>
