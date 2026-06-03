<?php
if (!defined('FLUX_ROOT')) exit;
$siteTitle  = Flux::config('SiteTitle');
$emailTitle = sprintf('%s : changement d’e-mail', $siteTitle);
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
		
		<p>Vous recevez cet e-mail car une demande de changement d’adresse e-mail a été faite depuis votre compte.
			Si vous êtes bien à l’origine de cette action, cliquez sur le lien ci-dessous pour confirmer le changement.</p>
		
		<p>
			<table style="margin-left: 18px">
				<tr>
					<td align="right">Compte :&nbsp;&nbsp;</td>
					<th align="left">{AccountUsername}</th>
				</tr>
				<tr>
					<td align="right">Ancien e-mail :&nbsp;&nbsp;</td>
					<th align="left">{OldEmail}</th>
				</tr>
				<tr>
					<td align="right">Nouvel e-mail :&nbsp;&nbsp;</td>
					<th align="left">{NewEmail}</th>
				</tr>
				<tr>
					<td align="right">Changer l’e-mail :&nbsp;&nbsp;</td>
					<th align="left"><a href="{ChangeLink}" title="Changer l’e-mail de ce compte.">{ChangeLink}</a></th>
				</tr>
			</table>
		</p>
		
		<p><em><strong>Note :</strong> Ceci est un e-mail automatique, merci de ne pas répondre à cette adresse.</em></p>
	</body>
</html>
