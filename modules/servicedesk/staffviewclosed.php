<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$tbl = Flux::config('FluxTables.ServiceDeskTable'); 
$tblcat = Flux::config('FluxTables.ServiceDeskCatTable'); 

$rep = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbl WHERE status = 'Closed' ORDER BY ticket_id DESC");
$rep->execute();
$ticketlist = $rep->fetchAll();
$rowoutput=NULL;
$statusLabels = array(
	'Pending'  => 'En attente',
	'Resolved' => 'Résolu',
	'Closed'   => 'Fermé'
);
$lastReplyLabels = array(
	'Staff'  => 'Équipe',
	'Player' => 'Joueur'
);
foreach($ticketlist as $trow){
$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE cat_id = ?");
$catsql->execute(array($trow->category));
$catlist = $catsql->fetch();
$statusLabel = isset($statusLabels[$trow->status]) ? $statusLabels[$trow->status] : $trow->status;
$lastReplyLabel = isset($lastReplyLabels[$trow->lastreply]) ? $lastReplyLabels[$trow->lastreply] : $trow->lastreply;

$rowoutput.='<tr >
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->ticket_id .'</a></td>
				<td>'. $trow->account_id .'</td>
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->subject .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >
					'. $catlist->name .'</a></td>
				<td>
					<font color="'. Flux::config('Font'. $trow->status .'Colour') .'"><strong>'. $statusLabel .'</strong></font>
				</td>
				<td width="50">';
				if($trow->lastreply=='0'){$rowoutput.='<i>Aucun</i>';} else {$rowoutput.= $lastReplyLabel;}
$rowoutput.='</td>
				<td>
					'. Flux::message('SDGroup'. $trow->team) .'
				</td>
				<td>'. date(Flux::config('DateFormat'),strtotime($trow->timestamp)) .'</td>
			</tr>';
}

?>
