<?php
//$Id$ 
//gen openMairie le 05/12/2022 11:22

$import= "Insertion dans la table habilitation_tiers_consulte voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."habilitation_tiers_consulte";
$id='habilitation_tiers_consulte'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "habilitation_tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "type_habilitation_tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "type_habilitation_tiers_consulte",
            "foreign_column_name" => "type_habilitation_tiers_consulte",
            "sql_exist" => sprintf(
                "SELECT
                    *
                FROM
                    %stype_habilitation_tiers_consulte
                WHERE
                    type_habilitation_tiers_consulte = '",
                DB_PREFIXE
            ),
        ),
    ),
    "texte_agrement" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
    ),
    "division_territoriales" => array(
        "notnull" => "",
        "type" => "blob",
        "len" => "-5",
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
    "tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "tiers_consulte",
            "foreign_column_name" => "tiers_consulte",
            "sql_exist" => sprintf(
                "SELECT
                    *
                FROM
                    %stiers_consulte
                WHERE
                    tiers_consulte = '",
                DB_PREFIXE
            ),
        ),
    ),
);
