<?php
if (!defined('FLUX_ROOT')) exit;
$siteTitle  = Flux::config('SiteTitle');
$emailTitle = sprintf('%s : réponse à votre ticket', $siteTitle);
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
		
		<p>Vous recevez cet e-mail car un membre de l’équipe de support a répondu à votre ticket.</p>
		
		<p>
			<table style="margin-left: 18px">
				<tr>
					<td align="right">ID du ticket :&nbsp;&nbsp;</td>
					<th align="left">{TicketID}</th>
				</tr>
				<tr>
					<td align="right">Mis à jour par :&nbsp;&nbsp;</td>
					<th align="left">{Staff}</th>
				</tr>
			</table>
		</p>
		<br />
		<p><em><strong>Note :</strong> Ceci est un e-mail automatique, merci de ne pas répondre à cette adresse.</em></p>
	</body>
</html>
