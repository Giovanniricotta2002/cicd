<?php
//$Id$ 
//gen openMairie le 11/06/2021 12:03

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_sig_contrainte_dossier_instruction_type");
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
$table = DB_PREFIXE."lien_sig_contrainte_dossier_instruction_type
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."sig_contrainte 
        ON lien_sig_contrainte_dossier_instruction_type.sig_contrainte=sig_contrainte.sig_contrainte ";
// SELECT 
$champAffiche = array(
    'lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type as "'.__("lien_sig_contrainte_dossier_instruction_type").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type as "'.__("lien_sig_contrainte_dossier_instruction_type").'"',
    'sig_contrainte.libelle as "'.__("sig_contrainte").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    );
$tri="ORDER BY sig_contrainte.libelle ASC NULLS LAST";
$edition="lien_sig_contrainte_dossier_instruction_type";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "sig_contrainte" => array("sig_contrainte", ),
);
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - sig_contrainte
if (in_array($retourformulaire, $foreign_keys_extended["sig_contrainte"])) {
    $selection = " WHERE (lien_sig_contrainte_dossier_instruction_type.sig_contrainte = ".intval($idxformulaire).") ";
}

