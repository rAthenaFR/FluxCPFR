<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<h2>Paramètres équipe</h2>
<h3><?php echo Flux::message('SDH3StaffList') ?></h3>
<?php if($stafflist): ?>
	<table class="horizontal-table" width="100%"> 
		<tbody>
		<tr>
			<th>Nom de compte</th>
			<th>Nom affiché</th>
			<th>Équipe</th>
			<th>Alertes e-mail</th>
			<?php if(isset($staffsess) && $staffsess->team>'1'): ?>
			<th>Options</th>
			<?php endif ?>
		</tr>
		<?php foreach($stafflist as $trow):?>
			<tr >
				<td><?php echo $trow->account_name?></td>
				<td><?php echo $trow->prefered_name?></td>
				<td><?php echo Flux::message('SDGroup'. $trow->team) ?></td>
				<td>
					<?php if($trow->emailalerts=='1'): ?>
					Oui
					<?php else: ?>
					Non
					<?php endif ?>
					
					<?php if($trow->account_id==$session->account->account_id): ?>
						<a href="<?php echo $this->url('servicedesk', 'staffsettings', array('option' => 'alerttoggle', 'staffid' => $trow->account_id, 'cur' => $trow->emailalerts))?>" ><i>(basculer)</i></a>
					<?php endif ?>
					</td>
				<?php if(isset($staffsess) && $staffsess->team>'1'): ?>
				<td><a href="<?php echo $this->url('servicedesk', 'staffsettings', array('option' => 'delete', 'staffid' => $trow->account_id))?>" >Supprimer</a></td>
				<?php endif ?>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p>
		Aucun paramètre équipe n'est actuellement enregistré.<br/><br/>
	</p>
<?php endif ?>
<br />
<h3><?php echo Flux::message('SDH3StaffCreate') ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Nom de compte</th>
			<th>Nom affiché</th>
			<th>Équipe</th>
			<th>Alertes e-mail</th>
		</tr>
		<tr>
			<td><input type="text" name="account_name" value="<?php echo $session->account->userid ?>" readonly="readonly" /></td>
			<td><input type="text" name="prefered_name" /></td>
			<td><select name="team"><option value="1"><?php echo Flux::message('SDGroup1') ?></option><option value="2"><?php echo Flux::message('SDGroup2') ?></option><option value="3"><?php echo Flux::message('SDGroup3') ?></option></select></td>
			<td><input type="checkbox" name="emailalerts" value="1" /></td>
		</tr>
		<tr>
			<td colspan="4">
			<input type="hidden" name="account_id" value="<?php echo $session->account->account_id ?>" />
			<input type="submit" value="Ajouter à l'équipe" /></td>
		</tr>
    </table>
</form>
