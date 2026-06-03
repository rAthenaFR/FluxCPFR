<?php
if (!defined('FLUX_ROOT')) exit;

require_once 'Flux/Installer/SchemaPermissionError.php';

// Force debug mode off here.
Flux::config('DebugMode', false);

// Define minimum requirements.
$requiredExtensions = array(
	'pdo',
	'pdo_mysql',
	'curl',
	//'gd',
	//'dom',
	//'json',
	//'mbstring',
	//'zip',
	'xml',
	'xmlreader',
	'mysqli'
);

$minimumVersionCheck = [
	'php' => [
		'required' => '7.3.0',
		'recommended' => '8.4.0'
	],
	'mysql' => [
		'required' => '5.0.0',
		'recommended' => '8.0.44'
	]
];
$sth = $server->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
$sth->execute();
$res = $sth->fetch();

$permissionsChecks = [
	FLUX_DATA_DIR.'/logs'		=> 'log storage',
	FLUX_DATA_DIR.'/itemshop'	=> 'item shop image',
	FLUX_DATA_DIR.'/tmp'		=> 'temporary'
];

if ($session->installerAuth) {
	if ($params->get('logout')) {
		$session->setInstallerAuthData(false);
	}
	else {
		$requiredMySqlVersion = '5.0';

		foreach (Flux::$loginAthenaGroupRegistry as $serverName => $loginAthenaGroup) {
			$sth = $loginAthenaGroup->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
			$sth->execute();
			
			$res = $sth->fetch();
			if (!$res || version_compare($res->mysql_version, $requiredMySqlVersion, '<')) {
				$message  = "MySQL $requiredMySqlVersion ou supérieur est requis pour Flux.";
				$message .= $res ? " Version détectée : {$res->mysql_version}" : " Version détectée inconnue";
				$message .= " sur le serveur '$serverName'"; 
				throw new Flux_Error($message);
			}
		}
		
		if ($params->get('update_all')) {
			try {
				$installer->updateAll();
				if (!$installer->updateNeeded()) {
					$session->setMessageData('Les mises à jour ont été installées.');
					$session->setInstallerAuthData(false);
					$this->redirect();
				}
			}
			catch (Flux_Installer_SchemaPermissionError $e) {
				$permissionError = $e;
			}
		}
		elseif (($username=$params->get('username')) && $username instanceOf Flux_Config &&
				($password=$params->get('password')) && $password instanceOf Flux_Config &&
				($update=$params->get('update')) && $update instanceOf Flux_Config) {
				
			$server64     = key($update->toArray());
			$username     = $username->get($server64);
			$password     = $password->get($server64);
			$serverName   = base64_decode($server64);
			$server       = array_key_exists($serverName, $installer->servers) ? $installer->servers[$serverName] : false;
			$updateNeeded = false;
			
			if ($server) {
				foreach ($server->schemas as $schema) {
					if (!$schema->isLatest()) {
						$updateNeeded = true;
						break;
					}
				}
				
				if (!$updateNeeded) {
					foreach ($server->charMapServers as $charMapServer) {
						foreach ($charMapServer->schemas as $schema) {
							if (!$schema->isLatest()) {
								$updateNeeded = true;
								break;
							}
						}
					}
				}
			}
			
			if (!$updateNeeded || !$server) {
				$errorMessage = 'Serveur invalide ou aucune mise à jour disponible.';
			}
			elseif (!$username || !$password) {
				$errorMessage = "Le nom d’utilisateur et le mot de passe sont requis pour mettre à jour un serveur individuellement.";
			}
			else {
				$connection = $server->loginAthenaGroup->connection;
				$connection->reconnectAs($username, $password);
				try {
					$server->updateAll();
					$session->setMessageData("Les mises à jour pour $serverName ont été installées.");
					$this->redirect();
				}
				catch (Flux_Installer_SchemaPermissionError $e) {
					$permissionError = $e;
				}
			}
		}
	}
}

if (count($_POST) && !$session->installerAuth) {
	$inputPassword  = $params->get('installer_password');
	$actualPassword = Flux::config('InstallerPassword');
	
	if ($inputPassword == $actualPassword) {
		$session->setInstallerAuthData(true);
	}
	else {
		$errorMessage = 'Mot de passe incorrect.';
	}
}
?>
