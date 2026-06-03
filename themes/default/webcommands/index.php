<?php
 if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();


?>
<h2><?php echo $pageTitle ?></h2>

<table width="950">
<?php if(!isset($_POST['updatefile'])): ?>
	<tr><td>Saisissez ci-dessous les commandes à exécuter.</td></tr>
	<tr><td>
			<form method="post" action="<?php echo $this->url('webcommands', 'index') ?>">
					<center>
						<input type="text" name="command" value="" />
						<input type="submit" name="submit" onclick="this.value='Envoi de la commande...';" class="button" value="Envoyer la commande">
					</center>
				</form>
			</td>
		</tr>
<?php endif ?>

<?php if(isset($_POST['command'])): ?>


	<tr><td colspan="2">Commande envoyée.<meta http-equiv="refresh" content="1;URL='<?php echo $this->url('webcommands', 'index') ?>'"></td></tr>


<?php endif ?>

</table>



<table>
<?php echo $output ?>
</table>
