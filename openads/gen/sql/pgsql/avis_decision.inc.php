<?php
//$Id$ 
//gen openMairie le 30/11/2021 18:58

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("avis_decision");
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
$table = DB_PREFIXE."avis_decision
    LEFT JOIN ".DB_PREFIXE."avis_decision_nature 
        ON avis_decision.avis_decision_nature=avis_decision_nature.avis_decision_nature 
    LEFT JOIN ".DB_PREFIXE."avis_decision_type 
        ON avis_decision.avis_decision_type=avis_decision_type.avis_decision_type ";
// SELECT 
$champAffiche = array(
    'avis_decision.avis_decision as "'.__("avis_decision").'"',
    'avis_decision.libelle as "'.__("libelle").'"',
    'avis_decision.typeavis as "'.__("typeavis").'"',
    'avis_decision.sitadel as "'.__("sitadel").'"',
    'avis_decision.sitadel_motif as "'.__("sitadel_motif").'"',
    "case avis_decision.tacite when 't' then 'Oui' else 'Non' end as \"".__("tacite")."\"",
    'avis_decision_type.libelle as "'.__("avis_decision_type").'"',
    'avis_decision_nature.libelle as "'.__("avis_decision_nature").'"',
    "case avis_decision.prescription when 't' then 'Oui' else 'Non' end as \"".__("prescription")."\"",
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'avis_decision.avis_decision as "'.__("avis_decision").'"',
    'avis_decision.libelle as "'.__("libelle").'"',
    'avis_decision.typeavis as "'.__("typeavis").'"',
    'avis_decision.sitadel as "'.__("sitadel").'"',
    'avis_decision.sitadel_motif as "'.__("sitadel_motif").'"',
    'avis_decision_type.libelle as "'.__("avis_decision_type").'"',
    'avis_decision_nature.libelle as "'.__("avis_decision_nature").'"',
    );
$tri="ORDER BY avis_decision.libelle ASC NULLS LAST";
$edition="avis_decision";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "avis_decision_nature" => array("avis_decision_nature", ),
    "avis_decision_type" => array("avis_decision_type", ),
);
// Filtre listing sous formulaire - avis_decision_nature
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision_nature"])) {
    $selection = " WHERE (avis_decision.avis_decision_nature = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - avis_decision_type
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision_type"])) {
    $selection = " WHERE (avis_decision.avis_decision_type = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'dossier',
    'dossier_autorisation',
    'evenement',
    'instruction',
);

