<?php
//$Id$ 
//gen openMairie le 14/04/2015 22:08

$import= "Insertion dans la table direction voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."direction";
$id='direction'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "direction" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "code" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "20",
    ),
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "100",
    ),
    "description" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "chef" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "100",
    ),
    "om_validite_debut" => array(
        "notnull" => "",
        "type" => "date",
        "len" => "12",
    ),
    "om_validite_fin" => array(
        "notnull" => "",
        "type" => "date",
        "len" => "12",
    ),
    "om_collectivite" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "om_collectivite",
            "foreign_column_name" => "om_collectivite",
            "sql_exist" => "select * from ".DB_PREFIXE."om_collectivite where om_collectivite = '",
        ),
    ),
);
?>