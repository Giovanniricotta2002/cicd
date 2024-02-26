<?php
//$Id$ 
//gen openMairie le 03/11/2021 18:22

$import= "Insertion dans la table service voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."service";
$id='service'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "service" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "abrege" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "10",
    ),
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "70",
    ),
    "adresse" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "40",
    ),
    "adresse2" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "39",
    ),
    "cp" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "5",
    ),
    "ville" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "30",
    ),
    "email" => array(
        "notnull" => "1",
        "type" => "blob",
        "len" => "-5",
    ),
    "delai" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
    ),
    "delai_type" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "100",
    ),
    "type_consultation" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "70",
    ),
    "edition" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "om_etat",
            "foreign_column_name" => "om_etat",
            "sql_exist" => "select * from ".DB_PREFIXE."om_etat where om_etat = '",
        ),
    ),
    "consultation_papier" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "notification_email" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "service_type" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "255",
    ),
    "generate_edition" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "uid_platau_acteur" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "255",
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
