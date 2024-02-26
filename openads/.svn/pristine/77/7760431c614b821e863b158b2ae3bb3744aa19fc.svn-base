<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_contrainte");
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
$table = DB_PREFIXE."dossier_contrainte
    LEFT JOIN ".DB_PREFIXE."contrainte 
        ON dossier_contrainte.contrainte=contrainte.contrainte 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_contrainte.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'dossier_contrainte.dossier_contrainte as "'.__("dossier_contrainte").'"',
    'dossier.annee as "'.__("dossier").'"',
    'contrainte.libelle as "'.__("contrainte").'"',
    "case dossier_contrainte.reference when 't' then 'Oui' else 'Non' end as \"".__("reference")."\"",
    );
//
$champNonAffiche = array(
    'dossier_contrainte.texte_complete as "'.__("texte_complete").'"',
    );
//
$champRecherche = array(
    'dossier_contrainte.dossier_contrainte as "'.__("dossier_contrainte").'"',
    'dossier.annee as "'.__("dossier").'"',
    'contrainte.libelle as "'.__("contrainte").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="dossier_contrainte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "contrainte" => array("contrainte", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - contrainte
if (in_array($retourformulaire, $foreign_keys_extended["contrainte"])) {
    $selection = " WHERE (dossier_contrainte.contrainte = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (dossier_contrainte.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

