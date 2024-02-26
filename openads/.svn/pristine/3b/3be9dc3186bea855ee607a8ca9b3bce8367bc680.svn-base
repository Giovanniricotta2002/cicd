<?php
//$Id$ 
//gen openMairie le 16/12/2019 16:51

$import= "Insertion dans la table bible voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."bible";
$id='bible'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "bible" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "60",
    ),
    "evenement" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "evenement",
            "foreign_column_name" => "evenement",
            "sql_exist" => "select * from ".DB_PREFIXE."evenement where evenement = '",
        ),
    ),
    "contenu" => array(
        "notnull" => "1",
        "type" => "blob",
        "len" => "-5",
    ),
    "complement" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
    ),
    "automatique" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "3",
    ),
    "dossier_autorisation_type" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "dossier_autorisation_type",
            "foreign_column_name" => "dossier_autorisation_type",
            "sql_exist" => "select * from ".DB_PREFIXE."dossier_autorisation_type where dossier_autorisation_type = '",
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
);
