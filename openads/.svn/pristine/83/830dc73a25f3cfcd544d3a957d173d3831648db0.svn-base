<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_commission");
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
$table = DB_PREFIXE."dossier_commission
    LEFT JOIN ".DB_PREFIXE."commission 
        ON dossier_commission.commission=commission.commission 
    LEFT JOIN ".DB_PREFIXE."commission_type 
        ON dossier_commission.commission_type=commission_type.commission_type 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_commission.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'dossier_commission.dossier_commission as "'.__("dossier_commission").'"',
    'dossier.annee as "'.__("dossier").'"',
    'commission_type.libelle as "'.__("commission_type").'"',
    'to_char(dossier_commission.date_souhaitee ,\'DD/MM/YYYY\') as "'.__("date_souhaitee").'"',
    'commission.libelle as "'.__("commission").'"',
    "case dossier_commission.lu when 't' then 'Oui' else 'Non' end as \"".__("lu")."\"",
    );
//
$champNonAffiche = array(
    'dossier_commission.motivation as "'.__("motivation").'"',
    'dossier_commission.avis as "'.__("avis").'"',
    );
//
$champRecherche = array(
    'dossier_commission.dossier_commission as "'.__("dossier_commission").'"',
    'dossier.annee as "'.__("dossier").'"',
    'commission_type.libelle as "'.__("commission_type").'"',
    'commission.libelle as "'.__("commission").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="dossier_commission";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "commission" => array("commission", ),
    "commission_type" => array("commission_type", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - commission
if (in_array($retourformulaire, $foreign_keys_extended["commission"])) {
    $selection = " WHERE (dossier_commission.commission = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - commission_type
if (in_array($retourformulaire, $foreign_keys_extended["commission_type"])) {
    $selection = " WHERE (dossier_commission.commission_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (dossier_commission.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

