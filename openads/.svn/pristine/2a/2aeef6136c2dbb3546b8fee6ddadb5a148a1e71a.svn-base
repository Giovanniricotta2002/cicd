<?php
/**
 * Ce script a pour objet de recuperer la liste des quartiers d'un arrondissement
 *
 * @package openfoncier
 * @version SVN : $Id: listData.php 4418 2015-02-24 17:30:28Z tbenita $
 */

require_once "../obj/utils.class.php";

$f = new utils("nohtml");
$f->isAccredited(array("demande","demande_modifier","demande_ajouter"), "OR");
$f->disableLog();

// Identifiant de l'arrondissement
$idx = ($f->get_submitted_get_value("idx") != null) ? $f->get_submitted_get_value("idx") : "";
$tableName = ($f->get_submitted_get_value("tableName") != null) ? $f->get_submitted_get_value("tableName") : "";
$linkedField = ($f->get_submitted_get_value("linkedField") != null) ? $f->get_submitted_get_value("linkedField") : "";
$nature = ($f->get_submitted_get_value("nature") != null) ? $f->get_submitted_get_value("nature") : "";

$sql = '';
if ( isset($idx) && $idx !== '' && $idx !== '*' && is_numeric($idx)){
    
    /*Requête qui récupère les quartiers en fonction de leur arrondissement*/
    $sql .= sprintf(
        'WHERE
            %s = %s 
            AND demande_nature = %d
        ORDER BY 
            libelle',
        $this->f->db->escapeSimple($linkedField),
        intval($idx),
        $nature != "" ? 2 : 1
    );
}

$qres = $f->get_all_results_from_db_query(
    sprintf(
        'SELECT 
            %2$s,
            libelle
        FROM 
            %1$s%2$s
        %3$s',
        DB_PREFIXE,
        $this->f->db->escapeSimple($tableName),
        $sql
    ),
    array(
        'origin' => 'app/listData.php'
    )
);

$listData = array();
foreach ($qres['result'] as $row) {
    $listData .= $row[$tableName]."_".$row['libelle'].";";
}

echo json_encode($listData);
?>