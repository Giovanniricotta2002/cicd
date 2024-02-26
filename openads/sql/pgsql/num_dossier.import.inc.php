<?php
//$Id$ 
//gen openMairie le 31/08/2017 10:31

$import= "Insertion dans la table dossier voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."dossier";
$id='num_dossier'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "num_dossier" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "ref" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "30",
    ),
    "code" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "20",
    ),
    "petition" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "num_commande" => array(
        "notnull" => "",
        "type" => "float",
        "len" => "20",
    ),
    "date_depot" => array(
        "notnull" => "",
        "type" => "date",
        "len" => "12",
    ),
);
