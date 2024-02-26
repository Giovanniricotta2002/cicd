<?php
//$Id: lien_demande_type_dossier_instruction_type.inc.php 8640 2019-03-27 11:49:05Z softime $ 
//gen openMairie le 15/11/2018 16:09

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_demande_type_dossier_instruction_type");
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
$table = DB_PREFIXE."lien_demande_type_dossier_instruction_type
    LEFT JOIN ".DB_PREFIXE."demande_type 
        ON lien_demande_type_dossier_instruction_type.demande_type=demande_type.demande_type 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_demande_type_dossier_instruction_type.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type ";
// SELECT 
$champAffiche = array(
    'lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type as "'.__("lien_demande_type_dossier_instruction_type").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type as "'.__("lien_demande_type_dossier_instruction_type").'"',
    'demande_type.libelle as "'.__("demande_type").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
$tri="ORDER BY demande_type.libelle ASC NULLS LAST";
$edition="lien_demande_type_dossier_instruction_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "demande_type" => array("demande_type", ),
    "dossier_instruction_type" => array("dossier_instruction_type", ),
);
// Filtre listing sous formulaire - demande_type
if (in_array($retourformulaire, $foreign_keys_extended["demande_type"])) {
    $selection = " WHERE (lien_demande_type_dossier_instruction_type.demande_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_demande_type_dossier_instruction_type.dossier_instruction_type = ".intval($idxformulaire).") ";
}

