<?php
/**
 * Ce script a pour objet de recuperer la liste des pétionnaires correspondant aux critères de recherche
 *
 * @package openfoncier
 * @version SVN : $Id: findArchitecte.php 4418 2015-02-24 17:30:28Z tbenita $
 */

require_once "../obj/utils.class.php";
$f = new utils("nohtml");
$f->isAccredited(array("donnees_techniques","donnees_techniques_modifier","donnees_techniques_ajouter"), "OR");
//Récupération des valeurs envoyées
$f->set_submitted_value();
// Donnees
$nom = ($f->get_submitted_post_value("nom") != null) ? $f->get_submitted_post_value("nom") : "";
$nom = str_replace('*', '', $nom);
$nom = html_entity_decode($nom, ENT_QUOTES);
$nom = $f->db->escapeSimple($nom);

$prenom = ($f->get_submitted_post_value("prenom") != null) ? $f->get_submitted_post_value("prenom") : "";
$prenom = str_replace('*', '', $prenom);
$prenom = html_entity_decode($prenom, ENT_QUOTES);
$prenom = $f->db->escapeSimple($prenom);

$listData = "";

$f->disableLog();

$qres = $f->get_all_results_from_db_query(
    sprintf(
        'SELECT 
            architecte AS value,
            TRIM(CONCAT_WS(
                \' \',
                nom,
                prenom,
                cp,
                ville
            )) AS content
        FROM
            %sarchitecte 
        WHERE 
            frequent IS TRUE
            %s
            %s',
        DB_PREFIXE,
        $nom != "" ? "AND nom ILIKE '%$nom%'": '',
        $prenom != "" ? "AND prenom ILIKE '%$prenom%'" : ''
    ),
    array(
        'origin' => 'app/findArchitecte'
    )
);
$listData = array();
foreach ($qres['result'] as $row) {
    $listData[] = $row;
}

echo json_encode($listData);

?>