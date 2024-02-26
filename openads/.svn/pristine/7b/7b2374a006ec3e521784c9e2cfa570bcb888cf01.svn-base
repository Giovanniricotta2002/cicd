<?php
//$Id$ 
//gen openMairie le 14/04/2015 22:09

$import= "Insertion dans la table division voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."division";
$id='division'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "division" => array(
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
    "direction" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "direction",
            "foreign_column_name" => "direction",
            "sql_exist" => "select * from ".DB_PREFIXE."direction where direction = '",
        ),
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
);
?>