<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_demandeur");
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
$table = DB_PREFIXE."lien_dossier_demandeur
    LEFT JOIN ".DB_PREFIXE."demandeur 
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON lien_dossier_demandeur.dossier=dossier.dossier ";
// SELECT 
$champAffiche = array(
    'lien_dossier_demandeur.lien_dossier_demandeur as "'.__("lien_dossier_demandeur").'"',
    "case lien_dossier_demandeur.petitionnaire_principal when 't' then 'Oui' else 'Non' end as \"".__("petitionnaire_principal")."\"",
    'dossier.annee as "'.__("dossier").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_demandeur.lien_dossier_demandeur as "'.__("lien_dossier_demandeur").'"',
    'dossier.annee as "'.__("dossier").'"',
    'demandeur.type_demandeur as "'.__("demandeur").'"',
    );
$tri="ORDER BY lien_dossier_demandeur.petitionnaire_principal ASC NULLS LAST";
$edition="lien_dossier_demandeur";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demandeur" => array("demandeur", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
);
// Filtre listing sous formulaire - demandeur
if (in_array($retourformulaire, $foreign_keys_extended["demandeur"])) {
    $selection = " WHERE (lien_dossier_demandeur.demandeur = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (lien_dossier_demandeur.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}

