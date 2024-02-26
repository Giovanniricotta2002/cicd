<?php
//$Id: architecte.import.inc.php 4598 2015-04-19 20:48:30Z tbenita $ 
//gen openMairie le 19/04/2015 22:32

$import= "Insertion dans la table architecte voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."architecte";
$id='architecte'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "architecte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "nom" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "prenom" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "adresse1" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "adresse2" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "cp" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "5",
    ),
    "ville" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "50",
    ),
    "pays" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "40",
    ),
    "inscription" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "20",
    ),
    "telephone" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "20",
    ),
    "fax" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "14",
    ),
    "email" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "60",
    ),
    "note" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "frequent" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "nom_cabinet" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "100",
    ),
    "conseil_regional" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "100",
    ),
);
?>