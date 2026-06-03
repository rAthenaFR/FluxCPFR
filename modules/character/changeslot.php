<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$charID = $params->get('id');

if (!$charID) {
	$this->deny();
}

$char = $server->getCharacter($charID);
if (!$char || ($char->account_id != $session->account->account_id && !$auth->allowedToChangeSlot)) {
	$this->deny();
}

$title = "Changer l’emplacement de {$char->name}";

if ($char->online) {
	$session->setMessageData("Impossible de changer l’emplacement de {$char->name}. Ce personnage est actuellement en ligne.");
	$this->redirect();
}

if (count($_POST)) {
	if (!$params->get('changeslot')) {
		$this->deny();
	}
	
	$slot = (int)$params->get('slot');
	
	if ($slot > $server->maxCharSlots) {
		$errorMessage = "Le numéro d’emplacement ne doit pas dépasser {$server->maxCharSlots}.";
	}
	elseif ($slot < 1) {
		$errorMessage = 'Le numéro d’emplacement doit être supérieur à zéro.';
	}
	elseif ($slot === (int)$char->char_num+1) {
		$errorMessage = 'Veuillez choisir un emplacement différent.';
	}
	else {
		$sql  = "SELECT char_id, name, online FROM {$server->charMapDatabase}.`char` AS ch ";
		$sql .= "WHERE account_id = ? AND char_num = ? AND char_id != ?";
		$sth  = $server->connection->getStatement($sql);
		
		$sth->execute(array($char->account_id, $slot-1, $charID));
		
		$otherChar = $sth->fetch();
		
		if ($otherChar) {
			if ($otherChar->online) {
				$errorMessage = "{$otherChar->name} utilise déjà cet emplacement et est actuellement en ligne.";
			}
			else {
				$sql  = "UPDATE {$server->charMapDatabase}.`char` SET `char`.char_num = ?";
				$sql .= "WHERE `char`.char_id = ?";
				$sth  = $server->connection->getStatement($sql);
				
				$sth->execute(array($char->char_num, $otherChar->char_id));
			}
		}
		
		if (empty($errorMessage)) {
			$sql  = "UPDATE {$server->charMapDatabase}.`char` SET `char`.char_num = ?";
			$sql .= "WHERE `char`.char_id = ?";
			$sth  = $server->connection->getStatement($sql);
			
			$sth->execute(array($slot-1, $charID));
			
			if ($otherChar) {
				$otherNum = $char->char_num + 1;
				$session->setMessageData("L’emplacement de {$char->name} a bien été échangé avec celui de {$otherChar->name} (#$otherNum et #$slot).");
			}
			else {
				$session->setMessageData("L’emplacement de {$char->name} a bien été changé en #$slot.");
			}
			
			$isMine = $char->account_id == $session->account->account_id;
			if ($auth->actionAllowed('character', 'view') && ($isMine || $auth->allowedToViewCharacter)) {
				$this->redirect($this->url('character', 'view', array('id' => $char->char_id)));
			}
			else {
				$this->redirect();
			}
		}
	}
}
?>
