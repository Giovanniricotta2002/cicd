<?php
//$Id: contrainte.import.inc.php 4598 2015-04-19 20:48:30Z tbenita $ 
//gen openMairie le 19/04/2015 22:33

$import= "Insertion dans la table contrainte voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."contrainte";
$id='contrainte'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "contrainte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "numero" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "250",
    ),
    "nature" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "10",
    ),
    "groupe" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "250",
    ),
    "sousgroupe" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "250",
    ),
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "250",
    ),
    "texte" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "no_ordre" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
    ),
    "reference" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "service_consulte" => array(
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