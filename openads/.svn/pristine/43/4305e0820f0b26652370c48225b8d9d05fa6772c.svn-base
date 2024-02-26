<?php
//$Id$ 
//gen openMairie le 21/03/2022 12:21

$import= "Insertion dans la table tiers_consulte voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."tiers_consulte";
$id='tiers_consulte'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "categorie_tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "categorie_tiers_consulte",
            "foreign_column_name" => "categorie_tiers_consulte",
            "sql_exist" => sprintf(
                "SELECT
                    *
                FROM
                    %scategorie_tiers_consulte
                WHERE
                    categorie_tiers_consulte = '",
                DB_PREFIXE
            ),
        ),
    ),
    "abrege" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "30",
    ),
    "libelle" => array(
        "notnull" => "1",
        "type" => "string",
        "len" => "255",
    ),
    "adresse" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "300",
    ),
    "complement" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "300",
    ),
    "cp" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "ville" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "255",
    ),
    "liste_diffusion" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "accepte_notification_email" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "uid_platau_acteur" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "255",
    ),
);
