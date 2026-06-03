<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<h2>Gestion des catégories</h2>
<h3><?php echo Flux::message('SDH3CurrentCat') ?></h3>
<?php if($catlist): ?>
	<table class="horizontal-table" width="100%"> 
		<tbody>
		<tr>
			<th>ID</th>
			<th>Nom de la catégorie</th>
			<th>Afficher ?</th>
			<th>Options</th>
		</tr>
		<?php foreach($catlist as $trow):?>
			<tr >
				<td><?php echo $trow->cat_id?></td>
				<td><?php echo $trow->name?></td>
				<td>
					<?php if($trow->display=='1'): ?>
					Oui
					<?php else: ?>
					<i>Masquée</i>
					<?php endif ?></td>
				<td>
					<?php if($trow->display=='1'): ?>
						<a href="<?php echo $this->url('servicedesk', 'catcontrol', array('option' => 'hide', 'catid' => $trow->cat_id))?>" >Masquer</a>
					<?php else: ?>
						<a href="<?php echo $this->url('servicedesk', 'catcontrol', array('option' => 'show', 'catid' => $trow->cat_id))?>" >Afficher</a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p>
		<?php echo Flux::message('SDNoCats') ?><br/><br/>
	</p>
<?php endif ?>
<br />
<h3><?php echo Flux::message('SDH3CreateCat') ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Nom de la catégorie</th>
			<th>Afficher ?</th>
		</tr>
		<tr>
			<td><input type="text" name="name" /></td>
			<td><select name="display"><option value="1">Oui</option><option value="0">Non</option></select></td>
		</tr>
		<tr>
			<td colspan="2">
			<input type="submit" value="Ajouter la catégorie" /></td>
		</tr>
    </table>
</form>
