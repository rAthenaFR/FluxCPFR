<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Vendeurs';

// Recuperer le total et l'envoyer au paginateur.
$sth = $server->connection->getStatement("SELECT COUNT(id) AS total FROM vendings");
$sth->execute();
$paginator = $this->getPaginator($sth->fetch()->total);

// Colonnes triables.
$sortable = array(
    'id' => 'asc', 'map', 'char_name'
    
);
$paginator->setSortableColumns($sortable);

// Requete principale.
$sql    = "SELECT `char`.name as char_name, `vendings`.id, `vendings`.sex, `vendings`.map, `vendings`.x, `vendings`.y, `vendings`.title, autotrade ";
$sql    .= "FROM vendings ";
$sql    .= "LEFT JOIN `char` on vendings.char_id = `char`.char_id ";
$sql  = $paginator->getSQL($sql);
$sth  = $server->connection->getStatement($sql);
$sth->execute();

$vendings = $sth->fetchAll();
?>
