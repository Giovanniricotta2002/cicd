<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("dossier_message");
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
$table = DB_PREFIXE."dossier_message
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON dossier_message.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'dossier_message.dossier_message as "'.__("dossier_message").'"',
    'dossier.annee as "'.__("dossier").'"',
    'dossier_message.type as "'.__("type").'"',
    'dossier_message.emetteur as "'.__("emetteur").'"',
    'dossier_message.date_emission as "'.__("date_emission").'"',
    "case dossier_message.lu when 't' then 'Oui' else 'Non' end as \"".__("lu")."\"",
    'dossier_message.categorie as "'.__("categorie").'"',
    'dossier_message.destinataire as "'.__("destinataire").'"',
    );
//
$champNonAffiche = array(
    'dossier_message.contenu as "'.__("contenu").'"',
    );
//
$champRecherche = array(
    'dossier_message.dossier_message as "'.__("dossier_message").'"',
    'dossier.annee as "'.__("dossier").'"',
    'dossier_message.type as "'.__("type").'"',
    'dossier_message.emetteur as "'.__("emetteur").'"',
    'dossier_message.categorie as "'.__("categorie").'"',
    'dossier_message.destinataire as "'.__("destinataire").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="dossier_message";
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
    $selection = " WHERE (dossier_message.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

