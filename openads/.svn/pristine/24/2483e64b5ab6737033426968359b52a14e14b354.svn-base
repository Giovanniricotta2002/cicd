<?php
//$Id$ 
//gen openMairie le 05/12/2022 11:30

$import= "Insertion dans la table lien_habilitation_tiers_consulte_commune voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."lien_habilitation_tiers_consulte_commune";
$id='lien_habilitation_tiers_consulte_commune'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "lien_habilitation_tiers_consulte_commune" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "habilitation_tiers_consulte" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "habilitation_tiers_consulte",
            "foreign_column_name" => "habilitation_tiers_consulte",
            "sql_exist" => sprintf(
                "SELECT
                    *
                FROM
                    %shabilitation_tiers_consulte
                WHERE
                    habilitation_tiers_consulte = '",
                DB_PREFIXE
            ),
        ),
    ),
    "commune" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "commune",
            "foreign_column_name" => "commune",
            "sql_exist" => sprintf(
                "SELECT
                    *
                FROM
                    %scommune
                WHERE
                    commune = '",
                DB_PREFIXE
            ),
        ),
    ),
);
