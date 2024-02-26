<?php
//$Id$ 
//gen openMairie le 17/10/2022 11:48

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("evenement_type_habilitation_tiers_consulte");
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
$table = DB_PREFIXE."evenement_type_habilitation_tiers_consulte
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON evenement_type_habilitation_tiers_consulte.evenement=evenement.evenement 
    LEFT JOIN ".DB_PREFIXE."type_habilitation_tiers_consulte 
        ON evenement_type_habilitation_tiers_consulte.type_habilitation_tiers_consulte=type_habilitation_tiers_consulte.type_habilitation_tiers_consulte ";
// SELECT 
$champAffiche = array(
    'evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte as "'.__("evenement_type_habilitation_tiers_consulte").'"',
    'evenement.libelle as "'.__("evenement").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte as "'.__("evenement_type_habilitation_tiers_consulte").'"',
    'evenement.libelle as "'.__("evenement").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
    );
$tri="ORDER BY evenement.libelle ASC NULLS LAST";
$edition="evenement_type_habilitation_tiers_consulte";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "evenement" => array("evenement", ),
    "type_habilitation_tiers_consulte" => array("type_habilitation_tiers_consulte", ),
);
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (evenement_type_habilitation_tiers_consulte.evenement = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - type_habilitation_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["type_habilitation_tiers_consulte"])) {
    $selection = " WHERE (evenement_type_habilitation_tiers_consulte.type_habilitation_tiers_consulte = ".intval($idxformulaire).") ";
}

