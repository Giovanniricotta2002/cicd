<?php
//$Id$ 
//gen openMairie le 28/03/2023 16:36

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_dit_nature_travaux");
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
$table = DB_PREFIXE."lien_dit_nature_travaux
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_dit_nature_travaux.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."nature_travaux 
        ON lien_dit_nature_travaux.nature_travaux=nature_travaux.nature_travaux ";
// SELECT 
$champAffiche = array(
    'lien_dit_nature_travaux.lien_dit_nature_travaux as "'.__("lien_dit_nature_travaux").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'nature_travaux.libelle as "'.__("nature_travaux").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_dit_nature_travaux.lien_dit_nature_travaux as "'.__("lien_dit_nature_travaux").'"',
    'dossier_instruction_type.libelle as "'.__("dossier_instruction_type").'"',
    'nature_travaux.libelle as "'.__("nature_travaux").'"',
    );
$tri="ORDER BY dossier_instruction_type.libelle ASC NULLS LAST";
$edition="lien_dit_nature_travaux";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_instruction_type" => array("dossier_instruction_type", ),
    "nature_travaux" => array("nature_travaux", ),
);
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_dit_nature_travaux.dossier_instruction_type = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - nature_travaux
if (in_array($retourformulaire, $foreign_keys_extended["nature_travaux"])) {
    $selection = " WHERE (lien_dit_nature_travaux.nature_travaux = ".intval($idxformulaire).") ";
}

