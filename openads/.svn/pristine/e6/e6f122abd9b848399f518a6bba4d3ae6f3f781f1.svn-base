<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_nature_travaux");
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
$table = DB_PREFIXE."lien_dossier_nature_travaux
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON lien_dossier_nature_travaux.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."nature_travaux 
        ON lien_dossier_nature_travaux.nature_travaux=nature_travaux.nature_travaux ";
// SELECT 
$champAffiche = array(
    'lien_dossier_nature_travaux.lien_dossier_nature_travaux as "'.__("lien_dossier_nature_travaux").'"',
    'dossier.annee as "'.__("dossier").'"',
    'nature_travaux.libelle as "'.__("nature_travaux").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_nature_travaux.lien_dossier_nature_travaux as "'.__("lien_dossier_nature_travaux").'"',
    'dossier.annee as "'.__("dossier").'"',
    'nature_travaux.libelle as "'.__("nature_travaux").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="lien_dossier_nature_travaux";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "nature_travaux" => array("nature_travaux", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (lien_dossier_nature_travaux.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - nature_travaux
if (in_array($retourformulaire, $foreign_keys_extended["nature_travaux"])) {
    $selection = " WHERE (lien_dossier_nature_travaux.nature_travaux = ".intval($idxformulaire).") ";
}

