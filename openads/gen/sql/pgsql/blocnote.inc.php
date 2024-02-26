<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("blocnote");
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
$table = DB_PREFIXE."blocnote
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON blocnote.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'blocnote.blocnote as "'.__("blocnote").'"',
    'blocnote.categorie as "'.__("categorie").'"',
    'dossier.annee as "'.__("dossier").'"',
    );
//
$champNonAffiche = array(
    'blocnote.note as "'.__("note").'"',
    );
//
$champRecherche = array(
    'blocnote.blocnote as "'.__("blocnote").'"',
    'blocnote.categorie as "'.__("categorie").'"',
    'dossier.annee as "'.__("dossier").'"',
    );
$tri="ORDER BY blocnote.categorie ASC NULLS LAST";
$edition="blocnote";
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
    $selection = " WHERE (blocnote.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

