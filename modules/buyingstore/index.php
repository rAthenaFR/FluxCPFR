<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Acheteurs';

// Recuperer le total et l'envoyer au paginateur.
$sth = $server->connection->getStatement("SELECT COUNT(id) AS total FROM buyingstores");
$sth->execute();
$paginator = $this->getPaginator($sth->fetch()->total);

// Colonnes triables.
$sortable = array(
 'id' => 'asc', 'map', 'char_name'
);
$paginator->setSortableColumns($sortable);

// Requete principale.
$sql = "SELECT `buyingstores`.char_id,`char`.name as char_name, `buyingstores`.id, `buyingstores`.sex, `buyingstores`.map, `buyingstores`.x, `buyingstores`.y, `buyingstores`.title, autotrade ";
$sql .= "FROM buyingstores ";
$sql .= "LEFT JOIN `char` on buyingstores.char_id = `char`.char_id ";
$sql = $paginator->getSQL($sql);
$sth = $server->connection->getStatement($sql);
$sth->execute();

$stores = $sth->fetchAll();
