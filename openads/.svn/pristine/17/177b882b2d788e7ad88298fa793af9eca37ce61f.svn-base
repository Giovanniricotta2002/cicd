<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_parcelle");
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
$table = DB_PREFIXE."dossier_parcelle
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_parcelle.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'dossier_parcelle.dossier_parcelle as "'.__("dossier_parcelle").'"',
    'dossier.annee as "'.__("dossier").'"',
    'dossier_parcelle.parcelle as "'.__("parcelle").'"',
    'dossier_parcelle.libelle as "'.__("libelle").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'dossier_parcelle.dossier_parcelle as "'.__("dossier_parcelle").'"',
    'dossier.annee as "'.__("dossier").'"',
    'dossier_parcelle.parcelle as "'.__("parcelle").'"',
    'dossier_parcelle.libelle as "'.__("libelle").'"',
    );
$tri="ORDER BY dossier_parcelle.libelle ASC NULLS LAST";
$edition="dossier_parcelle";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (dossier_parcelle.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

