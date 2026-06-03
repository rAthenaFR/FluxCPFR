<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$ticket_id = trim($params->get('ticketid'));
$tbl = Flux::config('FluxTables.ServiceDeskTable');
$tbla = Flux::config('FluxTables.ServiceDeskATable');
$tblsettings = Flux::config('FluxTables.ServiceDeskSettingsTable');

$sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblsettings WHERE account_id = ?");
$sth->execute(array($session->account->account_id));
$staff = $sth->fetchAll();
if(!$staff){
	$session->setMessageData('Erreur : le compte n’est pas présent dans les paramètres équipe. Renseignez votre nom affiché avant d’utiliser le Service Desk.'); $this->redirect($this->url('servicedesk','staffsettings'));
} else {
	foreach($staff as $staffsess){}
}

if(isset($_POST['postreply']) && $_POST['postreply'] == 'gogolol'){
//	Répondre et revenir au ticket : <input type="radio" name="secact" value="1"/>
//	Répondre et revenir à la liste : <input type="radio" name="secact" value="2"/>
//	Répondre et résoudre le ticket : <input type="radio" name="secact" value="3"/>
//	Escalader : <input type="radio" name="secact" value="4"/>
//	Fermer le ticket : <input type="radio" name="secact" value="5"/>
//	Répondre et rouvrir le ticket : <input type="radio" name="secact" value="6"/>
//	Résoudre le ticket et créditer le compte : <input type="radio" name="secact" value="7"/>
	if($_POST['secact']=='1'){
		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, 0, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $_SERVER['REMOTE_ADDR']));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
				require_once 'Flux/Mailer.php';
				$name = $session->loginAthenaGroup->serverName;
				$mail = new Flux_Mailer();
				$sent = $mail->send($_POST['curemail'], 'Réponse au ticket', 'ticketreply', array(
					'TicketID'		=> $ticket_id,
					'Staff'			=> $staffsess->prefered_name
				));
				if ($sent) {
					$this->redirect($this->url('servicedesk','staffview', array('ticketid' => $ticket_id)));
				}
				else {
					$fail = true;
				}

	}elseif($_POST['secact']=='2'){
		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, 0, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $_SERVER['REMOTE_ADDR']));
				require_once 'Flux/Mailer.php';
				$name = $session->loginAthenaGroup->serverName;
				$mail = new Flux_Mailer();
				$sent = $mail->send($email, 'Réponse au ticket', 'ticketreply', array(
					'TicketID'		=> $ticket_id,
					'Staff'			=> $staffsess->prefered_name
				));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));

	}elseif($_POST['secact']=='3'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Resolved' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));

		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action='Ticket résolu';

		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $action, $_SERVER['REMOTE_ADDR']));
				require_once 'Flux/Mailer.php';
				$name = $session->loginAthenaGroup->serverName;
				$mail = new Flux_Mailer();
				$sent = $mail->send($email, 'Réponse au ticket', 'ticketreply', array(
					'TicketID'		=> $ticket_id,
					'Staff'			=> $staffsess->prefered_name
				));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));

	}elseif($_POST['secact']=='4'){
		if($staffsess->team=='1'){
			$escalateto=2;
		}
		if($staffsess->team=='2'){
			$escalateto=3;
		}
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET team = ? WHERE ticket_id = ?");
		$sth->execute(array($escalateto, $ticket_id));

		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action='Ticket transmis à l’équipe '. Flux::message('SDGroup'. $escalateto) .'.';
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $action, $_SERVER['REMOTE_ADDR']));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));

	}elseif($_POST['secact']=='5'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Closed' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action='Ticket fermé par un membre du groupe '. Flux::message('SDGroup'. $staffsess->team) .'.';
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $action, $_SERVER['REMOTE_ADDR']));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));

	}elseif($_POST['secact']=='6'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Pending' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));

		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action='Ticket rouvert par un membre du groupe '. Flux::message('SDGroup'. $staffsess->team) .'.';

		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $action, $_SERVER['REMOTE_ADDR'])); 
				require_once 'Flux/Mailer.php';
				$name = $session->loginAthenaGroup->serverName;
				$mail = new Flux_Mailer();
				$sent = $mail->send($email, 'Réponse au ticket', 'ticketreply', array(
					'TicketID'		=> $ticket_id,
					'Staff'			=> $staffsess->prefered_name
				));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));

	}elseif($_POST['secact']=='7'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Resolved' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$give_credits = intval($_POST['award_credits']);

		if($_POST['response']=='Leave as-is to skip text response.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action = sprintf('Ticket résolu, %d crédits attribués.', $give_credits);

		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 1)";
		$sth = $server->connection->getStatement($sql);
		$res = $server->loginServer->depositCredits($_POST['account_id'], $give_credits);
		$sth->execute(array($ticket_id, $_POST['staff_reply_name'], $text, $action, $_SERVER['REMOTE_ADDR']));
				require_once 'Flux/Mailer.php';
				$name = $session->loginAthenaGroup->serverName;
				$mail = new Flux_Mailer();
				$sent = $mail->send($email, 'Réponse au ticket', 'ticketreply', array(
					'TicketID'		=> $ticket_id,
					'Staff'			=> $staffsess->prefered_name
				));
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Staff' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id));
		$this->redirect($this->url('servicedesk','staffindex'));
	}
}

$tbl = Flux::config('FluxTables.ServiceDeskTable');
$tbla = Flux::config('FluxTables.ServiceDeskATable');
$sql = "SELECT * FROM {$server->loginDatabase}.$tbl WHERE ticket_id = $ticket_id";
$rep = $server->connection->getStatement($sql);
$rep->execute();
$ticketlist = $rep->fetchAll();
if($ticketlist) {
    foreach($ticketlist as $trow) {
		$chid=$trow->char_id;
		$sql = "SELECT * FROM {$server->charMapDatabase}.char WHERE char_id = $chid";
		$ch = $server->connection->getStatement($sql);
		$ch->execute();
		$chr = $ch->fetchAll();
		foreach($chr as $char) {
		}

		$aid=$trow->account_id;
		$ah = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.login WHERE account_id = $aid");
		$ah->execute();
		$ar = $ah->fetchAll();
		foreach($ar as $ticketaccount) {
		}
	}

} else {
    $this->redirect($this->url('servicedesk','index'));
}
$sqlr = "SELECT * FROM {$server->loginDatabase}.$tbla WHERE ticket_id = $ticket_id";
$repr = $server->connection->getStatement($sqlr);
$repr->execute();
$replylist = $repr->fetchAll();

$tblc = Flux::config('FluxTables.ServiceDeskCatTable');
$sth  = $server->connection->getStatement("SELECT name FROM {$server->loginDatabase}.$tblc WHERE cat_id = ?");
$sth->execute(array($trow->category));
$ticketlist = $sth->fetchAll();
if($ticketlist) {
	foreach($ticketlist as $crow) {
		$catname=$crow->name;
	}
}
?>
