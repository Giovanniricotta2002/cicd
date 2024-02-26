<?php
//$Id: demandeur.import.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 06/02/2015 16:44

$import= "Insertion dans la table demandeur voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."demandeur";
$id='demandeur'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
/**
 *
 */
$fields = array(
    "demandeur" => array(
        "notnull" => "1",
        "type" => "int",
        "len" => "11",
    ),
    "type_demandeur" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "40",
    ),
    "qualite" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "40",
    ),
    "particulier_nom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "100",
    ),
    "particulier_prenom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "particulier_date_naissance" => array(
        "notnull" => "",
        "type" => "date",
        "len" => "12",
    ),
    "particulier_commune_naissance" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "30",
    ),
    "particulier_departement_naissance" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "80",
    ),
    "particulier_pays_naissance" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "250",
    ),
    "personne_morale_denomination" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "40",
    ),
    "personne_morale_raison_sociale" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "personne_morale_siret" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "15",
    ),
    "personne_morale_categorie_juridique" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "15",
    ),
    "personne_morale_nom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "personne_morale_prenom" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "numero" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "voie" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "55",
    ),
    "complement" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "lieu_dit" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "39",
    ),
    "localite" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "50",
    ),
    "code_postal" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "bp" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "cedex" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "pays" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "40",
    ),
    "division_territoriale" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "40",
    ),
    "telephone_fixe" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "20",
    ),
    "telephone_mobile" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "20",
    ),
    "indicatif" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "5",
    ),
    "courriel" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "60",
    ),
    "notification" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "frequent" => array(
        "notnull" => "",
        "type" => "bool",
        "len" => "1",
    ),
    "particulier_civilite" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "civilite",
            "foreign_column_name" => "civilite",
            "sql_exist" => "select * from ".DB_PREFIXE."civilite where civilite = '",
        ),
    ),
    "personne_morale_civilite" => array(
        "notnull" => "",
        "type" => "int",
        "len" => "11",
        "fkey" => array(
            "foreign_table_name" => "civilite",
            "foreign_column_name" => "civilite",
            "sql_exist" => "select * from ".DB_PREFIXE."civilite where civilite = '",
        ),
    ),
    "fax" => array(
        "notnull" => "",
        "type" => "string",
        "len" => "20",
    ),
);
?>