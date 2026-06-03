<?php
if (!defined('FLUX_ROOT')) exit;

if (!extension_loaded('zip')) {
	throw new Flux_Error('L’extension `zip` doit être chargée pour utiliser cette fonctionnalité. Consultez le manuel PHP pour les instructions.');
}

$this->loginRequired();

$title = 'Exporter les emblèmes de guilde';

require_once 'Flux/EmblemExporter.php';
$exporter = new Flux_EmblemExporter($session->loginAthenaGroup);

$serverNames = $session->getAthenaServerNames();

if (count($_POST)) {
	$serverArr = $params->get('server');
	
	if ($serverArr instanceOf Flux_Config) {
		$array = $serverArr->toArray();
		
		foreach ($array as $serv) {
			$athenaServer = $session->getAthenaServer($serv);
			
			if ($athenaServer) {
				$exporter->addAthenaServer($athenaServer);
			}
		}
		
		$exporter->exportArchive();
	}
	else {
		$session->setMessageData('Vous devez d’abord sélectionner un serveur.');
	}
}
?>
