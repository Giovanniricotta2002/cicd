<?php
//$Id: bible.import_specific.inc.php 9245 2020-04-03 09:21:03Z softime $ 
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
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "61",
    ),
    "contenu" => array(
        "notnull" => "1",
        "type" => "blob",
        "len" => "-5",
    ),
    "codes" => array(
        "notnull" => "1",
        "type" => "blob",
        "len" => "-5",
    )
);
