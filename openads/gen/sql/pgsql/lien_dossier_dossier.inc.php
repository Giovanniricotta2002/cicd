<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_dossier");
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
$table = DB_PREFIXE."lien_dossier_dossier
    LEFT JOIN ".DB_PREFIXE."dossier as dossier0 
        ON lien_dossier_dossier.dossier_cible=dossier0.dossier 
    LEFT JOIN ".DB_PREFIXE."dossier as dossier1 
        ON lien_dossier_dossier.dossier_src=dossier1.dossier ";
// SELECT 
$champAffiche = array(
    'lien_dossier_dossier.lien_dossier_dossier as "'.__("lien_dossier_dossier").'"',
    'dossier1.annee as "'.__("dossier_src").'"',
    'dossier0.annee as "'.__("dossier_cible").'"',
    'lien_dossier_dossier.type_lien as "'.__("type_lien").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_dossier.lien_dossier_dossier as "'.__("lien_dossier_dossier").'"',
    'dossier1.annee as "'.__("dossier_src").'"',
    'dossier0.annee as "'.__("dossier_cible").'"',
    );
$tri="ORDER BY dossier1.annee ASC NULLS LAST";
$edition="lien_dossier_dossier";
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
    $selection = " WHERE (lien_dossier_dossier.dossier_cible = '".$f->db->escapeSimple($idxformulaire)."' OR lien_dossier_dossier.dossier_src = '".$f->db->escapeSimple($idxformulaire)."') ";
}

