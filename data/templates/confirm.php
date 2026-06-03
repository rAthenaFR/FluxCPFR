<?php
if (!defined('FLUX_ROOT')) exit;
$siteTitle  = Flux::config('SiteTitle');
$emailTitle = sprintf('%s : confirmation du compte', $siteTitle);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo htmlspecialchars($emailTitle) ?></title>
		<style type="text/css" media="screen">
			body, table {
				font-family: sans-serif;
				font-size: 10pt;
			}
		</style>
	</head>
	<body>
		<h2><?php echo htmlspecialchars($emailTitle) ?></h2>
		
		<p>Vous recevez cet e-mail car vous, ou une autre personne, avez créé un compte
			sur <strong><?php echo htmlspecialchars($siteTitle) ?></strong> avec cette
			adresse e-mail. Ouvrez le lien ci-dessous pour activer le compte.</p>
		
		<?php if ($expire=Flux::config('EmailConfirmExpire')): ?>
		<p>Tout compte non confirmé sera supprimé de notre système dans les <?php echo (int)$expire ?> heure(s) suivant son inscription.</p>
		<?php endif ?>
		
		<p>
			<table style="margin-left: 18px">
				<tr>
					<td align="right">Compte :&nbsp;&nbsp;</td>
					<th align="left">{AccountUsername}</th>
				</tr>
				<tr>
					<td align="right">Confirmation :&nbsp;&nbsp;</td>
					<th align="left"><a href="{ConfirmationLink}" title="Activer ce compte.">{ConfirmationLink}</a></th>
				</tr>
			</table>
		</p>
		
		<p><em><strong>Note :</strong> Ceci est un e-mail automatique, merci de ne pas répondre à cette adresse.</em></p>
	</body>
</html>
