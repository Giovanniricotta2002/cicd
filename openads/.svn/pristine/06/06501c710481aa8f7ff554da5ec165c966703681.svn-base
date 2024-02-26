<?php
//$Id$ 
//gen openMairie le 23/01/2023 14:57

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_tiers");
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
$table = DB_PREFIXE."lien_dossier_tiers
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON lien_dossier_tiers.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte 
        ON lien_dossier_tiers.tiers=tiers_consulte.tiers_consulte ";
// SELECT 
$champAffiche = array(
    'lien_dossier_tiers.lien_dossier_tiers as "'.__("lien_dossier_tiers").'"',
    'dossier.annee as "'.__("dossier").'"',
    'tiers_consulte.libelle as "'.__("tiers").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_tiers.lien_dossier_tiers as "'.__("lien_dossier_tiers").'"',
    'dossier.annee as "'.__("dossier").'"',
    'tiers_consulte.libelle as "'.__("tiers").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="lien_dossier_tiers";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "tiers_consulte" => array("tiers_consulte", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (lien_dossier_tiers.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["tiers_consulte"])) {
    $selection = " WHERE (lien_dossier_tiers.tiers = ".intval($idxformulaire).") ";
}

