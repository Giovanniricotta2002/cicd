<?php
//$Id$ 
//gen openMairie le 14/04/2015 22:09

$import= "Insertion dans la table signataire_arrete voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."signataire_arrete";
$id='signataire_arrete'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "signataire_arrete" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "civilite" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "civilite",
            "foreign_column_name" => "civilite",
            "sql_exist" => "select * from ".DB_PREFIXE."civilite where civilite = '",
        ),
    ),
    "nom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "80",
    ),
    "prenom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "80",
    ),
    "qualite" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "80",
    ),
    "signature" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "defaut" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
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