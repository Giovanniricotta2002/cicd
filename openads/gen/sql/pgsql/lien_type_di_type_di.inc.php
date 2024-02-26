<?php
//$Id$ 
//gen openMairie le 04/08/2022 19:13

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("lien_type_di_type_di");
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
$table = DB_PREFIXE."lien_type_di_type_di
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type as dossier_instruction_type0 
        ON lien_type_di_type_di.dossier_instruction_type=dossier_instruction_type0.dossier_instruction_type 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type as dossier_instruction_type1 
        ON lien_type_di_type_di.type_di_parent=dossier_instruction_type1.dossier_instruction_type ";
// SELECT 
$champAffiche = array(
    'lien_type_di_type_di.lien_type_di_type_di as "'.__("lien_type_di_type_di").'"',
    'dossier_instruction_type1.libelle as "'.__("type_di_parent").'"',
    'dossier_instruction_type0.libelle as "'.__("dossier_instruction_type").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'lien_type_di_type_di.lien_type_di_type_di as "'.__("lien_type_di_type_di").'"',
    'dossier_instruction_type1.libelle as "'.__("type_di_parent").'"',
    'dossier_instruction_type0.libelle as "'.__("dossier_instruction_type").'"',
    );
$tri="ORDER BY dossier_instruction_type1.libelle ASC NULLS LAST";
$edition="lien_type_di_type_di";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "dossier_instruction_type" => array("dossier_instruction_type", ),
);
// Filtre listing sous formulaire - dossier_instruction_type
if (in_array($retourformulaire, $foreign_keys_extended["dossier_instruction_type"])) {
    $selection = " WHERE (lien_type_di_type_di.dossier_instruction_type = ".intval($idxformulaire)." OR lien_type_di_type_di.type_di_parent = ".intval($idxformulaire).") ";
}

