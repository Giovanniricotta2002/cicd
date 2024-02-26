<?php
//$Id$ 
//gen openMairie le 16/09/2020 15:11

$import= "Insertion dans la table affectation_automatique voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."affectation_automatique";
$id='affectation_automatique'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "affectation_automatique" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "arrondissement" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "arrondissement",
            "foreign_column_name" => "arrondissement",
            "sql_exist" => "select * from ".DB_PREFIXE."arrondissement where arrondissement = '",
        ),
    ),
    "quartier" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "quartier",
            "foreign_column_name" => "quartier",
            "sql_exist" => "select * from ".DB_PREFIXE."quartier where quartier = '",
        ),
    ),
    "section" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "2",
    ),
    "instructeur" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "instructeur",
            "foreign_column_name" => "instructeur",
            "sql_exist" => "select * from ".DB_PREFIXE."instructeur where instructeur = '",
        ),
    ),
    "dossier_autorisation_type_detaille" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "dossier_autorisation_type_detaille",
            "foreign_column_name" => "dossier_autorisation_type_detaille",
            "sql_exist" => "select * from ".DB_PREFIXE."dossier_autorisation_type_detaille where dossier_autorisation_type_detaille = '",
        ),
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
    "instructeur_2" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "instructeur",
            "foreign_column_name" => "instructeur",
            "sql_exist" => "select * from ".DB_PREFIXE."instructeur where instructeur = '",
        ),
    ),
    "communes" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "2000",
    ),
    "affectation_manuelle" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "100",
    ),
    "dossier_instruction_type" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "dossier_instruction_type",
            "foreign_column_name" => "dossier_instruction_type",
            "sql_exist" => "select * from ".DB_PREFIXE."dossier_instruction_type where dossier_instruction_type = '",
        ),
    ),
);
