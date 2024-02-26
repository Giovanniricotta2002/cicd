<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dossier_instruction_type_evenement");
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
$table = DB_PREFIXE."lien_dossier_instruction_type_evenement
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_dossier_instruction_type_evenement.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."evenement 
        ON lien_dossier_instruction_type_evenement.evenement=evenement.evenement ";
// SELECT 
$champAffiche = array(
    'lien_dossier_instruction_type_evenement.lien_dossier_instruction_type_evenement as "'.__("lien_dossier_instruction_type_evenement").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dossier_instruction_type_evenement.lien_dossier_instruction_type_evenement as "'.__("lien_dossier_instruction_type_evenement").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'evenement.libelle as "'.__("evenement").'"',
    );
$tri="ORDER BY dossier_instruction_type.libelle ASC NULLS LAST";
$edition="lien_dossier_instruction_type_evenement";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "evenement" => array("evenement", ),
);
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_dossier_instruction_type_evenement.dossier_instruction_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (lien_dossier_instruction_type_evenement.evenement = ".intval($idxformulaire).") ";
}

