<?php
//$Id$ 
//gen openMairie le 07/02/2019 11:54

$import= "Insertion dans la table instructeur voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."instructeur";
$id='instructeur'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "instructeur" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "nom" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "100",
    ),
    "telephone" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "20",
    ),
    "division" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "division",
            "foreign_column_name" => "division",
            "sql_exist" => "select * from ".DB_PREFIXE."division where division = '",
        ),
    ),
    "om_utilisateur" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "om_utilisateur",
            "foreign_column_name" => "om_utilisateur",
            "sql_exist" => "select * from ".DB_PREFIXE."om_utilisateur where om_utilisateur = '",
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
    "instructeur_qualite" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "instructeur_qualite",
            "foreign_column_name" => "instructeur_qualite",
            "sql_exist" => "select * from ".DB_PREFIXE."instructeur_qualite where instructeur_qualite = '",
        ),
    ),
);
