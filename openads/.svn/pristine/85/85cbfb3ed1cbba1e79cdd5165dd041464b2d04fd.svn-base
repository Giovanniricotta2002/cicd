<?php
//$Id$ 
//gen openMairie le 05/04/2023 17:16

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_instruction_type_categorie_tiers");
if(!isset($premier)) $premier='';
if(!isset($tricolsf)) $tricolsf='';
if(!isset($premiersf)) $premiersf='';
if(!isset($selection)) $selection='';
if(!isset($retourformulaire)) $retourformulaire='';
if (!isset($idxformulaire)) {
    $idxformulaire = '';
}
if (!isset($tricol)) {
    $tricol = '';
}
if (!isset($valide)) {
    $valide = '';
}
// FROM 
$table = DB_PREFIXE."lien_dossier_instruction_type_categorie_tiers
    LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte 
        ON lien_dossier_instruction_type_categorie_tiers.categorie_tiers=categorie_tiers_consulte.categorie_tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type ";
// SELECT 
$champAffiche = array(
    'lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers as "'.__("lien_dossier_instruction_type_categorie_tiers").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers").'"',
    "case lien_dossier_instruction_type_categorie_tiers.ajout_automatique when 't' then 'Oui' else 'Non' end as \"".__("ajout_automatique")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers as "'.__("lien_dossier_instruction_type_categorie_tiers").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers").'"',
    );
$tri="ORDER BY dossier_instruction_type.libelle ASC NULLS LAST";
$edition="lien_dossier_instruction_type_categorie_tiers";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
);
// Filtre listing sous formulaire - categorie_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["categorie_tiers_consulte"])) {
    $selection = " WHERE (lien_dossier_instruction_type_categorie_tiers.categorie_tiers = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type = ".intval($idxformulaire).") ";
}

