<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("rapport_instruction");
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
$table = DB_PREFIXE."rapport_instruction
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON rapport_instruction.dossier_instruction=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'rapport_instruction.rapport_instruction as "'.__("rapport_instruction").'"',
    'dossier.annee as "'.__("dossier_instruction").'"',
    'rapport_instruction.om_fichier_rapport_instruction as "'.__("om_fichier_rapport_instruction").'"',
    "case rapport_instruction.om_final_rapport_instruction when 't' then 'Oui' else 'Non' end as \"".__("om_final_rapport_instruction")."\"",
    "case rapport_instruction.om_fichier_rapport_instruction_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("om_fichier_rapport_instruction_dossier_final")."\"",
    );
//
$champNonAffiche = array(
    'rapport_instruction.analyse_reglementaire_om_html as "'.__("analyse_reglementaire_om_html").'"',
    'rapport_instruction.description_projet_om_html as "'.__("description_projet_om_html").'"',
    'rapport_instruction.proposition_decision as "'.__("proposition_decision").'"',
    'rapport_instruction.complement_om_html as "'.__("complement_om_html").'"',
    );
//
$champRecherche = array(
    'rapport_instruction.rapport_instruction as "'.__("rapport_instruction").'"',
    'dossier.annee as "'.__("dossier_instruction").'"',
    'rapport_instruction.om_fichier_rapport_instruction as "'.__("om_fichier_rapport_instruction").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="rapport_instruction";
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
    $selection = " WHERE (rapport_instruction.dossier_instruction = '".$f->db->escapeSimple($idxformulaire)."') ";
}

